<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
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

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_regappel = "1";
if (isset($_GET['idras'])) {
  $colname_select_regappel = $_GET['idras'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_regappel = sprintf("SELECT * FROM rep_decision, rg_social, reg_socialappel WHERE ((id_socialappel = %s) AND (rg_social.no_rgsocial=rep_decision.no_rgsocial) AND (rep_decision.no_decision=reg_socialappel.no_decision))", GetSQLValueString($colname_select_regappel, "int"));
$select_regappel = mysql_query($query_select_regappel, $jursta) or die(mysql_error());
$row_select_regappel = mysql_fetch_assoc($select_regappel);
$totalRows_select_regappel = mysql_num_rows($select_regappel);$colname_select_regappel = "1";
if (isset($_GET['idras'])) {
  $colname_select_regappel = $_GET['idras'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_regappel = sprintf("SELECT * FROM rep_decision, rg_social, reg_socialappel WHERE ((id_socialappel = %s) AND (rg_social.no_rgsocial=rep_decision.no_rgsocial) AND (rep_decision.no_decision=reg_socialappel.no_decision))", GetSQLValueString($colname_select_regappel, "int"));
$select_regappel = mysql_query($query_select_regappel, $jursta) or die(mysql_error());
$row_select_regappel = mysql_fetch_assoc($select_regappel);
$totalRows_select_regappel = mysql_num_rows($select_regappel);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_regappel['Id_admin'];
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
                <td width="100%" class="Style2"><p>Registre des Voies de Recours en Opposition - Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; d'ordre </span> : </td>
                <td colspan="2" class="Style10"><?php echo $row_select_regappel['no_socialappel']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Date du jour : </td>
                <td colspan="2" class="Style10"><?php echo Change_formatDate($row_select_regappel['datejour']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Date du jugement : </td>
                <td colspan="2" class="Style10"><?php echo Change_formatDate($row_select_regappel['datejugement']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">  Demandeur : </td>
                <td colspan="2" class="Style10"><?php echo $row_select_regappel['demandeur_rgsocial']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Defendeur : </span></td>
                <td colspan="2" class="Style10"><?php echo $row_select_regappel['defendeur_rgsocial']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Emargement : </td>
                <td colspan="2" class="Style10"><?php echo $row_select_regappel['Signature']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <th height="35" align="right" valign="middle" bgcolor="#FFFFFF" class="Style10">Date de cr&eacute;ation/ modification :</th>
                <td width="0" class="Style10"><?php echo Change_formatDate(substr($row_select_regappel['date_creation'],0,10)); ?> <br> � : <?php echo substr($row_select_regappel['date_creation'],11,8); ?></td>
                <td width="0" nowrap bgcolor="#FF0000" class="Style10"><?php echo Change_formatDate(substr($row_select_regappel['date_modif'],0,10)); ?> <br> � : <?php echo substr($row_select_regappel['date_modif'],11,8); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Cr&eacute;&eacute; / Modifi&eacute; par : </td>
                <td class="Style10"><?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?>(<?php echo $row_select_admin['login_admin']; ?>)</td>
                <td bgcolor="#FF0000" class="Style10"><?php echo substr($row_select_regappel['signature_president'],14,16); ?></td>
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
mysql_free_result($select_regappel);
?>
