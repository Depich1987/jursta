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

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_regplaintes = "-1";
if (isset($_GET['noregpl'])) {
  $colname_select_regplaintes = $_GET['noregpl'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_regplaintes = sprintf("SELECT * FROM reg_plaintes_desc d,  reg_plaintes_noms n WHERE (no_regplaintes = %s AND d.cles_pivot = n.cles_pivot)", GetSQLValueString($colname_select_regplaintes, "int"));
$select_regplaintes = mysql_query($query_select_regplaintes, $jursta) or die(mysql_error());
$row_select_regplaintes = mysql_fetch_assoc($select_regplaintes);
$totalRows_select_regplaintes = mysql_num_rows($select_regplaintes);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_regplaintes['Id_admin'];
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
                             
mysql_select_db($database_jursta, $jursta);
$query_listenomplainte_plainte = "SELECT * FROM reg_plaintes_noms WHERE cles_pivot = '".$row_select_regplaintes['cles_pivot']."'";
$listenomplainte_plainte = mysql_query($query_listenomplainte_plainte, $jursta) or die(mysql_error());
$row_listenomplainte_plainte = mysql_fetch_assoc($listenomplainte_plainte);
$totalRows_listenomplainte_plainte = mysql_num_rows($listenomplainte_plainte);                              

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
  <table width="550" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/mark_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre des plaintes- Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">#</td>
                <td class="Style10"></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; d'ordre</span> : </td>
                <td class="Style10"><?php echo $row_select_regplaintes['nodordre_plaintes']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">1&egrave;re Autorit&eacute; saisie</span> : </td>
                <td class="Style10"><?php echo $row_select_regplaintes['Pautosaisi_plaintes']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">r&eacute;dacteur et date du 1er PV de la plainte</span> : </td>
                <td class="Style10"><?php echo $row_select_regplaintes['Red_plaintes']; ?><br>
                                    <?php echo $row_select_regplaintes['PVdat_plaintes']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Nom pr&eacute;noms</span> et Domiciles des Inculp&eacute;s: </td>
                <td class="Style10"><table border="0" cellpadding="3" cellspacing="1" class="Style10">
                <?php do { ?>
                  <tr>
                    <td scope="col"><?php echo $row_listenomplainte_plainte['NomPreDomInculpes_plaintes']; ?></td>
                    <td scope="col"><?php echo $row_listenomplainte_plainte['NatInfraction_plaintes']; ?></td>
                  </tr>
                  <?php } while ($row_listenomplainte_plainte = mysql_fetch_assoc($listenomplainte_plainte)); ?>
              </table></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Date d'entr&eacute;e au Parquet : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_regplaintes['dateparquet_plaintes']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"> Nature, Date et Lieu de l'infraction: </td>
                <td class="Style10">                                  le <?php echo Change_formatDate($row_select_regplaintes['DatInfraction_plaintes']); ?><br>
                                  &agrave; <?php echo $row_select_regplaintes['LieuInfraction_plaintes']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Date d'entr&eacute;e dans la prison (MD)</span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_regplaintes['date_creation']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Suite donn&eacute;e a l'affaire</span> : </td>
                <td class="Style10"><p><?php echo $row_select_regplaintes['suite_plaintes']; ?></p>                  </td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Motif du classement :</td>
                <td class="Style10"><?php echo $row_select_regplaintes['MotifClass_plaintes']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Observation :</td>
                <td class="Style10"><?php echo $row_select_regplaintes['observations_plaintes']; ?></td>
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

mysql_free_result($select_regplaintes);
?>
