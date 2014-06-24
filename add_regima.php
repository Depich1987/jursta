<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Penitentiaire,Superviseur,AdminPenal";
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_controlnum (professiondet_ecrou, domicildet_ecrou, nationalite_ecrou, tailledet_ecrou, frontdet_ecrou, nezdet_ecrou, bouchedet_ecrou, teintdet_ecrou, signepartdet_ecrou, noordre_regcontrolnum, datnaisdet_ecrou, lieunaisdet_ecrou, peredet_ecrou, meredet_ecrou, sexe_regcontrolnum, date_regcontrolnum, Id_admin, date_creation, no_regmandat, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['professiondet_ecrou'], "text"),
                       GetSQLValueString($_POST['domicildet_ecrou'], "text"),
                       GetSQLValueString($_POST['nationalite_ecrou'], "text"),
                       GetSQLValueString($_POST['tailledet_ecrou'], "text"),
                       GetSQLValueString($_POST['frontdet_ecrou'], "text"),
                       GetSQLValueString($_POST['nezdet_ecrou'], "text"),
                       GetSQLValueString($_POST['bouchedet_ecrou'], "text"),
                       GetSQLValueString($_POST['teintdet_ecrou'], "text"),
                       GetSQLValueString($_POST['signepartdet_ecrou'], "text"),
                       GetSQLValueString($_POST['noordre_regcontrolnum'], "text"),
                       GetSQLValueString($_POST['datnaisdet_ecrou'], "date"),
                       GetSQLValueString($_POST['lieunaisdet_ecrou'], "text"),
                       GetSQLValueString($_POST['peredet_ecrou'], "text"),
                       GetSQLValueString($_POST['meredet_ecrou'], "text"),
                       GetSQLValueString($_POST['sexe_regcontrolnum'], "text"),
                       GetSQLValueString($_POST['date_regcontrolnum'], "date"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_regmandat'], "int"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

if ($_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";
if (isset($_POST['noordre_regmandat'])) {
  $colname_select_nodossier = (get_magic_quotes_gpc()) ? $_POST['noordre_regmandat'] : addslashes($_POST['noordre_regmandat']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_mandat WHERE noordre_regmandat = '%s'", $colname_select_nodossier);
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
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
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_regima.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="480" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre d'immatriculation - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="top" nowrap bgcolor="#CCE3FF" class="Style10"><form name="form1" method="post" action="add_regima.php">
                  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="left" valign="middle" nowrap class="Style10">N&deg; Mandat :</td>
                      <td><input name="noordre_regmandat" type="text" id="noordre_regmandat" value="<?php echo $row_select_nodossier['noordre_regmandat']; ?>" size="15"></td>
                      <td width="100%"><input type="submit" name="Afficher" value="Afficher"></td>
                    </tr>
<?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>                    
                    <tr align="center">
                      <td colspan="3" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                    </tr>
<?php } ?>					
<?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                    <tr>
                        <td align="left" valign="middle" nowrap class="Style10">Nom et pr&eacute;noms :</td>
                        <td colspan="2"><input name="nom_regmandat" type="text" disabled id="nom_regmandat" value="<?php echo $row_select_nodossier['nom_regmandat']; ?>" size="35"></td>
                    </tr>
                    <?php } // Show if recordset not empty ?>
                  </table>
              </form></td>
            </tr>
            <tr>
              <td width="100%" align="right" valign="top" nowrap bgcolor="#CCE3FF" class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="left" valign="middle" nowrap class="Style10">N&deg; d'Immatriculation : </td>
                      <td><input name="noordre_regcontrolnum" type="text" id="noordre_regcontrolnum" size="15"></td>
                      <td align="left" valign="middle" class="Style10">Date d'entr&eacute;e : </td>
                      <td colspan="2" class="Style10"><input name="date_regcontrolnum" type="text" id="datepicker2" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
                      </tr>
                    <tr>
                      <td align="left" valign="middle" nowrap class="Style10">Sexe : </td>
                      <td>
                        <select name="sexe_regcontrolnum" size="1" id="sexe_regcontrolnum">
                          <option value="M" selected>M</option>
                          <option value="F">F</option>
                        </select></td>
                      <td align="left" valign="middle" nowrap class="Style10">Date de naissance :</td>
                      <td colspan="2"><input name="datnaisdet_ecrou" type="text" id="datepicker" size="15"></td>
                      </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Lieu de naissance :</td>
    <td colspan="3"><input name="lieunaisdet_ecrou" type="text" id="lieunaisdet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Nom du p&egrave;re : </td>
    <td colspan="3"><input name="peredet_ecrou" type="text" id="peredet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Nom de la m&egrave;re : </td>
    <td colspan="3"><input name="meredet_ecrou" type="text" id="meredet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Profession : </td>
    <td colspan="3"><input name="professiondet_ecrou" type="text" id="professiondet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Domicile : </td>
    <td colspan="3"><input name="domicildet_ecrou" type="text" id="domicildet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Nationnalit&eacute; :</td>
    <td colspan="3"><input name="nationalite_ecrou" type="text" id="nationalite_ecrou" size="25"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Taille : </td>
    <td><input name="tailledet_ecrou" type="text" id="tailledet_ecrou" size="8"></td>
    <td align="left" valign="middle" class="Style10">Front :</td>
    <td><input name="frontdet_ecrou" type="text" id="frontdet_ecrou" size="15"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Nez : </td>
    <td><input name="nezdet_ecrou" type="text" id="nezdet_ecrou" size="15"></td>
    <td align="left" valign="middle" class="Style10">Teint :</td>
    <td><input name="teintdet_ecrou" type="text" id="teintdet_ecrou" size="15"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Bouche : </td>
    <td colspan="3"><input name="bouchedet_ecrou" type="text" id="bouchedet_ecrou" size="25"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Style10">Signe particulier : </td>
    <td colspan="3"><textarea name="signepartdet_ecrou" cols="25" rows="2" id="signepartdet_ecrou"></textarea></td>
    
  
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                        <input name="no_regmandat" type="hidden" id="no_regmandat" value="<?php echo $row_select_nodossier['no_regmandat']; ?>">
                        <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                      <td colspan="4"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form2">
                </form>
                <?php } // Show if recordset not empty ?></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</BODY>
</HTML>
<?php
mysql_free_result($select_nodossier);

mysql_free_result($select_admin);
?>
