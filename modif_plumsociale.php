<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Sociale,Administrateur,Superviseur";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE plum_social SET presi_plumsociale=%s, greffier_plumsociale=%s, accesseurs_plumsociale=%s, observ_plumsociale=%s, Id_admin=%s, date_creation=%s, date_modif=%s, no_rgsocial=%s, id_juridiction=%s WHERE id_plumsociale=%s",
                       GetSQLValueString($_POST['presi_plumsociale'], "text"),
                       GetSQLValueString($_POST['greffier_plumsociale'], "text"),
                       GetSQLValueString($_POST['accesseurs_plumsociale'], "text"),
                       GetSQLValueString($_POST['observ_plumsociale'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['date_modification'], "date"),
                       GetSQLValueString($_POST['no_rgsocial'], "int"),
                       GetSQLValueString($_POST['id_plumsociale'], "int"),
                       GetSQLValueString($_POST['id_plumsociale'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
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
rechargerpage("liste_plumsociale.php");
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
                <td width="100%" class="Style2"><p>Plumitif Social - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCEAFF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_plumsocial['noordre_rgsocial']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                <td class="Style10"><?php echo Change_formatDate($row_select_plumsocial['dateaudience_rgsocial']); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10">                  <?php echo $row_select_plumsocial['demandeur_rgsocial']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_plumsocial['defendeur_rgsocial']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">  Objet : </td>
                <td class="Style10"><?php echo $row_select_plumsocial['objet_rgsocial']; ?></td>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Pr&eacute;sident : </td>
                <td><input value="<?php echo $row_select_plumsocial['presi_plumsociale']; ?>" name="presi_plumsociale" type="text" id="presi_plumsociale" size="30"></td>
              </tr>
              <tr class="Style10">
                <td align="right" valign="top" nowrap class="Style10">Greffier : </td>
                <td><input value="<?php echo $row_select_plumsocial['greffier_plumsociale']; ?>" name="greffier_plumsociale" type="text" id="greffier_plumsociale" size="30"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Accesseurs :</td>
                <td><textarea name="accesseurs_plumsociale" cols="30" rows="3" id="accesseurs_plumsociale"><?php echo $row_select_plumsocial['accesseurs_plumsociale']; ?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                <td><textarea name="observ_plumsociale" cols="40" rows="7" id="observ_plumsociale"><?php echo $row_select_plumsocial['observ_plumsociale']; ?></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="date_modif" type="hidden" id="date_modif" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_plumsocial['id_juridiction']; ?>"><input name="id_plumsociale" type="hidden" id="id_plumsociale" value="<?php echo $row_select_plumsocial['id_plumsociale']; ?>">
                    <input name="no_rgsocial" type="hidden" id="no_rgsocial" value="<?php echo $row_select_plumsocial['no_rgsocial']; ?>"></td>
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
mysql_free_result($select_plumsocial);
?>
