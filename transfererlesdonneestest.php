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
<?php
require_once('Connections/jursta.php');
?>
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
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>              <?php 
if ($totalRows_insert_plum > 0) {
	$chaine=$chaine."Delete from plum_civil where id_juridiction=".$row_select_juridiction['id_juridiction'].";"; 
	do {
		$chaine=$chaine."Insert into plum_civil (id_plumcivil,presi_plumcivil,greffier_plumcivil,accesseurs_plumcivil,observ_plumcivil,Id_admin,date_creation,no_rolegeneral,id_juridiction) values (".$row_insert_plum['id_plumcivil'].",".$row_insert_plum['presi_plumcivil'].",".$row_insert_plum['greffier_plumcivil'].",".$row_insert_plum['accesseurs_plumcivil'].",".$row_insert_plum['observ_plumcivil'].",".$row_insert_plum['Id_admin'].",".$row_insert_plum['date_creation'].",".$row_insert_plum['no_rolegeneral'].",".$row_insert_plum['id_juridiction'].");";
	} while ($row_insert_plum = mysql_fetch_assoc($insert_plum));
}
?>
              <?php 
if ($totalRows_insert_rcrexterne > 0) {
	$chaine=$chaine."Delete from rcr_externe where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rcr_externe (no_rcrexterne,noordre_rcrexterne,datedepart_rcrexterne,destinataire_rcrexterne,objet_rcrexterne,observation_rcrexterne,id_juridiction,Id_admin,date_creation) values (".$row_insert_rcrexterne['no_rcrexterne'].",".$row_insert_rcrexterne['noordre_rcrexterne'].",".$row_insert_rcrexterne['datedepart_rcrexterne'].",".$row_insert_rcrexterne['destinataire_rcrexterne'].",".$row_insert_rcrexterne['objet_rcrexterne'].",".$row_insert_rcrexterne['observation_rcrexterne'].",".$row_insert_rcrexterne['id_juridiction'].",".$row_insert_rcrexterne['Id_admin'].",".$row_insert_rcrexterne['date_creation'].");";
	} while ($row_insert_rcrexterne = mysql_fetch_assoc($insert_rcrexterne));
}
?>
              <?php 
if ($totalRows_insert_rcrinterne > 0) {
	$chaine=$chaine."Delete from rcr_interne where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rcr_interne (no_rcrinterne,noordre_rcrinterne,datere&ccedil;u_rcrinterne,destinataire_rcrinterne,objet_rcrinterne,observation_rcrinterne,id_juridiction,Id_admin,date_creation) values (".$row_insert_rcrinterne['no_rcrinterne'].",".$row_insert_rcrinterne['noordre_rcrinterne'].",".$row_insert_rcrinterne['datere&ccedil;u_rcrinterne'].",".$row_insert_rcrinterne['destinataire_rcrinterne'].",".$row_insert_rcrinterne['objet_rcrinterne'].",".$row_insert_rcrinterne['observation_rcrinterne'].",".$row_insert_rcrinterne['id_juridiction'].",".$row_insert_rcrinterne['Id_admin'].",".$row_insert_rcrinterne['date_creation'].");";
	} while ($row_insert_rcrinterne = mysql_fetch_assoc($insert_rcrinterne));
}
?>
              <?php 
if ($totalRows_insert_regalphabet > 0) {
	$chaine=$chaine."Delete from reg_alphabdet where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_alphabdet (no_regalphabdet,asphys_regalphabdet,sexe_regalphabdet,moidat_regalphabdet,nomdet_regalphabdet,noecrou,datentre_regalphabdet,Id_admin,date_creation,id_juridiction) values (".$row_insert_regalphabet['no_regalphabdet'].",".$row_insert_regalphabet['asphys_regalphabdet'].",".$row_insert_regalphabet['sexe_regalphabdet'].",".$row_insert_regalphabet['moidat_regalphabdet'].",".$row_insert_regalphabet['nomdet_regalphabdet'].",".$row_insert_regalphabet['noecrou'].",".$row_insert_regalphabet['datentre_regalphabdet'].",".$row_insert_regalphabet['Id_admin'].",".$row_insert_regalphabet['date_creation'].",".$row_insert_regalphabet['id_juridiction'].");";
	} while ($row_insert_regalphabet = mysql_fetch_assoc($insert_regalphabet));
}
?>
              <?php 
