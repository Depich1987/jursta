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

//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['norej'])) && ($_GET['norej'] != "")) {
  $deleteSQL = sprintf("DELETE FROM rep_jugementsupp WHERE no_repjugementsupp=%s",
                       GetSQLValueString($_GET['norej'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le paramètres donné--------------------------

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


$maxRows_liste_repjug = 30;
$pageNum_liste_repjug = 0;
if (isset($_GET['pageNum_liste_repjug'])) {
  $pageNum_liste_repjug = $_GET['pageNum_liste_repjug'];
}
$startRow_liste_repjug = $pageNum_liste_repjug * $maxRows_liste_repjug;

mysql_select_db($database_jursta, $jursta);
$query_liste_repjug = "SELECT * FROM rep_jugementsupp, role_general WHERE ((role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral) AND (rep_jugementsupp.id_juridiction =".$row_select_juridic['id_juridiction'].")) ORDER BY nojugement_repjugementsupp ASC";
$query_limit_liste_repjug = sprintf("%s LIMIT %d, %d", $query_liste_repjug, $startRow_liste_repjug, $maxRows_liste_repjug);
$liste_repjug = mysql_query($query_limit_liste_repjug, $jursta) or die(mysql_error());
$row_liste_repjug = mysql_fetch_assoc($liste_repjug);

if (isset($_GET['totalRows_liste_repjug'])) {
  $totalRows_liste_repjug = $_GET['totalRows_liste_repjug'];
} else {
  $all_liste_repjug = mysql_query($query_liste_repjug);
  $totalRows_liste_repjug = mysql_num_rows($all_liste_repjug);
}
$totalPages_liste_repjug = ceil($totalRows_liste_repjug/$maxRows_liste_repjug)-1;

$queryString_liste_repjug = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_repjug") == false && 
        stristr($param, "totalRows_liste_repjug") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_repjug = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_repjug = sprintf("&totalRows_liste_repjug=%d%s", $totalRows_liste_repjug, $queryString_liste_repjug);
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
<script src="js/common.js" type="text/javascript"></script>
<script src="js/ajax_xhr_dossiersearch.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/index_01.gif);
	background-repeat: repeat-x;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style></head>

<body>
<table width="100%"  align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td>&nbsp;</td>
    <td><?php require_once('haut.php'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td bgcolor="#6186AF">&nbsp;</td>
    <td><?php require_once('menuhaut.php'); ?></td>
    <td bgcolor="#6186AF">&nbsp;</td>
  </tr>
  <tr align="center">
    <td bgcolor="#FFFF00">&nbsp;</td>
    <td><?php require_once('menuidentity.php'); ?></td>
    <td bgcolor="#FFFF00">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center" valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td bgcolor="#174F8A" class="Style28"><table width="100%" cellpadding="2" cellspacing="1" >
                        <tr bgcolor="#FFFFFF">
                          <td nowrap bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                              <a href="#" onClick="javascript:ouvre_popup('add_repjug.php',530,600)"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                              <?php } else {?>
                              <img src="images/edit.png" width="32" height="32" border="0">
                              <?php } ?></td>
                          <td width="50%" align="left" nowrap bgcolor="#174F8A"><span class="Style2">Le r&eacute;pertoire des jugements</span></td>
                         <td align="right" bgcolor="#174F8A" class="Style2"><span class="Style2">rechercher :</span>                            <input name="search_txt" type="text" class="Style30" id="search_txt" onKeyUp="getBlock('wrdkey='+this.value,'listedossiersearch','liste_jug.php')"/></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><div id="listedossiersearch">
                    <table width="100%" border="0" cellpadding="3" cellspacing="3">
                        <?php if ($totalRows_liste_repjug > 0) { // Show if recordset not empty ?>
                        <tr>
                          <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                    <tr bgcolor="#677787" class="Style3">
                                      <td>#</td>
                                      <td><span class="Style11">N&deg; du jugement </span></td>
                                      <td align="center"><span class="Style11">Date de l'audience </span></td>
                                      <td><span class="Style11">Objet </span></td>
                                      <td><span class="Style11">Demandeur</span></td>
                                      <td nowrap><span class="Style11">Defendeur</span></td>
                                      <td nowrap><span class="Style10">Dispositif</span></td>
                                      <td nowrap><span class="Style10">Caract&egrave;re</span></td>
                                      <td><span class="Style11">Observation</span></td>
                                      <td>Op&eacute;rations</td>
                                    </tr>
                                    <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_repjug*$pageNum_liste_repjug;
		?>
                                    <?php do { ?>
                                    <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                    <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                      <td align="center" valign="middle" class="Style11"><strong><?php echo $i ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><span class="Style25"><?php echo $row_liste_repjug['nojugement_repjugementsupp']; ?></span></strong></td>
                                      <td align="center" valign="middle" class="Style11"><strong><?php echo Change_formatDate($row_liste_repjug['dateaudience_rolegeneral']); ?></strong></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_repjug['objet_rolegeneral']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repjug['demandeur_rolegeneral']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repjug['defendeur_rolegeneral']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repjug['decision_repjugementsupp']; ?></strong></td>
                                      <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_repjug['dispositif_repjugementsupp']; ?></strong></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_repjug['observation_repjugementsupp']; ?></strong></td>
                                      <td valign="middle"><table width="72" height="33" >
                                          <tr align="center" class="Style16">
                                            <td><strong>
                                              <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                <a href="#" onClick="javascript:ouvre_popup('visual_repjug.php?norej=<?php echo $row_liste_repjug['no_repjugementsupp']; ?>',510,510)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                                <?php } ?>
                                            </strong></td>
                                            <td><strong>
                                              <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                <a href="#" onClick="javascript:ouvre_popup('modif_repjug.php?norej=<?php echo $row_liste_repjug['no_repjugementsupp']; ?>',530,560)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/rename.png" title="Modifier" width="28">
                                                <?php } ?>
                                            </strong></td>
                                            <td><strong>
                                              <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                <a href="liste_repjug.php?norej=<?php echo $row_liste_repjug['no_repjugementsupp']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                <?php } else {?>
                                                <img src="images/cancel.png" title="Supprimer" width="28">
                                                <?php } ?>
                                            </strong></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <?php } while ($row_liste_repjug = mysql_fetch_assoc($liste_repjug)); ?>
                                </table></td>
                              </tr>
                            </table>
                              <br>
                              <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                <tr class="Style11">
                                  <td><a href="<?php printf("%s?pageNum_liste_repjug=%d%s", $currentPage, max(0, $pageNum_liste_repjug - 1), $queryString_liste_repjug); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                  <td><a href="<?php printf("%s?pageNum_liste_repjug=%d%s", $currentPage, min($totalPages_liste_repjug, $pageNum_liste_repjug + 1), $queryString_liste_repjug); ?>"><strong>Suivant&raquo;</strong></a></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td><strong>Page</strong></td>
                                  <td><strong><?php echo $pageNum_liste_repjug+1 ?>/<?php echo $totalPages_liste_repjug+1; ?></strong></td>
                                  <td>&nbsp;</td>
                                  <td><strong>Enrg de <?php echo $startRow_liste_repjug+1; ?> &agrave; 30 </strong></td>
                                  <td><strong>Total </strong></td>
                                  <td><strong><?php echo $totalRows_liste_repjug ?> </strong></td>
                                </tr>
                            </table></td>
                        </tr>
                        <?php } // Show if recordset not empty ?>
                        <?php if ($totalRows_liste_repjug == 0) { // Show if recordset empty ?>
                        <tr>
                          <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                        </tr>
                        <?php } // Show if recordset empty ?>
                    </table></div></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="50%" align="center" valign="top" background="images/continue.jpg">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($liste_repjug);
?>