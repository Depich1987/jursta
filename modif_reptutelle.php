<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ChambreTutelle,Administrateur,Superviseur,AdminCivil";
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
  $updateSQL = sprintf("UPDATE rep_decisiontutel SET nodec_dectutel=%s, date_dectutel=%s, lien_dectutel=%s, decision_dectutel=%s, observation_dectutel=%s, signature_president=%s, date_modif=%s, Id_admin=%s, date_creation=%s, no_rolegeneral=%s, id_juridiction=%s WHERE no_dectutel=%s",
                       GetSQLValueString($_POST['nodec_dectutel'], "text"),
                       GetSQLValueString(Change_formatDat($_POST['date_dectutel']), "date"),
                       GetSQLValueString($_POST['lien_dectutel'], "text"),
                       GetSQLValueString($_POST['decision_dectutel'], "text"),
                       GetSQLValueString($_POST['observation_dectutel'], "text"),
                       GetSQLValueString($_POST['signature_president'], "text"),
                       GetSQLValueString($_POST['date_modif'], "date"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['no_dectutel'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
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

$colname_select_decisiontutel = "-1";
if (isset($_GET['idrpt'])) {
  $colname_select_decisiontutel = $_GET['idrpt'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_decisiontutel = sprintf("SELECT * FROM rep_decisiontutel, role_general WHERE ((no_dectutel = %s) AND (role_general.no_rolegeneral=rep_decisiontutel.no_rolegeneral))", GetSQLValueString($colname_select_decisiontutel, "int"));
$select_decisiontutel = mysql_query($query_select_decisiontutel, $jursta) or die(mysql_error());
$row_select_decisiontutel = mysql_fetch_assoc($select_decisiontutel);
$totalRows_select_decisiontutel = mysql_num_rows($select_decisiontutel);
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
rechargerpage("liste_reptutelle.php");
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
                <td width="100%" class="Style2"><p>R&eacute;pertoire de la Chambre des Tutelles  - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" valign="middle" nowrap bgcolor="#CCE3FF" class="Style10"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">

                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                      <td width="100%"><strong class="Style10"><?php echo Change_formatDate($row_select_decisiontutel['dateaudience_rolegeneral']); ?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Demandeur :</td>
                      <td><strong class="Style10"><?php echo $row_select_decisiontutel['demandeur_rolegeneral']; ?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Defendeur :</td>
                      <td><strong class="Style10"><?php echo $row_select_decisiontutel['defendeur_rolegeneral']; ?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Objet :</td>
                      <td class="Style10"><?php echo $row_select_decisiontutel['objet_rolegeneral']; ?></td>
                    </tr>
                </table></td>
            </tr>
            <tr>
              <td width="100%" align="right" valign="top" nowrap class="Style10">
                <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form2">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr class="Style10">
                      <td align="right" valign="middle" nowrap class="Style10">N&deg; D&eacute;cision : </td>
                      <td colspan="2"><input value="<?php echo $row_select_decisiontutel['nodec_dectutel']; ?>" name="nodec_dectutel" type="text" id="nodec_dectutel" size="15"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle" nowrap class="Style10">Date  :</td>
                      <td colspan="2"><input value="<?php echo Change_formatDate($row_select_decisiontutel['date_dectutel']); ?>" name="date_dectutel" type="text" id="datepicker" size="15"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle" nowrap class="Style10">D&eacute;cision : </td>
                      <td colspan="2"><select name="decision_dectutel" id="decision_dectutel">
                        <option value="Accord" <?php if (!(strcmp("Accord", $row_select_decisiontutel['decision_dectutel']))) {echo "selected=\"selected\"";} ?>>Accord / Garde juridique</option>
                        <option value="Radie" <?php if (!(strcmp("Radie", $row_select_decisiontutel['decision_dectutel']))) {echo "selected=\"selected\"";} ?>>Radi&eacute;</option>
                        <option value="Rejete" <?php if (!(strcmp("Rejete", $row_select_decisiontutel['decision_dectutel']))) {echo "selected=\"selected\"";} ?>>Rejet&eacute;e</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle" nowrap class="Style10">Fichier :</td>
                      <td colspan="2"><input value="<?php echo $row_select_decisiontutel['date_dectutel']; ?>" name="lien_dectutel" type="file" class="Style2" id="lien_dectutel"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle" nowrap class="Style10">Observation :</td>
                      <td colspan="2"><textarea name="observation_dectutel" id="observation_dectutel" cols="45" rows="5"><?php echo $row_select_decisiontutel['observation_dectutel']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Signature Greffier :</td>
                      <td colspan="2" class="Style10">Approuv&eacute;e par <?php echo substr($row_select_decisiontutel['signature_greffier'],0,36); ?> <?php echo Change_formatDate(substr($row_select_decisiontutel['signature_greffier'],36,10)); ?><?php echo substr($row_select_decisiontutel['signature_greffier'],47,12); ?></td>
                    </tr>
                    <tr>
                <td align="right" valign="top" nowrap class="Style10">Signature pr&eacute;sident :</td>
                <td><textarea name="signature_president" cols="40" rows="2" id="signature_president" readonly>Approuv&eacute;e par <?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?> le : <?php echo Change_formatDate(date("Y-m-d")); ?> à : <?php echo date("H:i:s");?></textarea></td>
              </tr>
                                        
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation" value="<?php echo $row_select_decisiontutel['date_creation']; ?>">
              		    <input name="date_modif" type="hidden" id="date_modif" value="<?php echo Change_formatDate(date("Y-m-d H:i:s")); ?>">
           		        <input name="no_dectutel" type="hidden" id="no_dectutel" value="<?php echo $row_select_decisiontutel['no_dectutel']; ?>">
                        <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_decisiontutel['no_rolegeneral']; ?>">
                        <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                      <td colspan="2"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form2">
                  <input type="hidden" name="MM_update" value="form2">
                </form>
 				</td>
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

mysql_free_result($select_decisiontutel);

mysql_free_result($select_decisiontutel);

mysql_free_result($select_admin);
?>