if ($totalRows_insert_regconsignation > 0) {
	$chaine=$chaine."Delete from reg_consignations where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_consignations (no_regconsign,noordre_regconsign,date_regconsign,montant_regconsign,decision_regconsign,somareclam_regconsign,somarestit_regconsign,liquidation_regconsign,observation_regconsign,Id_admin,date_creation,no_rolegeneral,id_juridiction) values (".$row_insert_regconsignation['no_regconsign'].",".$row_insert_regconsignation['noordre_regconsign'].",".$row_insert_regconsignation['date_regconsign'].",".$row_insert_regconsignation['montant_regconsign'].",".$row_insert_regconsignation['decision_regconsign'].",".$row_insert_regconsignation['somareclam_regconsign'].",".$row_insert_regconsignation['somarestit_regconsign'].",".$row_insert_regconsignation['liquidation_regconsign'].",".$row_insert_regconsignation['observation_regconsign'].",".$row_insert_regconsignation['Id_admin'].",".$row_insert_regconsignation['date_creation'].",".$row_insert_regconsignation['no_rolegeneral'].",".$row_insert_regconsignation['id_juridiction'].");";
	} while ($row_insert_regconsignation = mysql_fetch_assoc($insert_regconsignation));
}
?>
              <?php 
if ($totalRows_insert_regcontrolnum > 0) {
	$chaine=$chaine."Delete from reg_controlnum where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_controlnum (no_regcontrolnum,noordre_regcontrolnum,sexe_regcontrolnum,date_regcontrolnum,nom_regcontrolnum,procureur_regcontrolnum,naturdelit_regcontrolnum,Id_admin,date_creation,no_regmandat,id_juridiction) values (".$row_insert_regcontrolnum['no_regcontrolnum'].",".$row_insert_regcontrolnum['noordre_regcontrolnum'].",".$row_insert_regcontrolnum['sexe_regcontrolnum'].",".$row_insert_regcontrolnum['date_regcontrolnum'].",".$row_insert_regcontrolnum['nom_regcontrolnum'].",".$row_insert_regcontrolnum['procureur_regcontrolnum'].",".$row_insert_regcontrolnum['naturdelit_regcontrolnum'].",".$row_insert_regcontrolnum['Id_admin'].",".$row_insert_regcontrolnum['date_creation'].",".$row_insert_regcontrolnum['no_regmandat'].",".$row_insert_regcontrolnum['id_juridiction'].");";
	} while ($row_insert_regcontrolnum = mysql_fetch_assoc($insert_regcontrolnum));
}
?>
              <?php 
