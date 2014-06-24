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
  $updateSQL = sprintf("UPDATE rep_jugementsupp SET nojugement_repjugementsupp=%s, dispositif_repjugementsupp=%s, observation_repjugementsupp=%s, Id_admin=%s, date_creation=%s, no_rolegeneral=%s, statut_jugementsupp=%s, id_juridiction=%s, decision_repjugementsupp=%s, signature_president=%s, date_modif=%s WHERE no_repjugementsupp=%s",
                       GetSQLValueString($_POST['nojugement_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['dispositif_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['observation_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['objet_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['demandeur_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"),
                       GetSQLValueString($_POST['statut_jugementsupp'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['decision_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['signature_president'], "text"),
                       GetSQLValueString($_POST['date_modif'], "date"),
                       GetSQLValueString($_POST['no_repjugementsupp'], "int"));

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

$colname_select_repjug = "1";
if (isset($_GET['norej'])) {
  $colname_select_repjug = $_GET['norej'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_repjug = sprintf("SELECT * FROM rep_jugementsupp, role_general WHERE ((no_repjugementsupp = %s) AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))", GetSQLValueString($colname_select_repjug, "int"));
$select_repjug = mysql_query($query_select_repjug, $jursta) or die(mysql_error());
$row_select_repjug = mysql_fetch_assoc($select_repjug);
$totalRows_select_repjug = mysql_num_rows($select_repjug);

mysql_select_db($database_jursta, $jursta);
$query_select_dispositif = "SELECT libellé FROM dispositifs";
$select_dispositif = mysql_query($query_select_dispositif, $jursta) or die(mysql_error());
$row_select_dispositif = mysql_fetch_assoc($select_dispositif);
$totalRows_select_dispositif = mysql_num_rows($select_dispositif);
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
rechargerpage("liste_repjug.php");
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
                <td width="100%" class="Style2"><p>Le r&eacute;pertoire des jugements - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCECFF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_repjug['noordre_rolegeneral']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                <td class="Style10">                  <?php echo Change_formatDate($row_select_repjug['dateaudience_rolegeneral']); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td class="Style10">                  <?php echo $row_select_repjug['objet_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10"><?php echo $row_select_repjug['demandeur_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_repjug['defendeur_rolegeneral']; ?></td>
              </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; du Jugement : </td>
                <td><input name="nojugement_repjugementsupp" type="text" id="nojugement_repjugementsupp" value="<?php echo $row_select_repjug['nojugement_repjugementsupp']; ?>" size="20"></td>
              </tr>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Dispositif  :</td>
                <td nowrap><input <?php if (!(strcmp($row_select_repjug['decision_repjugementsupp'],"Fondé"))) {echo "checked=\"checked\"";} ?> type="radio" name="decision_repjugementsupp" id="radio" value="Fond&eacute;">
Fond&eacute;
<input <?php if (!(strcmp($row_select_repjug['decision_repjugementsupp'],"Mal Fondé"))) {echo "checked=\"checked\"";} ?> type="radio" name="decision_repjugementsupp" id="radio2" value="Mal Fond&eacute;">
Mal Fond&eacute;
<input <?php if (!(strcmp($row_select_repjug['decision_repjugementsupp'],"Partiellement Fondé"))) {echo "checked=\"checked\"";} ?> type="radio" name="decision_repjugementsupp" id="radio3" value="Partiellement Fond&eacute;">
Partiellement Fond&eacute;</td>
              </tr>
              <td colspan="3" align="right" valign="top" nowrap class="Style10">
              <div id="statut" style="display:none; visibility:hidden">
              <table>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Pour Statistique: </td>
                <td><input <?php if (!(strcmp($row_select_repjug['statut_jugementsupp'],"Acceptée"))) {echo "CHECKED";} ?> type="radio" name="statut_jugementsupp" value="Accept&eacute;e">
Accept&eacute;e
<input <?php if (!(strcmp($row_select_repjug['statut_jugementsupp'],"Rejetée"))) {echo "CHECKED";} ?> type="radio" name="statut_jugementsupp" value="Rejet&eacute;e">
Rejet&eacute;e</td>
              </tr>
              </table>
              </div>
              </td>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Caract&egrave;re  :</td>
                <td><select name="dispositif_repjugementsupp" size="1" id="select">
                  <?php
do {  
?>
                  <option value="<?php echo $row_select_dispositif['libellé']?>"<?php if (!(strcmp($row_select_dispositif['libellé'], $row_select_repjug['dispositif_repjugementsupp']))) {echo "selected=\"selected\"";} ?>><?php echo $row_select_dispositif['libellé']?></option>
                  <?php
} while ($row_select_dispositif = mysql_fetch_assoc($select_dispositif));
  $rows = mysql_num_rows($select_dispositif);
  if($rows > 0) {
      mysql_data_seek($select_dispositif, 0);
	  $row_select_dispositif = mysql_fetch_assoc($select_dispositif);
  }
?>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observation_repjugementsupp" cols="40" rows="7" id="observation_repjugementsupp"><?php echo $row_select_repjug['observation_repjugementsupp']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Signature greffier :</td>
                <td class="Style10"><?php echo $row_select_repjug['signature_greffier']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Signature pr&eacute;sident :</td>
                <td><textarea name="signature_president" cols="40" rows="2" readonly="readonly" id="signature_president">Approuv&eacute;e par <?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?> le : <?php echo Change_formatDate(date("Y-m-d H:i:s")); ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo Change_formatDate(date("Y-m-d H:i:s")); ?>">
                  <input name="date_modif" type="hidden" id="date_modif" value="<?php echo Change_formatDate(date("Y-m-d H:i:s")); ?>">
                  <input name="no_repjugementsupp" type="hidden" id="no_repjugementsupp" value="<?php echo $row_select_repjug['no_repjugementsupp']; ?>">
                  <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_repjug['no_rolegeneral']; ?>">
                  <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_repjug['id_juridiction']; ?>">
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

mysql_free_result($select_repjug);

mysql_free_result($select_dispositif);
?>
