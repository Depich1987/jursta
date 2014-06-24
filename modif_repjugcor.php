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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE rep_jugementcorr SET nojugement_repjugementcorr=%s, datejugement_repjugementcorr=%s, nomsprevenu_repjugementcorr=%s, infraction_repjugementcorr=%s, naturedecision_repjugementcorr=%s, decisiontribunal_repjugementcorr=%s, Id_admin=%s, date_creation=%s WHERE no_repjugementcorr=%s",
                       GetSQLValueString($_POST['nojugement_repjugementcorr'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datejugement_repjugementcorr']), "date"),
                       GetSQLValueString($_POST['nomsprevenu_repjugementcorr'], "text"),
                       GetSQLValueString($_POST['infraction_repjugementcorr'], "text"),
                       GetSQLValueString($_POST['naturedecision_repjugementcorr'], "text"),
					   GetSQLValueString($_POST['decisiontribunal_repjugementcorr'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_repjugementcorr'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE Login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

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
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc d, reg_plaintes_noms n WHERE d.id_juridiction ='".$row_select_juridic['id_juridiction']."' AND d.cles_pivot = n.cles_pivot GROUP BY n.cles_pivot ORDER BY d.date_creation DESC";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);
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
rechargerpage("liste_repjugcor.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="480" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/rename_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le r&eacute;pertoire des jugements correctionnels - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">N&deg; du Jugement</span> :</td>
                <td><input name="nojugement_repjugementcorr" type="text" id="nojugement_repjugementcorr" value="<?php echo $row_select_repjugcor['nojugement_repjugementcorr']; ?>" size="20"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Date du jugement</span> : </td>
                <td><input name="datejugement_repjugementcorr" type="text" id="datejugement_repjugementcorr" size="15" value="<?php echo Change_formatDate($row_select_repjugcor['datejugement_repjugementcorr']); ?>"></td>
              </tr>
              <tr>
                <td colspan="2" align="center" valign="top" nowrap class="Style10"><span class="Style10">Nom du ou des pr&eacute;v&eacute;nus</span> /Infraction: </td>
                </tr>
              <tr>
                <td colspan="2" align="center" valign="top" nowrap class="Style10"><table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" class="Style10">
                  <?php do { ?>
                  <tr>
                    <td><input <?php if (!(strcmp($row_select_repjugcor['id_noms'],$row_select_repjugcor['id_noms']))) {echo "checked=\"checked\"";} ?> type="checkbox" name="select_inculpes[]" id="select_inculpes_<?php echo $row_liste_plaintes['id_noms']; ?>" value="<?php echo $row_liste_plaintes['id_noms']; ?>"></td>
                    <td><?php echo $row_liste_plaintes['id_noms']; ?></td>
                    <td><?php echo $row_liste_plaintes['NomPreDomInculpes_plaintes']; ?></td>
                    <td><?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?></td>
                  </tr>
                  <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
                </table></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> <span class="Style10">Nature de la d&eacute;cision</span> : </td>
                <td><textarea name="naturedecision_repjugementcorr" cols="35" rows="4" id="naturedecision_repjugementcorr"><?php echo $row_select_repjugcor['naturedecision_repjugementcorr']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> <span class="Style10">D&eacute;cision du tribunal</span> :</td>
                <td><textarea name="decisiontribunal_repjugementcorr" cols="40" rows="5" id="decisiontribunal_repjugementcorr"><?php echo $row_select_repjugcor['decisiontribunal_repjugementcorr']; ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="no_repjugementcorr" type="hidden" id="no_repjugementcorr" value="<?php echo $row_select_repjugcor['no_repjugementcorr']; ?>"></td>
                <td><input type="submit" name="Valider_cmd" value="   Modifier l'enregistrement   "></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_update" value="form1">
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);

mysql_free_result($select_repjugcor);
?>
