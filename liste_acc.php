<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Civile,Administrateur,Superviseur,AdminCivil";
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

//----------------------------------- requete de suppression de l'enregistrement avec le param�tres donn�--------------------------
if ((isset($_GET['noracc'])) && ($_GET['noracc'] != "")) {
  $deleteSQL = sprintf("DELETE FROM rep_actesacc WHERE no_repactesacc=%s",
                       GetSQLValueString($_GET['noracc'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le param�tres donn�--------------------------

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = '%s') AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", $colname_select_juridic);
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);


$maxRows_liste_repacc = 30;
$pageNum_liste_repacc = 0;
if (isset($_GET['pageNum_liste_repacc'])) {
  $pageNum_liste_repacc = $_GET['pageNum_liste_repacc'];
}
$startRow_liste_repacc = $pageNum_liste_repacc * $maxRows_liste_repacc;

mysql_select_db($database_jursta, $jursta);
$query_liste_repacc = "SELECT * FROM rep_actesacc, categorie_affaire WHERE ((categorie_affaire.id_categorieaffaire=rep_actesacc.id_categorieaffaire) AND (rep_actesacc.id_juridiction =".$row_select_juridic['id_juridiction'].")AND ((rep_actesacc.nodordre_acc LIKE '".$_GET['wrdkey']."%') OR (rep_actesacc.nomparties_acc LIKE '".$_GET['wrdkey']."%'))) ORDER BY no_repactesacc DESC";
$query_limit_liste_repacc = sprintf("%s LIMIT %d, %d", $query_liste_repacc, $startRow_liste_repacc, $maxRows_liste_repacc);
$liste_repacc = mysql_query($query_limit_liste_repacc, $jursta) or die(mysql_error());
$row_liste_repacc = mysql_fetch_assoc($liste_repacc);

if (isset($_GET['totalRows_liste_repacc'])) {
  $totalRows_liste_repacc = $_GET['totalRows_liste_repacc'];
} else {
  $all_liste_repacc = mysql_query($query_liste_repacc);
  $totalRows_liste_repacc = mysql_num_rows($all_liste_repacc);
}
$totalPages_liste_repacc = ceil($totalRows_liste_repacc/$maxRows_liste_repacc)-1;

$queryString_liste_repacc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_repacc") == false && 
        stristr($param, "totalRows_liste_repacc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_repacc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_repacc = sprintf("&totalRows_liste_repacc=%d%s", $totalRows_liste_repacc, $queryString_liste_repacc);
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
                        <?php if ($totalRows_liste_repacc > 0) { // Show if recordset not empty ?>
                        <tr>
                          <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                    <tr bgcolor="#677787" class="Style3">
                                      <td align="center">#</td>
                                      <td align="center">N&deg; d'ordre </td>
                                      <td align="center">Date </td>
                                      <td nowrap>Nom des parties </td>
                                      <td>D&eacute;signation de l'acte </td>
                                      <td>Nature</td>
                                      <td>Op&eacute;rations</td>
                                    </tr>
                                    <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_repacc*$pageNum_liste_repacc;
		?>
                                    <?php do { ?>
                                    <?php
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                    <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                      <td align="center" valign="middle" class="Style11"><strong><?php echo $row_liste_repacc['no_repactesacc']; ?></strong></td>
                                      <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repacc['nodordre_acc']; ?></strong></td>
                                      <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo Change_formatDate($row_liste_repacc['date_acc']); ?></strong></td>
                                      <td width="50%" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repacc['nomparties_acc']; ?></strong></td>
                                      <td width="50%" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repacc['designationacte_acc']; ?></strong></td>
                                      <td width="50%" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repacc['lib_categorieaffaire']; ?></strong></td>
                                      <td valign="middle"><table width="72" height="33" >
                                          <tr align="center" class="Style16">
                                            <td><strong>
                                              <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                <a href="#" onClick="javascript:ouvre_popup('visual_repacc.php?noracc=<?php echo $row_liste_repacc['no_repactesacc']; ?>',490,370)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                                <?php } ?>
                                            </strong></td>
                                            <td><strong>
                                              <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                <a href="#" onClick="javascript:ouvre_popup('modif_repacc.php?noracc=<?php echo $row_liste_repacc['no_repactesacc']; ?>',520,330)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/rename.png" title="Modifier" width="28">
                                                <?php } ?>
                                            </strong></td>
                                            <td><strong>
                                              <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                <a href="liste_repacc.php?noracc=<?php echo $row_liste_repacc['no_repactesacc']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/cancel.png" title="Supprimer" width="28">
                                                <?php } ?>
                                            </strong></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <?php } while ($row_liste_repacc = mysql_fetch_assoc($liste_repacc)); ?>
                                </table></td>
                              </tr>
                            </table>
                              <br>
                              <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                <tr class="Style22">
                                  <td><a href="<?php printf("%s?pageNum_liste_repacc=%d%s", $currentPage, max(0, $pageNum_liste_repacc - 1), $queryString_liste_repacc); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                  <td><a href="<?php printf("%s?pageNum_liste_repacc=%d%s", $currentPage, min($totalPages_liste_repacc, $pageNum_liste_repacc + 1), $queryString_liste_repacc); ?>"><strong>Suivant&raquo;</strong></a></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td><strong>Page</strong></td>
                                  <td><strong><?php echo $pageNum_liste_repacc+1 ?>/<?php echo $totalPages_liste_repacc+1; ?></strong></td>
                                  <td>&nbsp;</td>
                                  <td><strong>Enrg de <?php echo $startRow_liste_repacc+1; ?> &agrave; 30 </strong></td>
                                  <td><strong>Total </strong></td>
                                  <td><strong><?php echo $totalRows_liste_repacc ?> </strong></td>
                                </tr>
                            </table></td>
                        </tr>
                        <?php } // Show if recordset not empty ?>
                        <?php if ($totalRows_liste_repacc == 0) { // Show if recordset empty ?>
                        <tr>
                          <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                        </tr>
                        <?php } // Show if recordset empty ?>
                    </table>