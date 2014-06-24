<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Penitentiaire,Superviseur,AdminPenal";
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
if ((isset($_GET['noregdec'])) && ($_GET['noregdec'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_transfert WHERE id_regtransfert=%s",
                       GetSQLValueString($_GET['noregdec'], "int"));

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


$maxRows_liste_deces = 30;
$pageNum_liste_deces = 0;
if (isset($_GET['pageNum_liste_deces'])) {
  $pageNum_liste_deces = $_GET['pageNum_liste_deces'];
}
$startRow_liste_deces = $pageNum_liste_deces * $maxRows_liste_deces;

mysql_select_db($database_jursta, $jursta);
$query_liste_deces = "SELECT * FROM reg_transfert, reg_ecrou, reg_controlnum, reg_mandat WHERE ((reg_transfert.id_juridiction =".$row_select_juridic['id_juridiction'].") AND (reg_transfert.no_ecrou = reg_ecrou.no_ecrou) AND (reg_ecrou.no_regcontrolnum = reg_controlnum.no_regcontrolnum) AND (reg_mandat.no_regmandat=reg_controlnum.no_regmandat)) ORDER BY reg_transfert.id_regtransfert DESC";
$query_limit_liste_deces = sprintf("%s LIMIT %d, %d", $query_liste_deces, $startRow_liste_deces, $maxRows_liste_deces);
$liste_deces = mysql_query($query_limit_liste_deces, $jursta) or die(mysql_error());
$row_liste_deces = mysql_fetch_assoc($liste_deces);

if (isset($_GET['totalRows_liste_deces'])) {
  $totalRows_liste_deces = $_GET['totalRows_liste_deces'];
} else {
  $all_liste_deces = mysql_query($query_liste_deces);
  $totalRows_liste_deces = mysql_num_rows($all_liste_deces);
}
$totalPages_liste_deces = ceil($totalRows_liste_deces/$maxRows_liste_deces)-1;

$queryString_liste_deces = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_deces") == false && 
        stristr($param, "totalRows_liste_deces") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_deces = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_deces = sprintf("&totalRows_liste_deces=%d%s", $totalRows_liste_deces, $queryString_liste_deces);
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
                              <a href="#" onClick="javascript:ouvre_popup('add_regdeces.php',520,470)"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                              <?php } else {?>
                              <img src="images/edit.png" width="32" height="32" border="0">
                              <?php } ?></td>
                          <td width="50%" align="left" bgcolor="#174F8A"><div align="left"><span class="Style2">Le registre des d&eacute;c&egrave;s</span></div></td>
                          <td width="54%" align="right" bgcolor="#174F8A" class="Style2"><span class="Style2">rechercher :</span>                            <input name="search_txt" type="text" class="Style30" id="search_txt" onKeyUp="getBlock('wrdkey='+this.value,'listedossiersearch','liste_deces.php')"/></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100%"><div id="listedossiersearch"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                              <?php if ($totalRows_liste_deces > 0) { // Show if recordset not empty ?>
                              <tr>
                                <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                          <tr bgcolor="#677787" class="Style3">
                                            <td>#</td>
                                            <td><span class="Style11">N&deg; d'ordre </span></td>
                                            <td>Date</td>
                                            <td align="center"><span class="Style11">N&deg; Ecrou</span></td>
                                            <td>Identit&eacute; du d&eacute;tenu</td>
                                            <td><span class="Style11">Situation carc&eacute;rale</span></td>
                                            <td nowrap><span class="Style11">Motif transf&egrave;rement</span></td>
                                            <td align="center" nowrap><span class="Style11">Destination</span></td>
                                            <td align="center" nowrap>Chef d'escorte <br> Nom + Signature</td>
                                            <td align="center" nowrap>Observation</td>
                                            <td>Op&eacute;rations</td>
                                          </tr>
                                          <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_deces*$pageNum_liste_deces;
		?>
                                          <?php do { ?>
                                          <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                          <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                            <td align="center" valign="middle" class="Style11"><strong><?php echo $i ?></strong></td>
                                            <td valign="middle" class="Style11"><strong><?php echo $row_liste_deces['numodre_regdeces']; ?></strong></td>
                                            <td valign="middle" class="Style11">&nbsp;</td>
                                            <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_deces['noordre_ecrou']; ?></strong></td>
                                            <td align="left" valign="top"><strong>Nom :<?php echo $row_liste_deces['nom_regmandat']; ?></strong>
                                              <strong><br>
                                              N&eacute;(e) le : <?php echo Change_formatDate($row_liste_deces['datnaisdet_ecrou']); ?></strong>
                                              <strong><br>A : <?php echo $row_liste_deces['lieunaisdet_ecrou']; ?></strong>
                                              <strong><br>Domiciliation : <?php echo $row_liste_deces['domicildet_ecrou']; ?></strong>
                                              <strong><br>Nationnalit&eacute; : </strong></td>
                                            <td align="center" valign="top" nowrap class="Style14"><strong>Date d'&eacute;crou : <br> 
                                              Titre de détention:<br> Jugement : <br></strong></td>
                                            <td valign="middle" class="Style11">&nbsp;</td>
                                            <td align="center" valign="middle" class="Style11">&nbsp;</td>
                                            <td align="center" valign="middle" class="Style11">&nbsp;</td>
                                            <td align="center" valign="middle" class="Style11">&nbsp;</td>
                                            <td valign="middle"><table >
                                              <tr align="center" class="Style16">
                                                <td nowrap><strong>
                                                  <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                  <a href="#" onClick="javascript:ouvre_popup('visual_regdeces.php?noregima=<?php echo $row_liste_deces['no_regcontrolnum']; ?>',480,450)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/mark.png" title="Visualiser" width="28" height="8">
                                                  <?php } ?>
                                                  </strong></td>
                                                <td nowrap><strong>
                                                  <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                  <a href="#" onClick="javascript:ouvre_popup('modif_regdeces.php?noregima=<?php echo $row_liste_deces['no_regcontrolnum']; ?>',500,330)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/rename.png" title="Modifier" width="28" height="8">
                                                  <?php } ?>
                                                  </strong></td>
                                                <td nowrap><strong>
                                                  <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                  <a href="liste_deces.php?noregima=<?php echo $row_liste_deces['no_regcontrolnum']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/cancel.png" title="Supprimer" width="28">
                                                  <?php } ?>
                                                  </strong></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                          <?php } while ($row_liste_deces = mysql_fetch_assoc($liste_deces)); ?>
                                      </table></td>
                                    </tr>
                                  </table>
                                    <br>
                                    <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                      <tr class="Style14">
                                        <td><a href="<?php printf("%s?pageNum_liste_deces=%d%s", $currentPage, max(0, $pageNum_liste_deces - 1), $queryString_liste_deces); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                        <td><a href="<?php printf("%s?pageNum_liste_deces=%d%s", $currentPage, min($totalPages_liste_deces, $pageNum_liste_deces + 1), $queryString_liste_deces); ?>"><strong>Suivant&raquo;</strong></a></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><strong>Page</strong></td>
                                        <td><strong><?php echo $pageNum_liste_deces+1 ?>/<?php echo $totalPages_liste_deces+1; ?></strong></td>
                                        <td>&nbsp;</td>
                                        <td><strong>Enrg de <?php echo $startRow_liste_deces+1; ?> &agrave; 30 </strong></td>
                                        <td><strong>Total </strong></td>
                                        <td><strong><?php echo $totalRows_liste_deces ?> </strong></td>
                                      </tr>
                                  </table></td>
                              </tr>
                              <?php } // Show if recordset not empty ?>
                              <?php if ($totalRows_liste_deces == 0) { // Show if recordset empty ?>
                              <tr>
                                <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                              </tr>
                              <?php } // Show if recordset empty ?>
                          </table></div></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
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
mysql_free_result($liste_deces);

mysql_free_result($select_juridic);

mysql_free_result($select_admin);
?>
