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

$colname_select_plumsocial = "1";
if (isset($_GET['idps'])) {
  $colname_select_plumsocial = $_GET['idps'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_plumsocial = sprintf("SELECT * FROM plum_social, rg_social WHERE ((id_plumsociale = %s) AND (rg_social.no_rgsocial=plum_social.no_rgsocial))", GetSQLValueString($colname_select_plumsocial, "int"));
$select_plumsocial = mysql_query($query_select_plumsocial, $jursta) or die(mysql_error());
$row_select_plumsocial = mysql_fetch_assoc($select_plumsocial);
$totalRows_select_plumsocial = mysql_num_rows($select_plumsocial);

mysql_select_db($database_jursta, $jursta);
$query_select_admin = "SELECT * FROM administrateurs WHERE Id_admin =".$row_select_plumsocial['Id_admin'];
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
  <table width="470" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/mark_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Plumitif Civil - Visualiser un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="2">
          <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Dossier N&deg; :</td>
                <td colspan="2" class="Style10"><?php echo $row_select_plumsocial['noordre_rgsocial']; ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10"><span class="Style10">Audience du </span> : </td>
                <td colspan="2" class="Style10"><?php echo Change_formatDate($row_select_plumsocial['dateaudience_rgsocial']); ?></td>
              </tr>
              <tr valign="middle" bgcolor="#FFFFFF">
                <td height="35" colspan="3" align="center" nowrap bgcolor="#FFFFFF" class="Style10">COMPOSITION DE LA COUR DU TRIBUNAL</td>
                </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" colspan="3" align="left" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">  Pr&eacute;sident : <?php echo $row_select_plumsocial['presi_plumsociale']; ?></td>
                </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" colspan="3" align="left" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Greffiers : <?php echo $row_select_plumsocial['greffier_plumsociale']; ?></td>
                </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" colspan="3" align="left" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Accesseurs : <?php echo $row_select_plumsocial['accesseurs_plumsociale']; ?></td>
                </tr>
              <tr align="left" valign="top" bgcolor="#FFFFFF">
                <td height="35" rowspan="2" align="center" valign="top" nowrap bgcolor="#FFFFFF" class="Style10"><p align="center">Demandeur :<br>
                  <?php echo $row_select_plumsocial['demandeur_rgsocial']; ?></p>
                  <p align="center"><br>
                    Defendeur :<br>
                  <?php echo $row_select_plumsocial['defendeur_rgsocial']; ?></p></td>
                <td height="0" colspan="2" align="center" valign="middle" class="Style10">Objet de la demande</td>
              </tr>
              <tr align="center" valign="middle" bgcolor="#FFFFFF">
                <th colspan="2" align="left" valign="top" class="Style10"><?php echo $row_select_plumsocial['objet_rgsocial']; ?></th>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" colspan="3" align="left" valign="middle" nowrap bgcolor="#FFFFFF" class="Style10">Observation : <?php echo $row_select_plumsocial['observ_plumsociale']; ?></td>
                </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" bgcolor="#FFFFFF" class="Style10">Date de cr&eacute;ation / modifiaction: </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_plumsocial['date_creation']); ?></td>
                <td class="Style10" bgcolor="#FF0000"><?php echo Change_formatDate($row_select_plumsocial['date_modif']); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td height="35" align="right" nowrap bgcolor="#FFFFFF" class="Style10">Cr&eacute;&eacute; ou Modifi&eacute; par : </td>
                <td colspan="2" class="Style10"><?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?>(<?php echo $row_select_admin['login_admin']; ?>)</td>
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
mysql_free_result($select_plumsocial);
?>