if ($totalRows_insert_regecrou > 0) {
	$chaine=$chaine."Delete from reg_ecrou where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_ecrou (no_ecrou,noordre_ecrou,datnaisdet_ecrou,lieunaisdet_ecrou,peredet_ecrou,meredet_ecrou,professiondet_ecrou,domicildet_ecrou,tailledet_ecrou,frontdet_ecrou,nezdet_ecrou,bouchedet_ecrou,teintdet_ecrou,signepartdet_ecrou,datenter_ecrou,prolongdet_ecrou,decisionjudic_ecrou,type_voiederecours,datedebutpeine_ecrou,dateexpirpeine_ecrou,datsortidet_ecrou,motifssortidet_ecrou,observation_ecrou,no_regmandat,no_regcontrolnum,id_juridiction,Id_admin,date_creation) values (".$row_insert_regecrou['no_ecrou'].",".$row_insert_regecrou['noordre_ecrou'].",".$row_insert_regecrou['datnaisdet_ecrou'].",".$row_insert_regecrou['lieunaisdet_ecrou'].",".$row_insert_regecrou['peredet_ecrou'].",".$row_insert_regecrou['meredet_ecrou'].",".$row_insert_regecrou['professiondet_ecrou'].",".$row_insert_regecrou['domicildet_ecrou'].",".$row_insert_regecrou['tailledet_ecrou'].",".$row_insert_regecrou['frontdet_ecrou'].",".$row_insert_regecrou['nezdet_ecrou'].",".$row_insert_regecrou['bouchedet_ecrou'].",".$row_insert_regecrou['teintdet_ecrou'].",".$row_insert_regecrou['signepartdet_ecrou'].",".$row_insert_regecrou['datenter_ecrou'].",".$row_insert_regecrou['prolongdet_ecrou'].",".$row_insert_regecrou['decisionjudic_ecrou'].",".$row_insert_regecrou['type_voiederecours'].",".$row_insert_regecrou['datedebutpeine_ecrou'].",".$row_insert_regecrou['dateexpirpeine_ecrou'].",".$row_insert_regecrou['datsortidet_ecrou'].",".$row_insert_regecrou['motifssortidet_ecrou'].",".$row_insert_regecrou['observation_ecrou'].",".$row_insert_regecrou['no_regmandat'].",".$row_insert_regecrou['no_regcontrolnum'].",".$row_insert_regecrou['id_juridiction'].",".$row_insert_regecrou['Id_admin'].",".$row_insert_regecrou['date_creation'].");";
	} while ($row_insert_regecrou = mysql_fetch_assoc($insert_regecrou));
}
?>
              <?php 
if ($totalRows_insert_regexecpeine > 0) {
	$chaine=$chaine."Delete from reg_execpeine where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_execpeine (noscelles,nodordre_scelle,datedepot_scelle,Nomdeposant_scelle,objetsdepose_scelle,observation_scelle,Id_admin,date_creation,id_juridiction) values (".$row_insert_regexecpeine['noscelles'].",".$row_insert_regexecpeine['nodordre_scelle'].",".$row_insert_regexecpeine['datedepot_scelle'].",".$row_insert_regexecpeine['Nomdeposant_scelle'].",".$row_insert_regexecpeine['objetsdepose_scelle'].",".$row_insert_regexecpeine['observation_scelle'].",".$row_insert_regexecpeine['Id_admin'].",".$row_insert_regexecpeine['date_creation'].",".$row_insert_regexecpeine['id_juridiction'].");";
	} while ($row_insert_regexecpeine = mysql_fetch_assoc($insert_regexecpeine));
}
?>
              <?php 
if ($totalRows_insert_regmandat > 0) {
	$chaine=$chaine."Delete from reg_mandat where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_mandat (no_regmandat,noordre_regmandat,date_regmandat,nom_regmandat,magistra_regmandat,infraction_regmandat,Id_admin,date_creation,type_regmandat,id_juridiction) values (".$row_insert_regmandat['no_regmandat'].",".$row_insert_regmandat['noordre_regmandat'].",".$row_insert_regmandat['date_regmandat'].",".$row_insert_regmandat['nom_regmandat'].",".$row_insert_regmandat['magistra_regmandat'].",".$row_insert_regmandat['infraction_regmandat'].",".$row_insert_regmandat['Id_admin'].",".$row_insert_regmandat['date_creation'].",".$row_insert_regmandat['type_regmandat'].",".$row_insert_regmandat['id_juridiction'].");";
	} while ($row_insert_regmandat = mysql_fetch_assoc($insert_regmandat));
}
?>
              <?php 
