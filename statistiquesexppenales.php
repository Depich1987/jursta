<?php require_once('Connections/jursta.php'); ?>
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

$deleteSQL = "TRUNCATE TABLE T31_DFSP";
mysql_select_db($database_jursta, $jursta);
$Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());

mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = "SELECT * FROM juridiction, type_juridiction WHERE (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction)";
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);

$sql_insert_t30="";
$sql_insert_t31="";
?>
<?php do { ?>
<?php 
mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Penale'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);
?>
    <?php do { ?>
    <?php
$categorie = $row_liste_nature['id_categorieaffaire'];
$juridiction = $row_liste_juridiction['id_juridiction'];
for ($annee=2010;$annee<=substr(date('Y-m-d'),0,4);$annee++){
	for ($ms=1;$ms<=12;$ms++){
	if ($ms<10) {$ms="0".$ms;}
	$mois=$ms;
	if (($annee==substr(date('Y-m-d'),0,4)) && ($mois>substr(date('Y-m-d'),5,2))){ break; }
$mois=intval($mois);
switch($mois)
{
	case 1 : 
		$trimestre=1;
		$semestre=1;
		break;
	case 2 : 
		$trimestre=1;
		$semestre=1;
		break;
	case 3 : 
		$trimestre=1;
		$semestre=1;
		break;
	case 4 : 
		$trimestre=2;
		$semestre=1;
		break;
	case 5 : 
		$trimestre=2;
		$semestre=1;
		break;
	case 6 : 
		$trimestre=2;
		$semestre=1;
		break;
	case 7 : 
		$trimestre=3;
		$semestre=2;
		break;
	case 8 : 
		$trimestre=3;
		$semestre=2;
		break;
	case 9 : 
		$trimestre=3;
		$semestre=2;
		break;
	case 10 : 
		$trimestre=4;
		$semestre=2;
		break;
	case 11 : 
		$trimestre=4;
		$semestre=2;
		break;
	case 12 : 
		$trimestre=4;
		$semestre=2;
		break;
}

mysql_select_db($database_jursta, $jursta);
$query_select_liaison = "SELECT * FROM t30_fs WHERE ((t30_fs.T06_ANNEE=".$annee.")"." AND (t30_fs.T30_MOIS=".$mois.") AND (id_juridiction=".$juridiction."));";
$select_liaison = mysql_query($query_select_liaison, $jursta) or die(mysql_error());
$row_select_liaison = mysql_fetch_assoc($select_liaison);
$totalRows_select_liaison = mysql_num_rows($select_liaison);

if ($totalRows_select_liaison==0){
	$insertSQL = "INSERT INTO t30_fs (T06_ANNEE, T30_MOIS, id_juridiction,T30_TRIM,T30_SEM) VALUES (".$annee.",".$mois.",".$juridiction.",".$trimestre.",".$semestre.");";
  	mysql_select_db($database_jursta, $jursta);
  	$Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
	$numero_liaison=mysql_insert_id();
	$sql_insert_t30=$sql_insert_t30.$insertSQL;
}
else{
	$numero_liaison=$row_select_liaison['T30_NUMERO'];
}

$mois_crimes_constates = "-1";
if (isset($_POST['mois'])) {
  $mois_crimes_constates = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}
$annee_crimes_constates = "-1";
if (isset($_POST['annee'])) {
  $annee_crimes_constates = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}


mysql_select_db($database_jursta, $jursta);
$query_crimes_constates = "SELECT count(*) as crimes_constatees FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturecrimes_plaintes='Constaté') AND (substr(reg_plaintes.date_creation,5,2)='".$mois_crimes_constates."') AND (substr(reg_plaintes.date_creation,0,4)='".$annee_crimes_constates."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
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
$query_crimes_poursuivis = sprintf("SELECT count(*) as crimes_poursuivis FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.naturecrimes_plaintes='Poursuivis') AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_crimes_poursuivis,$annee_crimes_poursuivis);
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
$query_pvdedenonciation = sprintf("SELECT count(*) as pvdedenonciation FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typepv_plaintes=1) AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_pvdedenonciation,$annee_pvdedenonciation);
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
$query_pvauteurinconnus = sprintf("SELECT count(*) as pvauteurinconnus FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (UCASE(reg_plaintes.NomPreDomInculpes_plaintes)='INCONNU') AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_pvauteurinconnus,$annee_pvauteurinconnus);
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
$query_pvcrimes = sprintf("SELECT count(*) as pvdecrimes FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typepv_plaintes=2) AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_pvcrimes,$annee_pvcrimes);
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
$query_pvdelit = sprintf("SELECT count(*) as pvdedelit FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typepv_plaintes=3) AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_pvdelit,$annee_pvdelit);
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
$query_pvcontraventions = sprintf("SELECT count(*) as pvdecontraventions FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typepv_plaintes=4) AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_pvcontraventions,$annee_pvcontraventions);
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
$query_affairepenals = sprintf("SELECT count(*) as affairepenals FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales') AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_affairepenals,$annee_affairepenals);
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
$query_affaireautresparquet = sprintf("SELECT count(*) as affaireautresparquet FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=%s) AND (reg_plaintes.typesaisine_plaintes='Autres affaires pénales')  AND (reg_plaintes.procedureautreparquet_plaintes=1) AND (substr(reg_plaintes.date_creation,5,2)='%s') AND (substr(reg_plaintes.date_creation,0,4)='%s') AND (reg_plaintes.id_categorieaffaire=".$categorie."))", $juridiction,$mois_affaireautresparquet,$annee_affaireautresparquet);
$affaireautresparquet = mysql_query($query_affaireautresparquet, $jursta) or die(mysql_error());
$row_affaireautresparquet = mysql_fetch_assoc($affaireautresparquet);
$totalRows_affaireautresparquet = mysql_num_rows($affaireautresparquet);
?>
<?php

  $insertSQL = sprintf("INSERT INTO T31_DFSP(T30_NUMERO,T34_CODE,T31_B0_CST_DELCRIM,T31_B0_CST_DELCRIM_EL,T31_B1_PVPLDEN_PV,T31_B1_PV_AUTEURINCONNU,T31_B1_PV_CRIME,T31_B1_PV_DELIT,T31_B1_PV_CONTRAV_INFRACT,T31_B1_AUTRES,T31_B1_PROV_AUTREPARQ,T31_B2_AFF_NON_POURSUIV,T31_B2_AFF_POURSUIV_AP,T31_B2_AP_TJI,T31_B2_AP_TJE,T31_B2_AP_TTC,T31_B2_PROC_ALTER,T31_B2_PROC_CSS,T31_B3_JUGEINST,T31_B3NOUVELLEAFF,T31_B3_AFFTERMINEE_AT,T31_B3_AT_DUREEMOYTTEAFF,T31_B3_AT_DUREEMOY_CRIME,T31_B3_AT_DUREEMOYDELIT,T31_B3_AT_PERSOMISEEXAMEN,T31_B3_AT_MESURE_DP,T31_B3DUREEMO_DP_PMD,T31_B4_CONDAPRESAPRESDP_CADP,T31_B4_CADP_CRIME,T31_B4_CADP_CRIME_DM_1AN,T31_B4_CADP_CRIME_DM_1_2AN,T31_B4_CADP_CRIME_DM_2_3AN,T31_B4_CADP_CRIME_DM_3AN_P,T31_B4CADP_CRIME_DM_MOIS,T31_B4_CADP_DELIT,T31_B4_CADP_DELIT_DM_1_2MOIS,T31_B4_CADP_DELIT_DM_2_4MOIS,T31_B4_CADP_DELIT_DM_4_8MOIS,T31_B4_CADP_DELIT_DM_8_1AN,T31_B4_CADP_DELIT_DM_1_AN,T31_B4_CADP_DELIT_DM_2_3AN,T31_B4_CADP_DELIT_DM_3AN_P,T31_B4_CADP_DELIT_DM_MOIS,T31_B5_MINEURS,T31_B5_MAJEURS) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($numero_liaison, "int"),
					   GetSQLValueString($categorie, "int"),				   
                       GetSQLValueString($row_crimes_constates['crimes_constatees']	, "int"),
                       GetSQLValueString($row_crimes_poursuivis['crimes_poursuivis'], "int"),
                       GetSQLValueString($row_pvdedenonciation['pvdedenonciation'], "int"),
                       GetSQLValueString($row_pvauteurinconnus['pvauteurinconnus'], "int"),
                       GetSQLValueString($row_pvcrimes['pvdecrimes'], "int"),
                       GetSQLValueString($row_pvdelit['pvdedelit'], "int"),
                       GetSQLValueString($row_pvcontraventions['pvdecontraventions'], "int"),
                       GetSQLValueString($row_affairepenals['affairepenals'], "int"),
                       GetSQLValueString($row_affaireautresparquet['affaireautresparquet'], "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString(0, "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
  $sql_insert_t31=$sql_insert_t31.$insertSQL;
    echo $sql_insert_t31;
?> 
	<?php 	}
	}
	?>
    <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
    <?php } while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction)); ?>	
