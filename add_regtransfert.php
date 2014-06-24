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
  $insertSQL = sprintf("INSERT INTO reg_transfert (numordre_regtransfert, date_regtransfert, motif_regtransfert, destination_regtransfert, chef_regtransfert, obs_regtransfert, no_ecrou, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numordre_regtransfert'], "text"),
                       GetSQLValueString(changedatefrus($_POST['date_regtransfert']), "date"),
                       GetSQLValueString($_POST['motif_regtransfert'], "text"),
                       GetSQLValueString($_POST['destination_regtransfert'], "text"),
                       GetSQLValueString($_POST['chef_regtransfert'], "text"),
                       GetSQLValueString($_POST['obs_regtransfert'], "text"),
                       GetSQLValueString($_POST['no_ecrou'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

if ($_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";
if (isset($_POST['noordre_ecrou'])) {
  $colname_select_nodossier = (get_magic_quotes_gpc()) ? $_POST['noordre_ecrou'] : addslashes($_POST['noordre_ecrou']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM  reg_ecrou, reg_controlnum, reg_mandat WHERE ((noordre_ecrou = '%s') AND (reg_ecrou.no_regcontrolnum = reg_controlnum.no_regcontrolnum) AND (reg_mandat.no_regmandat=reg_controlnum.no_regmandat)) ", $colname_select_nodossier);
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
rechargerpage("liste_regtransfert.php");
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
                <td width="100%" class="Style2"><p>Le registre des transf&egrave;rements- Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="top" nowrap bgcolor="#CCE3FF" class="Style10"><form name="form1" method="post" action="add_regtransfert.php">
                  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="middle" nowrap class="Style10">N&deg; Ecrou :</td>
                      <td><input name="noordre_ecrou" type="text" id="noordre_ecrou" value="<?php echo $row_select_nodossier['noordre_ecrou']; ?>" size="15"></td>
                      <td width="100%"><input type="submit" name="Afficher" value="Afficher"></td>
                    </tr>
<?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>                    
                    <tr align="center">
                      <td colspan="3" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                    </tr>
<?php } ?>					
<?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                     <tr>
                        <td align="right" valign="middle" nowrap class="Style10">Nom et pr&eacute;noms :</td>
                        <td colspan="2"><input name="nom_regmandat" type="text" disabled id="nom_regmandat" value="<?php echo $row_select_nodossier['nom_regmandat']; ?>" size="35"></td>
                    </tr>
                    <?php } // Show if recordset not empty ?>
                  </table>
              </form></td>
            </tr>
            <tr>
              <td width="100%" align="right" valign="top" nowrap class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">N&deg; d'Ordre : </td>
                      <td colspan="2"><input name="numordre_regtransfert" type="text" id="numordre_regtransfert" size="15"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Date  : </td>
                      <td colspan="2"><input name="date_regtransfert" type="text" id="datepicker" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Motif transfert :</td>
                      <td colspan="2"><input name="motif_regtransfert" type="text" id="motif_regtransfert" size="30"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Destination :</td>
                      <td colspan="2"><input name="destination_regtransfert" type="text" id="destination_regtransfert" size="30"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Chef escorte : </td>
                      <td colspan="2"><input name="chef_regtransfert" type="text" id="chef_regtransfert" size="30"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                      <td colspan="2"><textarea name="obs_regtransfert" cols="30" rows="4" id="obs_regtransfert"></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                        <input name="no_ecrou" type="hidden" id="no_ecrou" value="<?php echo $row_select_nodossier['no_ecrou']; ?>">
                        <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                      <td colspan="2"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
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
