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

$datedebut=$_SESSION['datedebut'];
$datefin=$_SESSION['datefin'];
$datedeb=Change_formatDate($_SESSION['datedebut']);
$datef=Change_formatDate($_SESSION['datefin']);

?>

<?php
function Change_formatDate($datedeb, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $datedeb);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $datedeb);
}
?>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col" align="center"><p>
      <?php
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_SESSION['id_juridiction'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_SESSION['id_juridiction'] : addslashes($_SESSION['id_juridiction']);
	}

	mysql_select_db($database_jursta, $jursta);
	$query_selectionner_juridiction = sprintf("SELECT * FROM juridiction, type_juridiction WHERE ((id_juridiction = %s) AND  (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($juridiction, "text"));
	$selectionner_juridiction = mysql_query($query_selectionner_juridiction, $jursta) or die(mysql_error());
	$row_selectionner_juridiction = mysql_fetch_assoc($selectionner_juridiction);
	$totalRows_selectionner_juridiction = mysql_num_rows($selectionner_juridiction);

	echo ($row_selectionner_juridiction['lib_typejuridiction']." DE ".$row_selectionner_juridiction['lib_juridiction']);
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
	echo ($row_select_juridiction['lib_typejuridiction']." DE ".$row_select_juridiction['lib_juridiction']);
}

?>
    </p>
      <p>STATISTIQUE DES DONNEES PROVENANTS DES SERVICES DE POLICE ET </p>
    <p>DE GENDAMERIE ET DES SAISINES DE PARQUET <?php echo("P&eacute;riode du ".$datedeb." au ".$datef); ?> </p></th>
  </tr>
</table>
<span></span>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="0%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <th bgcolor="#000000" scope="col"><table cellpadding="2" cellspacing="1" >
      <tr>
        <td colspan="2" rowspan="2" bgcolor="#9EC2E0">&nbsp;</td>
        <td colspan="2" rowspan="2" align="center" valign="middle" bgcolor="#9EC2E0"><p>Constats Service de Police<br> et de Gendamerie</p></td>
        <td colspan="7" align="center" bgcolor="#9EC2E0">Saisine des Parquets </td>
      </tr>
      <tr>
        <td colspan="5" align="center" valign="middle" bgcolor="#9EC2E0"><p>Proc&egrave;s verbaux </p></td>
        <td colspan="2" align="center" bgcolor="#9EC2E0">Autres Affaires P&eacute;nales</td>
      </tr>
      <tr bgcolor="#6186AF">
        <td align="center" bgcolor="#FFFFFF">#</td>
        <td width="100%" align="center" bgcolor="#FFFFFF">Nature</td>
        <td align="center" bgcolor="#FFFFFF">Crimes et D&eacute;lits<br>
          Constat&eacute;s </td>
        <td align="center" bgcolor="#FFFFFF">Crimes et D&eacute;lits<br>
          Poursuivis </td>
        <td align="center" bgcolor="#FFFFFF">PV Plaintes <br>
          D&eacute;nonciation </td>
        <td align="center" bgcolor="#FFFFFF">PV Auteurs<br>
          Inconnus </td>
        <td align="center" bgcolor="#FFFFFF">PV Crimes </td>
        <td align="center" bgcolor="#FFFFFF">PV d&eacute;lits </td>
        <td align="center" bgcolor="#FFFFFF"><p align="center">PV Contrav.&amp; Inf<br>
          Non pr&eacute;cises </p></td>
        <td align="center" bgcolor="#FFFFFF">Total</td>
        <td align="center" bgcolor="#FFFFFF"><p align="center">Dont Proc&eacute;dure <br>
          prov. <br>autres parquets </p></td>
      </tr>
      <?php
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_SESSION['id_juridiction'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_SESSION['id_juridiction'] : addslashes($_SESSION['id_juridiction']);
	}
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
}

