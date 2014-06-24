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
?>
<?php $chaine=""; ?>
<?php
$colname_select_administre = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_administre = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_administre = sprintf("SELECT * FROM administrateurs WHERE (Login_admin = %s)", GetSQLValueString($colname_select_administre, "int"));
$select_administre = mysql_query($query_select_administre, $jursta) or die(mysql_error());
$row_select_administre = mysql_fetch_assoc($select_administre);
$totalRows_select_administre = mysql_num_rows($select_administre);
?>
<?php if ($row_select_administre['type_admin'] != 'Superviseur') { // Show if recordset empty ?>
<?php
$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "int"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

mysql_select_db($database_jursta, $jursta);
$query_insert_acteagenda = "SELECT * FROM acte_agendacabin WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."))";
$insert_acteagenda = mysql_query($query_insert_acteagenda, $jursta) or die(mysql_error());
$row_insert_acteagenda = mysql_fetch_assoc($insert_acteagenda);
$totalRows_insert_acteagenda = mysql_num_rows($insert_acteagenda);

mysql_select_db($database_jursta, $jursta);
$query_insert_actecabin = "SELECT * FROM acte_regcabin WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."))";
$insert_actecabin = mysql_query($query_insert_actecabin, $jursta) or die(mysql_error());
$row_insert_actecabin = mysql_fetch_assoc($insert_actecabin);
$totalRows_insert_actecabin = mysql_num_rows($insert_actecabin);

mysql_select_db($database_jursta, $jursta);
$query_insert_agendacabin = "SELECT * FROM agenda_regcabin WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."))";
$insert_agendacabin = mysql_query($query_insert_agendacabin, $jursta) or die(mysql_error());
$row_insert_agendacabin = mysql_fetch_assoc($insert_agendacabin);
$totalRows_insert_agendacabin = mysql_num_rows($insert_agendacabin);

mysql_select_db($database_jursta, $jursta);
$query_insert_regcabin = "SELECT * FROM reg_cabin  WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regcabin = mysql_query($query_insert_regcabin, $jursta) or die(mysql_error());
$row_insert_regcabin = mysql_fetch_assoc($insert_regcabin);
$totalRows_insert_regcabin = mysql_num_rows($insert_regcabin);

mysql_select_db($database_jursta, $jursta);
$query_insert_penitentier = "SELECT * FROM penitentier WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_penitentier = mysql_query($query_insert_penitentier, $jursta) or die(mysql_error());
$row_insert_penitentier = mysql_fetch_assoc($insert_penitentier);
$totalRows_insert_penitentier = mysql_num_rows($insert_penitentier);

mysql_select_db($database_jursta, $jursta);
$query_insert_plum = "SELECT * FROM plum_civil WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_plum = mysql_query($query_insert_plum, $jursta) or die(mysql_error());
$row_insert_plum = mysql_fetch_assoc($insert_plum);
$totalRows_insert_plum = mysql_num_rows($insert_plum);

mysql_select_db($database_jursta, $jursta);
$query_insert_plumpenale = "SELECT * FROM plum_penale WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."))";
$insert_plumpenale = mysql_query($query_insert_plumpenale, $jursta) or die(mysql_error());
$row_insert_plumpenale = mysql_fetch_assoc($insert_plumpenale);
$totalRows_insert_plumpenale = mysql_num_rows($insert_plumpenale);

mysql_select_db($database_jursta, $jursta);
$query_insert_plumsocial = "SELECT * FROM plum_social WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."))";
$insert_plumsocial = mysql_query($query_insert_plumsocial, $jursta) or die(mysql_error());
$row_insert_plumsocial = mysql_fetch_assoc($insert_plumsocial);
$totalRows_insert_plumsocial = mysql_num_rows($insert_plumsocial);

mysql_select_db($database_jursta, $jursta);
$query_insert_rcrenvoi = "SELECT * FROM rcr_envoi WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."))";
$insert_rcrenvoi = mysql_query($query_insert_rcrenvoi, $jursta) or die(mysql_error());
$row_insert_rcrenvoi = mysql_fetch_assoc($insert_rcrenvoi);
$totalRows_insert_rcrenvoi = mysql_num_rows($insert_rcrenvoi);

mysql_select_db($database_jursta, $jursta);
$query_insert_rcr_rexu = "SELECT * FROM rcr_rexu where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_rcr_rexu = mysql_query($query_insert_rcr_rexu, $jursta) or die(mysql_error());
$row_insert_rcr_rexu = mysql_fetch_assoc($insert_rcr_rexu);
$totalRows_insert_rcr_rexu = mysql_num_rows($insert_rcr_rexu);

mysql_select_db($database_jursta, $jursta);
$query_insert_regalphabet = "SELECT * FROM reg_alphabdet where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regalphabet = mysql_query($query_insert_regalphabet, $jursta) or die(mysql_error());
$row_insert_regalphabet = mysql_fetch_assoc($insert_regalphabet);
$totalRows_insert_regalphabet = mysql_num_rows($insert_regalphabet);

mysql_select_db($database_jursta, $jursta);
$query_insert_regconsignation = "SELECT * FROM reg_consignations where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regconsignation = mysql_query($query_insert_regconsignation, $jursta) or die(mysql_error());
$row_insert_regconsignation = mysql_fetch_assoc($insert_regconsignation);
$totalRows_insert_regconsignation = mysql_num_rows($insert_regconsignation);

mysql_select_db($database_jursta, $jursta);
$query_insert_regcontrolnum = "SELECT * FROM reg_controlnum where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regcontrolnum = mysql_query($query_insert_regcontrolnum, $jursta) or die(mysql_error());
$row_insert_regcontrolnum = mysql_fetch_assoc($insert_regcontrolnum);
$totalRows_insert_regcontrolnum = mysql_num_rows($insert_regcontrolnum);

mysql_select_db($database_jursta, $jursta);
$query_insert_regecrou = "SELECT * FROM reg_ecrou where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regecrou = mysql_query($query_insert_regecrou, $jursta) or die(mysql_error());
$row_insert_regecrou = mysql_fetch_assoc($insert_regecrou);
$totalRows_insert_regecrou = mysql_num_rows($insert_regecrou);

mysql_select_db($database_jursta, $jursta);
$query_insert_regexecpeine = "SELECT * FROM reg_execpeine where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regexecpeine = mysql_query($query_insert_regexecpeine, $jursta) or die(mysql_error());
$row_insert_regexecpeine = mysql_fetch_assoc($insert_regexecpeine);
$totalRows_insert_regexecpeine = mysql_num_rows($insert_regexecpeine);

mysql_select_db($database_jursta, $jursta);
$query_insert_regmandat = "SELECT * FROM reg_mandat where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regmandat = mysql_query($query_insert_regmandat, $jursta) or die(mysql_error());
$row_insert_regmandat = mysql_fetch_assoc($insert_regmandat);
$totalRows_insert_regmandat = mysql_num_rows($insert_regmandat);

mysql_select_db($database_jursta, $jursta);
$query_insert_regmdepot = "SELECT * FROM reg_mdepot where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regmdepot = mysql_query($query_insert_regmdepot, $jursta) or die(mysql_error());
$row_insert_regmdepot = mysql_fetch_assoc($insert_regmdepot);
$totalRows_insert_regmdepot = mysql_num_rows($insert_regmdepot);

mysql_select_db($database_jursta, $jursta);
$query_insert_regobjdep = "SELECT * FROM reg_objdep where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regobjdep = mysql_query($query_insert_regobjdep, $jursta) or die(mysql_error());
$row_insert_regobjdep = mysql_fetch_assoc($insert_regobjdep);
$totalRows_insert_regobjdep = mysql_num_rows($insert_regobjdep);

mysql_select_db($database_jursta, $jursta);
$query_insert_regplaintes = "SELECT * FROM reg_plaintes_desc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regplaintes = mysql_query($query_insert_regplaintes, $jursta) or die(mysql_error());
$row_insert_regplaintes = mysql_fetch_assoc($insert_regplaintes);
$totalRows_insert_regplaintes = mysql_num_rows($insert_regplaintes);

mysql_select_db($database_jursta, $jursta);
$query_insert_regscelle = "SELECT * FROM reg_scelle where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regscelle = mysql_query($query_insert_regscelle, $jursta) or die(mysql_error());
$row_insert_regscelle = mysql_fetch_assoc($insert_regscelle);
$totalRows_insert_regscelle = mysql_num_rows($insert_regscelle);

mysql_select_db($database_jursta, $jursta);
$query_insert_regsuiviepc = "SELECT * FROM reg_suiviepc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regsuiviepc = mysql_query($query_insert_regsuiviepc, $jursta) or die(mysql_error());
$row_insert_regsuiviepc = mysql_fetch_assoc($insert_regsuiviepc);
$totalRows_insert_regsuiviepc = mysql_num_rows($insert_regsuiviepc);

mysql_select_db($database_jursta, $jursta);
$query_insert_regvrad = "SELECT * FROM reg_vrad where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regvrad = mysql_query($query_insert_regvrad, $jursta) or die(mysql_error());
$row_insert_regvrad = mysql_fetch_assoc($insert_regvrad);
$totalRows_insert_regvrad = mysql_num_rows($insert_regvrad);

