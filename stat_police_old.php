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

$colname_select_juridiction = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridiction = $_SESSION['MM_Username'];
}

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Penale'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);

mysql_select_db($database_jursta, $jursta);
$query_liste_typejuridiction = "SELECT * FROM type_juridiction WHERE (id_typejuridiction <> 5) ORDER BY lib_typejuridiction ASC";
$liste_typejuridiction = mysql_query($query_liste_typejuridiction, $jursta) or die(mysql_error());
$row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
$totalRows_liste_typejuridiction = mysql_num_rows($liste_typejuridiction);

$colname_liste_juridiction = "-1";
if (isset($_POST['id_typejuridiction'])) {
  $colname_liste_juridiction = $_POST['id_typejuridiction'];
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", GetSQLValueString($colname_liste_juridiction, "int"));
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);

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
  </script></head>

<body class="stat">
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td background="images/index_01.gif"><?php require_once('haut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuhaut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuidentity.php'); ?></td>
  </tr>
  <tr>
    <td><table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                      <td width="100%" align="center"><span class="Style2">FICHE STATISTIQUE DES DONNEES PROVENANTS DES SERVICES DE POLICE, DE GENDAMERIE ET DES SAISINES DE PARQUET <?php if ((isset($_POST['mois'])) && (isset($_POST['annee']))) echo("PERIODE DE ".$_POST['mois']."/".$_POST['annee']) ?> </span> </td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" ><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">                
                  <table align="center" cellpadding="3" cellspacing="0" >
                    <tr bgcolor="#EDF0F3" class="Style22">
                      <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
                      <td align="right" nowrap>Type de juridiction : </td>
                      <td nowrap><select name="id_typejuridiction" id="id_typejuridiction" onChange="document.form1.submit();">
                        <option value="-1" <?php if (!(strcmp(-1, $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>>Selectionner... </option>
                        <?php
do {  
?><option value="<?php echo $row_liste_typejuridiction['id_typejuridiction']?>"<?php if (!(strcmp($row_liste_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_liste_typejuridiction['lib_typejuridiction']?></option>
                        <?php
} while ($row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction));
  $rows = mysql_num_rows($liste_typejuridiction);
  if($rows > 0) {
      mysql_data_seek($liste_typejuridiction, 0);
	  $row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
  }
?>
                      </select></td>
<?php if (($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))){ ?>					  
                      <td align="center" nowrap>Juridiction : </td>
                      <td nowrap><select name="id_juridiction" id="id_juridiction" onChange="document.form1.submit();">
                        <option value="-1" <?php if (!(strcmp(-1, $_POST['id_juridiction']))) {echo "selected=\"selected\"";} ?>>Selectionner...</option>
                        <?php
do {  
?><option value="<?php echo $row_liste_juridiction['id_juridiction']?>"<?php if (!(strcmp($row_liste_juridiction['id_juridiction'], $_POST['id_juridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_liste_juridiction['lib_juridiction']?></option>
                        <?php
} while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction));
  $rows = mysql_num_rows($liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($liste_juridiction, 0);
	  $row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
  }
?>
                      </select></td>
<?php } ?>				  
                      <?php } // Show if recordset empty ?>
<?php if ((($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))) || ($row_select_juridiction['id_juridiction'] != 55)){ ?>	
                      <td align="right" nowrap>Mois : </td>
                      <td nowrap><select name="mois" id="mois">
                          <option value="01" <?php if (!(strcmp('01', $_POST['mois']))) {echo "SELECTED";} ?>>Janvier</option>
                          <option value="02" <?php if (!(strcmp('02', $_POST['mois']))) {echo "SELECTED";} ?>>F&eacute;vrier</option>
                          <option value="03" <?php if (!(strcmp('03', $_POST['mois']))) {echo "SELECTED";} ?>>Mars</option>
                          <option value="04" <?php if (!(strcmp('04', $_POST['mois']))) {echo "SELECTED";} ?>>Avril</option>
                          <option value="05" <?php if (!(strcmp('05', $_POST['mois']))) {echo "SELECTED";} ?>>Mai</option>
                          <option value="06" <?php if (!(strcmp('06', $_POST['mois']))) {echo "SELECTED";} ?>>Juin</option>
                          <option value="07" <?php if (!(strcmp('07', $_POST['mois']))) {echo "SELECTED";} ?>>Juillet</option>
                          <option value="08" <?php if (!(strcmp('08', $_POST['mois']))) {echo "SELECTED";} ?>>Ao&ucirc;t</option>
                          <option value="09" <?php if (!(strcmp('09', $_POST['mois']))) {echo "SELECTED";} ?>>Septembre</option>
                          <option value="10" <?php if (!(strcmp('10', $_POST['mois']))) {echo "SELECTED";} ?>>Octobre</option>
                          <option value="11" <?php if (!(strcmp('11', $_POST['mois']))) {echo "SELECTED";} ?>>Novembre</option>
                          <option value="12" <?php if (!(strcmp('12', $_POST['mois']))) {echo "SELECTED";} ?>>D&eacute;cembre</option>
                      </select></td>
                      <td nowrap>Ann&eacute;e</td>
                      <td nowrap><select name="annee" id="annee">
                          <option value="2010" <?php if (!(strcmp(2010, $_POST['annee']))) {echo "SELECTED";} ?>>2010</option>
<option value="2011" <?php if (!(strcmp(2011, $_POST['annee']))) {echo "SELECTED";} ?>>2011</option>
<option value="2012" <?php if (!(strcmp(2012, $_POST['annee']))) {echo "SELECTED";} ?>>2012</option>
<option value="2013" <?php if (!(strcmp(2013, $_POST['annee']))) {echo "SELECTED";} ?>>2013</option>
<option value="2014" <?php if (!(strcmp(2014, $_POST['annee']))) {echo "SELECTED";} ?>>2014</option>
<option value="2015" <?php if (!(strcmp(2015, $_POST['annee']))) {echo "SELECTED";} ?>>2015</option>
<option value="2016" <?php if (!(strcmp(2016, $_POST['annee']))) {echo "SELECTED";} ?>>2016</option>
<option value="2017" <?php if (!(strcmp(2017, $_POST['annee']))) {echo "SELECTED";} ?>>2017</option>
<option value="2018" <?php if (!(strcmp(2018, $_POST['annee']))) {echo "SELECTED";} ?>>2018</option>
<option value="2019" <?php if (!(strcmp(2019, $_POST['annee']))) {echo "SELECTED";} ?>>2019</option>
<option value="2020" <?php if (!(strcmp(2020, $_POST['annee']))) {echo "SELECTED";} ?>>2020</option>
<option value="2010" <?php if (!(strcmp(2021, $_POST['annee']))) {echo "SELECTED";} ?>>2021</option>
<option value="2011" <?php if (!(strcmp(2022, $_POST['annee']))) {echo "SELECTED";} ?>>2022</option>
<option value="2012" <?php if (!(strcmp(2023, $_POST['annee']))) {echo "SELECTED";} ?>>2023</option>
<option value="2013" <?php if (!(strcmp(2024, $_POST['annee']))) {echo "SELECTED";} ?>>2024</option>
<option value="2014" <?php if (!(strcmp(2025, $_POST['annee']))) {echo "SELECTED";} ?>>2025</option>
<option value="2015" <?php if (!(strcmp(2026, $_POST['annee']))) {echo "SELECTED";} ?>>2026</option>
<option value="2016" <?php if (!(strcmp(2027, $_POST['annee']))) {echo "SELECTED";} ?>>2027</option>
<option value="2017" <?php if (!(strcmp(2028, $_POST['annee']))) {echo "SELECTED";} ?>>2028</option>
<option value="2018" <?php if (!(strcmp(2030, $_POST['annee']))) {echo "SELECTED";} ?>>2029</option>
<option value="2019" <?php if (!(strcmp(2031, $_POST['annee']))) {echo "SELECTED";} ?>>2030</option>
<option value="2020" <?php if (!(strcmp(2032, $_POST['annee']))) {echo "SELECTED";} ?>>2031</option>
                      </select></td> 
                      <td  nowrap><input name="Afficher_cmd" type="submit" id="Afficher_cmd" value="Afficher"></td>
<?php } ?>
                    </tr>
                  </table>          
                  </form>                
                  <?php if ((isset($_POST['Afficher_cmd'])) && ($_POST['Afficher_cmd']=="Afficher")){  ?>
                  <table width="940" cellpadding="3" cellspacing="1" >
                    <tr>
                      <td colspan="2" rowspan="2">&nbsp;</td>
                      <td colspan="2" rowspan="2" align="center" bgcolor="#677787" class="Style22"><p>Constats Service de Police et de Gendamerie</p></td>
                      <td colspan="7" align="center" bgcolor="#677787" class="Style22"> <table width="100%"  border="0" cellspacing="0" cellpadding="8">
                          <tr>
                            <td align="center" class="Style22"> Saisine des Parquets </td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center" bgcolor="#677787" class="Style22"><p>Proc&egrave;s verbaux </p></td>
                      <td colspan="2" align="center" bgcolor="#677787" class="Style22">Autres Affaires P&eacute;nales</td>
                    </tr>
                    <tr bgcolor="#6186AF" class="Style22">
                      <td align="center">#</td>
                      <td width="100%" align="center">Nature</td>
                      <td align="center"><div align="center">Crimes et D&eacute;lits Constat&eacute;s </div></td>
                      <td align="center"><div align="center">Crimes et D&eacute;lits Poursuivis </div></td>
                      <td align="center"><div align="center">PV Plaintes D&eacute;nonciation </div></td>
                      <td align="center"><div align="center">PV Auteurs Inconnus </div></td>
                      <td align="center">
                      <div align="center">PV Crimes </div></td>
                      <td align="center">
                      <div align="center">PV d&eacute;lits </div></td>
                      <td align="center"><p align="center">PV Contrav.&amp; Inf. Non pr&eacute;cises </p></td>
                      <td align="center">
                      <div align="center">Total</div></td>
                      <td align="center"><p align="center">Dont Proc&eacute;dure prov. autres parquets </p></td>
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
$query_crimes_constates = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constat�e') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_crimes_constates."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_crimes_constates."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
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
$query_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires p�nales') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affairepenals."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affairepenals."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
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
$query_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires p�nales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affaireautresparquet."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affaireautresparquet."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affaireautresparquet = mysql_query($query_affaireautresparquet, $jursta) or die(mysql_error());
$row_affaireautresparquet = mysql_fetch_assoc($affaireautresparquet);
$totalRows_affaireautresparquet = mysql_num_rows($affaireautresparquet);

mysql_select_db($database_jursta, $jursta);
$query_total_crimes_constatees = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constat�e') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_crimes_constates."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_crimes_constates."') )";
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
$query_total_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires p�nales') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affairepenals."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affairepenals."'))";
$total_affairepenals = mysql_query($query_total_affairepenals, $jursta) or die(mysql_error());
$row_total_affairepenals = mysql_fetch_assoc($total_affairepenals);
$totalRows_total_affairepenals = mysql_num_rows($total_affairepenals);

mysql_select_db($database_jursta, $jursta);
$query_total_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires p�nales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (substr(reg_plaintes.date_creation,6,2)='".$mois_affaireautresparquet."') AND (substr(reg_plaintes.date_creation,1,4)='".$annee_affaireautresparquet."'))";
$total_affaireautresparquet = mysql_query($query_total_affaireautresparquet, $jursta) or die(mysql_error());
$row_total_affaireautresparquet = mysql_fetch_assoc($total_affaireautresparquet);
$totalRows_total_affaireautresparquet = mysql_num_rows($total_affaireautresparquet);
?>
					
                    <tr bgcolor="#EDF0F3" class="Style22">
                      <td align="center" bgcolor="#EDF0F3" class="Style22"><?php echo $row_liste_nature['id_categorieaffaire']; ?></td>
                      <td align="left"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_crimes_constates['crimes_constatees']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_crimes_poursuivis['crimes_poursuivis']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_pvdedenonciation['pvdedenonciation']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_pvauteurinconnus['pvauteurinconnus']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_pvcrimes['pvdecrimes']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_pvdelit['pvdedelit']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_pvcontraventions['pvdecontraventions']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_affairepenals['affairepenals']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_affaireautresparquet['affaireautresparquet']; ?></td>
                    </tr>
                    <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
