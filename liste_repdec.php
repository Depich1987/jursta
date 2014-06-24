<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Sociale,Superviseur";
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
//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['nored'])) && ($_GET['nored'] != "")) {
  $deleteSQL = sprintf("DELETE FROM rep_decision WHERE no_decision=%s",
                       GetSQLValueString($_GET['nored'], "int"));

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

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "int"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);


$maxRows_liste_repdecision = 30;
$pageNum_liste_repdecision = 0;
if (isset($_GET['pageNum_liste_repdecision'])) {
  $pageNum_liste_repdecision = $_GET['pageNum_liste_repdecision'];
}
$startRow_liste_repdecision = $pageNum_liste_repdecision * $maxRows_liste_repdecision;

mysql_select_db($database_jursta, $jursta);
$query_liste_repdecision = "SELECT * FROM rep_decision, rg_social WHERE ((rg_social.no_rgsocial=rep_decision.no_rgsocial) AND (rep_decision.id_juridiction =".$row_select_juridic['id_juridiction'].") AND ((rep_decision.nodec_decision LIKE '".$_GET['wrdkey']."%') OR (rg_social.demandeur_rgsocial LIKE '".$_GET['wrdkey']."%') OR (rg_social.defendeur_rgsocial LIKE '".$_GET['wrdkey']."%'))) ORDER BY no_decision DESC";
$query_limit_liste_repdecision = sprintf("%s LIMIT %d, %d", $query_liste_repdecision, $startRow_liste_repdecision, $maxRows_liste_repdecision);
$liste_repdecision = mysql_query($query_limit_liste_repdecision, $jursta) or die(mysql_error());
$row_liste_repdecision = mysql_fetch_assoc($liste_repdecision);

if (isset($_GET['totalRows_liste_repdecision'])) {
  $totalRows_liste_repdecision = $_GET['totalRows_liste_repdecision'];
} else {
  $all_liste_repdecision = mysql_query($query_liste_repdecision);
  $totalRows_liste_repdecision = mysql_num_rows($all_liste_repdecision);
}
$totalPages_liste_repdecision = ceil($totalRows_liste_repdecision/$maxRows_liste_repdecision)-1;

$queryString_liste_repdecision = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_repdecision") == false && 
        stristr($param, "totalRows_liste_repdecision") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_repdecision = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_repdecision = sprintf("&totalRows_liste_repdecision=%d%s", $totalRows_liste_repdecision, $queryString_liste_repdecision);
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
<table width="100%" border="0" cellpadding="3" cellspacing="3">
                        <?php if ($totalRows_liste_repdecision > 0) { // Show if recordset not empty ?>
                        <tr>
                          <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                    <tr bgcolor="#677787" class="Style3">
                                      <td>#</td>
                                      <td><span class="Style11">N&deg; de la D&eacute;cision </span></td>
                                      <td align="center"><span class="Style11">Date de l'audience </span></td>
                                      <td>Nom du Greffier</td>
                                      <td><span class="Style11">Objet </span></td>
                                      <td><span class="Style11">Demandeur</span></td>
                                      <td nowrap><span class="Style11">Defendeur</span></td>
                                      <td nowrap><span class="Style10">Dispositif</span></td>
                                      <td><span class="Style11">Observation</span></td>
                                      <td>Op&eacute;rations</td>
                                    </tr>
                                    <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_repdecision*$pageNum_liste_repdecision;
		?>
                                    <?php do { ?>
                                    <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                    <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                      <td align="center" valign="middle" class="Style11"><strong><?php echo $i ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><span class="Style25"><?php echo $row_liste_repdecision['nodec_decision']; ?></span></strong></td>
                                      <td align="center" valign="middle" class="Style11"><strong><?php echo Change_formatDate($row_liste_repdecision['dateaudience_rgsocial']); ?></strong></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_repdecision['grefier']; ?></strong></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_repdecision['objet_rgsocial']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repdecision['demandeur_rgsocial']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repdecision['defendeur_rgsocial']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repdecision['dispositif_decision']; ?></strong></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_repdecision['observation_decision']; ?></strong></td>
                                      <td valign="middle"><table width="72" height="33" >
                                          <tr align="center" class="Style16">
                                            <td><strong>
                                              <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                <a href="#" onClick="javascript:ouvre_popup('visual_repdecision.php?nored=<?php echo $row_liste_repdecision['no_decision']; ?>',480,470)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                                <?php } ?>
                                            </strong></td>
                                            <td><strong>
                                              <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                <a href="#" onClick="javascript:ouvre_popup('modif_repdecision.php?nored=<?php echo $row_liste_repdecision['no_decision']; ?>',500,590)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/rename.png" title="Modifier" width="28">
                                                <?php } ?>
                                            </strong></td>
                                            <td><strong>
                                              <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                <a href="liste_repdecision.php?nored=<?php echo $row_liste_repdecision['no_decision']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/cancel.png" title="Supprimer" width="28">
                                                <?php } ?>
                                            </strong></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <?php } while ($row_liste_repdecision = mysql_fetch_assoc($liste_repdecision)); ?>
                                </table></td>
                              </tr>
                            </table>
                              <br>
                              <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                <tr class="Style11">
                                  <td><a href="<?php printf("%s?pageNum_liste_repdecision=%d%s", $currentPage, max(0, $pageNum_liste_repdecision - 1), $queryString_liste_repdecision); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                  <td><a href="<?php printf("%s?pageNum_liste_repdecision=%d%s", $currentPage, min($totalPages_liste_repdecision, $pageNum_liste_repdecision + 1), $queryString_liste_repdecision); ?>"><strong>Suivant&raquo;</strong></a></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td><strong>Page</strong></td>
                                  <td><strong><?php echo $pageNum_liste_repdecision+1 ?>/<?php echo $totalPages_liste_repdecision+1; ?></strong></td>
                                  <td>&nbsp;</td>
                                  <td><strong>Enrg de <?php echo $startRow_liste_repdecision+1; ?> &agrave; 30 </strong></td>
                                  <td><strong>Total </strong></td>
                                  <td><strong><?php echo $totalRows_liste_repdecision ?> </strong></td>
                                </tr>
                            </table></td>
                        </tr>
                        <?php } // Show if recordset not empty ?>
                        <?php if ($totalRows_liste_repdecision == 0) { // Show if recordset empty ?>
                        <tr>
                          <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                        </tr>
                        <?php } // Show if recordset empty ?>
                    </table>