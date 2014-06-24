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
  $insertSQL = sprintf("INSERT INTO reg_ccm (noformalite_rccm, date_rccm, numentreprise_rccm, nomexploitant_rccm, datnais_rccm, lieunais_rccm, nationalite_rccm, domicil_rccm, objet_rccm, nomdeclarant_rccm, qualite_rccm, surete_rccm, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['noformalite_rccm'], "text"),
                       GetSQLValueString(changedatefrus($_POST['date_rccm']), "date"),
                       GetSQLValueString($_POST['numentreprise_rccm'], "text"),
                       GetSQLValueString($_POST['nomexploitant_rccm'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datnais_rccm']), "date"),
                       GetSQLValueString($_POST['lieunais_rccm'], "text"),
                       GetSQLValueString($_POST['nationalite_rccm'], "text"),
                       GetSQLValueString($_POST['domicil_rccm'], "text"),
                       GetSQLValueString($_POST['objet_rccm'], "text"),
                       GetSQLValueString($_POST['nomdeclarant_rccm'], "text"),
                       GetSQLValueString($_POST['qualite_rccm'], "text"),
                       GetSQLValueString($_POST['surete_rccm'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
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
rechargerpage("liste_regccm.php");
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
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre de commerce - Ajouter un enregistrement </p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date : </td>
                <td><input name="date_rccm" type="text" id="datepicker1" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; formalit&eacute;  : </td>
                <td><input name="noformalite_rccm" type="text" id="noformalite_rccm" size="20"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Entreprise :</td>
                <td><input name="numentreprise_rccm" type="text" id="numentreprise_rccm" size="20"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nom de l'exploitant :</td>
                <td><input name="nomexploitant_rccm" type="text" id="nomexploitant_rccm" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de naissance :</td>
                <td><input name="datnais_rccm" type="text" id="datepicker" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Lieu de naissance :</td>
                <td><input name="lieunais_rccm" type="text" id="lieunais_rccm" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nationnalit&eacute; :</td>
                <td><input name="nationalite_rccm" type="text" id="nationalite_rccm" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Domicile :</td>
                <td><input name="domicil_rccm" type="text" id="domicil_rccm" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet de la <br>
                  d&eacute;claration : </td>
                <td><textarea name="objet_rccm" cols="35" rows="3" id="objet_rccm"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Nom  du d&eacute;clarant :</td>
                <td><input name="nomdeclarant_rccm" type="text" id="nomdeclarant_rccm" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">qualit&eacute;
                  du d&eacute;clarant :</td>
                <td><input name="qualite_rccm" type="text" id="qualite_rccm" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Suret&eacute; ou <br>credit mobilier : </td>
                <td><input name="surete_rccm" type="text" id="surete_rccm" value="" size="35"></td>
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
