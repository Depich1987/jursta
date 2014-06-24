<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Penitentiaire,Superviseur";
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
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE reg_levecrou SET motif_reglevecrou=%s, origine_reglevecrou=%s, datedepart_reglevecrou=%s, dateretour_reglevecrou=%s, destination_reglevecrou=%s, noordre_ecrou=%s, id_juridiction=%s, date_creation=%s WHERE Id_admin=%s",
                       GetSQLValueString($_POST['motif_reglevecrou'], "text"),
                       GetSQLValueString($_POST['origine_reglevecrou'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datedepart_reglevecrou']), "date"),
                       GetSQLValueString(changedatefrus($_POST['dateretour_reglevecrou']), "date"),
                       GetSQLValueString($_POST['destination_reglevecrou'], "text"),
                       GetSQLValueString($_POST['noordre_ecrou'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_admin'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}


$colname_select_nodossier = "1";
if (isset($GET[noreglev])) {
  $colname_select_nodossier = $GET[noreglev];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_mandat, reg_controlnum, reg_ecrou,reg_levecrou WHERE ((id_reglevecrou = %s) AND (reg_ecrou.noordre_ecrou=reg_levecrou.noordre_ecrou))", GetSQLValueString($colname_select_nodossier, "int"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);


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
<style type="text/css">
<!--
.Style15 {font-size: small}
-->
</style>
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="100%" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre de lev&eacute;e d'ecrou- Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" valign="top" nowrap class="Style10">                    <table border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">N&deg; d'Immatriculation :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['noordre_regcontrolnum']; ?></td>
                      
                      <td valign="top" nowrap class="Style10">&nbsp;</td>
                      <td valign="top" nowrap class="Style10">N&deg; d'Ecrou:</td>
                      <td valign="top" nowrap class="Style10"><span class="Style10"><?php echo $row_select_nodossier['noordre_ecrou']; ?></span></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Nom et pr&eacute;noms :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['nom_regmandat']; ?></td>
                      <td valign="top" nowrap class="Style10">&nbsp;</td>
                      <td valign="top" nowrap class="Style10">Date de naissance :</td>
                      <td valign="top" nowrap class="Style10"><?php echo Change_formatDate($row_select_nodossier['datnaisdet_ecrou']); ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Nom du Procureur :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['magistra_regmandat']; ?></td>
                      <td valign="top" nowrap class="Style10">&nbsp;</td>
                      <td valign="top" nowrap class="Style10">Lieu de naissance :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['lieunaisdet_ecrou']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Type de mandat :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['type_regmandat']; ?></td>
                      <td valign="top" nowrap class="Style10">&nbsp;</td>
                      <td valign="top" nowrap class="Style10">Domicile : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['domicildet_ecrou']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Par : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['magistra_regmandat']; ?></td>
                      <td valign="top" nowrap class="Style10">&nbsp;</td>
                      <td valign="top" nowrap class="Style10">Taille : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['tailledet_ecrou']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Pour : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['infraction_regmandat']; ?></td>
                      <td valign="top" nowrap class="Style10">&nbsp;</td>
                      <td valign="top" nowrap class="Style10">Signe particulier : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['signepartdet_ecrou']; ?></td>
                    </tr>
                    
                </table></td></tr>
            <tr>
              <td width="100%" align="right" valign="top" nowrap class="Style10"><table align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td bgcolor="#6186AF"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#6186AF" class="Style10">
                    <tr>
                      <td colspan="4" align="right" valign="top" nowrap class="Style10"><table bgcolor="#6186AF">
                          <tr class="Style10">
                            <td align="right" valign="top" nowrap class="Style10">Date de D&eacute;part: </td>
                            <td><input name="datedepart_reglevecrou" type="text" id="datedepart_reglevecrou" size="15" value="<?php echo Change_formatDate($row_select_nodossier['datedepart_reglevecrou']); ?>"></td>
                          </tr>
                          <tr class="Style10">
                            <td align="right" valign="top" nowrap class="Style10">Motifs :</td>
                            <td><input value="<?php echo $row_select_nodossier['motif_reglevecrou']; ?>" name="motif_reglevecrou" type="text" id="motif_reglevecrou" size="35"></td>
                          </tr>
                          <tr class="Style10">
                            <td align="right" valign="top" nowrap class="Style10">Origine :</td>
                            <td><input name="origine_reglevecrou" type="text" id="origine_reglevecrou" value="<?php echo $row_select_nodossier['origine_reglevecrou']; ?>" size="35"></td>
                          </tr>
                          <tr class="Style10">
                            <td align="right" valign="top" nowrap class="Style10">Date retour : </td>
                            <td><input value="<?php echo $row_select_nodossier['dateretour_reglevecrou']; ?>" name="dateretour_reglevecrou" type="text" id="dateretour_reglevecrou" size="15"></td>
                          </tr>
                          <tr class="Style10">
                            <td align="right" valign="top" nowrap class="Style10"> Destination : </td>
                            <td><input value="<?php echo $row_select_nodossier['destination_reglevecrou']; ?>" name="destination_reglevecrou" type="text" id="destination_reglevecrou" size="35"></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin2" value="<?php echo $row_select_admin['Id_admin']; ?>">
                          <input name="date_creation" type="hidden" id="date_creation2" value="<?php echo date("Y-m-d H:i:s"); ?>">
                          <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_nodossier['id_juridiction']; ?>">
                          <input name="noordre_ecrou" type="hidden" id="noordre_ecrou" value="<?php echo $row_select_nodossier['noordre_ecrou']; ?>"></td>
                      <td colspan="3" align="center"><input type="submit" name="Valider_cmd" value="   Modifier l'enregistrement   "></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form2">
                </form>
                <?php } // Show if recordset not empty ?></td>
                  </tr>
              </table></td>
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
mysql_free_result($select_nodossier);

mysql_free_result($select_admin);
?>

