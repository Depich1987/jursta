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
  $updateSQL = sprintf("UPDATE rep_ordpresi SET noordonnace_ordonnance=%s, dispositif_ordonnance=%s, observation_ordonnance=%s, Id_admin=%s, date_creation=%s, no_rolegeneral=%s WHERE no_ordonnance=%s",
                       GetSQLValueString($_POST['noordonnace_ordonnance'], "text"),
                       GetSQLValueString($_POST['dispositif_ordonnance'], "text"),
                       GetSQLValueString($_POST['observation_ordonnance'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"),
                       GetSQLValueString($_POST['no_ordonnance'], "int"));

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

$colname_select_repordpresi = "1";
if (isset($_GET['norop'])) {
  $colname_select_repordpresi = (get_magic_quotes_gpc()) ? $_GET['norop'] : addslashes($_GET['norop']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_repordpresi = sprintf("SELECT * FROM role_general, rep_ordpresi WHERE ((no_ordonnance = %s) AND (role_general.no_rolegeneral=rep_ordpresi.no_rolegeneral))", $colname_select_repordpresi);
$select_repordpresi = mysql_query($query_select_repordpresi, $jursta) or die(mysql_error());
$row_select_repordpresi = mysql_fetch_assoc($select_repordpresi);
$totalRows_select_repordpresi = mysql_num_rows($select_repordpresi);
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
rechargerpage("liste_repordpresi.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
  <table width="480" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/rename_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le repertoire des ordonnances pr&eacute;sidentielles - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCE3FF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_repordpresi['noordre_rolegeneral']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                <td class="Style10">                  <?php echo Change_formatDate($row_select_repordpresi['dateaudience_rolegeneral']); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td class="Style10">                  <?php echo $row_select_repordpresi['objet_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10"><?php echo $row_select_repordpresi['demandeur_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_repordpresi['defendeur_rolegeneral']; ?></td>
              </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg;  de l'ordonnance :</td>
                <td><input name="noordonnace_ordonnance" type="text" id="noordonnace_ordonnance" value="<?php echo $row_select_repordpresi['noordonnace_ordonnance']; ?>" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> <span class="Style10">Dispositif </span> :</td>
                <td><select name="dispositif_ordonnance" id="select">
                  <option value="En cours" <?php if (!(strcmp("En cours", $row_select_repordpresi['dispositif_ordonnance']))) {echo "SELECTED";} ?>></option>
                  <option value="Contradictoire" <?php if (!(strcmp("Contradictoire", $row_select_repordpresi['dispositif_ordonnance']))) {echo "SELECTED";} ?>>Contradictoire</option>
                  <option value="Incompetence" <?php if (!(strcmp("Incompetence", $row_select_repordpresi['dispositif_ordonnance']))) {echo "SELECTED";} ?>>Incomp&eacute;tence</option>
                  <option value="Radiation" <?php if (!(strcmp("Radiation", $row_select_repordpresi['dispositif_ordonnance']))) {echo "SELECTED";} ?>>Radiation</option>
                  <option value="Defaut" <?php if (!(strcmp("Defaut", $row_select_repordpresi['dispositif_ordonnance']))) {echo "SELECTED";} ?>>D&eacute;faut</option>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="Style10">Observation : </td>
                <td><textarea name="observation_ordonnance" cols="40" rows="7" id="observation_ordonnance"><?php echo $row_select_repordpresi['observation_ordonnance']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Fichier :</td>
                <td><input name="lien_fich" type="file"  value="<?php echo $row_select_repordpresi['lien_fich']; ?>"class="Style2" id="lien_fich" size="30"> </td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="no_ordonnance" type="hidden" id="no_ordonnance" value="<?php echo $row_select_repordpresi['no_ordonnance']; ?>">
                    <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_repordpresi['no_rolegeneral']; ?>"></td>
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

mysql_free_result($select_repordpresi);
?>