if ($totalRows_insert_regmdepot > 0) {
	$chaine=$chaine."Delete from reg_mdepot where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_mdepot (no_regmdepot,noordre_regmdepot,date_regmdepot,nom_regmdepot,magistra_regmdepot,infraction_regmdepot,Id_admin,date_creation,id_juridiction) values (".$row_insert_regmdepot['no_regmdepot'].",".$row_insert_regmdepot['noordre_regmdepot'].",".$row_insert_regmdepot['date_regmdepot'].",".$row_insert_regmdepot['nom_regmdepot'].",".$row_insert_regmdepot['magistra_regmdepot'].",".$row_insert_regmdepot['infraction_regmdepot'].",".$row_insert_regmdepot['Id_admin'].",".$row_insert_regmdepot['date_creation'].",".$row_insert_regmdepot['id_juridiction'].");";
	} while ($row_insert_regmdepot = mysql_fetch_assoc($insert_regmdepot));
}
?>
              <?php 
if ($totalRows_insert_regobjdep > 0) {
	$chaine=$chaine."Delete from reg_objdep where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_objdep (no_regobjdep,datemd_regobjdep,nom_regobjdep,som_regobjdep,objet_redobjdep,observ_regobjdep,Id_admin,date_creation,id_juridiction) values (".$row_insert_regobjdep['no_regobjdep'].",".$row_insert_regobjdep['datemd_regobjdep'].",".$row_insert_regobjdep['nom_regobjdep'].",".$row_insert_regobjdep['som_regobjdep'].",".$row_insert_regobjdep['objet_redobjdep'].",".$row_insert_regobjdep['observ_regobjdep'].",".$row_insert_regobjdep['Id_admin'].",".$row_insert_regobjdep['date_creation'].",".$row_insert_regobjdep['id_juridiction'].");";
	} while ($row_insert_regobjdep = mysql_fetch_assoc($insert_regobjdep));
}
?>
              <?php 
if ($totalRows_insert_regplaintes > 0) {
	$chaine=$chaine."Delete from reg_plaintes where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_plaintes (no_regobjdep,datemd_regobjdep,nom_regobjdep,som_regobjdep,objet_redobjdep,observ_regobjdep,Id_admin,date_creation,id_juridiction) values (".$row_insert_regplaintes['no_regobjdep'].",".$row_insert_regplaintes['datemd_regobjdep'].",".$row_insert_regplaintes['nom_regobjdep'].",".$row_insert_regplaintes['som_regobjdep'].",".$row_insert_regplaintes['objet_redobjdep'].",".$row_insert_regplaintes['observ_regobjdep'].",".$row_insert_regplaintes['Id_admin'].",".$row_insert_regplaintes['date_creation'].",".$row_insert_regplaintes['id_juridiction'].");";
	} while ($row_insert_regplaintes = mysql_fetch_assoc($insert_regplaintes));
}
?>
              <?php 
if ($totalRows_insert_regscelle > 0) {
	$chaine=$chaine."Delete from reg_scelle where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_scelle (no_regscel,nodordre_regscel,datedepo_regscel,nomdeposant_regscel,objetdepo_regscel,observation_regscel,Id_admin,date_creation,id_juridiction) values (".$row_insert_regscelle['no_regscel'].",".$row_insert_regscelle['nodordre_regscel'].",".$row_insert_regscelle['datedepo_regscel'].",".$row_insert_regscelle['nomdeposant_regscel'].",".$row_insert_regscelle['objetdepo_regscel'].",".$row_insert_regscelle['observation_regscel'].",".$row_insert_regscelle['Id_admin'].",".$row_insert_regscelle['date_creation'].",".$row_insert_regscelle['id_juridiction'].");";
	} while ($row_insert_regscelle = mysql_fetch_assoc($insert_regscelle));
}
?>
              <?php 
