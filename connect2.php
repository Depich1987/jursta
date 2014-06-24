<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Civile,Penale,Administrateur,Sociale,Penitentiaire,Superviseur";
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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
<script src="js/common.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
  <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#datepicker1" ).datepicker();
	$( "#datepicker" ).datepicker();
  });
  </script><style type="text/css">
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
<table align="center" cellpadding="0" cellspacing="0">
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
   <?php if ($row_select_juridiction['id_juridiction'] != 55) { ?>
   <td valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?> </td>
   <?php } else  {?>
   <td valign="top" background="images/continue.jpg" width="50%">&nbsp;</td>
   <?php } ?>
    <td valign="top"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
 
    <td><table border="0" cellpadding="0" cellspacing="0" id="Tableau_01">
      <tr>
        <td colspan="28"><img border="0" src="images/fond-dec_01.jpg"></td>
        </tr>
      <tr>
        <td colspan="2" rowspan="4"><img border="0" src="images/fond-dec_02.jpg"></td>
        <td colspan="2" rowspan="4"><img border="0" src="images/fond-dec_03.jpg"></td>
        <td colspan="24"><img border="0" src="images/fond-dec_04.jpg"></td>
        </tr>
      <tr>
        <td colspan="20"><img border="0" src="images/fond-dec_05.jpg"></td>
        <td colspan="2" rowspan="2"><img border="0" src="images/fond-dec_06.jpg"></td>
        <td colspan="2" rowspan="2"><img border="0" src="images/fond-dec_07.jpg"></td>
        </tr>
      <tr>
        <td colspan="9" rowspan="2"><img border="0" src="images/fond-dec_08.jpg" title=""></td>
        <td colspan="2" rowspan="4"><?php if ($row_select_juridiction['id_juridiction'] == 55) {?><a href="organisation_judiciares.php"><?php }?><img border="0" src="images/fond-dec_09.jpg" title="Organisation des juridictions"><?php if ($row_select_juridiction['id_juridiction'] == 55) {?></a><?php }?></td>
        <td colspan="9"><img border="0" src="images/fond-dec_10.jpg"></td>
        </tr>
      <tr>
        <td colspan="8" rowspan="3"><img border="0" src="images/fond-dec_11.jpg"></td>
        <td colspan="4" rowspan="3"><img border="0" src="images/fond-dec_12.jpg"></td>
        <td rowspan="18" valign="top"><img border="0" src="images/fond-dec_13.jpg"></td>
        </tr>
      <tr>
        <td rowspan="17" valign="top"><img border="0" src="images/fond-dec_14.jpg"></td>
        <td colspan="5"><img border="0" src="images/fond-dec_15.jpg"></td>
        <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_16.jpg"></td>
        </tr>
      <tr>
        <td colspan="5" rowspan="4"><img border="0" src="images/fond-dec_17.jpg"></td>
        </tr>
      <tr>
        <td colspan="3" rowspan="2"><img border="0" src="images/fond-dec_18.jpg"></td>
        <td colspan="11"><?php if ($row_select_juridiction['id_juridiction'] == 55) {?><a href="organisation_judiciares.php"><?php }?><img border="0" src="images/fond-dec_19.jpg"><?php if ($row_select_juridiction['id_juridiction'] == 55) {?></a><?php }?></td>
        <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_20.jpg"></td>
        </tr>
      <tr>
        <td colspan="11"><img border="0" src="images/fond-dec_21.jpg"></td>
        </tr>
      <tr>
        <td valign="top"><img border="0" src="images/fond-dec_22.jpg"></td>
        <td colspan="2" valign="top"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="param_base.php"><?php }?><img border="0" src="images/fond-dec_23.jpg" title="Paramètres de base"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?></a><?php }?></td>
        <td colspan="10" rowspan="3" valign="top"><img border="0" src="images/fond-dec_24.jpg"></td>
        <td colspan="3" valign="top"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="admin_penitentiaires.php"><?php } ?><?php if ($row_select_juridiction['id_juridiction'] != 55) { ?><a href="admin_penitentiairesconsulte.php"><?php } ?><img border="0" src="images/fond-dec_25.jpg" title="Administration pénitentiaires"><?php if ($row_select_juridiction['id_juridiction'] >= 0) { ?></a><?php } ?></td>
        <td colspan="5"><a href="admin_penales.php"><img border="0" src="images/fond-dec_26.jpg"></a></td>
        </tr>
      <tr>
        <td colspan="2" rowspan="12" valign="top"><img border="0" src="images/fond-dec_27.jpg"></td>
        <td colspan="6" valign="top"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="param_base.php"><?php }?><img border="0" src="images/fond-dec_28.jpg"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?></a><?php }?></td>
        <td colspan="7" valign="top"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="admin_penitentiaires.php"><?php } ?><?php if ($row_select_juridiction['id_juridiction'] != 55) { ?><a href="admin_penitentiairesconsulte.php"><?php } ?><img border="0" src="images/fond-dec_29.jpg"><?php if ($row_select_juridiction > 0) { ?></a><?php } ?></td>
        <td rowspan="12" valign="top"><img border="0" src="images/fond-dec_30.jpg"></td>
        </tr>
      <tr>
        <td colspan="6"><img border="0" src="images/fond-dec_31.jpg"></td>
        <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_32.jpg"></td>
        </tr>
      <tr>
        <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_33.jpg"></td>
        <td colspan="2" rowspan="2"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="etats_edition.php"><?php } ?><img border="0" src="images/fond-dec_34.jpg" title="Etats et Editions"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?></a><?php } ?></td>
        <td colspan="9"><img border="0" src="images/fond-dec_35.jpg"></td>
        </tr>
      <tr>
        <td colspan="7"><img border="0" src="images/fond-dec_36.jpg"></td>
        <td colspan="4" rowspan="2"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="autresdonneestat.php"><?php } ?><?php if ($row_select_juridiction['id_juridiction'] != 55) { ?><a href="autresdonneestatconsulte.php"><?php } ?><img border="0" src="images/fond-dec_37.jpg" title="Autres Données Statistiques"><?php if ($row_select_juridiction['id_juridiction'] >= 0) { ?></a><?php } ?></td>
        <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_38.jpg"></td>
        </tr>
      <tr>
        <td colspan="2" rowspan="6" valign="top"><img border="0" src="images/fond-dec_39.jpg"></td>
        <td colspan="6" rowspan="2" valign="top"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="etats_edition.php"><?php } ?><img border="0" src="images/fond-dec_40.jpg" title="" width="194" height="34"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?></a><?php } ?></td>
        <td colspan="6"><img border="0" src="images/fond-dec_41.jpg"></td>
        </tr>
      <tr>
        <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_42.jpg"></td>
        <td colspan="9"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="autresdonneestat.php"><?php } ?><?php if ($row_select_juridiction['id_juridiction'] != 55) { ?><a href="autresdonneestatconsulte.php"><?php } ?><img border="0" src="images/fond-dec_43.jpg" width="318" height="31" title=""><?php if ($row_select_juridiction['id_juridiction'] >= 0) { ?></a><?php } ?></td>
        <td rowspan="7" valign="top"><img border="0" src="images/fond-dec_44.jpg"></td>
        </tr>
      <tr>
        <td colspan="6" rowspan="2"><img border="0" src="images/fond-dec_45.jpg"></td>
        <td colspan="9" rowspan="2"><img border="0" src="images/fond-dec_46.jpg"></td>
        </tr>
      <tr>
        <td><img border="0" src="images/fond-dec_47.jpg"></td>
        <td colspan="2"><a href="maj_data.php"><img border="0" src="images/fond-dec_48.jpg" title="Mise à Jour des Données"></a></td>
        <td colspan="2"><img border="0" src="images/fond-dec_49.jpg"></td>
        </tr>
      <tr>
        <td colspan="4" rowspan="2" valign="top"><img border="0" src="images/fond-dec_50.jpg"></td>
        <td colspan="9"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?><a href="maj_data.php"><?php } ?><img border="0" src="images/fond-dec_51.jpg"><?php if ($row_select_juridiction['id_juridiction'] == 55) { ?></a><?php } ?></td>
        <td colspan="7" rowspan="2" valign="top"><img border="0" src="images/fond-dec_52.jpg"></td>
        </tr>
      <tr>
        <td colspan="9" valign="top"><img border="0" src="images/fond-dec_53.jpg"></td>
        </tr>
      <tr>
        <td rowspan="2" valign="top"><img border="0" src="images/fond-dec_54.jpg"></td>
        <td colspan="20"><img border="0" src="images/fond-dec_55.jpg"></td>
        <td rowspan="2" valign="top"><img border="0" src="images/fond-dec_56.jpg"></td>
        </tr>
      <tr>
        <td colspan="20" valign="top"><img border="0" src="images/fond-dec_57.jpg"></td>
        </tr>
      <tr>
        <td><img border="0" src="images/spacer.gif" width="28" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="46" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="42" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="71" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="33" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="23" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="29" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="31" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="51" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="25" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="35" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="22" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="16" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="115" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="12" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="8" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="53" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="12" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="16" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="20" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="38" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="23" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="51" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="52" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="53" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="39" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="61" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="19" height="1" title=""></td>
        </tr>
    </table></td>
  </tr>
</table>
</td>
    <td width="50%" align="center" valign="top" background="images/continue.jpg">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
