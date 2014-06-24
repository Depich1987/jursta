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

$colname_select_regpieces = "-1";
if (isset($_GET['nopi'])) {
  $colname_select_regpieces = $_GET['nopi'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_regpieces = sprintf("SELECT * FROM reg_piece WHERE (id_regpiece = %s)", GetSQLValueString($colname_select_regpieces, "int"));
$select_regpieces = mysql_query($query_select_regpieces, $jursta) or die(mysql_error());
$row_select_regpieces = mysql_fetch_assoc($select_regpieces);
$totalRows_select_regpieces = mysql_num_rows($select_regpieces);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_regpieces['Id_admin'];
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
                             
mysql_select_db($database_jursta, $jursta);
$query_listenomplainte_plainte = "SELECT * FROM reg_plaintes_noms WHERE cles_pivot = '".$row_select_regpieces['cles_pivot']."'";
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
                <td width="100%" class="Style2"><p>Le registre des pi&egrave;ces &agrave; convictions- Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; d'ordre</span> : </td>
                <td class="Style10"><?php echo $row_select_regpieces['nordre_regpiece']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Autorit&eacute; d'origine</span> : </td>
                <td class="Style10"><?php echo $row_select_regpieces['autorigine']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; /date du PV </span> : </td>
                <td class="Style10"><?php echo $row_select_regpieces['Nopv']; ?>/ <?php echo $row_select_regpieces['datepv']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Pr&eacute;venus : </td>
                <td class="Style10"><?php echo $row_select_regpieces['nomprevenus']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Nature du scell&eacute; : </td>
                <td class="Style10"><?php echo $row_select_regpieces['naturescelle']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"> Lieu de conservation : </td>
                <td class="Style10"><?php echo $row_select_regpieces['lieuconserv']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; du jugement de d&eacute;cision</span> : </td>
                <td class="Style10"><?php echo $row_select_regpieces['nojugdecision']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">N&deg; Ord. Destruction</span> : </td>
                <td class="Style10"><p>&nbsp;<?php echo $row_select_regpieces['nordestruction']; ?></p>                  </td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">N&deg; Ord. remise au domaine :</td>
                <td class="Style10"><?php echo $row_select_regpieces['nordremise']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Date :</td>
                <td class="Style10"><?php echo $row_select_regpieces['daterestitution']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Num&eacute;ros de la C.N.I ou C.S :</td>
                <td class="Style10"><?php echo $row_select_regpieces['daterestitution']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Emargement :</td>
                <td class="Style10"><?php echo $row_select_regpieces['emargement']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Observation :</td>
                <td class="Style10"><?php echo $row_select_regpieces['observation']; ?></td>
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

mysql_free_result($select_regpieces);
?>