if ($totalRows_insert_regsuiviepc > 0) {
	$chaine=$chaine."Delete from reg_suiviepc where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_suiviepc (no_suiviepc,no_dordresuiviepc,autdorigine_suiviepc,nodatepv_suiviepc,prevenus_suiviepc,naturescelle_suiviepc,magasinlieuconserv_suiviepc,coffrefortlieuconserv_suiviepc,nojugedecision_suiviepc,noordonancedestruct_suiviepc,noordonanceremisedom_suiviepc,daterestitution_suivepc,nocnicsrestitution_suiviepc,emargementrestitution_suiviepc,observation_suiviepc,date_creation,Id_admin,id_juridiction) values (".$row_insert_regsuiviepc['no_suiviepc'].",".$row_insert_regsuiviepc['no_dordresuiviepc'].",".$row_insert_regsuiviepc['autdorigine_suiviepc'].",".$row_insert_regsuiviepc['nodatepv_suiviepc'].",".$row_insert_regsuiviepc['prevenus_suiviepc'].",".$row_insert_regsuiviepc['naturescelle_suiviepc'].",".$row_insert_regsuiviepc['magasinlieuconserv_suiviepc'].",".$row_insert_regsuiviepc['coffrefortlieuconserv_suiviepc'].",".$row_insert_regsuiviepc['nojugedecision_suiviepc'].",".$row_insert_regsuiviepc['noordonancedestruct_suiviepc'].",".$row_insert_regsuiviepc['noordonanceremisedom_suiviepc'].",".$row_insert_regsuiviepc['daterestitution_suivepc'].",".$row_insert_regsuiviepc['nocnicsrestitution_suiviepc'].",".$row_insert_regsuiviepc['emargementrestitution_suiviepc'].",".$row_insert_regsuiviepc['observation_suiviepc'].",".$row_insert_regsuiviepc['date_creation'].",".$row_insert_regsuiviepc['Id_admin'].",".$row_insert_regsuiviepc['id_juridiction'].");";
	} while ($row_insert_regsuiviepc = mysql_fetch_assoc($insert_regsuiviepc));
}
?>
              <?php 
if ($totalRows_insert_regvrad > 0) {
	$chaine=$chaine."Delete from reg_vrad where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_vrad (no_regvrad,noodre_regvrad,nomdet_regvrad,datmd_regvrad,datjug_regvrad,datdemande_regvrad,peine_regvrad,delit_regvrad,parquet_regvrad,nobatetcel_regvrad,Id_admin,date_creation,id_juridiction) values (".$row_insert_regvrad['no_regvrad'].",".$row_insert_regvrad['noodre_regvrad'].",".$row_insert_regvrad['nomdet_regvrad'].",".$row_insert_regvrad['datmd_regvrad'].",".$row_insert_regvrad['datjug_regvrad'].",".$row_insert_regvrad['datdemande_regvrad'].",".$row_insert_regvrad['peine_regvrad'].",".$row_insert_regvrad['delit_regvrad'].",".$row_insert_regvrad['parquet_regvrad'].",".$row_insert_regvrad['nobatetcel_regvrad'].",".$row_insert_regvrad['Id_admin'].",".$row_insert_regvrad['date_creation'].",".$row_insert_regvrad['id_juridiction'].");";
	} while ($row_insert_regvrad = mysql_fetch_assoc($insert_regvrad));
}
?>
              <?php 
if ($totalRows_insert_regvrlc > 0) {
	$chaine=$chaine."Delete from reg_vrlc where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_vrlc (no_regvrlc,noordre_regvrlc,nomdet_regvrlc,datmd_regvrlc,delit_regvrlc,peine_regvrlc,observ_regvrlc,Id_admin,date_creation,id_juridiction) values (".$row_insert_regvrlc['no_regvrlc'].",".$row_insert_regvrlc['noordre_regvrlc'].",".$row_insert_regvrlc['nomdet_regvrlc'].",".$row_insert_regvrlc['datmd_regvrlc'].",".$row_insert_regvrlc['delit_regvrlc'].",".$row_insert_regvrlc['peine_regvrlc'].",".$row_insert_regvrlc['observ_regvrlc'].",".$row_insert_regvrlc['Id_admin'].",".$row_insert_regvrlc['date_creation'].",".$row_insert_regvrlc['id_juridiction'].");";
	} while ($row_insert_regvrlc = mysql_fetch_assoc($insert_regvrlc));
}
?>
              <?php 
