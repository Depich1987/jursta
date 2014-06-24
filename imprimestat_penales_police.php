<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Penale,Administrateur,Superviseur,AdminPenal";
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

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Penale'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);

$colname_select_juridiction = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridiction = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridiction = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridiction, "text"));
$select_juridiction = mysql_query($query_select_juridiction, $jursta) or die(mysql_error());
$row_select_juridiction = mysql_fetch_assoc($select_juridiction);
$totalRows_select_juridiction = mysql_num_rows($select_juridiction);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="icon" href="images/favicon.ico">
</head>

<body>
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span><img src="images/forms48.png" width="32" border="0"></span></td>
                      <td width="100%"><div align="center">
                        <p><strong><?php echo $row_select_juridiction['lib_typejuridiction']; ?> DE <?php echo substr($row_select_juridiction['lib_juridiction'],2,10); ?></strong></p>
                        <p><strong>STATISTIQUE DES DONNEES PROVENANTS DES SERVICES DE POLICE ET </strong></p>
                        <p><strong>DE GENDAMERIE ET DES SAISINES DE PARQUET
                          <?php 
if ($row_select_juridiction['id_juridiction'] == 55) {
	if ((isset($_GET['du'])) && (isset($_GET['au']))) {
		echo("PERIODE DU ".$_GET['du']." au ".$_GET['au']);
	}
}
else { 
switch ($_POST['mois']){
	case "01": $mois="Janvier";
	break;
		case "02": $mois="Fevrier";
	break;
		case "03": $mois="Mars";
	break;
		case "04": $mois="Avril";
	break;
		case "05": $mois="Mai";
	break;
		case "06": $mois="Juin";
	break;
		case "07": $mois="Juillet";
	break;
		case "08": $mois="Août";
	break;
		case "09": $mois="Septembre";
	break;
		case "10": $mois="Octobre";
	break;
		case "11": $mois="Novembre";
	break;
		case "12": $mois="Décembre";
}
	echo Change_formatDate("période de ".$mois." ".$_POST['annee']);
}
?> 
                        </strong></p>
                      </div></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" ><p>&nbsp;</p>
                  <table>
                    <tr>
                      <td bgcolor="#000000"><table width="940" cellpadding="3" cellspacing="1" >
                        <tr>
                          <td colspan="2" rowspan="2" bgcolor="#FFFFFF">&nbsp;</td>
                          <td colspan="2" rowspan="2" align="center" bgcolor="#FFFFFF"><p>Constats Service de Police et de Gendamerie</p></td>
                          <td colspan="7" align="center" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="8">
                              <tr>
                                <td align="center"> Saisine des Parquets </td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="5" align="center" bgcolor="#FFFFFF"><p>Proc&egrave;s verbaux </p></td>
                          <td colspan="2" align="center" bgcolor="#FFFFFF">Autres Affaires P&eacute;nales</td>
                        </tr>
                        <tr bgcolor="#6186AF">
                          <td align="center" bgcolor="#FFFFFF">#</td>
                          <td width="100%" align="center" bgcolor="#FFFFFF">Nature</td>
                          <td align="center" bgcolor="#FFFFFF">Crimes et D&eacute;lits Constat&eacute;s </td>
                          <td align="center" bgcolor="#FFFFFF">Crimes et D&eacute;lits Poursuivis </td>
                          <td align="center" bgcolor="#FFFFFF">PV Plaintes D&eacute;nonciation </td>
                          <td align="center" bgcolor="#FFFFFF">PV Auteurs Inconnus </td>
                          <td align="center" bgcolor="#FFFFFF">PV Crimes </td>
                          <td align="center" bgcolor="#FFFFFF">PV d&eacute;lits </td>
                          <td align="center" bgcolor="#FFFFFF">PV Contrav.&amp; Inf. Non pr&eacute;cises </td>
                          <td align="center" bgcolor="#FFFFFF">Total</td>
                          <td align="center" bgcolor="#FFFFFF">Dont Proc&eacute;dure prov. autres parquets </td>
                        </tr>
                        <?php
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_POST['id_juridiction'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_POST['id_juridiction'] : addslashes($_POST['id_juridiction']);
	}
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
}

