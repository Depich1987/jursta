<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Sociale,Superviseur";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE rg_social SET noordre_rgsocial=%s, date_rgsocial=%s, demandeur_rgsocial=%s, defendeur_rgsocial=%s, objet_rgsocial=%s, observation_rgsocial=%s, Id_admin=%s, date_creation=%s, dateaudience_rgsocial=%s, id_categorieaffaire=%s, chambre_rgsocial=%s, id_juridiction=%s WHERE no_rgsocial=%s",
                       GetSQLValueString($_POST['noordre_rgsocial'], "text"),
                       GetSQLValueString(changedatefrus($_POST['date_rgsocial']), "date"),
                       GetSQLValueString($_POST['demandeur_rgsocial'], "text"),
                       GetSQLValueString($_POST['defendeur_rgsocial'], "text"),
                       GetSQLValueString($_POST['objet_rgsocial'], "text"),
                       GetSQLValueString($_POST['observation_rgsocial'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString(changedatefrus($_POST['dateaudience_rgsocial']), "date"),
                       GetSQLValueString($_POST['id_categorieaffaire'], "int"),
                       GetSQLValueString($_POST['chambre_rgsocial'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['no_rgsocial'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE Login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

$colname_select_rgsocial = "-1";
if (isset($_GET['norgs'])) {
  $colname_select_rgsocial = $_GET['norgs'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_rgsocial = sprintf("SELECT * FROM rg_social WHERE no_rgsocial = %s", GetSQLValueString($colname_select_rgsocial, "int"));
$select_rgsocial = mysql_query($query_select_rgsocial, $jursta) or die(mysql_error());
$row_select_rgsocial = mysql_fetch_assoc($select_rgsocial);
$totalRows_select_rgsocial = mysql_num_rows($select_rgsocial);
?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."/".$datefr{3}.$datefr{4}."/".$datefr{0}.$datefr{1};

return $dateus;
}
?>
<?php
function Change_formatDate($date, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
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
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_rgsocial.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="480" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/rename_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le r&ocirc;le g&eacute;n&eacute;ral - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; d'ordre :  </td>
                <td><input name="noordre_rgsocial" type="text" id="noordre_rgsocial" value="<?php echo $row_select_rgsocial['noordre_rgsocial']; ?>" size="20"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nature :</div></td>
                <td align="left" valign="top" nowrap class="Style10"><input type="text" name="id_categorieaffaire2" id="id_categorieaffaire" value="Affaires Sociales"></td>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date : </td>
                <td><input name="date_rgsocial" type="text" id="datepicker1" size="15" value="<?php echo Change_formatDate($row_select_rgsocial['date_rgsocial']); ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur :</td>
                <td><input name="demandeur_rgsocial" type="text" id="demandeur_rgsocial" value="<?php echo $row_select_rgsocial['demandeur_rgsocial']; ?>" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Defendeur :</td>
                <td><input name="defendeur_rgsocial" type="text" id="defendeur_rgsocial" value="<?php echo $row_select_rgsocial['defendeur_rgsocial']; ?>" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td><textarea name="objet_rgsocial" cols="40" rows="5" id="objet_rgsocial"><?php echo $row_select_rgsocial['objet_rgsocial']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> 1<sup>&egrave;re</sup>date d'audience :</td>
                <td><input name="dateaudience_rgsocial" type="text" id="datepicker" value="<?php echo Change_formatDate($row_select_rgsocial['dateaudience_rgsocial']); ?>" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Chambre :</td>
                <td>
                  <select name="chambre_rgsocial" id="chambre_rgsocial">
                    <option value="CS1" <?php if (!(strcmp("CS1", $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>>CS1</option>
                    <option value="CS2" <?php if (!(strcmp("CS2", $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>>CS2</option>
                    <option value="CS3" <?php if (!(strcmp("CS3", $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>>CS3</option>
                    <option value="CS4" <?php if (!(strcmp("CS4", $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>>CS4</option>
                    <option value="CS5" <?php if (!(strcmp("CS5", $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>>CS5</option>
                    <option value="CS6" <?php if (!(strcmp("CS6", $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>>CS6</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_select_rgsocial['chambre_rgsocial']?>"<?php if (!(strcmp($row_select_rgsocial['chambre_rgsocial'], $row_select_rgsocial['chambre_rgsocial']))) {echo "selected=\"selected\"";} ?>><?php echo $row_select_rgsocial['chambre_rgsocial']?></option>
                    <?php
} while ($row_select_rgsocial = mysql_fetch_assoc($select_rgsocial));
  $rows = mysql_num_rows($select_rgsocial);
  if($rows > 0) {
      mysql_data_seek($select_rgsocial, 0);
	  $row_select_rgsocial = mysql_fetch_assoc($select_rgsocial);
  }
?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observation_rgsocial" cols="40" rows="7" id="observation_rgsocial"><?php echo $row_select_rgsocial['observation_rgsocial']; ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="no_rgsocial" type="hidden" id="no_rgsocial" value="<?php echo $row_select_rgsocial['no_rgsocial']; ?>">
                    <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>">
                    <input name="id_categorieaffaire" type="hidden" value="10">
                    </td>
                <td><input type="submit" name="Valider_cmd" value="   Modifier l'enregistrement   "></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_update" value="form1">
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);

mysql_free_result($select_rgsocial);
?>