?>  
                    <?php do { ?>
<?php
$categorie = $row_liste_nature['id_categorieaffaire'];
mysql_select_db($database_jursta, $jursta);
$query_crimes_constates = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constatée') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$crimes_constates = mysql_query($query_crimes_constates, $jursta) or die(mysql_error());
$row_crimes_constates = mysql_fetch_assoc($crimes_constates);
$totalRows_crimes_constates = mysql_num_rows($crimes_constates);

mysql_select_db($database_jursta, $jursta);
$query_crimes_poursuivis = "SELECT count(*) as crimes_poursuivis FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Poursuivis') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$crimes_poursuivis = mysql_query($query_crimes_poursuivis, $jursta) or die(mysql_error());
$row_crimes_poursuivis = mysql_fetch_assoc($crimes_poursuivis);
$totalRows_crimes_poursuivis = mysql_num_rows($crimes_poursuivis);

mysql_select_db($database_jursta, $jursta);
$query_pvdedenonciation = "SELECT count(*) as pvdedenonciation FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=1) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvdedenonciation = mysql_query($query_pvdedenonciation, $jursta) or die(mysql_error());
$row_pvdedenonciation = mysql_fetch_assoc($pvdedenonciation);
$totalRows_pvdedenonciation = mysql_num_rows($pvdedenonciation);

mysql_select_db($database_jursta, $jursta);
$query_pvauteurinconnus = "SELECT count(*) as pvauteurinconnus FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (UCASE(reg_plaintes.NomPreDomInculpes_plaintes)='INCONNU') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvauteurinconnus = mysql_query($query_pvauteurinconnus, $jursta) or die(mysql_error());
$row_pvauteurinconnus = mysql_fetch_assoc($pvauteurinconnus);
$totalRows_pvauteurinconnus = mysql_num_rows($pvauteurinconnus);

mysql_select_db($database_jursta, $jursta);
$query_pvcrimes = "SELECT count(*) as pvdecrimes FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=2) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvcrimes = mysql_query($query_pvcrimes, $jursta) or die(mysql_error());
$row_pvcrimes = mysql_fetch_assoc($pvcrimes);
$totalRows_pvcrimes = mysql_num_rows($pvcrimes);

mysql_select_db($database_jursta, $jursta);
$query_pvdelit = "SELECT count(*) as pvdedelit FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=3) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvdelit = mysql_query($query_pvdelit, $jursta) or die(mysql_error());
$row_pvdelit = mysql_fetch_assoc($pvdelit);
$totalRows_pvdelit = mysql_num_rows($pvdelit);

mysql_select_db($database_jursta, $jursta);
$query_pvcontraventions = "SELECT count(*) as pvdecontraventions FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=4) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$pvcontraventions = mysql_query($query_pvcontraventions, $jursta) or die(mysql_error());
$row_pvcontraventions = mysql_fetch_assoc($pvcontraventions);
$totalRows_pvcontraventions = mysql_num_rows($pvcontraventions);

mysql_select_db($database_jursta, $jursta);
$query_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affairepenals = mysql_query($query_affairepenals, $jursta) or die(mysql_error());
$row_affairepenals = mysql_fetch_assoc($affairepenals);
$totalRows_affairepenals = mysql_num_rows($affairepenals);

mysql_select_db($database_jursta, $jursta);
$query_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affaireautresparquet = mysql_query($query_affaireautresparquet, $jursta) or die(mysql_error());
$row_affaireautresparquet = mysql_fetch_assoc($affaireautresparquet);
$totalRows_affaireautresparquet = mysql_num_rows($affaireautresparquet);

mysql_select_db($database_jursta, $jursta);
$query_total_crimes_constatees = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constatée') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_crimes_constatees = mysql_query($query_total_crimes_constatees, $jursta) or die(mysql_error());
$row_total_crimes_constatees = mysql_fetch_assoc($total_crimes_constatees);
$totalRows_total_crimes_constatees = mysql_num_rows($total_crimes_constatees);

mysql_select_db($database_jursta, $jursta);
$query_total_crimes_poursuivis = "SELECT count(*) as crimes_poursuivis FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Poursuivis') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_crimes_poursuivis = mysql_query($query_total_crimes_poursuivis, $jursta) or die(mysql_error());
$row_total_crimes_poursuivis = mysql_fetch_assoc($total_crimes_poursuivis);
$totalRows_total_crimes_poursuivis = mysql_num_rows($total_crimes_poursuivis);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdedenonciation = "SELECT count(*) as pvdedenonciation FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=1) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_pvdedenonciation = mysql_query($query_total_pvdedenonciation, $jursta) or die(mysql_error());
$row_total_pvdedenonciation = mysql_fetch_assoc($total_pvdedenonciation);
$totalRows_total_pvdedenonciation = mysql_num_rows($total_pvdedenonciation);

mysql_select_db($database_jursta, $jursta);
$query_total_pvauteurinconnus = "SELECT count(*) as pvauteurinconnus FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (UCASE(reg_plaintes.NomPreDomInculpes_plaintes)='INCONNU') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_pvauteurinconnus = mysql_query($query_total_pvauteurinconnus, $jursta) or die(mysql_error());
$row_total_pvauteurinconnus = mysql_fetch_assoc($total_pvauteurinconnus);
$totalRows_total_pvauteurinconnus = mysql_num_rows($total_pvauteurinconnus);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdecrimes = "SELECT count(*) as pvdecrimes FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=2) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_pvdecrimes = mysql_query($query_total_pvdecrimes, $jursta) or die(mysql_error());
$row_total_pvdecrimes = mysql_fetch_assoc($total_pvdecrimes);
$totalRows_total_pvdecrimes = mysql_num_rows($total_pvdecrimes);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdedelit = "SELECT count(*) as pvdedelit FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=3) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_pvdedelit = mysql_query($query_total_pvdedelit, $jursta) or die(mysql_error());
$row_total_pvdedelit = mysql_fetch_assoc($total_pvdedelit);
$totalRows_total_pvdedelit = mysql_num_rows($total_pvdedelit);

mysql_select_db($database_jursta, $jursta);
$query_total_pvdecontraventions = "SELECT count(*) as pvdecontraventions FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typepv_plaintes=4) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_pvdecontraventions = mysql_query($query_total_pvdecontraventions, $jursta) or die(mysql_error());
$row_total_pvdecontraventions = mysql_fetch_assoc($total_pvdecontraventions);
$totalRows_total_pvdecontraventions = mysql_num_rows($total_pvdecontraventions);

mysql_select_db($database_jursta, $jursta);
$query_total_affairepenals = "SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_affairepenals = mysql_query($query_total_affairepenals, $jursta) or die(mysql_error());
$row_total_affairepenals = mysql_fetch_assoc($total_affairepenals);
$totalRows_total_affairepenals = mysql_num_rows($total_affairepenals);

mysql_select_db($database_jursta, $jursta);
$query_total_affaireautresparquet = "SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
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
      <tr align="center" bgcolor="#677787" class="Style11">
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
    </table></th>
  </tr>
</table>


