<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Superviseur";
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
if ((isset($_GET['cpte'])) && ($_GET['cpte'] != "")) {
  $deleteSQL = sprintf("DELETE FROM administrateurs WHERE Id_admin=%s",
                       GetSQLValueString($_GET['cpte'], "int"));

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

$maxRows_liste_compte = 30;
$pageNum_liste_compte = 0;
if (isset($_GET['pageNum_liste_compte'])) {
  $pageNum_liste_compte = $_GET['pageNum_liste_compte'];
}
$startRow_liste_compte = $pageNum_liste_compte * $maxRows_liste_compte;

mysql_select_db($database_jursta, $jursta);
$query_liste_compte = "SELECT * FROM administrateurs, juridiction WHERE ((administrateurs.id_admincreation=".$row_select_admin['Id_admin'].") AND (administrateurs.id_juridiction=juridiction.id_juridiction)) ORDER BY nom_admin ASC";
$liste_compte = mysql_query($query_liste_compte, $jursta) or die(mysql_error());
$row_liste_compte = mysql_fetch_assoc($liste_compte);
$totalRows_liste_compte = mysql_num_rows($liste_compte);

$queryString_liste_compte = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_compte") == false && 
        stristr($param, "totalRows_liste_compte") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_compte = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_compte = sprintf("&totalRows_liste_compte=%d%s", $totalRows_liste_compte, $queryString_liste_compte);

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
   <?php if (($row_select_juridiction['id_juridiction'] != 55) && ($row_select_juridiction['id_juridiction'] != 0)) { ?>
   <td valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
   <?php } else  {?>
   <td valign="top" background="images/continue.jpg" width="50%">&nbsp;</td>
   <?php } ?>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#677787" class="Style28"><table width="100%" cellpadding="2" cellspacing="1" >
                          <tr bgcolor="#FFFFFF">
                            <td nowrap bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                                <a href="add_compte.php"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                                <?php } else {?>
                                <img src="images/edit.png" width="32" height="32" border="0">
                                <?php } ?></td>
                            <td width="100%" align="left" bgcolor="#174F8A"><div align="left"><span class="Style2">Liste des Comptes </span></div></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                          <?php if ($totalRows_liste_compte > 0) { // Show if recordset not empty ?>
                          <tr>
                            <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="1" class="Style11">
                                      <tr bgcolor="#677787" class="Style3">
                                        <td width="16%" align="center">#</td>
                                        <td>Nom et pr&eacute;noms - Email</td>
                                        <td width="17%" align="center">date de naissance </td>
                                        <td width="15%" align="center">sexe</td>
                                        <td width="26%" align="center" nowrap>Section admin</td>
                                        <td width="18%" align="center">Juridiction</td>
                                        <td width="18%" align="center">Droits</td>
                                        <td width="18%" align="center">Op&eacute;rations</td>
                                      </tr>
                                      <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_compte*$pageNum_liste_compte;
		?>
                                      <?php do { ?>
                                      <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                      <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                        <td align="center" valign="middle" class="Style22"><?php echo $i ?></td>
                                        <td width="100%" valign="middle" nowrap class="Style22"><strong><?php echo $row_liste_compte['nom_admin']; ?> <?php echo $row_liste_compte['prenoms_admin']; ?></strong><br>
                                            <?php echo $row_liste_compte['email_admin']; ?></td>
                                        <td align="center" valign="middle" nowrap class="Style22"><?php echo Change_formatDate($row_liste_compte['datenais_admin']); ?></td>
                                        <td align="center" valign="middle" nowrap class="Style22"><?php echo $row_liste_compte['sexe_admin']; ?></td>
                                        <td align="center" valign="middle" nowrap class="Style22"><?php echo $row_liste_compte['type_admin']; ?></td>
                                        <td valign="middle" nowrap class="Style22"><?php echo $row_liste_compte['lib_juridiction']; ?></td>
                                        <td valign="middle"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td bgcolor="#E9F2FB"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="Style10">
                                                  <tr bgcolor="#6186AF">
                                                    <td colspan="4"><div align="center">Droits sur les R&eacute;gistres </div></td>
                                                  </tr>
                                                  <tr align="center">
                                                    <td>Ajouter</td>
                                                    <td>Modifier</td>
                                                    <td>Visualiser</td>
                                                    <td>Supprimer</td>
                                                  </tr>
                                                  <tr align="center" bgcolor="#FFFFFF">
                                                    <td><?php if ($row_liste_compte['ajouter_admin']==1){ ?>
                                                        <img src="images/checklist.png" width="14" height="14">
                                                        <?php } ?></td>
                                                    <td><?php if ($row_liste_compte['modifier_admin']==1){ ?>
                                                        <img src="images/checklist.png" width="14" height="14">
                                                        <?php } ?></td>
                                                    <td><?php if ($row_liste_compte['visualiser_admin']==1){ ?>
                                                        <img src="images/checklist.png" width="14" height="14">
                                                        <?php } ?></td>
                                                    <td><?php if ($row_liste_compte['supprimer_admin']==1){ ?>
                                                        <img src="images/checklist.png" width="14" height="14">
                                                        <?php } ?></td>
                                                  </tr>
                                              </table></td>
                                            </tr>
                                        </table></td>
                                        <td valign="middle"><table width="72" height="33" >
                                            <tr align="center" class="Style16">
                                              <td nowrap><?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                  <a href="modif_compte.php?id=<?php echo $row_liste_compte['Id_admin']; ?>"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/rename.png" title="Modifier" width="28">
                                                  <?php } ?></td>
                                              <td nowrap><?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                  <a href="liste_compte.php?cpte=<?php echo $row_liste_compte['Id_admin']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                  <?php } else {?>
                                                  <img src="images/cancel.png" title="Supprimer" width="28">
                                                  <?php } ?></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                      <?php } while ($row_liste_compte = mysql_fetch_assoc($liste_compte)); ?>
                                  </table></td>
                                </tr>
                              </table>
                                <br>
                                <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                  <tr class="Style14">
                                    <td><a href="<?php printf("%s?pageNum_liste_compte=%d%s", $currentPage, max(0, $pageNum_liste_compte - 1), $queryString_liste_compte); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                    <td><a href="<?php printf("%s?pageNum_liste_compte=%d%s", $currentPage, min($totalPages_liste_compte, $pageNum_liste_compte + 1), $queryString_liste_compte); ?>"><strong>Suivant&raquo;</strong></a></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>Page</strong></td>
                                    <td><strong><?php echo $pageNum_liste_compte+1 ?>/<?php echo $totalPages_liste_compte+1; ?></strong></td>
                                    <td>&nbsp;</td>
                                    <td><strong>Enrg de <?php echo $startRow_liste_compte+1; ?> &agrave; 30 </strong></td>
                                    <td><strong>Total </strong></td>
                                    <td><strong><?php echo $totalRows_liste_compte ?> </strong></td>
                                  </tr>
                              </table></td>
                          </tr>
                          <?php } // Show if recordset not empty ?>
                          <?php if ($totalRows_liste_compte == 0) { // Show if recordset empty ?>
                          <tr>
                            <td height="40" align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                          </tr>
                          <?php } // Show if recordset empty ?>
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

?>
