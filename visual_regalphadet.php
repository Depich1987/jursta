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
$currentPage = $_SERVER["PHP_SELF"];

$colname_select_regalphadet = "1";
if (isset($_GET['noregal'])) {
  $colname_select_regalphadet = (get_magic_quotes_gpc()) ? $_GET['noregal'] : addslashes($_GET['noregal']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_regalphadet = sprintf("SELECT * FROM reg_alphabdet WHERE no_regalphabdet = %s", $colname_select_regalphadet);
$select_regalphadet = mysql_query($query_select_regalphadet, $jursta) or die(mysql_error());
$row_select_regalphadet = mysql_fetch_assoc($select_regalphadet);
$totalRows_select_regalphadet = mysql_num_rows($select_regalphadet);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_regalphadet['Id_admin'];
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
                <td width="100%" class="Style2"><p>Le registre alphab&eacute;tique des d&eacute;tenus - Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">#</td>
                <td class="Style10"><?php echo $row_select_regalphadet['no_regalphabdet']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Aspect physique</span> : </td>
                <td class="Style10"><?php echo $row_select_regalphadet['asphys_regalphabdet']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Sexe</span> : </td>
                <td class="Style10"><?php echo $row_select_regalphadet['sexe_regalphabdet']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Mois / Date</span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_regalphadet['moidat_regalphabdet']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Nom et pr&eacute;noms</span> : </td>
                <td class="Style10"><?php echo $row_select_regalphadet['nomdet_regalphabdet']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; d'Ecrou</span> : </td>
                <td class="Style10"><?php echo $row_select_regalphadet['noecrou']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"> <span class="Style10">Observation</span> : </td>
                <td class="Style10"><?php echo $row_select_regalphadet['datentre_regalphabdet']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Date d'entr&eacute;e dans la prison (MD)</span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_regalphadet['date_creation']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Date de cr&eacute;ation</span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_regalphadet['date_creation']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Cr&eacute;&eacute; ou Modifi&eacute; par : </td>
                <td class="Style10"><?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?>(<?php echo $row_select_admin['login_admin']; ?>)</td>
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

mysql_free_result($select_regalphadet);
?>
