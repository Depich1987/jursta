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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_evasion (numordre_regevasion, datevasion_regevasion, lieuevasion_regevasion, circonstance_regevasion, dateretour_regevasion, lieureintegration_regevasion, obs_regevasion, Id_admin, date_creation, id_juridiction, no_ecrou) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numordre_regevasion'], "text"),
                       GetSQLValueString($_POST['datevasion_regevasion'], "date"),
                       GetSQLValueString($_POST['lieuevasion_regevasion'], "text"),
                       GetSQLValueString($_POST['circonstance_regevasion'], "text"),
                       GetSQLValueString($_POST['dateretour_regevasion'], "date"),
                       GetSQLValueString($_POST['lieureintegration_regevasion'], "text"),
                       GetSQLValueString($_POST['obs_regevasion'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['no_ecrou'], "int"));

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
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
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
rechargerpage("liste_reglevecrou.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="480" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="480" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre d'&eacute;vasion - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" valign="top" bgcolor="#CCE3FF" class="Style10"><form name="form1" method="post" action="add_regevasion.php">
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
              <td width="100%" align="center" valign="top" nowrap class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#6186AF" class="Style10">
                    <tr>
                      <td colspan="4" align="center" valign="top" class="Style10"><table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#6186AF">
                        <tr class="Style10">
                          <td width="27%" align="right" valign="top" nowrap class="Style10">N&deg; d'ordre :</td>
                          <td width="73%"><input name="numordre_regevasion" type="text" id="numordre_regevasion" size="15"></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Date d'evasion : </td>
                            <td><input name="datevasion_regevasion" type="text" id="datepicker" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
                          </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Lieu d'&eacute;vasion :</td>
                          <td><input name="lieuevasion_regevasion" type="text" id="lieuevasion_regevasion" size="35"></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Circonstances :</td>
                            <td><textarea name="circonstance_regevasion" cols="35" rows="3" id="circonstance_regevasion"></textarea></td>
                          </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Date de r&eacute;integration :</td>
                            <td><input name="dateretour_regevasion" type="text" id="datepicker1" size="15"></td>
                          </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10"> Lieu de r&eacute;int&eacute;gration : </td>
                            <td><input name="lieureintegration_regevasion" type="text" id="lieureintegration_regevasion" size="35"></td>
                          </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Observation :</td>
                          <td><textarea name="obs_regevasion" cols="35" rows="3" id="obs_regevasion"></textarea></td>
                        </tr>
                      </table></td>
                      </tr>
                    
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                        <input name="no_ecrou" type="hidden" id="no_ecrou" value="<?php echo $row_select_nodossier['no_ecrou']; ?>">
                        <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                      <td colspan="3" align="center"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
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
mysql_free_result($select_admin);

mysql_free_result($select_nodossier);

mysql_free_result($select_admin);
?>

