<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
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
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php if ((isset($_POST['importation_cmd']) && ($_POST['importation_cmd']!="")) { ?>
<?php
mysql_select_db($database_jursta, $jursta);
$query_insert_plum = "SELECT * FROM plum_civil";
$insert_plum = mysql_query($query_insert_plum, $jursta) or die(mysql_error());
$row_insert_plum = mysql_fetch_assoc($insert_plum);
$totalRows_insert_plum = mysql_num_rows($insert_plum);

mysql_select_db($database_jursta, $jursta);
$query_insert_rcrexterne = "SELECT * FROM rcr_externe";
$insert_rcrexterne = mysql_query($query_insert_rcrexterne, $jursta) or die(mysql_error());
$row_insert_rcrexterne = mysql_fetch_assoc($insert_rcrexterne);
$totalRows_insert_rcrexterne = mysql_num_rows($insert_rcrexterne);

mysql_select_db($database_jursta, $jursta);
$query_insert_rcrinterne = "SELECT * FROM rcr_interne";
$insert_rcrinterne = mysql_query($query_insert_rcrinterne, $jursta) or die(mysql_error());
$row_insert_rcrinterne = mysql_fetch_assoc($insert_rcrinterne);
$totalRows_insert_rcrinterne = mysql_num_rows($insert_rcrinterne);

mysql_select_db($database_jursta, $jursta);
$query_insert_regalphabet = "SELECT * FROM reg_alphabdet";
$insert_regalphabet = mysql_query($query_insert_regalphabet, $jursta) or die(mysql_error());
$row_insert_regalphabet = mysql_fetch_assoc($insert_regalphabet);
$totalRows_insert_regalphabet = mysql_num_rows($insert_regalphabet);

mysql_select_db($database_jursta, $jursta);
$query_insert_regconsignation = "SELECT * FROM reg_consignations";
$insert_regconsignation = mysql_query($query_insert_regconsignation, $jursta) or die(mysql_error());
$row_insert_regconsignation = mysql_fetch_assoc($insert_regconsignation);
$totalRows_insert_regconsignation = mysql_num_rows($insert_regconsignation);

mysql_select_db($database_jursta, $jursta);
$query_insert_regcontrolnum = "SELECT * FROM reg_controlnum";
$insert_regcontrolnum = mysql_query($query_insert_regcontrolnum, $jursta) or die(mysql_error());
$row_insert_regcontrolnum = mysql_fetch_assoc($insert_regcontrolnum);
$totalRows_insert_regcontrolnum = mysql_num_rows($insert_regcontrolnum);

mysql_select_db($database_jursta, $jursta);
$query_insert_regecrou = "SELECT * FROM reg_ecrou";
$insert_regecrou = mysql_query($query_insert_regecrou, $jursta) or die(mysql_error());
$row_insert_regecrou = mysql_fetch_assoc($insert_regecrou);
$totalRows_insert_regecrou = mysql_num_rows($insert_regecrou);

mysql_select_db($database_jursta, $jursta);
$query_insert_regexecpeine = "SELECT * FROM reg_execpeine";
$insert_regexecpeine = mysql_query($query_insert_regexecpeine, $jursta) or die(mysql_error());
$row_insert_regexecpeine = mysql_fetch_assoc($insert_regexecpeine);
$totalRows_insert_regexecpeine = mysql_num_rows($insert_regexecpeine);

mysql_select_db($database_jursta, $jursta);
$query_insert_regmandat = "SELECT * FROM reg_mandat";
$insert_regmandat = mysql_query($query_insert_regmandat, $jursta) or die(mysql_error());
$row_insert_regmandat = mysql_fetch_assoc($insert_regmandat);
$totalRows_insert_regmandat = mysql_num_rows($insert_regmandat);

mysql_select_db($database_jursta, $jursta);
$query_insert_regmdepot = "SELECT * FROM reg_mdepot";
$insert_regmdepot = mysql_query($query_insert_regmdepot, $jursta) or die(mysql_error());
$row_insert_regmdepot = mysql_fetch_assoc($insert_regmdepot);
$totalRows_insert_regmdepot = mysql_num_rows($insert_regmdepot);

mysql_select_db($database_jursta, $jursta);
$query_insert_regobjdep = "SELECT * FROM reg_objdep";
$insert_regobjdep = mysql_query($query_insert_regobjdep, $jursta) or die(mysql_error());
$row_insert_regobjdep = mysql_fetch_assoc($insert_regobjdep);
$totalRows_insert_regobjdep = mysql_num_rows($insert_regobjdep);

mysql_select_db($database_jursta, $jursta);
$query_insert_regplaintes = "SELECT * FROM reg_plaintes";
$insert_regplaintes = mysql_query($query_insert_regplaintes, $jursta) or die(mysql_error());
$row_insert_regplaintes = mysql_fetch_assoc($insert_regplaintes);
$totalRows_insert_regplaintes = mysql_num_rows($insert_regplaintes);

mysql_select_db($database_jursta, $jursta);
$query_insert_regscelle = "SELECT * FROM reg_scelle";
$insert_regscelle = mysql_query($query_insert_regscelle, $jursta) or die(mysql_error());
$row_insert_regscelle = mysql_fetch_assoc($insert_regscelle);
$totalRows_insert_regscelle = mysql_num_rows($insert_regscelle);

mysql_select_db($database_jursta, $jursta);
$query_insert_regsuiviepc = "SELECT * FROM reg_suiviepc";
$insert_regsuiviepc = mysql_query($query_insert_regsuiviepc, $jursta) or die(mysql_error());
$row_insert_regsuiviepc = mysql_fetch_assoc($insert_regsuiviepc);
$totalRows_insert_regsuiviepc = mysql_num_rows($insert_regsuiviepc);

mysql_select_db($database_jursta, $jursta);
$query_insert_regvrad = "SELECT * FROM reg_vrad";
$insert_regvrad = mysql_query($query_insert_regvrad, $jursta) or die(mysql_error());
$row_insert_regvrad = mysql_fetch_assoc($insert_regvrad);
$totalRows_insert_regvrad = mysql_num_rows($insert_regvrad);

mysql_select_db($database_jursta, $jursta);
$query_insert_regvrlc = "SELECT * FROM reg_vrlc";
$insert_regvrlc = mysql_query($query_insert_regvrlc, $jursta) or die(mysql_error());
$row_insert_regvrlc = mysql_fetch_assoc($insert_regvrlc);
$totalRows_insert_regvrlc = mysql_num_rows($insert_regvrlc);

mysql_select_db($database_jursta, $jursta);
$query_insert_regvrmlp = "SELECT * FROM reg_vrmlp";
$insert_regvrmlp = mysql_query($query_insert_regvrmlp, $jursta) or die(mysql_error());
$row_insert_regvrmlp = mysql_fetch_assoc($insert_regvrmlp);
$totalRows_insert_regvrmlp = mysql_num_rows($insert_regvrmlp);

mysql_select_db($database_jursta, $jursta);
$query_insert_repactesacc = "SELECT * FROM rep_actesacc";
$insert_repactesacc = mysql_query($query_insert_repactesacc, $jursta) or die(mysql_error());
$row_insert_repactesacc = mysql_fetch_assoc($insert_repactesacc);
$totalRows_insert_repactesacc = mysql_num_rows($insert_repactesacc);

mysql_select_db($database_jursta, $jursta);
$query_insert_repactesnot = "SELECT * FROM rep_actesnot";
$insert_repactesnot = mysql_query($query_insert_repactesnot, $jursta) or die(mysql_error());
$row_insert_repactesnot = mysql_fetch_assoc($insert_repactesnot);
$totalRows_insert_repactesnot = mysql_num_rows($insert_repactesnot);

mysql_select_db($database_jursta, $jursta);
$query_insert_repdecision = "SELECT * FROM rep_decision";
$insert_repdecision = mysql_query($query_insert_repdecision, $jursta) or die(mysql_error());
$row_insert_repdecision = mysql_fetch_assoc($insert_repdecision);
$totalRows_insert_repdecision = mysql_num_rows($insert_repdecision);

mysql_select_db($database_jursta, $jursta);
$query_insert_repjugementcorr = "SELECT * FROM rep_jugementcorr";
$insert_repjugementcorr = mysql_query($query_insert_repjugementcorr, $jursta) or die(mysql_error());
$row_insert_repjugementcorr = mysql_fetch_assoc($insert_repjugementcorr);
$totalRows_insert_repjugementcorr = mysql_num_rows($insert_repjugementcorr);

mysql_select_db($database_jursta, $jursta);
$query_insert_repjugementsupp = "SELECT * FROM rep_jugementsupp";
$insert_repjugementsupp = mysql_query($query_insert_repjugementsupp, $jursta) or die(mysql_error());
$row_insert_repjugementsupp = mysql_fetch_assoc($insert_repjugementsupp);
$totalRows_insert_repjugementsupp = mysql_num_rows($insert_repjugementsupp);

mysql_select_db($database_jursta, $jursta);
$query_insert_repordpresi = "SELECT * FROM rep_ordpresi";
$insert_repordpresi = mysql_query($query_insert_repordpresi, $jursta) or die(mysql_error());
$row_insert_repordpresi = mysql_fetch_assoc($insert_repordpresi);
$totalRows_insert_repordpresi = mysql_num_rows($insert_repordpresi);

mysql_select_db($database_jursta, $jursta);
$query_insert_rgsocial = "SELECT * FROM rg_social";
$insert_rgsocial = mysql_query($query_insert_rgsocial, $jursta) or die(mysql_error());
$row_insert_rgsocial = mysql_fetch_assoc($insert_rgsocial);
$totalRows_insert_rgsocial = mysql_num_rows($insert_rgsocial);

mysql_select_db($database_jursta, $jursta);
$query_insert_rolegeneral = "SELECT * FROM role_general";
$insert_rolegeneral = mysql_query($query_insert_rolegeneral, $jursta) or die(mysql_error());
$row_insert_rolegeneral = mysql_fetch_assoc($insert_rolegeneral);
$totalRows_insert_rolegeneral = mysql_num_rows($insert_rolegeneral);
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
    <td width="50%" valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
    <td valign="top"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
    <td valign="top" background="images/continue.jpg" width="50%">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