if ($totalRows_insert_regvrmlp > 0) {
	$chaine=$chaine."Delete from reg_vrmlp where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into reg_vrmlp (no_regvrmlp,noordre_regvrmlp,datdemand_regvrmlp,nomdet_regvrmlp,Id_admin,date_creation,id_juridiction) values (".$row_insert_regvrmlp['no_regvrmlp'].",".$row_insert_regvrmlp['noordre_regvrmlp'].",".$row_insert_regvrmlp['datdemand_regvrmlp'].",".$row_insert_regvrmlp['nomdet_regvrmlp'].",".$row_insert_regvrmlp['Id_admin'].",".$row_insert_regvrmlp['date_creation'].",".$row_insert_regvrmlp['id_juridiction'].");";
	} while ($row_insert_regvrmlp = mysql_fetch_assoc($insert_regvrmlp));
}
?>
              <?php 
if ($totalRows_insert_repactesacc > 0) {
	$chaine=$chaine."Delete from rep_actesacc where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rep_actesacc (no_repactesacc,nodordre_acc,date_acc,nomparties_acc,designationacte_acc,Id_admin,date_creation,section_rolegeneral,id_categorieaffaire,id_juridiction) values (".$row_insert_repactesacc['no_repactesacc'].",".$row_insert_repactesacc['nodordre_acc'].",".$row_insert_repactesacc['date_acc'].",".$row_insert_repactesacc['nomparties_acc'].",".$row_insert_repactesacc['designationacte_acc'].",".$row_insert_repactesacc['Id_admin'].",".$row_insert_repactesacc['date_creation'].",".$row_insert_repactesacc['section_rolegeneral'].",".$row_insert_repactesacc['id_categorieaffaire'].",".$row_insert_repactesacc['id_juridiction'].");";
	} while ($row_insert_repactesacc = mysql_fetch_assoc($insert_repactesacc));
}
?>
              <?php 
if ($totalRows_insert_repactesnot > 0) {
	$chaine=$chaine."Delete from rep_actesnot where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rep_actesnot (no_repactesnot,dateaudience_repactesnot,noordre_repactesnot,demandeur_repactesnot,requerant_repactesnot,natdossier_repactesnot,Id_admin,date_creation,id_categorieaffaire,section_rolegeneral,id_juridiction) values (".$row_insert_repactesnot['no_repactesnot'].",".$row_insert_repactesnot['dateaudience_repactesnot'].",".$row_insert_repactesnot['noordre_repactesnot'].",".$row_insert_repactesnot['demandeur_repactesnot'].",".$row_insert_repactesnot['requerant_repactesnot'].",".$row_insert_repactesnot['natdossier_repactesnot'].",".$row_insert_repactesnot['Id_admin'].",".$row_insert_repactesnot['date_creation'].",".$row_insert_repactesnot['id_categorieaffaire'].",".$row_insert_repactesnot['section_rolegeneral'].",".$row_insert_repactesnot['id_juridiction'].");";
	} while ($row_insert_repactesnot = mysql_fetch_assoc($insert_repactesnot));
}
?>
              <?php 