mysql_select_db($database_jursta, $jursta);
$query_insert_regvrlc = "SELECT * FROM reg_vrlc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regvrlc = mysql_query($query_insert_regvrlc, $jursta) or die(mysql_error());
$row_insert_regvrlc = mysql_fetch_assoc($insert_regvrlc);
$totalRows_insert_regvrlc = mysql_num_rows($insert_regvrlc);

mysql_select_db($database_jursta, $jursta);
$query_insert_regvrmlp = "SELECT * FROM reg_vrmlp where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regvrmlp = mysql_query($query_insert_regvrmlp, $jursta) or die(mysql_error());
$row_insert_regvrmlp = mysql_fetch_assoc($insert_regvrmlp);
$totalRows_insert_regvrmlp = mysql_num_rows($insert_regvrmlp);

mysql_select_db($database_jursta, $jursta);
$query_insert_repactesacc = "SELECT * FROM rep_actesacc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_repactesacc = mysql_query($query_insert_repactesacc, $jursta) or die(mysql_error());
$row_insert_repactesacc = mysql_fetch_assoc($insert_repactesacc);
$totalRows_insert_repactesacc = mysql_num_rows($insert_repactesacc);

mysql_select_db($database_jursta, $jursta);
$query_insert_repactesnot = "SELECT * FROM rep_actesnot where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_repactesnot = mysql_query($query_insert_repactesnot, $jursta) or die(mysql_error());
$row_insert_repactesnot = mysql_fetch_assoc($insert_repactesnot);
$totalRows_insert_repactesnot = mysql_num_rows($insert_repactesnot);

mysql_select_db($database_jursta, $jursta);
$query_insert_repdecision = "SELECT * FROM rep_decision where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_repdecision = mysql_query($query_insert_repdecision, $jursta) or die(mysql_error());
$row_insert_repdecision = mysql_fetch_assoc($insert_repdecision);
$totalRows_insert_repdecision = mysql_num_rows($insert_repdecision);

mysql_select_db($database_jursta, $jursta);
$query_insert_repjugementcorr = "SELECT * FROM rep_jugementcorr where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_repjugementcorr = mysql_query($query_insert_repjugementcorr, $jursta) or die(mysql_error());
$row_insert_repjugementcorr = mysql_fetch_assoc($insert_repjugementcorr);
$totalRows_insert_repjugementcorr = mysql_num_rows($insert_repjugementcorr);

mysql_select_db($database_jursta, $jursta);
$query_insert_repjugementsupp = "SELECT * FROM rep_jugementsupp where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_repjugementsupp = mysql_query($query_insert_repjugementsupp, $jursta) or die(mysql_error());
$row_insert_repjugementsupp = mysql_fetch_assoc($insert_repjugementsupp);
$totalRows_insert_repjugementsupp = mysql_num_rows($insert_repjugementsupp);

mysql_select_db($database_jursta, $jursta);
$query_insert_repordpresi = "SELECT * FROM rep_ordpresi where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_repordpresi = mysql_query($query_insert_repordpresi, $jursta) or die(mysql_error());
$row_insert_repordpresi = mysql_fetch_assoc($insert_repordpresi);
$totalRows_insert_repordpresi = mysql_num_rows($insert_repordpresi);

mysql_select_db($database_jursta, $jursta);
$query_insert_rgsocial = "SELECT * FROM rg_social where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_rgsocial = mysql_query($query_insert_rgsocial, $jursta) or die(mysql_error());
$row_insert_rgsocial = mysql_fetch_assoc($insert_rgsocial);
$totalRows_insert_rgsocial = mysql_num_rows($insert_rgsocial);

mysql_select_db($database_jursta, $jursta);
$query_insert_rolegeneral = "SELECT * FROM role_general where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_rolegeneral = mysql_query($query_insert_rolegeneral, $jursta) or die(mysql_error());
$row_insert_rolegeneral = mysql_fetch_assoc($insert_rolegeneral);
$totalRows_insert_rolegeneral = mysql_num_rows($insert_rolegeneral);

mysql_select_db($database_jursta, $jursta);
$query_insert_regdeces = "SELECT * FROM reg_deces WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regdeces = mysql_query($query_insert_regdeces, $jursta) or die(mysql_error());
$row_insert_regdeces = mysql_fetch_assoc($insert_regdeces);
$totalRows_insert_regdeces = mysql_num_rows($insert_regdeces);

mysql_select_db($database_jursta, $jursta);
$query_insert_regevasion = "SELECT * FROM reg_evasion WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regevasion = mysql_query($query_insert_regevasion, $jursta) or die(mysql_error());
$row_insert_regevasion = mysql_fetch_assoc($insert_regevasion);
$totalRows_insert_regevasion = mysql_num_rows($insert_regevasion);

mysql_select_db($database_jursta, $jursta);
$query_insert_levecrou = "SELECT * FROM reg_levecrou WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_levecrou = mysql_query($query_insert_levecrou, $jursta) or die(mysql_error());
$row_insert_levecrou = mysql_fetch_assoc($insert_levecrou);
$totalRows_insert_levecrou = mysql_num_rows($insert_levecrou);

mysql_select_db($database_jursta, $jursta);
$query_insert_libcond = "SELECT * FROM reg_libcond WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_libcond = mysql_query($query_insert_libcond, $jursta) or die(mysql_error());
$row_insert_libcond = mysql_fetch_assoc($insert_libcond);
$totalRows_insert_libcond = mysql_num_rows($insert_libcond);

mysql_select_db($database_jursta, $jursta);
$query_insert_regpiece = "SELECT * FROM reg_piece WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regpiece = mysql_query($query_insert_regpiece, $jursta) or die(mysql_error());
$row_insert_regpiece = mysql_fetch_assoc($insert_regpiece);
$totalRows_insert_regpiece = mysql_num_rows($insert_regpiece);

mysql_select_db($database_jursta, $jursta);
$query_insert_plaintesnom = "SELECT * FROM reg_plaintes_noms WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_plaintesnom = mysql_query($query_insert_plaintesnom, $jursta) or die(mysql_error());
$row_insert_plaintesnom = mysql_fetch_assoc($insert_plaintesnom);
$totalRows_insert_plaintesnom = mysql_num_rows($insert_plaintesnom);

mysql_select_db($database_jursta, $jursta);
$query_insert_regsocialappel = "SELECT * FROM reg_socialappel WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regsocialappel = mysql_query($query_insert_regsocialappel, $jursta) or die(mysql_error());
$row_insert_regsocialappel = mysql_fetch_assoc($insert_regsocialappel);
$totalRows_insert_regsocialappel = mysql_num_rows($insert_regsocialappel);

mysql_select_db($database_jursta, $jursta);
$query_insert_regsocialopp = "SELECT * FROM reg_socialopposition WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regsocialopp = mysql_query($query_insert_regsocialopp, $jursta) or die(mysql_error());
$row_insert_regsocialopp = mysql_fetch_assoc($insert_regsocialopp);
$totalRows_insert_regsocialopp = mysql_num_rows($insert_regsocialopp);

mysql_select_db($database_jursta, $jursta);
$query_insert_regtransfert = "SELECT * FROM reg_transfert WHERE ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
$insert_regtransfert = mysql_query($query_insert_regtransfert, $jursta) or die(mysql_error());
$row_insert_regtransfert = mysql_fetch_assoc($insert_regtransfert);
$totalRows_insert_regtransfert = mysql_num_rows($insert_regtransfert);

?>
<?php 

if ($totalRows_acteagenda > 0) {
	$chaine=$chaine."Delete from acte_agendacabin where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into acte_agendacabin (id_acteagendacabin, nature_acteagendacabin, lien_acte, id_agenda, Id_admin, date_creation,  id_juridiction) values ('".str_replace("'","''",$row_insert_acteagenda['id_acteagendacabin'])."','".str_replace("'","''",$row_insert_acteagenda['nature_acteagendacabin'])."','".str_replace("'","''",$row_insert_acteagenda['lien_acte'])."','".str_replace("'","''",$row_insert_acteagenda['id_agenda'])."','".str_replace("'","''",$row_insert_acteagenda['Id_admin'])."','".str_replace("'","''",$row_insert_acteagenda['date_creation'])."','".str_replace("'","''",$row_insert_acteagenda['id_juridiction'])."');";
	} while ($row_insert_acteagenda = mysql_fetch_assoc($insert_acteagenda));
}

if ($totalRows_insert_actecabin > 0) {
	$chaine=$chaine."Delete from acte_regcabin where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into acte_regcabin (id_acteregcabin, num_acteregcabin, date_acteregcabin, nature_acteregcabin, lien_acte, id_regcabin, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_actecabin['id_acteregcabin'])."','".str_replace("'","''",$row_insert_actecabin['num_acteregcabin'])."','".str_replace("'","''",$row_insert_actecabin['date_acteregcabin'])."','".str_replace("'","''",$row_insert_actecabin['nature_acteregcabin'])."','".str_replace("'","''",$row_insert_actecabin['lien_acte'])."','".str_replace("'","''",$row_insert_actecabin['id_regcabin'])."','".str_replace("'","''",$row_insert_actecabin['Id_admin'])."','".str_replace("'","''",$row_insert_actecabin['date_creation'])."','".str_replace("'","''",$row_insert_actecabin['id_juridiction'])."');";
	} while ($row_insert_actecabin = mysql_fetch_assoc($insert_actecabin));
}

