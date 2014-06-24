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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reg_piece (nordre_regpiece, autorigine, Nopv, datepv, nomprevenus, naturescelle, lieuconserv, nojugdecision, nordestruction, nordremise, daterestitution, nocni, emargement, observation, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nordre_regpiece'], "text"),
                       GetSQLValueString($_POST['autorigine'], "text"),
                       GetSQLValueString($_POST['Nopv'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datepv']), "date"),
                       GetSQLValueString($_POST['nomprevenus'], "text"),
                       GetSQLValueString($_POST['naturescelle'], "text"),
                       GetSQLValueString($_POST['lieuconserv'], "text"),
                       GetSQLValueString($_POST['nojugdecision'], "text"),
                       GetSQLValueString($_POST['nordestruction'], "text"),
                       GetSQLValueString($_POST['nordremise'], "text"),
                       GetSQLValueString(changedatefrus($_POST['daterestitution']), "date"),
                       GetSQLValueString($_POST['nocni'], "text"),
                       GetSQLValueString($_POST['emargement'], "text"),
                       GetSQLValueString($_POST['observation'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
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
?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."-".$datefr{3}.$datefr{4}."-".$datefr{0}.$datefr{1};

return $dateus;
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
rechargerpage("liste_repgpieces_convictions.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="580" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre des pi&egrave;ces &agrave; convictions - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">N&deg; d'ordre </span> : </td>
                <td><input name="nordre_regpiece" type="text" id="nordre_regpiece" size="15"></td>
                <td align="right"><span class="Style10">Autorit&eacute; d'origine :</span></td>
                <td><select name="autorigine" id="autorigine">
                  <option value="Police">Police</option>
                  <option value="Douanes">Douanes</option>
                  <option value="Parquet">Parquet</option>
                  <option value="Gendarmerie">Gendarmerie</option>
                  <option value="Eaux et for&ecirc;ts">Eaux et for&ecirc;ts</option>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; du P.V :</td>
                <td><input name="Nopv" type="text" id="Nopv" value="" size="15"></td>
                <td align="right" nowrap class="Style10">Date du P.V :</td>
                <td><input name="datepv" type="text" id="datepicker" value="<?php echo date("d/m/Y"); ?>" size="12"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Nom du ou <br>des pr&eacute;v&eacute;nus</span> :</td>
                <td colspan="3">                  <textarea name="nomprevenus" cols="53" rows="5" id="nomprevenus"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Nature du scell&eacute;</span> :</td>
                <td colspan="3"><textarea name="naturescelle" cols="53" rows="4" id="naturescelle"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Lieu de conservation</span> :</td>
                <td>
                  <select name="lieuconserv" id="lieuconserv">
                    <option value="Magasin">Magasin</option>
                    <option value="Coffre-fort">Coffre-fort</option>
                  </select>
                </td>
                <td align="right"><span class="Style10">N&deg; du jugement de
d&eacute;cision :</span></td>
                <td><input name="nojugdecision" type="text" id="nojugdecision" size="13"></td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap class="Style10">N&deg; ord. destruction :</td>
                <td>
                  <input name="nordestruction" type="text" id="nordestruction" size="12">
                </td>
                <td align="right"><span class="Style10">N&deg; ord. remise au domaine :</span></td>
                <td valign="middle">
                  <input name="nordremise" type="text" id="nordremise" size="13">
                </td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap class="Style10">Date de restitution :</td>
                <td><input name="daterestitution" type="text" id="datepicker1" size="12"></td>
                <td align="right" valign="middle" nowrap class="Style10">N&deg; C.N.I ou C.S :</td>
                <td><input name="nocni" type="text" id="nocni" size="13"></td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap class="Style10">Emargement :</td>
                <td colspan="3"><input name="emargement" type="text" id="emargement" value="" size="43"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Observation </span> : </td>
                <td colspan="3"><textarea name="observation" cols="52" rows="5" id="observation"></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                <td colspan="3"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><span class="Style3">&copy; jursta 2010 - Tous droits r&eacute;serv&eacute;s </span></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);
?>
