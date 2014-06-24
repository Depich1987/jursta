<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Penitentiaire,Superviseur,AdminPenal";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reg_alphabdet (asphys_regalphabdet, sexe_regalphabdet, moidat_regalphabdet, nomdet_regalphabdet, no_ecrou, datentre_regalphabdet, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['asphys_regalphabdet'], "text"),
					   GetSQLValueString($_POST['sexe_regalphabdet'], "text"),
                       GetSQLValueString($_POST['moidat_regalphabdet'], "date"),
                       GetSQLValueString($_POST['nomdet_regalphabdet'], "text"),
                       GetSQLValueString($_POST['no_ecrou'], "text"),
                       GetSQLValueString($_POST['datentre_regalphabdet'], "date"),
					   GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
					   GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE Login_admin = %s", GetSQLValueString($colname_select_admin, "-1"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "text"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);


mysql_select_db($database_jursta, $jursta);
$query_select_detenu = "SELECT * FROM reg_ecrou, reg_mandat, reg_controlnum WHERE ((reg_ecrou.id_juridiction =".$row_select_juridic['id_juridiction'].") AND (reg_controlnum.no_regmandat = reg_mandat.no_regmandat) AND (reg_ecrou.no_regcontrolnum = reg_controlnum.no_regcontrolnum))";
$select_detenu = mysql_query($query_select_detenu, $jursta) or die(mysql_error());
$row_select_detenu = mysql_fetch_assoc($select_detenu);
$totalRows_select_detenu = mysql_num_rows($select_detenu);
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
rechargerpage("liste_regalphadet.php");
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
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre alphab&eacute;tique des d&eacute;tenus - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap class="Style10"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                      <td><input name="noordre_rolegeneral" type="text" id="noordre_rolegeneral" value="<?php echo $row_select_nodossier['noordre_rolegeneral']; ?>" size="15"></td>
                      <td width="100%"><input type="submit" name="Afficher" value="Afficher"></td>
                    </tr>
<?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>                    
                    <tr align="center">
                      <td colspan="3" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                    </tr>
<?php } ?>					
<?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                    <tr>
                        <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                        <td colspan="2" class="Style10"><?php echo Change_formatDate($row_select_nodossier['dateaudience_rolegeneral']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" nowrap class="Style10">Demandeur :</td>
                        <td colspan="2" class="Style10"><?php echo $row_select_nodossier['demandeur_rolegeneral']; ?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" nowrap class="Style10">Defendeur :</td>
                        <td colspan="2" class="Style10"><?php echo $row_select_nodossier['defendeur_rolegeneral']; ?>                        </td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Objet :</td>
                      <td colspan="2" class="Style10"><?php echo $row_select_nodossier['objet_rolegeneral']; ?></td>
                    </tr>
                    <?php } // Show if recordset not empty ?>
                  </table></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; d'Ecrou :</td>
                <td><input name="no_ecrou" type="text" id="no_ecrou" value="" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date d'entr&eacute;e <br> dans la prison (MD) :</td>
                <td><input name="datentre_regalphabdet" type="text" id="datentre_regalphabdet" value="" size="15"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Nom et pr&eacute;noms :</td>
                <td><input name="nomdet_regalphabdet" type="text" id="nomdet_regalphabdet" value="" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Sexe : </td>
                <td><span class="Style10">
                  <input name="sexe_regalphabdet" type="radio" value="M" checked>
Masculin
<input type="radio" name="sexe_regalphabdet" value="F">
Feminin</span></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Mois / Date : </td>
                <td class="Style10"><input name="moidat_regalphabdet" type="text" id="datepicker" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Aspect physique : </td>
                <td><textarea name="asphys_regalphabdet" cols="35" rows="4" id="asphys_regalphabdetl"></textarea></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                  <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
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
  <input type="hidden" name="MM_insert" value="form1">
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);

mysql_free_result($select_detenu);
?>