if ($totalRows_insert_agendacabin > 0) {
	$chaine=$chaine."Delete from agenda_regcabin where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into agenda_regcabin (id_agenda, date_agenda, nodossier_agenda, nomprenom_agenda, heure_agenda, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_agendacabin['id_agenda'])."','".str_replace("'","''",$row_insert_agendacabin['date_agenda'])."','".str_replace("'","''",$row_insert_agendacabin['nodossier_agenda'])."','".str_replace("'","''",$row_insert_agendacabin['nomprenom_agenda'])."','".str_replace("'","''",$row_insert_agendacabin['heure_agenda'])."','".str_replace("'","''",$row_insert_agendacabin['Id_admin'])."','".str_replace("'","''",$row_insert_agendacabin['date_creation'])."','".str_replace("'","''",$row_insert_agendacabin['id_juridiction'])."');";
	} while ($row_insert_agendacabin = mysql_fetch_assoc($insert_agendacabin));
}

if ($totalRows_insert_regcabin > 0) {
	$chaine=$chaine."Delete from reg_cabin where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into reg_cabin (id_regcabin, numodre_regcabin, datefait, daterequisitoire, datordcloture, decisionord, observation,  no_repjugementcorr, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regcabin['id_regcabin'])."','".str_replace("'","''",$row_insert_regcabin['numodre_regcabin'])."','".str_replace("'","''",$row_insert_regcabin['datefait'])."','".str_replace("'","''",$row_insert_regcabin['daterequisitoire'])."','".str_replace("'","''",$row_insert_regcabin['datordcloture'])."','".str_replace("'","''",$row_insert_regcabin['decisionord'])."','".str_replace("'","''",$row_insert_regcabin['observation'])."','".str_replace("'","''",$row_insert_regcabin['no_repjugementcorr'])."','".str_replace("'","''",$row_insert_regcabin['Id_admin'])."','".str_replace("'","''",$row_insert_regcabin['date_creation'])."','".str_replace("'","''",$row_insert_regcabin['id_juridiction'])."');";
	} while ($row_insert_regcabin = mysql_fetch_assoc($insert_regcabin));
}

if ($totalRows_insert_penitentier > 0) {
	$chaine=$chaine."Delete from penitentier where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into penitentier (id_penitentier, lib_penitentier, surface_dortoire, credit_alloue, id_juridiction, id_departement, observation,  no_repjugementcorr, Id_admin, date_creation) values ('".str_replace("'","''",$row_insert_penitentier['id_penitentier'])."','".str_replace("'","''",$row_insert_penitentier['lib_penitentier'])."','".str_replace("'","''",$row_insert_penitentier['surface_dortoire'])."','".str_replace("'","''",$row_insert_regcabin['credit_alloue'])."','".str_replace("'","''",$row_insert_regcabin['id_juridiction'])."','".str_replace("'","''",$row_insert_penitentier['id_departement'])."','".str_replace("'","''",$row_insert_penitentier['annee'])."','".str_replace("'","''",$row_insert_penitentier['annee'])."','".str_replace("'","''",$row_insert_penitentier['Id_admin'])."','".str_replace("'","''",$row_insert_penitentier['date_creation'])."');";
	} while ($row_insert_penitentier = mysql_fetch_assoc($insert_penitentier));
}

if ($totalRows_insert_plum > 0) {
	$chaine=$chaine."Delete from plum_civil where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into plum_civil (id_plumcivil, presi_plumcivil, greffier_plumcivil, accesseurs_plumcivil, Substitut_PlumCivil, observ_plumcivil, Id_admin, date_creation, date_modif, no_rolegeneral, id_juridiction) values ('".str_replace("'","''",$row_insert_plum['id_plumcivil'])."','".str_replace("'","''",$row_insert_plum['presi_plumcivil'])."','".str_replace("'","''",$row_insert_plum['greffier_plumcivil'])."','".str_replace("'","''",$row_insert_plum['accesseurs_plumcivil'])."','".str_replace("'","''",$row_insert_plum['Substitut_PlumCivil'])."','".str_replace("'","''",$row_insert_plum['observ_plumcivil'])."','".str_replace("'","''",$row_insert_plum['Id_admin'])."','".str_replace("'","''",$row_insert_plum['date_creation'])."','".str_replace("'","''",$row_insert_plum['date_modif'])."','".str_replace("'","''",$row_insert_plum['no_rolegeneral'])."','".str_replace("'","''",$row_insert_plum['id_juridiction'])."');";
	} while ($row_insert_plum = mysql_fetch_assoc($insert_plum));
}
if ($totalRows_insert_plumpenale > 0) {
	$chaine=$chaine."Delete from plum_penale where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into plum_penale (id_plumpenale, dataudience_plumpenale, presi_plumpenale, greffier_plumpenale, accesseurs_plumpenale, observ_plumpenale, Id_admin, date_creation, no_regplaintes, id_juridiction) values ('".str_replace("'","''",$row_insert_plumpenale['id_plumpenale'])."','".str_replace("'","''",$row_insert_plumpenale['dataudience_plumpenale'])."','".str_replace("'","''",$row_insert_plumpenale['presi_plumpenale'])."','".str_replace("'","''",$row_insert_plumpenale['greffier_plumpenale'])."','".str_replace("'","''",$row_insert_plumpenale['accesseurs_plumpenale'])."','".str_replace("'","''",$row_insert_plumpenale['observ_plumpenale'])."','".str_replace("'","''",$row_insert_plumpenale['Id_admin'])."','".str_replace("'","''",$row_insert_plumpenale['date_creation'])."','".str_replace("'","''",$row_insert_plumpenale['no_regplaintes'])."','".str_replace("'","''",$row_insert_plumpenale['id_juridiction'])."');";
	} while ($row_insert_plumpenale = mysql_fetch_assoc($insert_plumpenale));
}
if ($totalRows_insert_plumsocial > 0) {
	$chaine=$chaine."Delete from plum_social where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));"; 
	do {
		$chaine=$chaine."Insert into plum_social (id_plumsociale, dataudience_plumsociale, presi_plumsociale, greffier_plumsociale, accesseurs_plumsociale, observ_plumsociale, Id_admin, date_creation, no_rgsocial, id_juridiction) values ('".str_replace("'","''",$row_insert_plumsocial['id_plumsociale'])."','".str_replace("'","''",$row_insert_plumsocial['dataudience_plumsociale'])."','".str_replace("'","''",$row_insert_plumsocial['presi_plumsociale'])."','".str_replace("'","''",$row_insert_plumsocial['greffier_plumsociale'])."','".str_replace("'","''",$row_insert_plumsocial['accesseurs_plumsociale'])."','".str_replace("'","''",$row_insert_plumsocial['observ_plumsociale'])."','".str_replace("'","''",$row_insert_plumsocial['Id_admin'])."','".str_replace("'","''",$row_insert_plumsocial['date_creation'])."','".str_replace("'","''",$row_insert_plumsocial['no_rgsocial'])."','".str_replace("'","''",$row_insert_plumsocial['id_juridiction'])."');";
	} while ($row_insert_plumsocial = mysql_fetch_assoc($insert_plumsocial));
}

if ($totalRows_insert_rcrenvoi > 0) {
	$chaine=$chaine."Delete from rcr_envoi where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rcr_envoi (no_rcrenvoi, noordre_rcrenvoi, datedepart_rcrenvoi, destinataire_rcrenvoi, objet_rcrenvoi, observation_rcrenvoi, id_juridiction, Id_admin, date_creation)	values ('".str_replace("'","''",$row_insert_rcrenvoi['no_rcrenvoi'])."','".str_replace("'","''",$row_insert_rcrenvoi['noordre_rcrenvoi'])."','".str_replace("'","''",$row_insert_rcrenvoi['datedepart_rcrenvoi'])."','".str_replace("'","''",$row_insert_rcrenvoi['destinataire_rcrenvoi'])."','".str_replace("'","''",$row_insert_rcrenvoi['objet_rcrenvoi'])."','".str_replace("'","''",$row_insert_rcrenvoi['observation_rcrenvoi'])."','".str_replace("'","''",$row_insert_rcrenvoi['id_juridiction'])."','".str_replace("'","''",$row_insert_rcrenvoi['Id_admin'])."','".str_replace("'","''",$row_insert_rcrenvoi['date_creation'])."');";
	} while ($row_insert_rcrenvoi = mysql_fetch_assoc($insert_rcrenvoi));
}