<tr align="center" bgcolor="#677787" class="Style11">
                      <td colspan="2" class="Style22"><strong>Total</strong></td>
                      <td class="Style22"><strong><?php echo $row_total_crimes_constatees['crimes_constatees']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_crimes_poursuivis['crimes_poursuivis']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_pvdedenonciation['pvdedenonciation']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_pvauteurinconnus['pvauteurinconnus']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_pvdecrimes['pvdecrimes']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_pvdedelit['pvdedelit']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_pvdecontraventions['pvdecontraventions']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_affairepenals['affairepenals']; ?></strong></td>
                      <td class="Style22"><strong><?php echo $row_total_affaireautresparquet['affaireautresparquet']; ?></strong></td>
                    </tr>
                    <tr bgcolor="#677787">
                      <td colspan="11" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
                    </tr>
                  </table>
                  <form action="paramimprim.php" method="post" name="form2" id="form2">
  <table width="940" ><tr><td align="right"><table width="940" >
    <tr>
      <td align="right"><?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
          <input name="id_typejuridiction" type="hidden" id="id_typejuridiction" value="<?php echo $_POST['id_typejuridiction']; ?>">
          <?php if (($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))){ ?>
          <input type="hidden" name="id_juridiction" id="id_juridiction" value="<?php echo $_POST['id_juridiction']; ?>">
          <?php } ?>
          <?php } // Show if recordset empty ?>
          <input type="hidden" name="mois" id="mois" value="<?php echo $_POST['mois']; ?>">
          <input type="hidden" name="annee" id="annee" value="<?php echo $_POST['annee']; ?>">
  <input type="submit" name="Submit3" value="Imprimer"></td>
    </tr>
  </table></td>
                    </tr>
</table>
</form>                  <?php } ?>
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
<?php
mysql_free_result($liste_nature);

mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);

mysql_free_result($crimes_constates);

mysql_free_result($total_crimes_constatees);

mysql_free_result($total_crimes_poursuivis);

mysql_free_result($total_pvdedenonciation);

mysql_free_result($total_pvauteurinconnus);

mysql_free_result($total_pvdecrimes);

mysql_free_result($total_pvdedelit);

mysql_free_result($total_pvdecontraventions);

mysql_free_result($total_affairepenals);

mysql_free_result($total_affaireautresparquet);

mysql_free_result($affaireautresparquet);

mysql_free_result($affairepenals);

mysql_free_result($pvcontraventions);

mysql_free_result($pvdelit);

mysql_free_result($pvcrimes);

mysql_free_result($pvauteurinconnus);

mysql_free_result($pvdedenonciation);

mysql_free_result($crimes_poursuivis);
?>