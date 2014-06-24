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
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col" align="center"> <p>
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
      <p>      STATISTIQUE DES CONDAMNATIONS APRES DETENTIONS PROVISOIRES</p>      <?php echo("P&eacute;riode du ".$datedeb." au ".$datef); ?> </th>
  </tr>
</table>
<span class="bod"></span>
<p class="Style2">&nbsp;</p>
<p><table width="0%" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <th bgcolor="#000000" scope="col"><table width="0" cellpadding="3" cellspacing="1" >
      <tr bgcolor="#FFFFFF" class="Style22">
        <td colspan="2"><p></p></td>
        <td colspan="6" align="center" valign="middle" class="Style10"> CONDAMNATIONS APRES DETENTIONS<br /> PROVISOIRES POUR CRIME</td>
        <td colspan="9" align="center" valign="middle" class="Style10">CONDAMNATIONS APRES DETENTIONS<br /> PROVISOIRES POUR DELIT</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center">#</td>
        <td width="150" align="center">Nature
          <div align="center"></div>
          <div align="center"></div></td>
        <td width="50" align="center">Cond.<br />
          Apr&egrave;s <br />D.P.</td>
        <td width="50" align="center" nowrap="nowrap">DP<br />
          [0 &agrave; 1[<br />
          an</td>
        <td width="50" align="center" nowrap="nowrap">DP<br />
          [1 &agrave; 2[<br />
          ans</td>
        <td width="50" align="center" nowrap="nowrap">DP<br />
          [2 &agrave; 3[<br />
          ans</td>
        <td width="50" align="center" nowrap="nowrap"><p align="center">DP<br />
          [3 &agrave; +[</p></td>
        <td width="100%" align="center">Dur&eacute;e Moy.<br />
          D.P.<br />
          Criminelle</td>
        <td width="100%" align="center">Condam-<br />
          nation<br />
          Apr&egrave;s D.P.</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [0 &agrave; 2[<br />
          mois</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [2 &agrave; 4[<br />
          mois</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [4 &agrave; 8[<br />
          mois</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [8 &agrave; 1[<br />
          an</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [1 &agrave; 2[<br />
          ans</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [2 &agrave; 3[<br />
          ans</td>
        <td width="45" align="center" nowrap="nowrap">DP<br />
          [3 &agrave; +[</td>
        <td width="100%" align="center">Dur&eacute;e Moy.<br />
          D.P.<br />
          D&eacute;lictuelle</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center" class="Style22">1</td>
        <td nowrap="nowrap" >Vol,Recels, Desctructions</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center" class="Style22">2</td>
        <td nowrap="nowrap" >Viol, Agression sexuelle</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center" class="Style22">3</td>
        <td nowrap="nowrap" >Coups et Blessures volontaires</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center" class="Style22">5</td>
        <td nowrap="nowrap" >Escroqueries, Abus de Confiance</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center" class="Style22">7</td>
        <td nowrap="nowrap" >Atteintes aux moeurs</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
      </tr>
      <tr bgcolor="#FFFFFF" class="Style22">
        <td align="center" class="Style22">8</td>
        <td nowrap="nowrap" >Circulation Routi&egrave;re</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
        <td align="center" class="Style22">0</td>
      </tr>
      <tr bgcolor="#677787">
        <td colspan="17" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1" /></td>
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