if ($totalRows_insert_rcr_rexu > 0) {
	$chaine=$chaine."Delete from rcr_rexu where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rcr_rexu (no_rcrexu, noordre_rcrexu, daterecu_rcrexu, destinataire_rcrexu, objet_rcrexu, observation_rcrexu, id_juridiction, Id_admin, date_creation) values ('".str_replace("'","''",$row_insert_rcr_rexu['no_rcrexu'])."','".str_replace("'","''",$row_insert_rcr_rexu['noordre_rcrexu'])."','".str_replace("'","''",$row_insert_rcr_rexu['daterecu_rcrexu'])."','".str_replace("'","''",$row_insert_rcr_rexu['destinataire_rcrexu'])."','".str_replace("'","''",$row_insert_rcr_rexu['objet_rcrexu'])."','".str_replace("'","''",$row_insert_rcr_rexu['observation_rcrexu'])."','".str_replace("'","''",$row_insert_rcr_rexu['id_juridiction'])."','".str_replace("'","''",$row_insert_rcr_rexu['Id_admin'])."','".str_replace("'","''",$row_insert_rcr_rexu['date_creation'])."');";
	} while ($row_insert_rcr_rexu = mysql_fetch_assoc($insert_rcr_rexu));
}

if ($totalRows_insert_regalphabet > 0) {
	$chaine=$chaine."Delete from reg_alphabdet where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_alphabdet (no_regalphabdet, asphys_regalphabdet, sexe_regalphabdet, moidat_regalphabdet, nomdet_regalphabdet, no_ecrou, datentre_regalphabdet, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regalphabet['no_regalphabdet'])."','".str_replace("'","''",$row_insert_regalphabet['asphys_regalphabdet'])."','".str_replace("'","''",$row_insert_regalphabet['sexe_regalphabdet'])."','".str_replace("'","''",$row_insert_regalphabet['moidat_regalphabdet'])."','".str_replace("'","''",$row_insert_regalphabet['nomdet_regalphabdet'])."','".str_replace("'","''",$row_insert_regalphabet['no_ecrou'])."','".str_replace("'","''",$row_insert_regalphabet['datentre_regalphabdet'])."','".str_replace("'","''",$row_insert_regalphabet['Id_admin'])."','".str_replace("'","''",$row_insert_regalphabet['date_creation'])."','".str_replace("'","''",$row_insert_regalphabet['id_juridiction'])."');";
	} while ($row_insert_regalphabet = mysql_fetch_assoc($insert_regalphabet));
}

