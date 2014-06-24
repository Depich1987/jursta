<?php require_once('Connections/jursta.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrateur,Civile,Superviseur,Admincivil";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['id_socialappel'])) && ($_GET['id_socialappel'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_socialappel WHERE id_socialappel=%s", GetSQLValueString($_GET['id_socialappel'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le paramètres donné--------------------------

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

$maxRows_liste_appelsocial = 30;
$pageNum_liste_appelsocial = 0;
if (isset($_GET['pageNum_liste_appelsocial'])) {
  $pageNum_liste_appelsocial = $_GET['pageNum_liste_appelsocial'];
}
$startRow_liste_appelsocial = $pageNum_liste_appelsocial * $maxRows_liste_appelsocial;

mysql_select_db($database_jursta, $jursta);
$query_liste_appelsocial = "SELECT * FROM reg_socialappel, rep_jugementsupp, role_general WHERE ((role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral) AND (reg_socialappel.no_repjugementsupp=rep_jugementsupp.no_repjugementsupp) AND ((reg_socialappel.no_socialappel LIKE '".$_GET['wrdkey']."%') OR (role_general.demandeur_rolegeneral LIKE '".$_GET['wrdkey']."%') OR (role_general.defendeur_rolegeneral LIKE '".$_GET['wrdkey']."%'))) ORDER BY id_socialappel DESC";
$query_limit_liste_appelsocial = sprintf("%s LIMIT %d, %d", $query_liste_appelsocial, $startRow_liste_appelsocial, $maxRows_liste_appelsocial);
$liste_appelsocial = mysql_query($query_limit_liste_appelsocial, $jursta) or die(mysql_error());
$row_liste_appelsocial = mysql_fetch_assoc($liste_appelsocial);

if (isset($_GET['totalRows_liste_appelsocial'])) {
  $totalRows_liste_appelsocial = $_GET['totalRows_liste_appelsocial'];
} else {
  $all_liste_appelsocial = mysql_query($query_liste_appelsocial);
  $totalRows_liste_appelsocial = mysql_num_rows($all_liste_appelsocial);
}
$totalPages_liste_appelsocial = ceil($totalRows_liste_appelsocial/$maxRows_liste_appelsocial)-1;

$queryString_liste_appelsocial = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_appelsocial") == false && 
        stristr($param, "totalRows_liste_appelsocial") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_appelsocial = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_appelsocial = sprintf("&totalRows_liste_appelsocial=%d%s", $totalRows_liste_appelsocial, $queryString_liste_appelsocial);
?>
<?php
function Change_formatDate($date, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
                              <?php if ($totalRows_liste_appelsocial > 0) { // Show if recordset not empty ?>
                              <tr>
                                <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                          <tr bgcolor="#677787" class="Style3">
                                            <td>#</td>
                                            <td align="center"><span class="Style11">N&deg; d'ordre</span></td>
                                            <td class="Style11">Date du jour</td>
                                            <td><span class="Style11">Date du Jugement</span></td>
                                            <td align="center" nowrap><span class="Style11">Nom et Pr&eacute;noms des parties</span></td>
                                            <td>Emargement</td>
                                            <td>Op&eacute;rations</td>
                                          </tr>
                                          <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_appelsocial*$pageNum_liste_appelsocial;
		?>
                                          <?php do { ?>
                                          <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                          <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                            <td align="center" valign="middle" class="Style11"><strong><?php echo $i ?></strong></td>
                                            <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_appelsocial['no_socialappel']; ?></strong></td>
                                            <td valign="middle" nowrap class="Style11"><strong><?php echo Change_formatDate($row_liste_appelsocial['datejour']); ?></strong></td>
                                            <td valign="middle" nowrap class="Style11"><strong><?php echo Change_formatDate($row_liste_appelsocial['datejugement']); ?></strong></td>
                                            <td align="left" valign="middle" class="Style11"><p><strong><?php echo $row_liste_appelsocial['demandeur_rolegeneral']; ?></strong></p>
                                              <p><strong><?php echo $row_liste_appelsocial['defendeur_rolegeneral']; ?></strong></p></td>
                                            <td valign="middle" class="Style11"><strong><?php echo $row_liste_appelsocial['Signature']; ?></strong></td>
                                            <td valign="middle"><table >
                                              <tr align="center" class="Style16">
                                                <td nowrap><strong>
                                                  <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                  <a href="#" onClick="javascript:ouvre_popup('visual_regappciv.php?idras=<?php echo $row_liste_appelsocial['id_socialappel']; ?>',490,420)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                                  <?php } ?>
                                                </strong></td>
                                                <td nowrap><strong>
                                                  <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                  <a href="#" onClick="javascript:ouvre_popup('modif_regappciv.php?idras=<?php echo $row_liste_appelsocial['id_socialappel']; ?>',490,310)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/rename.png" title="Modifier" width="28">
                                                  <?php } ?>
                                                </strong></td>
                                                <td nowrap><strong>
                                                  <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                  <a href="liste_regappelcivil.php?idras=<?php echo $row_liste_appelsocial['id_socialappel']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/cancel.png" title="Supprimer" width="28">
                                                  <?php } ?>
                                                </strong></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                          <?php } while ($row_liste_appelsocial = mysql_fetch_assoc($liste_appelsocial)); ?>
                                      </table></td>
                                    </tr>
                                  </table>
                                    <br>
                                    <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                      <tr class="Style14">
                                        <td><a href="<?php printf("%s?pageNum_liste_appelsocial=%d%s", $currentPage, max(0, $pageNum_liste_appelsocial - 1), $queryString_liste_appelsocial); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                        <td><a href="<?php printf("%s?pageNum_liste_appelsocial=%d%s", $currentPage, min($totalPages_liste_appelsocial, $pageNum_liste_appelsocial + 1), $queryString_liste_appelsocial); ?>"><strong>Suivant&raquo;</strong></a></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><strong>Page</strong></td>
                                        <td><strong><?php echo $pageNum_liste_appelsocial+1 ?>/<?php echo $totalPages_liste_appelsocial+1; ?></strong></td>
                                        <td>&nbsp;</td>
                                        <td><strong>Enrg de <?php echo $startRow_liste_appelsocial+1; ?> &agrave; 30 </strong></td>
                                        <td><strong>Total </strong></td>
                                        <td><strong><?php echo $totalRows_liste_appelsocial ?> </strong></td>
                                      </tr>
                                  </table></td>
                              </tr>
                              <?php } // Show if recordset not empty ?>
                              <?php if ($totalRows_liste_appelsocial == 0) { // Show if recordset empty ?>
                              <tr>
                                <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                              </tr>
                              <?php } // Show if recordset empty ?>
                          </table>