if ($totalRows_insert_repdecision > 0) {
	$chaine=$chaine."Delete from rep_decision where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rep_decision (no_decision,nodec_decision,dispositif_decision,observation_decision,Id_admin,date_creation,no_rgsocial,statut_decision,id_juridiction) values (".$row_insert_repdecision['no_decision'].",".$row_insert_repdecision['nodec_decision'].",".$row_insert_repdecision['dispositif_decision'].",".$row_insert_repdecision['observation_decision'].",".$row_insert_repdecision['Id_admin'].",".$row_insert_repdecision['date_creation'].",".$row_insert_repdecision['no_rgsocial'].",".$row_insert_repdecision['statut_decision'].",".$row_insert_repdecision['id_juridiction'].");";
	} while ($row_insert_repdecision = mysql_fetch_assoc($insert_repdecision));
}
?>
              <?php 
if ($totalRows_insert_repjugementcorr > 0) {
	$chaine=$chaine."Delete from rep_jugementcorr where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rep_jugementcorr (no_repjugementcorr,nojugement_repjugementcorr,datejugement_repjugementcorr,nomsprevenu_repjugementcorr,infraction_repjugementcorr,naturedecision_repjugementcorr,decisiontribunal_repjugementcorr,Id_admin,date_creation,id_juridiction) values (".$row_insert_repjugementcorr['no_repjugementcorr'].",".$row_insert_repjugementcorr['nojugement_repjugementcorr'].",".$row_insert_repjugementcorr['datejugement_repjugementcorr'].",".$row_insert_repjugementcorr['nomsprevenu_repjugementcorr'].",".$row_insert_repjugementcorr['infraction_repjugementcorr'].",".$row_insert_repjugementcorr['naturedecision_repjugementcorr'].",".$row_insert_repjugementcorr['decisiontribunal_repjugementcorr'].",".$row_insert_repjugementcorr['Id_admin'].",".$row_insert_repjugementcorr['date_creation'].",".$row_insert_repjugementcorr['id_juridiction'].");";
	} while ($row_insert_repjugementcorr = mysql_fetch_assoc($insert_repjugementcorr));
}
?>
              <?php 
if ($totalRows_insert_repjugementsupp > 0) {
	$chaine=$chaine."Delete from rep_jugementsupp where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rep_jugementsupp (no_repjugementsupp,nojugement_repjugementsupp,dispositif_repjugementsupp,observation_repjugementsupp,Id_admin,date_creation,no_rolegeneral,statut_jugementsupp,id_juridiction) values (".$row_insert_repjugementsupp['no_repjugementsupp'].",".$row_insert_repjugementsupp['nojugement_repjugementsupp'].",".$row_insert_repjugementsupp['dispositif_repjugementsupp'].",".$row_insert_repjugementsupp['observation_repjugementsupp'].",".$row_insert_repjugementsupp['Id_admin'].",".$row_insert_repjugementsupp['date_creation'].",".$row_insert_repjugementsupp['no_rolegeneral'].",".$row_insert_repjugementsupp['statut_jugementsupp'].",".$row_insert_repjugementsupp['id_juridiction'].");";
	} while ($row_insert_repjugementsupp = mysql_fetch_assoc($insert_repjugementsupp));
}
?>
              <?php 
if ($totalRows_insert_repordpresi > 0) {
	$chaine=$chaine."Delete from rep_ordpresi where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rep_ordpresi (no_ordonnance,noordonnace_ordonnance,dispositif_ordonnance,observation_ordonnance,Id_admin,date_creation,no_rolegeneral,id_juridiction) values (".$row_insert_repordpresi['no_ordonnance'].",".$row_insert_repordpresi['noordonnace_ordonnance'].",".$row_insert_repordpresi['dispositif_ordonnance'].",".$row_insert_repordpresi['observation_ordonnance'].",".$row_insert_repordpresi['Id_admin'].",".$row_insert_repordpresi['date_creation'].",".$row_insert_repordpresi['no_rolegeneral'].",".$row_insert_repordpresi['id_juridiction'].");";
	} while ($row_insert_repordpresi = mysql_fetch_assoc($insert_repordpresi));
}
?>
              <?php 
