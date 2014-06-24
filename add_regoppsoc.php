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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_socialopposition (noordre_socialopp, datejour, datejugdefaut, datesignification, newdataudience, signature, no_decision, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['noordre_socialopp'], "text"),
                       GetSQLValueString($_POST['datejour'], "date"),
                       GetSQLValueString(Change_formatDat($_POST['datejugdefaut']), "date"),
                       GetSQLValueString(Change_formatDat($_POST['datesignification']), "date"),
                       GetSQLValueString(Change_formatDat($_POST['newdataudience']), "date"),
                       GetSQLValueString($_POST['signature'], "text"),
                       GetSQLValueString($_POST['no_decision'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

if ($_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";
if (isset($_POST['noordre_rgsocial'])) {
  $colname_select_nodossier = $_POST['noordre_rgsocial'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM rg_social,rep_decision WHERE ((noordre_rgsocial = %s) AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))", GetSQLValueString($colname_select_nodossier, "text"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
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

function Change_formatDat($date, $format = 'en')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'fr')
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
	$( "#datepicker2" ).datepicker();
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
<table width="480" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="100%" valign="middle" ><table width="100%" >
          <tr bgcolor="#FFFFFF">
            <td><img src="images/forms48.png" width="32" border="0"></td>
            <td width="100%" class="Style2"><p>Registre des Voies de Recours en Opposition   - Ajouter un enregistrement</p></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
          <tr>
            <td align="right" valign="top" nowrap class="Style10"><form name="form1" method="post" action="add_regoppsoc.php">
              <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                <tr>
                  <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                  <td><input name="noordre_rgsocial" type="text" id="noordre_rgsocial" value="<?php echo $row_select_nodossier['noordre_rgsocial']; ?>" size="15"></td>
                  <td width="100%"><input type="submit" name="Afficher" value="Afficher"></td>
                </tr>
                <?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>
                <tr align="center">
                  <td colspan="3" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                </tr>
                <?php } ?>
                <?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <tr>
                  <td align="right" valign="top" nowrap class="Style10">Demandeur :</td>
                  <td colspan="2"><input name="demandeur_rgsocial" type="text" disabled id="demandeur_rgsocial" value="<?php echo $row_select_nodossier['demandeur_rgsocial']; ?>" size="35"></td>
                </tr>
                <tr>
                  <td align="right" valign="top" nowrap class="Style10">Defendeur :</td>
                  <td colspan="2"><input name="defendeur_rgsocial" type="text" disabled id="defendeur_rgsocial" value="<?php echo $row_select_nodossier['defendeur_rgsocial']; ?>" size="35"></td>
                </tr>
                <?php } // Show if recordset not empty ?>
              </table>
            </form></td>
          </tr>
          <tr>
            <td width="100%" align="right" valign="top" nowrap class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
              <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr class="Style10">
                    <td width="31%" align="right" valign="top" nowrap class="Style10">N&deg; d'Ordre : </td>
                    <td width="69%" colspan="2"><input name="noordre_socialopp" type="text" id="noordre_socialopp" size="15"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Date du 
                      jugement <br> par d&eacute;faut :</td>
                    <td colspan="2"><input name="datejugdefaut" type="text" id="datepicker" value="<?php echo Change_formatDate($row_select_nodossier['dateaudience_rgsocial']); ?>" size="15"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Date de 
  Signification : </td>
                    <td colspan="2"><input name="datesignification" type="text" id="datepicker1" size="15"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Nouvelle date <br>d'audience : </td>
                    <td colspan="2"><input name="newdataudience" type="text" id="datepicker2" value="" size="15"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Emmargement : </td>
                    <td colspan="2"><input name="signature" type="text" id="signature" value="" size="30"></td>
                  </tr>
                  <tr>
                    <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                      <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                      <input name="datejour" type="hidden" id="datejour" value="<?php echo date("Y-m-d"); ?>">
                      <input name="no_decision" type="hidden" id="no_decision" value="<?php echo $row_select_nodossier['no_decision']; ?>">
                      <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                    <td colspan="2"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form2">
              </form>
              <?php } // Show if recordset not empty ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</BODY>
</HTML>
<?php
mysql_free_result($select_nodossier);

mysql_free_result($select_admin);
?>
