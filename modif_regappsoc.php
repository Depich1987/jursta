<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Sociale,Administrateur,Superviseur";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE reg_socialappel SET no_socialappel=%s, datejour=%s, datejugement=%s, Signature=%s, no_decision=%s, Id_admin=%s, date_creation=%s, date_modif=%s, id_juridiction=%s WHERE id_socialappel=%s",
                       GetSQLValueString($_POST['no_socialappel'], "text"),
                       GetSQLValueString($_POST['datejour'], "date"),
                       GetSQLValueString(Change_formatDat($_POST['datejugement']), "date"),
                       GetSQLValueString($_POST['signature'], "text"),
                       GetSQLValueString($_POST['no_decision'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['date_modif'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['id_socialappel'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_regapp = "1";
if (isset($_GET['idras'])) {
  $colname_select_regapp = $_GET['idras'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_regapp = sprintf("SELECT * FROM reg_socialappel, rg_social, rep_decision WHERE ((id_socialappel = %s) AND (rg_social.no_rgsocial=rep_decision.no_rgsocial) AND (rep_decision.no_decision=reg_socialappel.no_decision))", GetSQLValueString($colname_select_regapp, "int"));
$select_regapp = mysql_query($query_select_regapp, $jursta) or die(mysql_error());
$row_select_regapp = mysql_fetch_assoc($select_regapp);
$totalRows_select_regapp = mysql_num_rows($select_regapp);

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
?>
<?php
function Change_formatDate($date, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}

function Change_formatDat($date, $format = 'en')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'fr')
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
rechargerpage("liste_regappelsocial.php");
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
                <td width="100%" class="Style2"><p>Registre des Voies de Recours en Appel - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCE3FF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_regapp['noordre_rgsocial']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10">                  <?php echo $row_select_regapp['demandeur_rgsocial']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_regapp['defendeur_rgsocial']; ?></td>
              </tr>
                 </table></td>
              </tr>
              <tr>
                <td width="31%" align="right" valign="top" nowrap class="Style10">N&deg; d'Ordre : </td>
                <td class="Style10"><label>
                  <input name="no_socialappel" type="text" id="no_socialappel" value="<?php echo $row_select_regapp['no_socialappel']; ?>" size="15">
                  </label></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date du 
                  jugement :</td>
                <td><input value="<?php echo Change_formatDate($row_select_regapp['datejugement']); ?>" name="datejugement" type="text" id="datejugement" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Emmargement : </td>
                <td><input value="<?php echo $row_select_regapp['Signature']; ?>" name="signature" type="text" id="signature" size="30"></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                  <input name="date_modif" type="hidden" id="date_modif" value="<?php echo date("Y-m-d H:i:s"); ?>">
                  <input name="id_socialappel" type="hidden" id="id_socialappel" value="<?php echo $row_select_regapp['id_socialappel']; ?>">
                  <input name="datejour" type="hidden" id="datejour" value="<?php echo $row_select_regapp['datejour']; ?>">
                  <input name="no_decision" type="hidden" id="no_decision" value="<?php echo $row_select_regapp['no_decision']; ?>">
                  <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_regapp['id_juridiction']; ?>"></td>
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
  <input type="hidden" name="MM_update" value="form1">
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_regapp);

mysql_free_result($select_admin);
?>