if ($totalRows_insert_rgsocial > 0) {
	$chaine=$chaine."Delete from rg_social where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into rg_social (no_rgsocial,noordre_rgsocial,date_rgsocial,demandeur_rgsocial,defendeur_rgsocial,objet_rgsocial,observation_rgsocial,Id_admin,date_creation,dateaudience_rgsocial,id_categorieaffaire,section_rgsocial,id_juridiction) values (".$row_insert_rgsocial['no_rgsocial'].",".$row_insert_rgsocial['noordre_rgsocial'].",".$row_insert_rgsocial['date_rgsocial'].",".$row_insert_rgsocial['demandeur_rgsocial'].",".$row_insert_rgsocial['defendeur_rgsocial'].",".$row_insert_rgsocial['objet_rgsocial'].",".$row_insert_rgsocial['observation_rgsocial'].",".$row_insert_rgsocial['Id_admin'].",".$row_insert_rgsocial['date_creation'].",".$row_insert_rgsocial['dateaudience_rgsocial'].",".$row_insert_rgsocial['id_categorieaffaire'].",".$row_insert_rgsocial['section_rgsocial'].",".$row_insert_rgsocial['id_juridiction'].");";
	} while ($row_insert_rgsocial = mysql_fetch_assoc($insert_rgsocial));
}
?>
              <?php 
if ($totalRows_insert_rolegeneral > 0) {
	$chaine=$chaine."Delete from role_general where id_juridiction=".$row_select_juridiction['id_juridiction'].";";
	do {
		$chaine=$chaine."Insert into role_general (no_rolegeneral,noordre_rolegeneral,date_rolegeneral,demandeur_rolegeneral,defendeur_rolegeneral,objet_rolegeneral,observation_rolegeneral,Id_admin,date_creation,dateaudience_rolegeneral,section_rolegeneral,id_categorieaffaire,id_juridiction) values (".$row_insert_rolegeneral['no_rolegeneral'].",".$row_insert_rolegeneral['noordre_rolegeneral'].",".$row_insert_rolegeneral['date_rolegeneral'].",".$row_insert_rolegeneral['demandeur_rolegeneral'].",".$row_insert_rolegeneral['defendeur_rolegeneral'].",".$row_insert_rolegeneral['objet_rolegeneral'].",".$row_insert_rolegeneral['observation_rolegeneral'].",".$row_insert_rolegeneral['Id_admin'].",".$row_insert_rolegeneral['date_creation'].",".$row_insert_rolegeneral['dateaudience_rolegeneral'].",".$row_insert_rolegeneral['section_rolegeneral'].",".$row_insert_rolegeneral['id_categorieaffaire'].",".$row_insert_rolegeneral['id_juridiction'].");";
	} while ($row_insert_rolegeneral = mysql_fetch_assoc($insert_rolegeneral));
}
?>

</td>
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
<?php
mysql_free_result($insert_plum);

mysql_free_result($insert_rcrexterne);

mysql_free_result($insert_rcrinterne);

mysql_free_result($insert_regalphabet);

mysql_free_result($insert_regconsignation);
 
mysql_free_result($insert_regcontrolnum);

mysql_free_result($insert_regecrou);

mysql_free_result($insert_regexecpeine);

mysql_free_result($insert_regmandat);

mysql_free_result($insert_regmdepot);

mysql_free_result($insert_regobjdep);

mysql_free_result($insert_regplaintes);

mysql_free_result($insert_regscelle);

mysql_free_result($insert_regsuiviepc);

mysql_free_result($insert_regvrad);

mysql_free_result($insert_regvrlc);

mysql_free_result($insert_regvrmlp);

mysql_free_result($insert_repactesacc);

mysql_free_result($insert_repactesnot);

mysql_free_result($insert_repdecision);

mysql_free_result($insert_repjugementcorr);

mysql_free_result($insert_repjugementsupp);

mysql_free_result($insert_repordpresi);

mysql_free_result($insert_rgsocial);

mysql_free_result($insert_rolegeneral);
?>
