<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Civile,Administrateur,Superviseur,AdminCivil";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO role_general (noordre_rolegeneral, date_rolegeneral, demandeur_rolegeneral, defendeur_rolegeneral, objet_rolegeneral, observation_rolegeneral, Id_admin, date_creation, dateaudience_rolegeneral, chambre_rolegeneral, id_categorieaffaire, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['noordre_rolegeneral'], "text"),
                       GetSQLValueString(changedatefrus($_POST['date_rolegeneral']), "date"),
                       GetSQLValueString($_POST['demandeur_rolegeneral'], "text"),
                       GetSQLValueString($_POST['defendeur_rolegeneral'], "text"),
                       GetSQLValueString($_POST['objet_rolegeneral'], "text"),
                       GetSQLValueString($_POST['observation_rolegeneral'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString(changedatefrus($_POST['dateaudience_rolegeneral']), "date"),
                       GetSQLValueString($_POST['chambre_rolegeneral'], "text"),
                       GetSQLValueString($_POST['id_categorieaffaire'], "int"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE Login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Civile'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);
?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."-".$datefr{3}.$datefr{4}."-".$datefr{0}.$datefr{1};

return $dateus;
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
  </script>
<?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_rolegeneral.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST" onsubmit="window.location.assign('#close')">
  <table width="480" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le r&ocirc;le g&eacute;n&eacute;ral - Ajouter un enregistrement </p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; d'ordre : </td>
                <td><input name="noordre_rolegeneral" type="text" id="noordre_rolegeneral" size="20"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nature : </td>
                <td><select name="id_categorieaffaire" id="id_categorieaffaire">
                  <?php
do {  
?>
                  <option value="<?php echo $row_liste_nature['id_categorieaffaire']?>"><?php echo $row_liste_nature['lib_categorieaffaire']?></option>
                  <?php
} while ($row_liste_nature = mysql_fetch_assoc($liste_nature));
  $rows = mysql_num_rows($liste_nature);
  if($rows > 0) {
      mysql_data_seek($liste_nature, 0);
	  $row_liste_nature = mysql_fetch_assoc($liste_nature);
  }
?>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date : </td>
                <td><input name="date_rolegeneral" type="text" id="datepicker1" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur</td>
                <td><input name="demandeur_rolegeneral" type="text" id="demandeur_rolegeneral" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Defendeur</td>
                <td><input name="defendeur_rolegeneral" type="text" id="defendeur_rolegeneral" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet: </td>
                <td><textarea name="objet_rolegeneral" cols="40" rows="5" id="objet_rolegeneral"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> 1<sup>&egrave;re</sup>date d'audience</td>
                <td><input name="dateaudience_rolegeneral" type="text" id="datepicker" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Chambre :</td>
                <td><label>
                  <select name="chambre_rolegeneral" id="chambre_rolegeneral">
                    <option value="CS1">CS1</option>
                    <option value="CS2">CS2</option>
                    <option value="CS3">CS3</option>
                    <option value="CS4">CS4</option>
                    <option value="CS5">CS5</option>
                    <option value="CS6">CS6</option>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observation_rolegeneral" cols="40" rows="7" id="observation_rolegeneral"></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                <td><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);

mysql_free_result($liste_nature);
?>
