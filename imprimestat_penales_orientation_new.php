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
<?php
function Change_formatDate($datef, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
	
    return @ereg_replace($r, '\\3-\\2-\\1', $datef);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $datef);
}
?>
<style type="text/css">
<!--
.texte {
	font-family: Georgia, "Times New Roman", Times, serif;
}
.bod {
	text-align: center;
}
.bod {
	text-align: center;
}
-->
</style>

<link href="css/global.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(..);
}
-->
</style><table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="bod">
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

	echo Change_formatDate($row_selectionner_juridiction['lib_typejuridiction']." DE ".$row_selectionner_juridiction['lib_juridiction']);
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
	echo Change_formatDate($row_select_juridiction['lib_typejuridiction']." DE ".$row_select_juridiction['lib_juridiction']);
}

?>
    </p>
    <p>STATISTIQUE DES ORIENTATIONS DES AFFAIRES DU PARQUET <?php echo("P&eacute;riode du ".$datedeb." au ".$datef); ?> </p></th>
  </tr>
</table>
<span class="bod"></span>
<p >&nbsp;</p>
<p><table width="0%" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <th bgcolor="#000000" scope="col"><table width="100%" cellpadding="3" cellspacing="1" >
      <tr>
        <td colspan="3" bgcolor="#FFFFFF"><p></p></td>
        <td colspan="6" align="center" valign="middle" bgcolor="#FFFFFF"> AFFAIRES POURSUIVABLES </td>
      </tr>
      <tr bgcolor="#6186AF">
        <th width="50" align="center" bgcolor="#FFFFFF">#</th>
        <th width="300" align="center" bgcolor="#FFFFFF">Nature</th>
        <th width="100" align="center" bgcolor="#FFFFFF"><p>Affaires
          Non<br />
          poursuivables</p>
