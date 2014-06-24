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
  $updateSQL = sprintf("UPDATE reg_controlnum SET noordre_regcontrolnum=%s, sexe_regcontrolnum=%s, date_regcontrolnum=%s, Id_admin=%s, date_creation=%s, no_regmandat=%s WHERE no_regcontrolnum=%s",
                       GetSQLValueString($_POST['noordre_regcontrolnum'], "text"),
                       GetSQLValueString($_POST['sexe_regcontrolnum'], "text"),
                       GetSQLValueString(changedatefrus($_POST['date_regcontrolnum']), "date"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_regmandat'], "int"),
                       GetSQLValueString($_POST['no_regcontrolnum'], "int"));

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

$colname_select_regima = "1";
if (isset($_GET['noregima'])) {
  $colname_select_regima = (get_magic_quotes_gpc()) ? $_GET['noregima'] : addslashes($_GET['noregima']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_regima = sprintf("SELECT * FROM reg_controlnum, reg_mandat WHERE ((no_regcontrolnum = %s) AND (reg_mandat.no_regmandat=reg_controlnum.no_regmandat))", $colname_select_regima);
$select_regima = mysql_query($query_select_regima, $jursta) or die(mysql_error());
$row_select_regima = mysql_fetch_assoc($select_regima);
$totalRows_select_regima = mysql_num_rows($select_regima);
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
rechargerpage("liste_regima.php");
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
                <td width="100%" class="Style2"><p>Le registre d'immatriculation - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCE3FF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Mandat :</td>
                <td class="Style10">
                  <input name="textfield" type="text" value="<?php echo $row_select_regima['noordre_regmandat']; ?>" size="15" disabled></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nom et pr&eacute;noms : </td>
                <td class="Style10">                  <?php echo $row_select_regima['nom_regmandat']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nom du Procureur  : </td>
                <td class="Style10">                  <?php echo $row_select_regima['magistra_regmandat']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nature du d&eacute;lit : </td>
                <td class="Style10"><?php echo $row_select_regima['infraction_regmandat']; ?></td>
              </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; d'Immatriculation : </td>
                <td><input name="noordre_regcontrolnum" type="text" id="noordre_regcontrolnum" value="<?php echo $row_select_regima['noordre_regcontrolnum']; ?>" size="20"></td>
              </tr>
               <tr>
                <td align="right" valign="top" nowrap class="Style10"> Sexe :</td>
                <td><select name="sexe_regcontrolnum" size="1" id="sexe_regcontrolnum">
                  <option value="Masculin" selected <?php if (!(strcmp("Masculin", $row_select_regima['sexe_regcontrolnum']))) {echo "SELECTED";} ?>>M</option>
                  <option value="Feminin" <?php if (!(strcmp("Feminin", $row_select_regima['sexe_regcontrolnum']))) {echo "SELECTED";} ?>>F</option>
                                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date : </td>
                <td><input name="date_regcontrolnum" type="text" id="datepicker" value="<?php echo Change_formatDate($row_select_regima['date_regcontrolnum']); ?>" size="15"></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="no_regcontrolnum" type="hidden" id="no_regcontrolnum" value="<?php echo $row_select_regima['no_regcontrolnum']; ?>">
                    <input name="no_regmandat" type="hidden" id="no_regmandat" value="<?php echo $row_select_regima['no_regmandat']; ?>"></td>
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

mysql_free_result($select_regima);
?>
