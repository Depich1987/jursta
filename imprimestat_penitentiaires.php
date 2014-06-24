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
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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

$colname_liste_juridiction = "1";
if (isset($_POST['type_juridiction'])) {
  $colname_liste_juridiction = (get_magic_quotes_gpc()) ? $_POST['type_juridiction'] : addslashes($_POST['type_juridiction']);
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", $colname_liste_juridiction);
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

<body class="imprime">
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span class="Style2"><a href="paramimprim.php"><img src="images/forms48.png" width="32" border="0"></a></span></td>
                      <td width="100%"><div align="center"><span class="Style2">FICHE STATISTIQUE DES DONNEES PROVENANTS DES SERVICES DE POLICE ET DE GENDAMERIE ET DES SAISINES DE PARQUET 
                        <?php 
if ($row_select_juridiction['id_juridiction'] == 55) {
	if ((isset($_GET['du'])) && (isset($_GET['au']))) {
		echo("PERIODE DU ".$_GET['du']." au ".$_GET['au']);
	}
}
else { 
	switch ($_POST['mois']) {
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
	echo Change_formatDate("PERIODE DE ".$mois." ".$_POST['annee']);
}
?> 
                      </span> </div></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" ><p>&nbsp;</p>
                <table>
                    <tr>
                      <td bgcolor="#000000"><table width="940" cellpadding="2" cellspacing="1" >
                        <tr bgcolor="#FFFFFF">
                          <td colspan="2" rowspan="2">&nbsp;</td>
                          <td colspan="2" rowspan="2" align="center" class="Style22"><p>Constats Service de Police et de Gendamerie</p></td>
                          <td colspan="7" align="center" class="Style22"><table width="100%"  border="0" cellspacing="0" cellpadding="8">
                              <tr>
                                <td align="center" class="Style22"> Saisine des Parquets </td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="5" align="center" bgcolor="#FFFFFF" class="Style22"><p>Proc&egrave;s verbaux </p></td>
                          <td colspan="2" align="center" bgcolor="#FFFFFF" class="Style22">Autres Affaires P&eacute;nales</td>
                        </tr>
                        <tr class="Style22">
                          <td align="center" bgcolor="#FFFFFF">#</td>
                          <td width="100%" align="center" bgcolor="#FFFFFF">Nature</td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">Crimes et D&eacute;lits Constat&eacute;s </div></td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">Crimes et D&eacute;lits Poursuivis </div></td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">PV Plaintes D&eacute;nonciation </div></td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">PV Auteurs Inconnus </div></td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">PV Crimes </div></td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">PV d&eacute;lits </div></td>
                          <td align="center" bgcolor="#FFFFFF"><p align="center">PV Contrav.&amp; Inf. Non pr&eacute;cises </p></td>
                          <td align="center" bgcolor="#FFFFFF"><div align="center">Total</div></td>
                          <td align="center" bgcolor="#FFFFFF"><p align="center">Dont Proc&eacute;dure prov. autres parquets </p></td>
                        </tr>
                        <?php do { ?>
                        <?php
$categorie = $row_liste_nature['id_categorieaffaire'];
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_GET['juri'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_GET['juri'] : addslashes($_GET['juri']);
	}
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
}

$du=$_GET['du'];
$au=$_GET['au'];

mysql_select_db($database_jursta, $jursta);
$query_crimes_constates = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constaté') AND (reg_plaintes.date_creation>='".$du."') AND (reg_plaintes.date_creation<='".$au."') AND (reg_plaintes.id_categorieaffaire=".$categorie."));";
$crimes_constates = mysql_query($query_crimes_constates, $jursta) or die(mysql_error());
$row_crimes_constates = mysql_fetch_assoc($crimes_constates);
$totalRows_crimes_constates = mysql_num_rows($crimes_constates);


mysql_select_db($database_jursta, $jursta);
$query_crimes_poursuivis = sprintf("SELECT count(*) as crimes_poursuivis FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.naturecrimes_plaintes='Poursuivis') AND (reg_plaintes.date_creation>='%s') AND (reg_plaintes.date_creation<='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$du,$au);
$crimes_poursuivis = mysql_query($query_crimes_poursuivis, $jursta) or die(mysql_error());
$row_crimes_poursuivis = mysql_fetch_assoc($crimes_poursuivis);
$totalRows_crimes_poursuivis = mysql_num_rows($crimes_poursuivis);

mysql_select_db($database_jursta, $jursta);
$query_pvdedenonciation = sprintf("SELECT count(*) as pvdedenonciation FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typepv_plaintes=1) AND (reg_plaintes.date_creation>='%s') AND (reg_plaintes.date_creation<='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$du,$au);
$pvdedenonciation = mysql_query($query_pvdedenonciation, $jursta) or die(mysql_error());
$row_pvdedenonciation = mysql_fetch_assoc($pvdedenonciation);
$totalRows_pvdedenonciation = mysql_num_rows($pvdedenonciation);

mysql_select_db($database_jursta, $jursta);
$query_pvauteurinconnus = sprintf("SELECT count(*) as pvauteurinconnus FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (UCASE(reg_plaintes.NomPreDomInculpes_plaintes)='INCONNU') AND (reg_plaintes.date_creation>='%s') AND (reg_plaintes.date_creation<='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$du,$au);
$pvauteurinconnus = mysql_query($query_pvauteurinconnus, $jursta) or die(mysql_error());
$row_pvauteurinconnus = mysql_fetch_assoc($pvauteurinconnus);
$totalRows_pvauteurinconnus = mysql_num_rows($pvauteurinconnus);


mysql_select_db($database_jursta, $jursta);
$query_pvcrimes = "SELECT count(*) as pvdecrimes FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=2) AND (reg_plaintes.date_creation>='".$du."') AND (reg_plaintes.date_creation<='".$au."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvcrimes = mysql_query($query_pvcrimes, $jursta) or die(mysql_error());
$row_pvcrimes = mysql_fetch_assoc($pvcrimes);
$totalRows_pvcrimes = mysql_num_rows($pvcrimes);


mysql_select_db($database_jursta, $jursta);
$query_pvdelit = "SELECT count(*) as pvdedelit FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=3) AND (reg_plaintes.date_creation>='".$du."') AND (reg_plaintes.date_creation<='".$au."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvdelit = mysql_query($query_pvdelit, $jursta) or die(mysql_error());
$row_pvdelit = mysql_fetch_assoc($pvdelit);
$totalRows_pvdelit = mysql_num_rows($pvdelit);


mysql_select_db($database_jursta, $jursta);
$query_pvcontraventions = "SELECT count(*) as pvdecontraventions FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=4) AND (reg_plaintes.date_creation>='".$du."') AND (reg_plaintes.date_creation<='".$au."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvcontraventions = mysql_query($query_pvcontraventions, $jursta) or die(mysql_error());
$row_pvcontraventions = mysql_fetch_assoc($pvcontraventions);
$totalRows_pvcontraventions = mysql_num_rows($pvcontraventions);


mysql_select_db($database_jursta, $jursta);
$query_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (reg_plaintes.date_creation>='".$du."') AND (reg_plaintes.date_creation<='".$au."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affairepenals = mysql_query($query_affairepenals, $jursta) or die(mysql_error());
$row_affairepenals = mysql_fetch_assoc($affairepenals);
$totalRows_affairepenals = mysql_num_rows($affairepenals);


mysql_select_db($database_jursta, $jursta);
$query_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (reg_plaintes.date_creation>='".$du."') AND (reg_plaintes.date_creation<='".$au."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affaireautresparquet = mysql_query($query_affaireautresparquet, $jursta) or die(mysql_error());
$row_affaireautresparquet = mysql_fetch_assoc($affaireautresparquet);
$totalRows_affaireautresparquet = mysql_num_rows($affaireautresparquet);
?>
                        <tr class="Style22">
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_liste_nature['id_categorieaffaire']; ?></td>
                          <td bgcolor="#FFFFFF"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_crimes_constates['crimes_constatees']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_crimes_poursuivis['crimes_poursuivis']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_pvdedenonciation['pvdedenonciation']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_pvauteurinconnus['pvauteurinconnus']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_pvcrimes['pvdecrimes']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_pvdelit['pvdedelit']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_pvcontraventions['pvdecontraventions']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_affairepenals['affairepenals']; ?></td>
                          <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_affaireautresparquet['affaireautresparquet']; ?></td>
                        </tr>
                        <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
                        <tr bgcolor="#FFFFFF">
                          <td colspan="11" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
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
<?php
mysql_free_result($liste_nature);

mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);

mysql_free_result($crimes_constates);

mysql_free_result($crimes_poursuivis);

mysql_free_result($pvdedenonciation);

mysql_free_result($pvauteurinconnus);

mysql_free_result($pvcrimes);

mysql_free_result($pvdelit);

mysql_free_result($pvcontraventions);

mysql_free_result($affairepenals);

mysql_free_result($affaireautresparquet);
?>