if ($totalRows_insert_regconsignation > 0) {
	$chaine=$chaine."Delete from reg_consignations where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_consignations (no_regconsign, noordre_regconsign, date_regconsign, montant_regconsign, decision_regconsign, somareclam_regconsign, somarestit_regconsign, liquidation_regconsign, observation_regconsign, Id_admin, date_creation, no_rolegeneral, id_juridiction) values ('".str_replace("'","''",$row_insert_regconsignation['no_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['noordre_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['date_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['montant_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['decision_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['somareclam_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['somarestit_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['liquidation_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['observation_regconsign'])."','".str_replace("'","''",$row_insert_regconsignation['Id_admin'])."','".str_replace("'","''",$row_insert_regconsignation['date_creation'])."','".str_replace("'","''",$row_insert_regconsignation['no_rolegeneral'])."','".str_replace("'","''",$row_insert_regconsignation['id_juridiction'])."');";
	} while ($row_insert_regconsignation = mysql_fetch_assoc($insert_regconsignation));
}

if ($totalRows_insert_regcontrolnum > 0) {
	$chaine=$chaine."Delete from reg_controlnum where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_controlnum (no_regcontrolnum, noordre_regcontrolnum, sexe_regcontrolnum, date_regcontrolnum, nom_regcontrolnum, procureur_regcontrolnum, naturdelit_regcontrolnum, Id_admin, date_creation, no_regmandat, id_juridiction) values ('".str_replace("'","''",$row_insert_regcontrolnum['no_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['noordre_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['sexe_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['date_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['nom_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['procureur_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['naturdelit_regcontrolnum'])."','".str_replace("'","''",$row_insert_regcontrolnum['Id_admin'])."','".str_replace("'","''",$row_insert_regcontrolnum['date_creation'])."','".str_replace("'","''",$row_insert_regcontrolnum['no_regmandat'])."','".str_replace("'","''",$row_insert_regcontrolnum['id_juridiction'])."');";
	} while ($row_insert_regcontrolnum = mysql_fetch_assoc($insert_regcontrolnum));
}

if ($totalRows_insert_regecrou > 0) {
	$chaine=$chaine."Delete from reg_ecrou where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_ecrou (no_ecrou, noordre_ecrou, datnaisdet_ecrou, lieunaisdet_ecrou, peredet_ecrou, meredet_ecrou, professiondet_ecrou, domicildet_ecrou, tailledet_ecrou, frontdet_ecrou, nezdet_ecrou, bouchedet_ecrou, teintdet_ecrou, signepartdet_ecrou, datenter_ecrou, prolongdet_ecrou, decisionjudic_ecrou, type_voiederecours, datedebutpeine_ecrou, dateexpirpeine_ecrou, datsortidet_ecrou, motifssortidet_ecrou, observation_ecrou, no_regmandat, no_regcontrolnum, id_juridiction, Id_admin, date_creation) values ('".str_replace("'","''",$row_insert_regecrou['no_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['noordre_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['datnaisdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['lieunaisdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['peredet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['meredet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['professiondet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['domicildet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['tailledet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['frontdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['nezdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['bouchedet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['teintdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['signepartdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['datenter_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['prolongdet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['decisionjudic_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['type_voiederecours'])."','".str_replace("'","''",$row_insert_regecrou['datedebutpeine_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['dateexpirpeine_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['datsortidet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['motifssortidet_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['observation_ecrou'])."','".str_replace("'","''",$row_insert_regecrou['no_regmandat'])."','".str_replace("'","''",$row_insert_regecrou['no_regcontrolnum'])."','".str_replace("'","''",$row_insert_regecrou['id_juridiction'])."','".str_replace("'","''",$row_insert_regecrou['Id_admin'])."','".str_replace("'","''",$row_insert_regecrou['date_creation'])."');";
	} while ($row_insert_regecrou = mysql_fetch_assoc($insert_regecrou));
}

if ($totalRows_insert_regexecpeine > 0) {
	$chaine=$chaine."Delete from reg_execpeine where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_execpeine (id_execpeine, nodordre_execpeine, peine_execpeine, naturedelit_execpeine, situation_execpeine, datemdpot_execpeine, datgrosse_execpeine, dateperson_execpeine, datetrxprison_execpeine, datetrxtresor_execpeine, datetrxcasier, datenvoipolice, datarrestation, sursisarrestation, sursiaexecution, causesretard, datexpirpeine, observation, no_repjugementcorr, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regexecpeine['id_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['nodordre_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['peine_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['naturedelit_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['situation_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['datemdpot_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['datgrosse_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['dateperson_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['datetrxprison_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['datetrxtresor_execpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['datetrxcasier'])."','".str_replace("'","''",$row_insert_regexecpeine['datenvoipolice'])."','".str_replace("'","''",$row_insert_regexecpeine['datarrestation'])."','".str_replace("'","''",$row_insert_regexecpeine['sursisarrestation'])."','".str_replace("'","''",$row_insert_regexecpeine['sursiaexecution'])."','".str_replace("'","''",$row_insert_regexecpeine['causesretard'])."','".str_replace("'","''",$row_insert_regexecpeine['datexpirpeine'])."','".str_replace("'","''",$row_insert_regexecpeine['observation'])."','".str_replace("'","''",$row_insert_regexecpeine['no_repjugementcorr'])."','".str_replace("'","''",$row_insert_regexecpeine['Id_admin'])."','".str_replace("'","''",$row_insert_regexecpeine['date_creation'])."','".str_replace("'","''",$row_insert_regexecpeine['id_juridiction'])."');";
	} while ($row_insert_regexecpeine = mysql_fetch_assoc($insert_regexecpeine));
}

if ($totalRows_insert_regmandat > 0) {
	$chaine=$chaine."Delete from reg_mandat where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_mandat (no_regmandat, noordre_regmandat, date_regmandat, nom_regmandat, magistra_regmandat, infraction_regmandat, Id_admin, date_creation, type_regmandat, id_juridiction) values ('".str_replace("'","''",$row_insert_regmandat['no_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['noordre_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['date_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['nom_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['magistra_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['infraction_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['Id_admin'])."','".str_replace("'","''",$row_insert_regmandat['date_creation'])."','".str_replace("'","''",$row_insert_regmandat['type_regmandat'])."','".str_replace("'","''",$row_insert_regmandat['id_juridiction'])."');";
	} while ($row_insert_regmandat = mysql_fetch_assoc($insert_regmandat));
}

if ($totalRows_insert_regmdepot > 0) {
	$chaine=$chaine."Delete from reg_mdepot where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_mdepot (no_regmdepot, noordre_regmdepot, date_regmdepot, nom_regmdepot, magistra_regmdepot, infraction_regmdepot, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regmdepot['no_regmdepot'])."','".str_replace("'","''",$row_insert_regmdepot['noordre_regmdepot'])."','".str_replace("'","''",$row_insert_regmdepot['date_regmdepot'])."','".str_replace("'","''",$row_insert_regmdepot['nom_regmdepot'])."','".str_replace("'","''",$row_insert_regmdepot['magistra_regmdepot'])."','".str_replace("'","''",$row_insert_regmdepot['infraction_regmdepot'])."','".str_replace("'","''",$row_insert_regmdepot['Id_admin'])."','".str_replace("'","''",$row_insert_regmdepot['date_creation'])."','".str_replace("'","''",$row_insert_regmdepot['id_juridiction'])."');";
	} while ($row_insert_regmdepot = mysql_fetch_assoc($insert_regmdepot));
}

if ($totalRows_insert_regobjdep > 0) {
	$chaine=$chaine."Delete from reg_objdep where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_objdep (no_regobjdep, datemd_regobjdep, nom_regobjdep, som_regobjdep, objet_redobjdep, observ_regobjdep, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regobjdep['no_regobjdep'])."','".str_replace("'","''",$row_insert_regobjdep['datemd_regobjdep'])."','".str_replace("'","''",$row_insert_regobjdep['nom_regobjdep'])."','".str_replace("'","''",$row_insert_regobjdep['som_regobjdep'])."','".str_replace("'","''",$row_insert_regobjdep['objet_redobjdep'])."','".str_replace("'","''",$row_insert_regobjdep['observ_regobjdep'])."','".str_replace("'","''",$row_insert_regobjdep['Id_admin'])."','".str_replace("'","''",$row_insert_regobjdep['date_creation'])."','".str_replace("'","''",$row_insert_regobjdep['id_juridiction'])."');";
	} while ($row_insert_regobjdep = mysql_fetch_assoc($insert_regobjdep));
}

if ($totalRows_insert_regplaintes > 0) {
	$chaine=$chaine."Delete from reg_plaintes_desc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_plaintes (no_regplaintes, nodordre_plaintes, Pautosaisi_plaintes, Red_plaintes, dateparquet_plaintes,  suite_plaintes, MotifClass_plaintes, observations_plaintes, Id_admin, date_creation, DatInfraction_plaintes, LieuInfraction_plaintes, id_categorieaffaire, PVdat_plaintes, naturesuite_plaintes, typepv_plaintes, naturecrimes_plaintes, procedureautreparquet_plaintes, typesaisine_plaintes, id_juridiction, cles_pivot) values ('".str_replace("'","''",$row_insert_regplaintes['no_regplaintes'])."','".str_replace("'","''",$row_insert_regplaintes['nodordre_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['Pautosaisi_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['Red_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['NatInfraction_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['suite_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['MotifClass_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['observations_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['Id_admin'])."','".str_replace("'","''",$row_insert_regplaintes['date_creation'])."','".str_replace("'","''",$row_insert_regplaintes['DatInfraction_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['LieuInfraction_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['id_categorieaffaire'])."','".str_replace("'","''",$row_insert_regplaintes['PVdat_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['naturesuite_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['typepv_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['naturecrimes_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['procedureautreparquet_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['typesaisine_plaintes'])."','".str_replace("'","''",$row_insert_regplaintes['id_juridiction'])."','".str_replace("'","''",$row_insert_regplaintes['cles_pivot'])."');";
	} while ($row_insert_regplaintes = mysql_fetch_assoc($insert_regplaintes));
}

if ($totalRows_insert_regscelle > 0) {
	$chaine=$chaine."Delete from reg_scelle where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_scelle (no_regscel, nodordre_regscel, datedepo_regscel, nomdeposant_regscel, objetdepo_regscel, observation_regscel, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regscelle['no_regscel'])."','".str_replace("'","''",$row_insert_regscelle['nodordre_regscel'])."','".str_replace("'","''",$row_insert_regscelle['datedepo_regscel'])."','".str_replace("'","''",$row_insert_regscelle['nomdeposant_regscel'])."','".str_replace("'","''",$row_insert_regscelle['objetdepo_regscel'])."','".str_replace("'","''",$row_insert_regscelle['observation_regscel'])."','".str_replace("'","''",$row_insert_regscelle['Id_admin'])."','".str_replace("'","''",$row_insert_regscelle['date_creation'])."','".str_replace("'","''",$row_insert_regscelle['id_juridiction'])."');";
	} while ($row_insert_regscelle = mysql_fetch_assoc($insert_regscelle));
}

if ($totalRows_insert_regsuiviepc > 0) {
	$chaine=$chaine."Delete from reg_suiviepc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_suiviepc (no_suiviepc, no_dordresuiviepc, autdorigine_suiviepc, nodatepv_suiviepc, prevenus_suiviepc, naturescelle_suiviepc, magasinlieuconserv_suiviepc, coffrefortlieuconserv_suiviepc, nojugedecision_suiviepc, noordonancedestruct_suiviepc, noordonanceremisedom_suiviepc, daterestitution_suivepc, nocnicsrestitution_suiviepc, emargementrestitution_suiviepc, observation_suiviepc, date_creation, Id_admin, id_juridiction) values ('".str_replace("'","''",$row_insert_regsuiviepc['no_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['no_dordresuiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['autdorigine_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['nodatepv_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['prevenus_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['naturescelle_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['magasinlieuconserv_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['coffrefortlieuconserv_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['nojugedecision_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['noordonancedestruct_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['noordonanceremisedom_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['daterestitution_suivepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['nocnicsrestitution_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['emargementrestitution_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['observation_suiviepc'])."','".str_replace("'","''",$row_insert_regsuiviepc['date_creation'])."','".str_replace("'","''",$row_insert_regsuiviepc['Id_admin'])."','".str_replace("'","''",$row_insert_regsuiviepc['id_juridiction'])."');";
	} while ($row_insert_regsuiviepc = mysql_fetch_assoc($insert_regsuiviepc));
}

if ($totalRows_insert_regvrad > 0) {
	$chaine=$chaine."Delete from reg_vrad where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_vrad (no_regvrad, noodre_regvrad, nomdet_regvrad, datmd_regvrad, datjug_regvrad, datdemande_regvrad, peine_regvrad, delit_regvrad, parquet_regvrad, nobatetcel_regvrad, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regvrad['no_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['noodre_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['nomdet_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['datmd_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['datjug_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['datdemande_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['peine_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['delit_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['parquet_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['nobatetcel_regvrad'])."','".str_replace("'","''",$row_insert_regvrad['Id_admin'])."','".str_replace("'","''",$row_insert_regvrad['date_creation'])."','".str_replace("'","''",$row_insert_regvrad['id_juridiction'])."');";
	} while ($row_insert_regvrad = mysql_fetch_assoc($insert_regvrad));
}

if ($totalRows_insert_regvrlc > 0) {
	$chaine=$chaine."Delete from reg_vrlc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_vrlc (no_regvrlc, noordre_regvrlc, nomdet_regvrlc, datmd_regvrlc, delit_regvrlc, peine_regvrlc, observ_regvrlc, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regvrlc['no_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['noordre_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['nomdet_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['datmd_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['delit_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['peine_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['observ_regvrlc'])."','".str_replace("'","''",$row_insert_regvrlc['Id_admin'])."','".str_replace("'","''",$row_insert_regvrlc['date_creation'])."','".str_replace("'","''",$row_insert_regvrlc['id_juridiction'])."');";
	} while ($row_insert_regvrlc = mysql_fetch_assoc($insert_regvrlc));
}

if ($totalRows_insert_regvrmlp > 0) {
	$chaine=$chaine."Delete from reg_vrmlp where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_vrmlp (no_regvrmlp, noordre_regvrmlp, datdemand_regvrmlp, nomdet_regvrmlp, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regvrmlp['no_regvrmlp'])."','".str_replace("'","''",$row_insert_regvrmlp['noordre_regvrmlp'])."','".str_replace("'","''",$row_insert_regvrmlp['datdemand_regvrmlp'])."','".str_replace("'","''",$row_insert_regvrmlp['nomdet_regvrmlp'])."','".str_replace("'","''",$row_insert_regvrmlp['Id_admin'])."','".str_replace("'","''",$row_insert_regvrmlp['date_creation'])."','".str_replace("'","''",$row_insert_regvrmlp['id_juridiction'])."');";
	} while ($row_insert_regvrmlp = mysql_fetch_assoc($insert_regvrmlp));
}

if ($totalRows_insert_repactesacc > 0) {
	$chaine=$chaine."Delete from rep_actesacc where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rep_actesacc (no_repactesacc, nodordre_acc, date_acc, nomparties_acc, designationacte_acc, lien_fich, Id_admin, date_creation, section_rolegeneral, id_categorieaffaire, id_juridiction) values ('".str_replace("'","''",$row_insert_repactesacc['no_repactesacc'])."','".str_replace("'","''",$row_insert_repactesacc['nodordre_acc'])."','".str_replace("'","''",$row_insert_repactesacc['date_acc'])."','".str_replace("'","''",$row_insert_repactesacc['nomparties_acc'])."','".str_replace("'","''",$row_insert_repactesacc['designationacte_acc'])."','".str_replace("'","''",$row_insert_repactesacc['lien_fich'])."','".str_replace("'","''",$row_insert_repactesacc['Id_admin'])."','".str_replace("'","''",$row_insert_repactesacc['date_creation'])."','".str_replace("'","''",$row_insert_repactesacc['section_rolegeneral'])."','".str_replace("'","''",$row_insert_repactesacc['id_categorieaffaire'])."','".str_replace("'","''",$row_insert_repactesacc['id_juridiction'])."');";
	} while ($row_insert_repactesacc = mysql_fetch_assoc($insert_repactesacc));
}

if ($totalRows_insert_repactesnot > 0) {
	$chaine=$chaine."Delete from rep_actesnot where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rep_actesnot (no_repactesnot, dateaudience_repactesnot, noordre_repactesnot, demandeur_repactesnot, requerant_repactesnot, natdossier_repactesnot, lien_fich, Id_admin, date_creation, id_categorieaffaire, section_rolegeneral, id_juridiction) values ('".str_replace("'","''",$row_insert_repactesnot['no_repactesnot'])."','".str_replace("'","''",$row_insert_repactesnot['dateaudience_repactesnot'])."','".str_replace("'","''",$row_insert_repactesnot['noordre_repactesnot'])."','".str_replace("'","''",$row_insert_repactesnot['demandeur_repactesnot'])."','".str_replace("'","''",$row_insert_repactesnot['requerant_repactesnot'])."','".str_replace("'","''",$row_insert_repactesnot['natdossier_repactesnot'])."','".str_replace("'","''",$row_insert_repactesnot['lien_fich'])."','".str_replace("'","''",$row_insert_repactesnot['Id_admin'])."','".str_replace("'","''",$row_insert_repactesnot['date_creation'])."','".str_replace("'","''",$row_insert_repactesnot['id_categorieaffaire'])."','".str_replace("'","''",$row_insert_repactesnot['section_rolegeneral'])."','".str_replace("'","''",$row_insert_repactesnot['id_juridiction'])."');";
	} while ($row_insert_repactesnot = mysql_fetch_assoc($insert_repactesnot));
}

if ($totalRows_insert_repdecision > 0) {
	$chaine=$chaine."Delete from rep_decision where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rep_decision (no_decision, nodec_decision, dispositif_decision, observation_decision, statut_decision, signature_greffier, signature_president, Id_admin, date_creation, no_rgsocial, statut_decision, id_juridiction) values ('".str_replace("'","''",$row_insert_repdecision['no_decision'])."','".str_replace("'","''",$row_insert_repdecision['nodec_decision'])."','".str_replace("'","''",$row_insert_repdecision['dispositif_decision'])."','".str_replace("'","''",$row_insert_repdecision['observation_decision'])."','".str_replace("'","''",$row_insert_repdecision['statut_decision'])."','".str_replace("'","''",$row_insert_repdecision['signature_greffier'])."','".str_replace("'","''",$row_insert_repdecision['signature_president'])."','".str_replace("'","''",$row_insert_repdecision['Id_admin'])."','".str_replace("'","''",$row_insert_repdecision['date_creation'])."','".str_replace("'","''",$row_insert_repdecision['no_rgsocial'])."','".str_replace("'","''",$row_insert_repdecision['statut_decision'])."','".str_replace("'","''",$row_insert_repdecision['id_juridiction'])."');";
	} while ($row_insert_repdecision = mysql_fetch_assoc($insert_repdecision));
}

if ($totalRows_insert_repjugementcorr > 0) {
	$chaine=$chaine."Delete from rep_jugementcorr where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rep_jugementcorr (no_repjugementcorr, nojugement_repjugementcorr, datejugement_repjugementcorr, no_regplaintes, naturedecision_repjugementcorr, decisiontribunal_repjugementcorr, id_noms, Id_admin, date_creation, id_juridiction, nomsprevenu_repjugementcorr, infraction_repjugementcorr) values ('".str_replace("'","''",$row_insert_repjugementcorr['no_repjugementcorr'])."','".str_replace("'","''",$row_insert_repjugementcorr['nojugement_repjugementcorr'])."','".str_replace("'","''",$row_insert_repjugementcorr['datejugement_repjugementcorr'])."','".str_replace("'","''",$row_insert_repjugementcorr['no_regplaintes'])."','".str_replace("'","''",$row_insert_repjugementcorr['naturedecision_repjugementcorr'])."','".str_replace("'","''",$row_insert_repjugementcorr['decisiontribunal_repjugementcorr'])."','".str_replace("'","''",$row_insert_repjugementcorr['id_noms'])."','".str_replace("'","''",$row_insert_repjugementcorr['Id_admin'])."','".str_replace("'","''",$row_insert_repjugementcorr['date_creation'])."','".str_replace("'","''",$row_insert_repjugementcorr['id_juridiction'])."','".str_replace("'","''",$row_insert_repjugementcorr['nomsprevenu_repjugementcorr'])."','".str_replace("'","''",$row_insert_repjugementcorr['infraction_repjugementcorr'])."');";
	} while ($row_insert_repjugementcorr = mysql_fetch_assoc($insert_repjugementcorr));
}

if ($totalRows_insert_repjugementsupp > 0) {
	$chaine=$chaine."Delete from rep_jugementsupp where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rep_jugementsupp (no_repjugementsupp, nojugement_repjugementsupp, dispositif_repjugementsupp, observation_repjugementsupp, Id_admin, date_creation, no_rolegeneral, statut_jugementsupp, id_juridiction, signature_greffier, signature_president, date_modif) values ('".str_replace("'","''",$row_insert_repjugementsupp['no_repjugementsupp'])."','".str_replace("'","''",$row_insert_repjugementsupp['nojugement_repjugementsupp'])."','".str_replace("'","''",$row_insert_repjugementsupp['dispositif_repjugementsupp'])."','".str_replace("'","''",$row_insert_repjugementsupp['observation_repjugementsupp'])."','".str_replace("'","''",$row_insert_repjugementsupp['Id_admin'])."','".str_replace("'","''",$row_insert_repjugementsupp['date_creation'])."','".str_replace("'","''",$row_insert_repjugementsupp['no_rolegeneral'])."','".str_replace("'","''",$row_insert_repjugementsupp['statut_jugementsupp'])."','".str_replace("'","''",$row_insert_repjugementsupp['id_juridiction'])."','".str_replace("'","''",$row_insert_repjugementsupp['signature_greffier'])."','".str_replace("'","''",$row_insert_repjugementsupp['signature_president'])."','".str_replace("'","''",$row_insert_repjugementsupp['date_modif'])."');";
	} while ($row_insert_repjugementsupp = mysql_fetch_assoc($insert_repjugementsupp));
}

if ($totalRows_insert_repordpresi > 0) {
	$chaine=$chaine."Delete from rep_ordpresi where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rep_ordpresi (no_ordonnance, noordonnace_ordonnance, dispositif_ordonnance, observation_ordonnance, lien_fich,Id_admin, date_creation, no_rolegeneral, id_juridiction) values ('".str_replace("'","''",$row_insert_repordpresi['no_ordonnance'])."','".str_replace("'","''",$row_insert_repordpresi['noordonnace_ordonnance'])."','".str_replace("'","''",$row_insert_repordpresi['dispositif_ordonnance'])."','".str_replace("'","''",$row_insert_repordpresi['observation_ordonnance'])."','".str_replace("'","''",$row_insert_repordpresi['lien_fich'])."','".str_replace("'","''",$row_insert_repordpresi['Id_admin'])."','".str_replace("'","''",$row_insert_repordpresi['date_creation'])."','".str_replace("'","''",$row_insert_repordpresi['no_rolegeneral'])."','".str_replace("'","''",$row_insert_repordpresi['id_juridiction'])."');";
	} while ($row_insert_repordpresi = mysql_fetch_assoc($insert_repordpresi));
}

if ($totalRows_insert_rgsocial > 0) {
	$chaine=$chaine."Delete from rg_social where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into rg_social (no_rgsocial, noordre_rgsocial, date_rgsocial, demandeur_rgsocial, defendeur_rgsocial, objet_rgsocial, observation_rgsocial, Id_admin, date_creation, dateaudience_rgsocial, id_categorieaffaire, section_rgsocial, id_juridiction) values ('".str_replace("'","''",$row_insert_rgsocial['no_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['noordre_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['date_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['demandeur_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['defendeur_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['objet_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['observation_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['Id_admin'])."','".str_replace("'","''",$row_insert_rgsocial['date_creation'])."','".str_replace("'","''",$row_insert_rgsocial['dateaudience_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['id_categorieaffaire'])."','".str_replace("'","''",$row_insert_rgsocial['section_rgsocial'])."','".str_replace("'","''",$row_insert_rgsocial['id_juridiction'])."');";
	} while ($row_insert_rgsocial = mysql_fetch_assoc($insert_rgsocial));
}

if ($totalRows_insert_rolegeneral > 0) {
	$chaine=$chaine."Delete from role_general where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into role_general (no_rolegeneral, noordre_rolegeneral, date_rolegeneral, demandeur_rolegeneral, defendeur_rolegeneral, objet_rolegeneral, observation_rolegeneral, Id_admin, date_creation, dateaudience_rolegeneral, section_rolegeneral, id_categorieaffaire, id_juridiction) values ('".str_replace("'","''",$row_insert_rolegeneral['no_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['noordre_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['date_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['demandeur_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['defendeur_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['objet_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['observation_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['Id_admin'])."','".str_replace("'","''",$row_insert_rolegeneral['date_creation'])."','".str_replace("'","''",$row_insert_rolegeneral['dateaudience_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['section_rolegeneral'])."','".str_replace("'","''",$row_insert_rolegeneral['id_categorieaffaire'])."','".str_replace("'","''",$row_insert_rolegeneral['id_juridiction'])."');";
	} while ($row_insert_rolegeneral = mysql_fetch_assoc($insert_rolegeneral));
}

if ($totalRows_insert_regdeces > 0) {
	$chaine=$chaine."Delete from  reg_deces where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_deces (id_regdeces, numodre_regdeces, date_regdeces, lieu_regdeces, details_regdeces, suite_regdeces, observation_regdeces, no_ecrou, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regdeces['id_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['numodre_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['date_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['lieu_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['details_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['suite_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['observation_regdeces'])."','".str_replace("'","''",$row_insert_regdeces['no_ecrou'])."','".str_replace("'","''",$row_insert_regdeces['Id_admin'])."','".str_replace("'","''",$row_insert_regdeces['date_creation'])."','".str_replace("'","''",$row_insert_regdeces['id_juridiction'])."');";
	} while ($row_insert_regdeces = mysql_fetch_assoc($insert_regdeces));
}

if ($totalRows_insert_regevasion > 0) {
	$chaine=$chaine."Delete from reg_evasion where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_evasion (id_regevasion, datevasion_regevasion, circonstance_regevasion, dateretour_regevasion, lieureintegration_regevasion, Id_admin, date_creation, id_juridiction, noordre_ecrou) values ('".str_replace("'","''",$row_insert_regevasion['id_regevasion'])."','".str_replace("'","''",$row_insert_regevasion['datevasion_regevasion'])."','".str_replace("'","''",$row_insert_regevasion['circonstance_regevasion'])."','".str_replace("'","''",$row_insert_regevasion['dateretour_regevasion'])."','".str_replace("'","''",$row_insert_regevasion['lieureintegration_regevasion'])."','".str_replace("'","''",$row_insert_regevasion['Id_admin'])."','".str_replace("'","''",$row_insert_regevasion['date_creation'])."','".str_replace("'","''",$row_insert_regevasion['id_juridiction'])."','".str_replace("'","''",$row_insert_regevasion['noordre_ecrou'])."');";
	} while ($row_insert_regevasion = mysql_fetch_assoc($insert_regevasion));
}

if ($totalRows_insert_levecrou > 0) {
	$chaine=$chaine."Delete from reg_levecrou where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_levecrou (id_reglevecrou, motif_reglevecrou, origine_reglevecrou, datedepart_reglevecrou, dateretour_reglevecrou, destination_reglevecrou, noordre_ecrou, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_levecrou['id_reglevecrou'])."','".str_replace("'","''",$row_insert_levecrou['motif_reglevecrou'])."','".str_replace("'","''",$row_insert_levecrou['origine_reglevecrou'])."','".str_replace("'","''",$row_insert_levecrou['datedepart_reglevecrou'])."','".str_replace("'","''",$row_insert_levecrou['dateretour_reglevecrou'])."','".str_replace("'","''",$row_insert_levecrou['destination_reglevecrou'])."','".str_replace("'","''",$row_insert_levecrou['noordre_ecrou'])."','".str_replace("'","''",$row_insert_levecrou['Id_admin'])."','".str_replace("'","''",$row_insert_levecrou['date_creation'])."','".str_replace("'","''",$row_insert_levecrou['id_juridiction'])."');";
	} while ($row_insert_levecrou = mysql_fetch_assoc($insert_levecrou));
}

if ($totalRows_insert_libcond > 0) {
	$chaine=$chaine."Delete from reg_libcond where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_libcond (id_reglibcond, numordre_reglibcond, ref_reglibcond, obs_reglibcond, no_ecrou, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_libcond['id_reglibcond'])."','".str_replace("'","''",$row_insert_libcond['numordre_reglibcond'])."','".str_replace("'","''",$row_insert_libcond['ref_reglibcond'])."','".str_replace("'","''",$row_insert_libcond['obs_reglibcond'])."','".str_replace("'","''",$row_insert_libcond['no_ecrou'])."','".str_replace("'","''",$row_insert_libcond['Id_admin'])."','".str_replace("'","''",$row_insert_libcond['date_creation'])."','".str_replace("'","''",$row_insert_libcond['id_juridiction'])."');";
	} while ($row_insert_libcond = mysql_fetch_assoc($insert_libcond));
}

if ($totalRows_insert_regpiece > 0) {
	$chaine=$chaine."Delete from reg_piece where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_piece (id_regpiece, nordre_regpiece, autorigine, Nopv, datepv, nomprevenus, naturescelle, lieuconserv,  nojugdecision, nordestruction, nordremise, daterestitution, nocni, emargement, observation, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regpiece['id_regpiece'])."','".str_replace("'","''",$row_insert_regpiece['nordre_regpiece'])."','".str_replace("'","''",$row_insert_regpiece['autorigine'])."','".str_replace("'","''",$row_insert_regpiece['Nopv'])."','".str_replace("'","''",$row_insert_regpiece['datepv'])."','".str_replace("'","''",$row_insert_regpiece['nomprevenus'])."','".str_replace("'","''",$row_insert_regpiece['naturescelle'])."','".str_replace("'","''",$row_insert_regpiece['lieuconserv'])."','".str_replace("'","''",$row_insert_regpiece['nojugdecision'])."','".str_replace("'","''",$row_insert_regpiece['nordestruction'])."','".str_replace("'","''",$row_insert_regpiece['nordremise'])."','".str_replace("'","''",$row_insert_regpiece['daterestitution'])."','".str_replace("'","''",$row_insert_regpiece['nocni'])."','".str_replace("'","''",$row_insert_regpiece['emargement'])."','".str_replace("'","''",$row_insert_regpiece['observation'])."','".str_replace("'","''",$row_insert_regpiece['Id_admin'])."','".str_replace("'","''",$row_insert_regpiece['date_creation'])."',,'".str_replace("'","''",$row_insert_regpiece['id_juridiction'])."');";
	} while ($row_insert_regpiece = mysql_fetch_assoc($insert_regpiece));
}

if ($totalRows_insert_plaintesnom > 0) {
	$chaine=$chaine."Delete from reg_plaintes_noms where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_plaintes_noms (id_noms, NomPreDomInculpes_plaintes, Domicile, age, NatInfraction_plaintes, cles_pivot,  Id_admin, id_juridiction) values ('".str_replace("'","''",$row_insert_plaintesnom['id_noms'])."','".str_replace("'","''",$row_insert_plaintesnom['NomPreDomInculpes_plaintes'])."','".str_replace("'","''",$row_insert_plaintesnom['Domicile'])."','".str_replace("'","''",$row_insert_plaintesnom['age'])."','".str_replace("'","''",$row_insert_plaintesnom['NatInfraction_plaintes'])."','".str_replace("'","''",$row_insert_plaintesnom['cles_pivot'])."','".str_replace("'","''",$row_insert_plaintesnom['Id_admin'])."','".str_replace("'","''",$row_insert_plaintesnom['id_juridiction'])."');";
	} while ($row_insert_plaintesnom = mysql_fetch_assoc($insert_plaintesnom));
}

if ($totalRows_insert_regsocialappel > 0) {
	$chaine=$chaine."Delete from reg_socialappel where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_socialappel (id_socialappel, no_socialappel, datejour, datejugement, Signature, no_decision, no_repjugementsupp, Id_admin, date_creation, date_modif, id_juridiction) values ('".str_replace("'","''",$row_insert_regsocialappel['id_socialappel'])."','".str_replace("'","''",$row_insert_regsocialappel['no_socialappel'])."','".str_replace("'","''",$row_insert_regsocialappel['datejour'])."','".str_replace("'","''",$row_insert_regsocialappel['datejugement'])."','".str_replace("'","''",$row_insert_regsocialappel['Signature'])."','".str_replace("'","''",$row_insert_regsocialappel['no_decision'])."','".str_replace("'","''",$row_insert_regsocialappel['no_repjugementsupp'])."','".str_replace("'","''",$row_insert_regsocialappel['Id_admin'])."','".str_replace("'","''",$row_insert_regsocialappel['date_creation'])."','".str_replace("'","''",$row_insert_regsocialappel['date_modif'])."','".str_replace("'","''",$row_insert_regsocialappel['id_juridiction'])."');";
	} while ($row_insert_regsocialappel = mysql_fetch_assoc($insert_regsocialappel));
}

if ($totalRows_insert_regsocialopp > 0) {
	$chaine=$chaine."Delete from reg_socialopposition where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_socialopposition (id_socialopp, noordre_socialopp, datejour, datejugdefaut, datesignification, newdataudience, signature, no_decision, no_repjugementsupp, Id_admin, date_creation, date_modif, id_juridiction) values ('".str_replace("'","''",$row_insert_regsocialopp['id_socialopp'])."','".str_replace("'","''",$row_insert_regsocialopp['noordre_socialopp'])."','".str_replace("'","''",$row_insert_regsocialopp['datejour'])."','".str_replace("'","''",$row_insert_regsocialopp['datejugdefaut'])."','".str_replace("'","''",$row_insert_regsocialopp['datesignification'])."','".str_replace("'","''",$row_insert_regsocialopp['newdataudience'])."','".str_replace("'","''",$row_insert_regsocialopp['signature'])."','".str_replace("'","''",$row_insert_regsocialopp['no_decision'])."','".str_replace("'","''",$row_insert_regsocialopp['no_repjugementsupp'])."','".str_replace("'","''",$row_insert_regsocialopp['Id_admin'])."','".str_replace("'","''",$row_insert_regsocialopp['date_creation'])."','".str_replace("'","''",$row_insert_regsocialopp['date_modif'])."','".str_replace("'","''",$row_insert_regsocialopp['id_juridiction'])."');";
	} while ($row_insert_regsocialopp = mysql_fetch_assoc($insert_regsocialopp));
}

if ($totalRows_insert_regtransfert > 0) {
	$chaine=$chaine."Delete from reg_transfert where ((id_juridiction=".$row_select_juridic['id_juridiction'].") AND (Id_admin=".$row_select_juridic['Id_admin']."));";
	do {
		$chaine=$chaine."Insert into reg_transfert (id_regtransfert, numordre_regtransfert, date_regtransfert, motif_regtransfert, destination_regtransfert, chef_regtransfert, obs_regtransfert, no_ecrou, Id_admin, date_creation, id_juridiction) values ('".str_replace("'","''",$row_insert_regtransfert['id_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['numordre_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['date_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['motif_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['destination_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['chef_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['obs_regtransfert'])."','".str_replace("'","''",$row_insert_regtransfert['no_ecrou'])."','".str_replace("'","''",$row_insert_regtransfert['Id_admin'])."','".str_replace("'","''",$row_insert_regtransfert['date_creation'])."','".str_replace("'","''",$row_insert_regtransfert['id_juridiction'])."');";
	} while ($row_insert_regtransfert = mysql_fetch_assoc($insert_regtransfert));
}

?>
<?php } 
else {
?>
<?php 
mysql_select_db($database_jursta, $jursta);
$query_insert_annees = "SELECT * FROM annees";
$insert_annees = mysql_query($query_insert_annees, $jursta) or die(mysql_error());
$row_insert_annees = mysql_fetch_assoc($insert_annees);
$totalRows_insert_annees = mysql_num_rows($insert_annees);

mysql_select_db($database_jursta, $jursta);
$query_insert_categirieaffaire = "SELECT * FROM categorie_affaire";
$insert_categirieaffaire = mysql_query($query_insert_categirieaffaire, $jursta) or die(mysql_error());
$row_insert_categirieaffaire = mysql_fetch_assoc($insert_categirieaffaire);
$totalRows_insert_categirieaffaire = mysql_num_rows($insert_categirieaffaire);

mysql_select_db($database_jursta, $jursta);
$query_insert_commune = "SELECT * FROM commune";
$insert_commune = mysql_query($query_insert_commune, $jursta) or die(mysql_error());
$row_insert_commune = mysql_fetch_assoc($insert_commune);
$totalRows_insert_commune = mysql_num_rows($insert_commune);

mysql_select_db($database_jursta, $jursta);
$query_insert_departement = "SELECT * FROM departement";
$insert_departement = mysql_query($query_insert_departement, $jursta) or die(mysql_error());
$row_insert_departement = mysql_fetch_assoc($insert_departement);
$totalRows_insert_departement = mysql_num_rows($insert_departement);

mysql_select_db($database_jursta, $jursta);
$query_insert_juridiction = "SELECT * FROM juridiction";
$insert_juridiction = mysql_query($query_insert_juridiction, $jursta) or die(mysql_error());
$row_insert_juridiction = mysql_fetch_assoc($insert_juridiction);
$totalRows_insert_juridiction = mysql_num_rows($insert_juridiction);

mysql_select_db($database_jursta, $jursta);
$query_insert_region = "SELECT * FROM region";
$insert_region = mysql_query($query_insert_region, $jursta) or die(mysql_error());
$row_insert_region = mysql_fetch_assoc($insert_region);
$totalRows_insert_region = mysql_num_rows($insert_region);

mysql_select_db($database_jursta, $jursta);
$query_insert_typejuridiction = "SELECT * FROM type_juridiction";
$insert_typejuridiction = mysql_query($query_insert_typejuridiction, $jursta) or die(mysql_error());
$row_insert_typejuridiction = mysql_fetch_assoc($insert_typejuridiction);
$totalRows_insert_typejuridiction = mysql_num_rows($insert_typejuridiction);

mysql_select_db($database_jursta, $jursta);
$query_insert_dispositif = "SELECT * FROM dispositifs";
$insert_dispositif = mysql_query($query_insert_dispositif, $jursta) or die(mysql_error());
$row_insert_dispositif = mysql_fetch_assoc($insert_dispositif);
$totalRows_insert_dispositif = mysql_num_rows($insert_dispositif);

?>
<?php 
if ($totalRows_insert_annees > 0) {
	$chaine=$chaine."Delete from annees;";
	do {
		$chaine=$chaine."Insert into annees (annee)  values ('".str_replace("'","''",$row_insert_annees['annee'])."');";
	} while ($row_insert_annees = mysql_fetch_assoc($insert_annees));
}

if ($totalRows_insert_categirieaffaire > 0) {
	$chaine=$chaine."Delete from categorie_affaire;";
	do {
		$chaine=$chaine."Insert into categorie_affaire (id_categorieaffaire,lib_categorieaffaire,justice_categorieaffaire) values ('".str_replace("'","''",$row_insert_categirieaffaire['id_categorieaffaire'])."','".str_replace("'","''",$row_insert_categirieaffaire['lib_categorieaffaire'])."','".str_replace("'","''",$row_insert_categirieaffaire['justice_categorieaffaire'])."');";
	} while ($row_insert_categirieaffaire = mysql_fetch_assoc($insert_categirieaffaire));
}

if ($totalRows_insert_commune > 0) {
	$chaine=$chaine."Delete from commune;";
	do {
		$chaine=$chaine."Insert into commune (id_commune,lib_commune) values ('".str_replace("'","''",$row_insert_commune['id_commune'])."','".str_replace("'","''",$row_insert_commune['lib_commune'])."');";
	} while ($row_insert_commune = mysql_fetch_assoc($insert_commune));
}

if ($totalRows_insert_departement > 0) {
	$chaine=$chaine."Delete from departement;";
	do {
		$chaine=$chaine."Insert into departement (id_departement,lib_departement) values ('".str_replace("'","''",$row_insert_departement['id_departement'])."','".str_replace("'","''",$row_insert_departement['lib_departement'])."');";
	} while ($row_insert_departement = mysql_fetch_assoc($insert_departement));
}

if ($totalRows_insert_juridiction > 0) {
	$chaine=$chaine."Delete from juridiction;";
	do {
		$chaine=$chaine."Insert into juridiction (id_juridiction,lib_juridiction,id_commune,id_typejuridiction,id_juridictiontutelle,annee) values ('".str_replace("'","''",$row_insert_juridiction['id_juridiction'])."','".str_replace("'","''",$row_insert_juridiction['lib_juridiction'])."','".str_replace("'","''",$row_insert_juridiction['id_commune'])."','".str_replace("'","''",$row_insert_juridiction['id_typejuridiction'])."','".str_replace("'","''",$row_insert_juridiction['id_juridictiontutelle'])."','".str_replace("'","''",$row_insert_juridiction['annee'])."');";
	} while ($row_insert_juridiction = mysql_fetch_assoc($insert_juridiction));
}

if ($totalRows_insert_region > 0) {
	$chaine=$chaine."Delete from region;";
	do {
		$chaine=$chaine."Insert into region (id_region) values ('".str_replace("'","''",$row_insert_region['id_region'])."');";
	} while ($row_insert_region = mysql_fetch_assoc($insert_region));
}

if ($totalRows_insert_typejuridiction > 0) {
	$chaine=$chaine."Delete from type_juridiction;";
	do {
		$chaine=$chaine."Insert into type_juridiction (id_typejuridiction,lib_typejuridiction) values ('".str_replace("'","''",$row_insert_typejuridiction['id_typejuridiction'])."','".str_replace("'","''",$row_insert_typejuridiction['lib_typejuridiction'])."');";
	} while ($row_insert_typejuridiction = mysql_fetch_assoc($insert_typejuridiction));
}

if ($totalRows_insert_dispositif > 0) {
	$chaine=$chaine."Delete from dispositifs;";
	do {
		$chaine=$chaine."Insert into dispositifs (id,libellé) values ('".str_replace("'","''",$row_insert_dispositif['id'])."','".str_replace("'","''",$row_insert_dispositif['libellé'])."');";
	} while ($row_insert_dispositif = mysql_fetch_assoc($insert_dispositif));
}
?>
<?php } ?>
<?php
if ($row_select_administre['type_admin'] != 'Superviseur') { 
	$fichier=str_replace("'","_",str_replace(" ","_",$row_select_juridic['lib_juridiction']))."_".$row_select_juridic['id_juridiction']."_Date_".date("d_m_Y").".sql";
}
else {
	$fichier="Superviseur.sql";
}
header('Content-type: text/plain');
header("Content-Disposition: application/force-download; name=".$fichier."");
header("Content-Disposition: attachment; filename=".$fichier."");
echo $chaine;



mysql_free_result($select_administre);
?>
