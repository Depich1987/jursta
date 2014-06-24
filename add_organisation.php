<?php require_once('Connections/jursta.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrateur,Superviseur";
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
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO juridiction (id_juridiction, lib_juridiction, id_commune, id_typejuridiction, id_juridictionTU, T05_ANNEE, id_admin, date_creation) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['lib_juridiction'], "text"),
                       GetSQLValueString($_POST['id_commune'], "text"),
                       GetSQLValueString($_POST['id_typejuridiction'], "int"),
                       GetSQLValueString($_POST['id_juridictionTU'], "int"),
                       GetSQLValueString($_POST['T05_ANNEE'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
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

mysql_select_db($database_jursta, $jursta);
$query_Liste_commune = "SELECT * FROM commune ORDER BY id_commune ASC";
$Liste_commune = mysql_query($query_Liste_commune, $jursta) or die(mysql_error());
$row_Liste_commune = mysql_fetch_assoc($Liste_commune);
$totalRows_Liste_commune = mysql_num_rows($Liste_commune);

mysql_select_db($database_jursta, $jursta);
$query_Liste_typejuridiction = "SELECT * FROM type_juridiction ORDER BY lib_typejuridiction ASC";
$Liste_typejuridiction = mysql_query($query_Liste_typejuridiction, $jursta) or die(mysql_error());
$row_Liste_typejuridiction = mysql_fetch_assoc($Liste_typejuridiction);
$totalRows_Liste_typejuridiction = mysql_num_rows($Liste_typejuridiction);

mysql_select_db($database_jursta, $jursta);
$query_Liste_juridiction = "SELECT * FROM juridiction ORDER BY lib_juridiction ASC";
$Liste_juridiction = mysql_query($query_Liste_juridiction, $jursta) or die(mysql_error());
$row_Liste_juridiction = mysql_fetch_assoc($Liste_juridiction);
$totalRows_Liste_juridiction = mysql_num_rows($Liste_juridiction);
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
rechargerpage("liste_rgsociale.php");
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
          <td width="100%" valign="middle" ><table width="100%" >
            <tr>
              <td bgcolor="#174F8A"><img border="0" src="images/fond-dec_09.jpg" title="" width="32"></td>
              <td width="100%" bgcolor="#174F8A" class="Style2">Organisation g&eacute;n&eacute;rale des juridictions - Ajouter</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Code : </td>
                <td><input name="id_juridiction" type="text" id="id_juridiction" size="11"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">D&eacute;signation : </td>
                <td><input name="lib_juridiction" type="text" id="lib_juridiction" size="30"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Commune :</td>
                <td><select name="id_commune" id="id_commune">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Liste_commune['id_commune']?>"><?php echo $row_Liste_commune['id_commune']?></option>
                  <?php
} while ($row_Liste_commune = mysql_fetch_assoc($Liste_commune));
  $rows = mysql_num_rows($Liste_commune);
  if($rows > 0) {
      mysql_data_seek($Liste_commune, 0);
	  $row_Liste_commune = mysql_fetch_assoc($Liste_commune);
  }
?>
                  </select>
                  <input type="button" name="commune_cmd" id="commune_cmd" value="..." onClick="javascript:ouvre_popup('add_organisation_commune.php',495,180)"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Type de juridiction :</td>
                <td><select name="id_typejuridiction" id="id_typejuridiction">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Liste_typejuridiction['id_typejuridiction']?>"><?php echo $row_Liste_typejuridiction['lib_typejuridiction']?></option>
                  <?php
} while ($row_Liste_typejuridiction = mysql_fetch_assoc($Liste_typejuridiction));
  $rows = mysql_num_rows($Liste_typejuridiction);
  if($rows > 0) {
      mysql_data_seek($Liste_typejuridiction, 0);
	  $row_Liste_typejuridiction = mysql_fetch_assoc($Liste_typejuridiction);
  }
?>
                </select>
                  <input type="button" name="typejuridiction_cmd" id="typejuridiction_cmd" value="..." onClick="javascript:ouvre_popup('add_organisation_typejuridiction.php',495,180)"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Tutelle : </td>
                <td><select name="id_juridictionTU" id="id_juridictionTU">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Liste_juridiction['id_juridiction']?>"><?php echo $row_Liste_juridiction['lib_juridiction']?></option>
                  <?php
} while ($row_Liste_juridiction = mysql_fetch_assoc($Liste_juridiction));
  $rows = mysql_num_rows($Liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($Liste_juridiction, 0);
	  $row_Liste_juridiction = mysql_fetch_assoc($Liste_juridiction);
  }
?>
                </select>
<label></label></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Ann&eacute;e :</td>
                <td><input name="T05_ANNEE" type="text" id="T05_ANNEE" size="15"></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input type="hidden" name="MM_insert" value="form1"></td>
                <td><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
              </tr>
          </table></td>
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

mysql_free_result($Liste_commune);

mysql_free_result($Liste_typejuridiction);

mysql_free_result($Liste_juridiction);
?>
