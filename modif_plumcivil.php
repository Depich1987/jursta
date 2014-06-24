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
  $updateSQL = sprintf("UPDATE plum_civil SET presi_plumcivil=%s, greffier_plumcivil=%s, accesseurs_plumcivil=%s, Substitut_PlumCivil=%s, type_affaire=%s, observ_plumcivil=%s, Id_admin=%s, date_creation=%s, date_modif=%s, no_rolegeneral=%s WHERE id_plumcivil=%s",
                       GetSQLValueString($_POST['presi_plumcivil'], "text"),
                       GetSQLValueString($_POST['greffier_plumcivil'], "text"),
                       GetSQLValueString($_POST['accesseurs_plumcivil'], "text"),
                       GetSQLValueString($_POST['substitu_plumcivil'], "text"),
                       GetSQLValueString($_POST['type_affaire'], "text"),
                       GetSQLValueString($_POST['observ_plumcivil'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['date_modification'], "date"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"),
                       GetSQLValueString($_POST['id_plumcivil'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_plumcivil = "1";
if (isset($_GET['idpc'])) {
  $colname_select_plumcivil = $_GET['idpc'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_plumcivil = sprintf("SELECT * FROM plum_civil, role_general WHERE ((id_plumcivil = %s) AND (role_general.no_rolegeneral=plum_civil.no_rolegeneral))", GetSQLValueString($colname_select_plumcivil, "int"));
$select_plumcivil = mysql_query($query_select_plumcivil, $jursta) or die(mysql_error());
$row_select_plumcivil = mysql_fetch_assoc($select_plumcivil);
$totalRows_select_plumcivil = mysql_num_rows($select_plumcivil);

$colname_select_date = "-1";
if (isset($_GET['idpc'])) {
  $colname_select_date = $_GET['idpc'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_date = sprintf("SELECT date_creation, date_modif FROM plum_civil WHERE id_plumcivil = %s", GetSQLValueString($colname_select_date, "int"));
$select_date = mysql_query($query_select_date, $jursta) or die(mysql_error());
$row_select_date = mysql_fetch_assoc($select_date);
$totalRows_select_date = mysql_num_rows($select_date);
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
rechargerpage("liste_plumcivil.php");
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
                <td width="100%" class="Style2"><p>Plumitif Civil - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCE3FF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_plumcivil['noordre_rolegeneral']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                <td class="Style10">                  <?php echo Change_formatDate($row_select_plumcivil['dateaudience_rolegeneral']); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10">                  <?php echo $row_select_plumcivil['demandeur_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_plumcivil['defendeur_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">  Objet : </td>
                <td class="Style10"><?php echo $row_select_plumcivil['objet_rolegeneral']; ?></td>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Pr&eacute;sident : </td>
                <td><input value="<?php echo $row_select_plumcivil['presi_plumcivil']; ?>" name="presi_plumcivil" type="text" id="presi_plumcivil" size="30"></td>
              </tr>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Accesseurs :</td>
                <td><textarea name="accesseurs_plumcivil" cols="30" rows="3" id="accesseurs_plumcivil"><?php echo $row_select_plumcivil['accesseurs_plumcivil']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Substitut du P.R :</td>
                <td><input value="<?php echo $row_select_plumcivil['Substitut_PlumCivil']; ?>" name="substitu_plumcivil" type="text" id="substitu_plumcivil" size="30"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Greffier : </td>
                <td><input value="<?php echo $row_select_plumcivil['greffier_plumcivil']; ?>" name="greffier_plumcivil" type="text" id="greffier_plumcivil" size="30"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Type d'affaire :</td>
                <td><select name="type_affaire" id="type_affaire">
                  <option value="" <?php if (!(strcmp("", $row_select_plumcivil['type_affaire']))) {echo "selected=\"selected\"";} ?>></option>
                  <option value="Délibérée" <?php if (!(strcmp("Délibérée", $row_select_plumcivil['type_affaire']))) {echo "selected=\"selected\"";} ?>>Délibérée</option>
                  <option value="Ancienne" <?php if (!(strcmp("Ancienne", $row_select_plumcivil['type_affaire']))) {echo "selected=\"selected\"";} ?>>Ancienne</option>
                  <option value="Nouvelle" <?php if (!(strcmp("Nouvelle", $row_select_plumcivil['type_affaire']))) {echo "selected=\"selected\"";} ?>>Nouvelle</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_select_plumcivil['type_affaire']?>"<?php if (!(strcmp($row_select_plumcivil['type_affaire'], $row_select_plumcivil['type_affaire']))) {echo "selected=\"selected\"";} ?>><?php echo $row_select_plumcivil['type_affaire']?></option>
                  <?php
} while ($row_select_plumcivil = mysql_fetch_assoc($select_plumcivil));
  $rows = mysql_num_rows($select_plumcivil);
  if($rows > 0) {
      mysql_data_seek($select_plumcivil, 0);
	  $row_select_plumcivil = mysql_fetch_assoc($select_plumcivil);
  }
?>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observ_plumcivil" cols="40" rows="7" id="observ_plumcivil"><?php echo $row_select_plumcivil['observ_plumcivil']; ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php $row_select_date['date_creation']; ?>">
                    <input name="date_modification" type="hidden" id="date_modif" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="id_plumcivil" type="hidden" id="id_plumcivil" value="<?php echo $row_select_plumcivil['id_plumcivil']; ?>">
                    <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_plumcivil['no_rolegeneral']; ?>"></td>
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
mysql_free_result($select_plumcivil);

mysql_free_result($select_date);
?>
