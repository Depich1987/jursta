<?php require_once('Connections/jursta.php'); ?>
<?php require_once('Connections/jursta.php'); ?>
<?php require_once('Connections/jursta.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrateur,Sociale,Superviseur";
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
  $updateSQL = sprintf("UPDATE rep_decision SET nodec_decision=%s, grefier=%s, dispositif_decision=%s, observation_decision=%s, statut_decision=%s, signature_president=%s, date_modif=%s, Id_admin=%s, date_creation=%s, no_rgsocial=%s, id_juridiction=%s WHERE no_decision=%s",
                       GetSQLValueString($_POST['nodec_decision'], "text"),
                       GetSQLValueString($_POST['grefier'], "text"),
                       GetSQLValueString($_POST['dispositif_decision'], "text"),
                       GetSQLValueString($_POST['observation_decision'], "text"),
                       GetSQLValueString($_POST['statut_decision'], "text"),
                       GetSQLValueString($_POST['signature_president'], "text"),
                       GetSQLValueString($_POST['date_modif'], "date"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_rgsocial'], "int"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['no_decision'], "int"));

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

$colname_select_repdec = "1";
if (isset($_GET['nored'])) {
  $colname_select_repdec = $_GET['nored'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_repdec = sprintf("SELECT * FROM rep_decision, rg_social WHERE ((no_decision = %s) AND (rg_social.no_rgsocial =rep_decision.no_rgsocial))", GetSQLValueString($colname_select_repdec, "int"));
$select_repdec = mysql_query($query_select_repdec, $jursta) or die(mysql_error());
$row_select_repdec = mysql_fetch_assoc($select_repdec);
$totalRows_select_repdec = mysql_num_rows($select_repdec);
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
rechargerpage("liste_repdecision.php");
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
                <td width="100%" class="Style2"><p>Le r&eacute;pertoire des d&eacute;cisions - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCE3FF" class="Style10"><table border="0" cellspacing="0" cellpadding="2">
                  <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10" bgcolor="#FFFF00"><?php echo $row_select_repdec['noordre_rgsocial']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                <td class="Style10">                  <?php echo Change_formatDate($row_select_repdec['dateaudience_rgsocial']); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td class="Style10">                  <?php echo $row_select_repdec['objet_rgsocial']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10"><?php echo $row_select_repdec['demandeur_rgsocial']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_repdec['defendeur_rgsocial']; ?></td>
              </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; d&eacute;cision : </td>
                <td><input name="nodec_decision" type="text" id="nodec_decision" value="<?php echo $row_select_repdec['nodec_decision']; ?>" size="20"></td>
              </tr>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Greffier :</td>
                <td nowrap><label>
                  <input name="grefier" type="text" id="grefier" value="<?php echo $row_select_repdec['grefier']; ?>" size="30">
                </label></td>
              </tr>
              <td colspan="3" align="right" valign="top" nowrap class="Style10">
              <div id="statut" style="display:none; visibility:hidden">
              <table>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Pour Statistique: </td>
                <td><input <?php if (!(strcmp($row_select_repdec['statut_decision'],"Acceptée"))) {echo "CHECKED";} ?> type="radio" name="statut_decision" value="Accept&eacute;e">
Accept&eacute;e
<input <?php if (!(strcmp($row_select_repdec['statut_decision'],"Rejetée"))) {echo "CHECKED";} ?> type="radio" name="statut_decision" value="Rejet&eacute;e">
Rejet&eacute;e</td>
              </tr>
              </table>
              </div>
              </td>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Dispositif  :</td>
                <td><select name="dispositif_decision" size="1" id="select">
                  <?php
do {  
?>
                  <option value="<?php echo $row_select_repdec['dispositif_decision']?>"<?php if (!(strcmp($row_select_repdec['dispositif_decision'], $row_select_repdec['dispositif_repjugementsupp']))) {echo "selected=\"selected\"";} ?>><?php echo $row_select_repdec['dispositif_decision']?></option>
                  <?php
} while ($row_select_repdec = mysql_fetch_assoc($select_repdec));
  $rows = mysql_num_rows($select_repdec);
  if($rows > 0) {
      mysql_data_seek($select_repdec, 0);
	  $row_select_repdec = mysql_fetch_assoc($select_repdec);
  }
?>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observation_decision" cols="40" rows="7" id="observation_decision"><?php echo $row_select_repdec['observation_decision']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Signature greffier :</td>
                <td class="Style10"><?php echo substr($row_select_repdec['signature_greffier'],0,36); ?> <?php echo Change_formatDate(substr($row_select_repdec['signature_greffier'],36,10)); ?> à : <?php echo substr($row_select_repdec['signature_greffier'],47,8); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Signature pr&eacute;sident :</td>
                <td><textarea name="signature_president" cols="40" rows="2" id="signature_president" readonly>Approuv&eacute;e par <?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?> le : <?php echo Change_formatDate(date("Y-m-d")); ?> à : <?php echo date("H:i:s");?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo $row_select_repdec['date_creation']; ?>">
                  <input name="date_modif" type="hidden" id="date_modif" value="<?php echo Change_formatDate(date("Y-m-d H:i:s")); ?>">
                  <input name="no_decision" type="hidden" id="no_decision" value="<?php echo $row_select_repdec['no_decision']; ?>">
                  <input name="no_rgsocial" type="hidden" id="no_rgsocial" value="<?php echo $row_select_repdec['no_rgsocial']; ?>">
                  <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_repdec['id_juridiction']; ?>">
                  </td>
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

mysql_free_result($select_repdec);
?>
