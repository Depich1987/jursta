<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Penale,Administrateur,Superviseur,AdminPenal";
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

$colname_select_repjugcor = "1";
if (isset($_GET['norejc'])) {
  $colname_select_repjugcor = (get_magic_quotes_gpc()) ? $_GET['norejc'] : addslashes($_GET['norejc']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_repjugcor = sprintf("SELECT * FROM rep_jugementcorr WHERE no_repjugementcorr = %s", $colname_select_repjugcor);
$select_repjugcor = mysql_query($query_select_repjugcor, $jursta) or die(mysql_error());
$row_select_repjugcor = mysql_fetch_assoc($select_repjugcor);
$totalRows_select_repjugcor = mysql_num_rows($select_repjugcor);


mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_repjugcor['Id_admin'];
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
                <td width="100%" class="Style2"><p>Le r&eacute;pertoire des jugements correctionnels - Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10">#</td>
                <td class="Style10"><?php echo $row_select_repjugcor['no_repjugementcorr']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; du Jugement</span> : </td>
                <td class="Style10"><?php echo $row_select_repjugcor['nojugement_repjugementcorr']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Date du jugement</span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_repjugcor['datejugement_repjugementcorr']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Nom du ou des pr&eacute;v&eacute;nus</span>: </td>
                <td class="Style10"><?php echo $row_select_repjugcor['nomsprevenu_repjugementcorr']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Infraction</span> : </td>
                <td class="Style10"><?php echo $row_select_repjugcor['infraction_repjugementcorr']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"> <span class="Style10">Nature de la d&eacute;cision</span> : </td>
                <td class="Style10"><?php echo $row_select_repjugcor['naturedecision_repjugementcorr']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">D&eacute;cision du tribunal : </span></td>
                <td class="Style10"><?php echo $row_select_repjugcor['decisiontribunal_repjugementcorr']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Date de cr&eacute;ation : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_repjugcor['date_creation']); ?></td>
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

mysql_free_result($select_repjugcor);
?>
