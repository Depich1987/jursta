<?php require_once('Connections/jursta.php'); ?>
<?php require_once('Connections/jursta.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE reg_cabin SET numodre_regcabin=%s, datefait=%s, daterequisitoire=%s, datordcloture=%s, decisionord=%s, observation=%s, no_repjugementcorr=%s, Id_admin=%s, date_creation=%s, id_juridiction=%s WHERE id_regcabin=%s",
                       GetSQLValueString($_POST['numodre_regcabin'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datefait']), "date"),
                       GetSQLValueString(changedatefrus($_POST['daterequisitoire']), "date"),
                       GetSQLValueString(changedatefrus($_POST['datordcloture']), "date"),
                       GetSQLValueString($_POST['decisionord'], "text"),
                       GetSQLValueString($_POST['observation'], "text"),
                       GetSQLValueString($_POST['no_repjugementcorr'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['id_regcabin'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);



mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc ORDER BY date_creation DESC";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "int"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

$colname_select_nodossier = "-1";
if (isset($_POST['nodordre_plaintes'])) {
  $colname_select_nodossier = $_POST['nodordre_plaintes'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_plaintes_desc WHERE reg_plaintes_desc.nodordre_plaintes = %s", GetSQLValueString($colname_select_nodossier, "text"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);

$colname_select_cabin = "-1";
if (isset($_GET['idrca'])) {
  $colname_select_cabin = $_GET['idrca'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_cabin = sprintf("SELECT * FROM reg_cabin WHERE id_regcabin = %s", GetSQLValueString($colname_select_cabin, "int"));
$select_cabin = mysql_query($query_select_cabin, $jursta) or die(mysql_error());
$row_select_cabin = mysql_fetch_assoc($select_cabin);
$totalRows_select_cabin = mysql_num_rows($select_cabin);

mysql_select_db($database_jursta, $jursta);
$query_listenomplainte_plainte = "SELECT * FROM reg_plaintes_noms WHERE cles_pivot = '".$row_liste_plaintes['cles_pivot']."'";
$listenomplainte_plainte = mysql_query($query_listenomplainte_plainte, $jursta) or die(mysql_error());
$row_listenomplainte_plainte = mysql_fetch_assoc($listenomplainte_plainte);
$totalRows_listenomplainte_plainte = mysql_num_rows($listenomplainte_plainte);                              
?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."-".$datefr{3}.$datefr{4}."-".$datefr{0}.$datefr{1};

return $dateus;
}

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
	$( "#datepicker2" ).datepicker();
  });
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_regcabin.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="0" align="center" >
  <tr>
    <td align="center" bgcolor="#CCE3FF"><table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td class="Style2"><p>Le Registre du service des activit&eacute;s <br>
Cabinet d'Instruction - Modifier un enregistrement</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" valign="top" nowrap class="Style10"><form action="<?php echo $editFormAction; ?>" method="POST" name="form2">
                <table border="0" align="center" cellpadding="2" cellspacing="2">
                  <tr>
                    <td width="100%" valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
                      <tr>
                        <td align="right" valign="middle" nowrap class="Style10">N&deg; Dossier :</td>
                        <td><input name="nodordre_plaintes" type="text" id="nodordre_plaintes" value="<?php echo $row_liste_plaintes['nodordre_plaintes']; ?>" size="15"></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" valign="middle" nowrap bgcolor="#999999" class="Style10">Nom et Pr&eacute;noms des Inculp&eacute;s / Infractions</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" valign="middle" bgcolor="#FFFFFF" class="Style10"><table  bgcolor="#FFFFFF" border="0" cellpadding="1" cellspacing="1" class="Style10">
                          <?php do { ?>
                            <tr>
                              <td scope="col"><?php echo $row_listenomplainte_plainte['NomPreDomInculpes_plaintes']; ?></td>
                              <td scope="col"><?php echo $row_listenomplainte_plainte['NatInfraction_plaintes']; ?></td>
                            </tr>
                            <?php } while ($row_listenomplainte_plainte = mysql_fetch_assoc($liste_plaintes)); ?>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" class="Style10"><p>N&deg; du Cabinet<br>
d'instruction :<strong></strong></p></td>
                        <td><input name="numodre_regcabin" type="text" id="numodre_regcabin" size="15" value="<?php echo $row_select_cabin['numodre_regcabin']; ?>"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">Date du fait</span> : </td>
                        <td><input name="datefait" type="text" id="datepicker" value="<?php echo Change_formatDate($row_select_cabin['datefait']); ?>" size="15"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">Date du r&eacute;quisitoire </span>:</td>
                        <td><input name="daterequisitoire" type="text" id="datepicker1" value="<?php echo Change_formatDate($row_select_cabin['daterequisitoire']); ?>" size="15"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" nowrap class="Style10"><p align="right">Date Ordonnance<br>
                          de cl&ocirc;ture:</p></td>
                        <td><input name="datordcloture" type="text" id="datepicker3" value="<?php echo Change_formatDate($row_select_cabin['datordcloture']); ?>" size="15"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" nowrap class="Style10"><p align="right">D&eacute;cision Ordonnance<br>
                          de cl&ocirc;ture :</p><p>&nbsp;</p></td>
                        <td><label>
                          <textarea name="decisionord" cols="35" rows="4" id="decisionord"><?php echo $row_select_cabin['decisionord']; ?></textarea>
                        </label></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Observation </span> : </td>
                        <td><textarea name="observation" cols="35" rows="4" id="observation"><?php echo $row_select_cabin['observation']; ?></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_cabin['Id_admin']; ?>">
                          <input name="date_creation" type="hidden" id="date_creation" value="<?php echo $row_select_cabin['date_creation']; ?>">
                          <input name="id_juridiction" type="hidden" value="<?php echo $row_select_cabin['id_juridiction']; ?>">
                          <input name="no_repjugementcorr" type="hidden" id="no_repjugementcorr" value="<?php echo $row_select_cabin['no_repjugementcorr']; ?>">
                          <input name="id_regcabin" type="hidden" id="id_regcabin" value="<?php echo $row_select_cabin['id_regcabin']; ?>"></td>
                        <td><input type="submit" name="Valider_cmd" value="   Modifier l'enregistrement   "></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form2">
                <input type="hidden" name="MM_update" value="form2">
              </form></td>
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
mysql_free_result($select_admin);

mysql_free_result($select_admin);

mysql_free_result($select_nodossier);

mysql_free_result($select_cabin);

mysql_free_result($liste_plaintes);

mysql_free_result($select_juridic);

?>
