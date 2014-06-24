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
  $updateSQL = sprintf("UPDATE role_general SET noordre_rolegeneral=%s, date_rolegeneral=%s, demandeur_rolegeneral=%s, defendeur_rolegeneral=%s, objet_rolegeneral=%s, observation_rolegeneral=%s, Id_admin=%s, date_creation=%s dateaudience_rolegeneral=%s WHERE no_rolegeneral=%s",
                       GetSQLValueString($_POST['noordre_rolegeneral'], "text"),
                       GetSQLValueString($_POST['date_rolegeneral'], "date"),
                       GetSQLValueString($_POST['demandeur_rolegeneral'], "text"),
                       GetSQLValueString($_POST['defendeur_rolegeneral'], "text"),
                       GetSQLValueString($_POST['objet_rolegeneral'], "text"),
                       GetSQLValueString($_POST['observation_rolegeneral'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['dateaudience_rolegeneral'], "date"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"));

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

$colname_select_rolegeneral = "1";
if (isset($_GET['norg'])) {
  $colname_select_rolegeneral = (get_magic_quotes_gpc()) ? $_GET['norg'] : addslashes($_GET['norg']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_rolegeneral = sprintf("SELECT * FROM role_general WHERE no_rolegeneral = %s", $colname_select_rolegeneral);
$select_rolegeneral = mysql_query($query_select_rolegeneral, $jursta) or die(mysql_error());
$row_select_rolegeneral = mysql_fetch_assoc($select_rolegeneral);
$totalRows_select_rolegeneral = mysql_num_rows($select_rolegeneral);
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
rechargerpage("liste_rgsociale.php");
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
                <td width="100%" class="Style2"><p>Le role g&eacute;n&eacute;ral - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; d'ordre : </td>
                <td><input name="noordre_rolegeneral" type="text" id="noordre_rolegeneral" value="<?php echo $row_select_rolegeneral['noordre_rolegeneral']; ?>" size="20"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date : </td>
                <td><input name="date_rolegeneral" type="text" id="date_rolegeneral" size="15" value="<?php echo $row_select_rolegeneral['date_rolegeneral']; ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur</td>
                <td><input name="demandeur_rolegeneral" type="text" id="demandeur_rolegeneral" value="<?php echo $row_select_rolegeneral['demandeur_rolegeneral']; ?>" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Defendeur</td>
                <td><input name="defendeur_rolegeneral" type="text" id="defendeur_rolegeneral" value="<?php echo $row_select_rolegeneral['defendeur_rolegeneral']; ?>" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td><textarea name="objet_rolegeneral" cols="40" rows="5" id="objet_rolegeneral"><?php echo $row_select_rolegeneral['objet_rolegeneral']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> 1<sup>&egrave;re</sup>date d'audience</td>
                <td><input name="dateaudience_rolegeneral" type="text" id="dateaudience_rolegeneral" value="<?php echo $row_select_rolegeneral['dateaudience_rolegeneral']; ?>" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observation_rolegeneral" cols="40" rows="7" id="observation_rolegeneral"><?php echo $row_select_rolegeneral['observation_rolegeneral']; ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_rolegeneral['no_rolegeneral']; ?>"></td>
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

mysql_free_result($select_rolegeneral);
?>
