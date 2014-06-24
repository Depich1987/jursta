<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "CabinetJugEnfant,Administrateur,Superviseur,AdminPenal";
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

$colname_select_plumpenale = "1";
if (isset($_GET['idpe'])) {
  $colname_select_plumpenale = $_GET['idpe'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_plumpenale = sprintf("SELECT * FROM plum_regenfant, reg_plaintes_desc WHERE ((id_plumenfant = %s) AND (reg_plaintes_desc.no_regplaintes=plum_regenfant.no_regplaintes))", GetSQLValueString($colname_select_plumpenale, "int"));
$select_plumpenale = mysql_query($query_select_plumpenale, $jursta) or die(mysql_error());
$row_select_plumpenale = mysql_fetch_assoc($select_plumpenale);
$totalRows_select_plumpenale = mysql_num_rows($select_plumpenale);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_plumpenale['Id_admin'];
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

mysql_select_db($database_jursta, $jursta);
$query_liste_idnom = "SELECT * FROM reg_plaintes_desc d, plum_regenfant j WHERE ((d.no_regplaintes=j.no_regplaintes) AND (j.id_juridiction ='".$row_select_juridic['id_juridiction']."')) ORDER BY j.date_creation DESC";
$liste_idnom = mysql_query($query_liste_idnom, $jursta) or die(mysql_error()); 
$row_liste_idnom = mysql_fetch_assoc($liste_idnom);
$totalRows_liste_idnom = mysql_num_rows($liste_idnom);

mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_noms n  WHERE (n.id_noms IN ('".$row_liste_idnom['id_noms']."'))";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);

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
                <td width="100%" class="Style2"><p>Registre d'audience - Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10">#</td>
                <td class="Style10"><?php echo $row_select_plumpenale['id_plumenfant']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10"><span class="Style10">Audience du </span> : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_plumpenale['dataudience_plumenfant']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10">  Pr&eacute;sident : </td>
                <td class="Style10"><?php echo $row_select_plumpenale['presi_plumenfant']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10">Greffiers : </td>
                <td class="Style10"><?php echo $row_select_plumpenale['greffier_plumenfant']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10">Accesseurs : </td>
                <td class="Style10"><?php echo $row_select_plumpenale['accesseurs_plumenfant']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10"><p><strong>Nom des parties /</strong><br>
                  <strong>Infraction :</strong></p></td>
                <td class="Style10"><table border="0" align="center" cellpadding="5" cellspacing="1" class="Style10">
                  <?php do { ?>
                  <tr bgcolor="#FFFFFF">
                    <td scope="col"><?php echo $row_liste_plaintes['NomPreDomInculpes_plaintes']; ?></td>
                    <td scope="col"><?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?></td>
                  </tr>
                  <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
                </table></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10">  Objet : </td>
                <td class="Style10"><?php echo $row_select_plumpenale['NatInfraction_plaintes']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="top" bgcolor="#FFFFFF" class="Style10">Observation : </td>
                <td class="Style10"><?php echo $row_select_plumpenale['observ_plumenfant']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" bgcolor="#FFFFFF" class="Style10">Date de cr&eacute;ation : </td>
                <td class="Style10"><?php echo $row_select_plumpenale['date_creation']; ?></td>
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
mysql_free_result($select_plumpenale);
?>