?>
                        <?php do { ?>
                        <?php
$categorie = $row_liste_nature['id_categorieaffaire'];

$mois_crimes_constates = "-1";
if (isset($_POST['mois'])) {
  $mois_crimes_constates = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_crimes_constates = "-1";
if (isset($_POST['annee'])) {
  $annee_crimes_constates = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}


mysql_select_db($database_jursta, $jursta);
$query_crimes_constates = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constatée') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_crimes_constates."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_crimes_constates."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$crimes_constates = mysql_query($query_crimes_constates, $jursta) or die(mysql_error());
$row_crimes_constates = mysql_fetch_assoc($crimes_constates);
$totalRows_crimes_constates = mysql_num_rows($crimes_constates);

$mois_crimes_poursuivis = "-1";
if (isset($_POST['mois'])) {
  $mois_crimes_poursuivis = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_crimes_poursuivis = "-1";
if (isset($_POST['annee'])) {
  $annee_crimes_poursuivis = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_crimes_poursuivis = "SELECT count(*) as crimes_poursuivis FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Poursuivis') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_crimes_poursuivis."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_crimes_poursuivis."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$crimes_poursuivis = mysql_query($query_crimes_poursuivis, $jursta) or die(mysql_error());
$row_crimes_poursuivis = mysql_fetch_assoc($crimes_poursuivis);
$totalRows_crimes_poursuivis = mysql_num_rows($crimes_poursuivis);

$mois_pvdedenonciation = "-1";
if (isset($_POST['mois'])) {
  $mois_pvdedenonciation = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_pvdedenonciation = "-1";
if (isset($_POST['annee'])) {
  $annee_pvdedenonciation = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_pvdedenonciation = "SELECT count(*) as pvdedenonciation FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=1) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvdedenonciation."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvdedenonciation."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvdedenonciation = mysql_query($query_pvdedenonciation, $jursta) or die(mysql_error());
$row_pvdedenonciation = mysql_fetch_assoc($pvdedenonciation);
$totalRows_pvdedenonciation = mysql_num_rows($pvdedenonciation);

$mois_pvauteurinconnus = "-1";
if (isset($_POST['mois'])) {
  $mois_pvauteurinconnus = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_pvauteurinconnus = "-1";
if (isset($_POST['annee'])) {
  $annee_pvauteurinconnus = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_pvauteurinconnus = "SELECT count(*) as pvauteurinconnus FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (UCASE(reg_plaintes.NomPreDomInculpes_plaintes)='INCONNU') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvauteurinconnus."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvauteurinconnus."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvauteurinconnus = mysql_query($query_pvauteurinconnus, $jursta) or die(mysql_error());
$row_pvauteurinconnus = mysql_fetch_assoc($pvauteurinconnus);
$totalRows_pvauteurinconnus = mysql_num_rows($pvauteurinconnus);

$mois_pvcrimes = "-1";
if (isset($_POST['mois'])) {
  $mois_pvcrimes = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_pvcrimes = "-1";
if (isset($_POST['annee'])) {
  $annee_pvcrimes = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_pvcrimes = "SELECT count(*) as pvdecrimes FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=2) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvcrimes."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvcrimes."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvcrimes = mysql_query($query_pvcrimes, $jursta) or die(mysql_error());
$row_pvcrimes = mysql_fetch_assoc($pvcrimes);
$totalRows_pvcrimes = mysql_num_rows($pvcrimes);

$mois_pvdelit = "-1";
if (isset($_POST['mois'])) {
  $mois_pvdelit = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_pvdelit = "-1";
if (isset($_POST['annee'])) {
  $annee_pvdelit = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_pvdelit = "SELECT count(*) as pvdedelit FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=3) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvdelit."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvdelit."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvdelit = mysql_query($query_pvdelit, $jursta) or die(mysql_error());
$row_pvdelit = mysql_fetch_assoc($pvdelit);
$totalRows_pvdelit = mysql_num_rows($pvdelit);

$mois_pvcontraventions = "-1";
if (isset($_POST['mois'])) {
  $mois_pvcontraventions = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_pvcontraventions = "-1";
if (isset($_POST['annee'])) {
  $annee_pvcontraventions = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_pvcontraventions = "SELECT count(*) as pvdecontraventions FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=4) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvcontraventions."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvcontraventions."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvcontraventions = mysql_query($query_pvcontraventions, $jursta) or die(mysql_error());
$row_pvcontraventions = mysql_fetch_assoc($pvcontraventions);
$totalRows_pvcontraventions = mysql_num_rows($pvcontraventions);

$mois_affairepenals = "-1";
if (isset($_POST['mois'])) {
  $mois_affairepenals = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_affairepenals = "-1";
if (isset($_POST['annee'])) {
  $annee_affairepenals = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affairepenals."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affairepenals."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affairepenals = mysql_query($query_affairepenals, $jursta) or die(mysql_error());
$row_affairepenals = mysql_fetch_assoc($affairepenals);
$totalRows_affairepenals = mysql_num_rows($affairepenals);

$mois_affaireautresparquet = "-1";
if (isset($_POST['mois'])) {
  $mois_affaireautresparquet = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_affaireautresparquet = "-1";
if (isset($_POST['annee'])) {
  $annee_affaireautresparquet = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}

mysql_select_db($database_jursta, $jursta);
$query_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affaireautresparquet."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affaireautresparquet."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affaireautresparquet = mysql_query($query_affaireautresparquet, $jursta) or die(mysql_error());
$row_affaireautresparquet = mysql_fetch_assoc($affaireautresparquet);
$totalRows_affaireautresparquet = mysql_num_rows($affaireautresparquet);

mysql_select_db($database_jursta, $jursta);
$query_total_crimes_constatees = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constatée') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_crimes_constates."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_crimes_constates."') )";
$total_crimes_constatees = mysql_query($query_total_crimes_constatees, $jursta) or die(mysql_error());
$row_total_crimes_constatees = mysql_fetch_assoc($total_crimes_constatees);
$totalRows_total_crimes_constatees = mysql_num_rows($total_crimes_constatees);

mysql_select_db($database_jursta, $jursta);
$query_total_crimes_poursuivis = "SELECT count(*) as crimes_poursuivis FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Poursuivis') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_crimes_poursuivis."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_crimes_poursuivis."'))";
$total_crimes_poursuivis = mysql_query($query_total_crimes_poursuivis, $jursta) or die(mysql_error());
$row_total_crimes_poursuivis = mysql_fetch_assoc($total_crimes_poursuivis);
$totalRows_total_crimes_poursuivis = mysql_num_rows($total_crimes_poursuivis);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdedenonciation = "SELECT count(*) as pvdedenonciation FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=1) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvdedenonciation."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvdedenonciation."') )";
$total_pvdedenonciation = mysql_query($query_total_pvdedenonciation, $jursta) or die(mysql_error());
$row_total_pvdedenonciation = mysql_fetch_assoc($total_pvdedenonciation);
$totalRows_total_pvdedenonciation = mysql_num_rows($total_pvdedenonciation);

mysql_select_db($database_jursta, $jursta);
$query_total_pvauteurinconnus = "SELECT count(*) as pvauteurinconnus FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (UCASE(reg_plaintes.NomPreDomInculpes_plaintes)='INCONNU') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvauteurinconnus."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvauteurinconnus."'))";
$total_pvauteurinconnus = mysql_query($query_total_pvauteurinconnus, $jursta) or die(mysql_error());
$row_total_pvauteurinconnus = mysql_fetch_assoc($total_pvauteurinconnus);
$totalRows_total_pvauteurinconnus = mysql_num_rows($total_pvauteurinconnus);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdecrimes = "SELECT count(*) as pvdecrimes FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=2) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvcrimes."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvcrimes."'))";
$total_pvdecrimes = mysql_query($query_total_pvdecrimes, $jursta) or die(mysql_error());
$row_total_pvdecrimes = mysql_fetch_assoc($total_pvdecrimes);
$totalRows_total_pvdecrimes = mysql_num_rows($total_pvdecrimes);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdedelit = "SELECT count(*) as pvdedelit FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=3) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvdelit."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvdelit."'))";
$total_pvdedelit = mysql_query($query_total_pvdedelit, $jursta) or die(mysql_error());
$row_total_pvdedelit = mysql_fetch_assoc($total_pvdedelit);
$totalRows_total_pvdedelit = mysql_num_rows($total_pvdedelit);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdecontraventions = "SELECT count(*) as pvdecontraventions FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=4) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_pvcontraventions."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_pvcontraventions."') )";
$total_pvdecontraventions = mysql_query($query_total_pvdecontraventions, $jursta) or die(mysql_error());
$row_total_pvdecontraventions = mysql_fetch_assoc($total_pvdecontraventions);
$totalRows_total_pvdecontraventions = mysql_num_rows($total_pvdecontraventions);

mysql_select_db($database_jursta, $jursta);
$query_total_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affairepenals."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affairepenals."'))";
$total_affairepenals = mysql_query($query_total_affairepenals, $jursta) or die(mysql_error());
$row_total_affairepenals = mysql_fetch_assoc($total_affairepenals);
$totalRows_total_affairepenals = mysql_num_rows($total_affairepenals);

mysql_select_db($database_jursta, $jursta);
$query_total_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affaireautresparquet."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affaireautresparquet."'))";
$total_affaireautresparquet = mysql_query($query_total_affaireautresparquet, $jursta) or die(mysql_error());
$row_total_affaireautresparquet = mysql_fetch_assoc($total_affaireautresparquet);
$totalRows_total_affaireautresparquet = mysql_num_rows($total_affaireautresparquet);
?>
<tbody>
                        <tr bgcolor="#EDF0F3">
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_liste_nature['id_categorieaffaire']; ?></td>
                          <td align="left" bgcolor="#FFFFFF"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_crimes_constates['crimes_constatees']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_crimes_poursuivis['crimes_poursuivis']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_pvdedenonciation['pvdedenonciation']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_pvauteurinconnus['pvauteurinconnus']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_pvcrimes['pvdecrimes']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_pvdelit['pvdedelit']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_pvcontraventions['pvdecontraventions']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_affairepenals['affairepenals']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo $row_affaireautresparquet['affaireautresparquet']; ?></td>
                        </tr>
                        </tbody>
                                                <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
                        <tr align="center" bgcolor="#677787">
                          <td colspan="2" bgcolor="#FFFFFF"><strong>Total</strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_crimes_constatees['crimes_constatees']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_crimes_poursuivis['crimes_poursuivis']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_pvdedenonciation['pvdedenonciation']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_pvauteurinconnus['pvauteurinconnus']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_pvdecrimes['pvdecrimes']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_pvdedelit['pvdedelit']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_pvdecontraventions['pvdecontraventions']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_affairepenals['affairepenals']; ?></strong></td>
                          <td bgcolor="#FFFFFF"><strong><?php echo $row_total_affaireautresparquet['affaireautresparquet']; ?></strong></td>
                        </tr>
                        <tr bgcolor="#677787">
                          <td colspan="11" align="center" bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="1"></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                </td>
              </tr>
          </table></td>
        </tr>
        </table></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
