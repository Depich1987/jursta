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

$select_inculpes='';
foreach ($_POST['select_inculpes'] as $value) {
	if ($select_inculpes!='') $select_inculpes.=',';
	$select_inculpes.=$value;
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE plum_penale SET dataudience_plumpenale=%s, presi_plumpenale=%s, greffier_plumpenale=%s, accesseurs_plumpenale=%s, observ_plumpenale=%s, id_noms=%s, Id_admin=%s, date_creation=%s, no_regplaintes=%s, id_juridiction=%s WHERE id_plumpenale=%s",
                       GetSQLValueString($_POST['dateaudience_plumpenale'], "date"),
                       GetSQLValueString($_POST['presi_plumpenale'], "text"),
                       GetSQLValueString($_POST['greffier_plumpenale'], "text"),
                       GetSQLValueString($_POST['accesseurs_plumpenale'], "text"),
                       GetSQLValueString($_POST['observ_plumpenale'], "text"),
                       GetSQLValueString($select_inculpes,"text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_regplaintes'], "int"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['id_plumpenale'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];



$colname_select_plumpenale = "1";
if (isset($_GET['idpp'])) {
  $colname_select_plumpenale = $_GET['idpp'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_plumpenale = sprintf("SELECT * FROM plum_penale, reg_plaintes_desc WHERE ((id_plumpenale = %s) AND (reg_plaintes_desc.no_regplaintes=plum_penale.no_regplaintes))", GetSQLValueString($colname_select_plumpenale, "int"));
$select_plumpenale = mysql_query($query_select_plumpenale, $jursta) or die(mysql_error());
$row_select_plumpenale = mysql_fetch_assoc($select_plumpenale);
$totalRows_select_plumpenale = mysql_num_rows($select_plumpenale);

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "int"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc d, reg_plaintes_noms n WHERE d.id_juridiction ='".$row_select_juridic['id_juridiction']."' AND d.cles_pivot = n.cles_pivot AND (d.nodordre_plaintes='".$row_select_plumpenale['nodordre_plaintes']."') GROUP BY n.cles_pivot ORDER BY d.date_creation DESC";
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
rechargerpage("liste_regplaintes.php");
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
                <td width="100%" class="Style2"><p>Plumitif P&eacute;nale - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_plumpenale['nodordre_plaintes']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td class="Style10">                  <?php echo $row_select_plumpenale['NatInfraction_plaintes']; ?></td>
              </tr>
              <tr>
                <td colspan="2" align="center" valign="top" nowrap class="Style10">Nom des parties / Nature de l'infraction                  </td>
                </tr>
              <tr>
                <td colspan="2" align="center" valign="top" nowrap class="Style10"><table border="0"  bgcolor="#CCE3FF" align="center" cellpadding="3" cellspacing="1" class="Style10">
                  <?php do { ?>
                  <tr>
                    <td><input <?php if (!(strcmp($row_select_plumpenale['id_noms'], $row_select_plumpenale['id_noms']))) {echo "checked=\"checked\"";} ?> type="checkbox" name="select_inculpes[]" id="select_inculpes[]"></td>
                    <td><?php echo $row_liste_plaintes['id_noms']; ?></td>
                    <td><?php echo $row_liste_plaintes['NomPreDomInculpes_plaintes']; ?></td>
                    <td><?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?></td>
                  </tr>
                  <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
                </table></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">   Date de l'audience : </td>
                <td class="Style10"><input name="dateaudience_plumpenale" type="text" id="datepicker" value="<?php echo Change_formatDate($row_select_plumpenale['dataudience_plumpenale']); ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Pr&eacute;sident : </td>
                <td><input value="<?php echo $row_select_plumpenale['presi_plumpenale']; ?>" name="presi_plumpenale" type="text" id="presi_plumpenale" size="30"></td>
              </tr>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Greffier : </td>
                <td><input value="<?php echo $row_select_plumpenale['greffier_plumpenale']; ?>" name="greffier_plumpenale" type="text" id="greffier_plumpenale" size="30"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Accesseurs :</td>
                <td><textarea name="accesseurs_plumpenale" cols="30" rows="3" id="accesseurs_plumpenale"><?php echo $row_select_plumpenale['accesseurs_plumpenale']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observ_plumpenale" cols="40" rows="7" id="observ_plumpenale"><?php echo $row_select_plumpenale['observ_plumpenale']; ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_plumpenale['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo $row_select_plumpenale['date_creation']; ?>">
                    <input name="id_plumpenale" type="hidden" id="id_plumpenale" value="<?php echo $row_select_plumpenale['id_plumpenale']; ?>">
                    <input name="no_regplaintes" type="hidden" id="no_regplaintes" value="<?php echo $row_select_plumpenale['no_regplaintes']; ?>">
                    <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_plumpenale['id_juridiction']; ?>"></td>
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
mysql_free_result($select_plumpenale);

mysql_free_result($liste_plaintes);

mysql_free_result($select_juridic);

mysql_free_result($select_admin);

mysql_free_result($select_admin);
?>