<div align="center"></div></th>
        <th width="100" align="center" bgcolor="#FFFFFF">Toutes<br />
          les affaires<br />
          Poursuivables</th>
        <th width="100" align="center" bgcolor="#FFFFFF">Affaires<br />
          Transmis<br />
          Juge<br />
          d'Instruction</th>
        <th width="100" align="center" bgcolor="#FFFFFF">Affaires<br />
          Transmis<br />
          Juge<br />
          des enfants</th>
        <th width="100" align="center" bgcolor="#FFFFFF">Affaires<br />
          Transmis<br />
          Tribunal<br />
          Correctionnel</th>
        <th width="100" align="center" bgcolor="#FFFFFF"><p align="center">Nb. Proc&eacute;dures<br />
          Alternatives</p></th>
        <th width="100" align="center" bgcolor="#FFFFFF">Nb. proc&eacute;dures<br />
          Class&eacute;es<br />
          Sans Suite</th>
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
                    <?php $h=0; ?>
                    <?php do { ?>
<?php
$h++;
$categorie = $row_liste_nature['id_categorieaffaire'];


mysql_select_db($database_jursta, $jursta);
$query_affairesnonpoursuivables = "SELECT count(*) as affairesnonpoursuivables FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturesuite_plaintes='Non Poursuivable') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affairesnonpoursuivables = mysql_query($query_affairesnonpoursuivables, $jursta) or die(mysql_error());
$row_affairesnonpoursuivables = mysql_fetch_assoc($affairesnonpoursuivables);
$totalRows_affairesnonpoursuivables = mysql_num_rows($affairesnonpoursuivables);

mysql_select_db($database_jursta, $jursta);
$query_affairespoursuivables = "SELECT count(*) as affairespoursuivables FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturesuite_plaintes='Poursuivable') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affairespoursuivables = mysql_query($query_affairespoursuivables, $jursta) or die(mysql_error());
$row_affairespoursuivables = mysql_fetch_assoc($affairespoursuivables);
$totalRows_affairespoursuivables = mysql_num_rows($affairespoursuivables);

mysql_select_db($database_jursta, $jursta);
$query_transmisjugeinstrution = "SELECT count(*) as transmisjugeinstrution FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.suite_plaintes='Juge d''instruction') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$transmisjugeinstrution = mysql_query($query_transmisjugeinstrution, $jursta) or die(mysql_error());
$row_transmisjugeinstrution = mysql_fetch_assoc($transmisjugeinstrution);
$totalRows_transmisjugeinstrution = mysql_num_rows($transmisjugeinstrution);

mysql_select_db($database_jursta, $jursta);
$query_transmisjugeenfants = "SELECT count(*) as transmisjugeenfants FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.suite_plaintes='Juge des enfants') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$transmisjugeenfants = mysql_query($query_transmisjugeenfants, $jursta) or die(mysql_error());
$row_transmisjugeenfants = mysql_fetch_assoc($transmisjugeenfants);
$totalRows_transmisjugeenfants = mysql_num_rows($transmisjugeenfants);

mysql_select_db($database_jursta, $jursta);
$query_transmistribunalcorrectionnel = "SELECT count(*) as transmistribunalcorrectionnel FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.suite_plaintes='Tribunal correctionnel') AND (substr(reg_plaintes.date_creation,6,2)='".$mois_transmistribunalcorrectionnel."') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$transmistribunalcorrectionnel = mysql_query($query_transmistribunalcorrectionnel, $jursta) or die(mysql_error());
$row_transmistribunalcorrectionnel = mysql_fetch_assoc($transmistribunalcorrectionnel);
$totalRows_transmistribunalcorrectionnel = mysql_num_rows($transmistribunalcorrectionnel);

mysql_select_db($database_jursta, $jursta);
$query_affairesclassesanssuite = "SELECT count(*) as affairesclassesanssuite FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturesuite_plaintes='Classée') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$affairesclassesanssuite = mysql_query($query_affairesclassesanssuite, $jursta) or die(mysql_error());
$row_affairesclassesanssuite = mysql_fetch_assoc($affairesclassesanssuite);
$totalRows_affairesclassesanssuite = mysql_num_rows($affairesclassesanssuite);


mysql_select_db($database_jursta, $jursta);
$query_total_affairnonpoursuivable = "SELECT count(*) as affairesnonpoursuivables FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturesuite_plaintes='Non Poursuivable') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_affairnonpoursuivable = mysql_query($query_total_affairnonpoursuivable, $jursta) or die(mysql_error());
$row_total_affairnonpoursuivable = mysql_fetch_assoc($total_affairnonpoursuivable);
$totalRows_total_affairnonpoursuivable = mysql_num_rows($total_affairnonpoursuivable);


mysql_select_db($database_jursta, $jursta);
$query_total_affairpoursuivable = "SELECT count(*) as affairespoursuivables FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturesuite_plaintes='Poursuivable') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_affairpoursuivable = mysql_query($query_total_affairpoursuivable, $jursta) or die(mysql_error());
$row_total_affairpoursuivable = mysql_fetch_assoc($total_affairpoursuivable);
$totalRows_total_affairpoursuivable = mysql_num_rows($total_affairpoursuivable);

mysql_select_db($database_jursta, $jursta);
$query_total_tjuginstruction = "SELECT count(*) as transmisjugeinstrution FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.suite_plaintes='Juge d''instruction') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_plaintes.id_categorieaffaire=".$categorie."))";
$total_tjuginstruction = mysql_query($query_total_tjuginstruction, $jursta) or die(mysql_error());
$row_total_tjuginstruction = mysql_fetch_assoc($total_tjuginstruction);
$totalRows_total_tjuginstruction = mysql_num_rows($total_tjuginstruction);

mysql_select_db($database_jursta, $jursta);
$query_total_tjugenfants = "SELECT count(*) as transmisjugeenfants FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.suite_plaintes='Juge des enfants') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_tjugenfants = mysql_query($query_total_tjugenfants, $jursta) or die(mysql_error());
$row_total_tjugenfants = mysql_fetch_assoc($total_tjugenfants);
$totalRows_total_tjugenfants = mysql_num_rows($total_tjugenfants);

mysql_select_db($database_jursta, $jursta);
$query_total_tjugcorectionnel = "SELECT count(*) as transmistribunalcorrectionnel FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.suite_plaintes='Tribunal correctionnel') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_tjugcorectionnel = mysql_query($query_total_tjugcorectionnel, $jursta) or die(mysql_error());
$row_total_tjugcorectionnel = mysql_fetch_assoc($total_tjugcorectionnel);
$totalRows_total_tjugcorectionnel = mysql_num_rows($total_tjugcorectionnel);

mysql_select_db($database_jursta, $jursta);
$query_total_affairsanssuite = "SELECT count(*) as affairesclassesanssuite FROM reg_plaintes, administrateurs WHERE ((administrateurs.Id_admin=reg_plaintes.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (reg_plaintes.naturesuite_plaintes='Classée') AND (reg_plaintes.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_affairsanssuite = mysql_query($query_total_affairsanssuite, $jursta) or die(mysql_error());
$row_total_affairsanssuite = mysql_fetch_assoc($total_affairsanssuite);
$totalRows_total_affairsanssuite = mysql_num_rows($total_affairsanssuite);
?>
      <tr bgcolor="#EDF0F3">
        <td align="center" bgcolor="#FFFFFF"><?php echo $h; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
        <td align="center" bgcolor="#FFFFFF" ><?php echo $row_affairesnonpoursuivables['affairesnonpoursuivables']; ?></td>
        <td align="center" bgcolor="#FFFFFF" ><?php echo $row_affairespoursuivables['affairespoursuivables']; ?></td>
        <td align="center" bgcolor="#FFFFFF" ><?php echo $row_transmisjugeinstrution['transmisjugeinstrution']; ?></td>
        <td align="center" bgcolor="#FFFFFF" ><?php echo $row_transmisjugeenfants['transmisjugeenfants']; ?></td>
        <td align="center" bgcolor="#FFFFFF" ><?php echo $row_transmistribunalcorrectionnel['transmistribunalcorrectionnel']; ?></td>
        <td align="center" bgcolor="#FFFFFF" >0</td>
        <td align="center" bgcolor="#FFFFFF" ><?php echo $row_affairesclassesanssuite['affairesclassesanssuite']; ?></td>
      </tr>
      <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
      <tr align="center" bgcolor="#677787">
        <td colspan="2" bgcolor="#FFFFFF"><strong>Total</strong></td>
        <td bgcolor="#FFFFFF" ><strong><?php echo $row_total_affairnonpoursuivable['affairesnonpoursuivables']; ?></strong></td>
        <td bgcolor="#FFFFFF" ><strong><?php echo $row_total_affairpoursuivable['affairespoursuivables']; ?></strong></td>
        <td bgcolor="#FFFFFF" ><strong><?php echo $row_total_tjuginstruction['transmisjugeinstrution']; ?></strong></td>
        <td bgcolor="#FFFFFF" ><strong><?php echo $row_total_tjugenfants['transmisjugeenfants']; ?></strong></td>
        <td bgcolor="#FFFFFF" ><strong><?php echo $row_total_tjugcorectionnel['transmistribunalcorrectionnel']; ?></strong></td>
        <td bgcolor="#FFFFFF" ><strong>0</strong></td>
        <td bgcolor="#FFFFFF" ><strong><?php echo $row_total_affairsanssuite['affairesclassesanssuite']; ?></strong></td>
      </tr>
      <tr bgcolor="#677787">
        <td colspan="9" align="center" bgcolor="#FFFFFF" ><img src="images/spacer.gif" width="1" height="1" /></td>
      </tr>
    </table></th>
  </tr>
</table>
</p>
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td></td>
  </tr>
</table>
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

mysql_free_result($total_crimes_constatees);

mysql_free_result($total_crimes_poursuivis);

mysql_free_result($total_pvdedenonciation);

mysql_free_result($total_pvauteurinconnus);

mysql_free_result($total_pvdecrimes);

mysql_free_result($total_pvdedelit);

mysql_free_result($total_pvdecontraventions);

mysql_free_result($total_affairepenals);

mysql_free_result($total_affaireautresparquet);

mysql_free_result($select_juridiction);
?>
