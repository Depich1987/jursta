<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Penitentiaire,Administrateur,Superviseur";
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

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_evecrou = "1";
if (isset($_GET['norege'])) {
  $colname_select_evecrou = $_GET['norege'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_evecrou = sprintf("SELECT * FROM reg_ecrou, reg_mandat, reg_controlnum WHERE ((no_ecrou = %s) AND (reg_controlnum.no_regcontrolnum=reg_ecrou.no_regcontrolnum) AND (reg_controlnum.no_regcontrolnum=reg_mandat.no_regmandat))", GetSQLValueString($colname_select_evecrou, "int"));
$select_evecrou = mysql_query($query_select_evecrou, $jursta) or die(mysql_error());
$row_select_evecrou = mysql_fetch_assoc($select_evecrou);
$totalRows_select_evecrou = mysql_num_rows($select_evecrou);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs, reg_ecrou WHERE administrateurs.Id_admin=reg_ecrou.Id_admin";
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_evecrou['Id_admin'];
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
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form name="form1" method="POST">
  <table width="480" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/mark_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre  d'ecrou- Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">#</td>
                <td class="Style10"><?php echo $row_select_evecrou['no_ecrou']; ?></td>
                <td align="right" nowrap class="Style10">N&deg; d'ecrou : </td>
                <td class="Style10"><?php echo $row_select_evecrou['noordre_ecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Nom et pr&eacute;noms : </td>
                <td class="Style10"><?php echo $row_select_evecrou['nom_regmandat']; ?></td>
                <td align="right" nowrap class="Style10">Date D'entr&eacute;e : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_evecrou['datenter_ecrou']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Date et Lieu de Naissance : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_evecrou['datnaisdet_ecrou']); ?>/<?php echo $row_select_evecrou['lieunaisdet_ecrou']; ?></td>
                <td align="right" nowrap class="Style10">Prolongation de la d&eacute;tention :</td>
                <td class="Style10"><?php echo $row_select_evecrou['prolongdet_ecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Parents : </td>
                <td class="Style10"><?php echo $row_select_evecrou['peredet_ecrou']; ?>/<?php echo $row_select_evecrou['meredet_ecrou']; ?></td>
                <td align="right" nowrap class="Style10">D&eacute;cision judiciaire intervenue :</td>
                <td class="Style10"><?php echo $row_select_evecrou['decisionjudic_ecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"> Profession : </td>
                <td class="Style10"><?php echo $row_select_evecrou['professiondet_ecrou']; ?></td>
                <td align="right" class="Style10">Date d'ex&eacute;cution de la peine :</td>
                <td class="Style10"><p>D&eacute;but :<?php echo $row_select_evecrou['datedebutpeine_ecrou']; ?></p>
                  <p>Expire le : <?php echo $row_select_evecrou['dateexpirpeine_ecrou']; ?></p></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Domicile : </td>
                <td class="Style10"><?php echo $row_select_evecrou['domicildet_ecrou']; ?></td>
                <td align="right" class="Style10">Sortie Effective :</td>
                <td class="Style10"><?php echo $row_select_evecrou['datsortidet_ecrou']; ?>pour <?php echo $row_select_evecrou['motifssortidet_ecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" bgcolor="#FFFFFF" class="Style10"><p>Taille/Front/Nez/</p>
                  <p>Bouche/Teint :</p></td>
                <td class="Style10"><?php echo $row_select_evecrou['tailledet_ecrou']; ?>/<?php echo $row_select_evecrou['frontdet_ecrou']; ?>/<?php echo $row_select_evecrou['nezdet_ecrou']; ?>/<?php echo $row_select_evecrou['bouchedet_ecrou']; ?>/<?php echo $row_select_evecrou['teintdet_ecrou']; ?></td>
                <td align="right" class="Style10">Signe Particulier :</td>
                <td class="Style10"><?php echo $row_select_evecrou['signepartdet_ecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Date de cr&eacute;ation</span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_evecrou['date_creation']); ?></td>
                <td align="right" class="Style10">Observation :</td>
                <td class="Style10"><?php echo $row_select_evecrou['observation_ecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" colspan="4" align="center" nowrap bgcolor="#FFFFFF" class="Style10">Cr&eacute;&eacute; ou Modifi&eacute; par : <?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?>(<?php echo $row_select_admin['login_admin']; ?>)</td>
                </tr>
          </table>            </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);

mysql_free_result($select_evecrou);
?>
