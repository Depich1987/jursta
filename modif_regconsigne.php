<?php require_once('Connections/jursta.php'); ?>
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
  $updateSQL = sprintf("UPDATE reg_consignations SET noordre_regconsign=%s, date_regconsign=%s, montant_regconsign=%s, decision_regconsign=%s, somareclam_regconsign=%s, somarestit_regconsign=%s, liquidation_regconsign=%s, observation_regconsign=%s, Id_admin=%s, date_creation=%s, no_rolegeneral=%s WHERE no_regconsign=%s",
                       GetSQLValueString($_POST['noordre_regconsign'], "text"),
                       GetSQLValueString(changedatefrus($_POST['date_regconsign']), "date"),
                       GetSQLValueString($_POST['montant_regconsign'], "double"),
                       GetSQLValueString($_POST['decision_regconsign'], "text"),
                       GetSQLValueString($_POST['somareclam_regconsign'], "double"),
                       GetSQLValueString($_POST['somarestit_regconsign'], "double"),
                       GetSQLValueString($_POST['liquidation_regconsign'], "text"),
                       GetSQLValueString($_POST['observation_regconsign'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"),
                       GetSQLValueString($_POST['no_regconsign'], "int"));

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

$colname_select_regconsi = "1";
if (isset($_GET['noregconsi'])) {
  $colname_select_regconsi = (get_magic_quotes_gpc()) ? $_GET['noregconsi'] : addslashes($_GET['noregconsi']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_regconsi = sprintf("SELECT * FROM role_general, reg_consignations WHERE ((no_regconsign = %s) AND (role_general.no_rolegeneral=reg_consignations.no_rolegeneral))", $colname_select_regconsi);
$select_regconsi = mysql_query($query_select_regconsi, $jursta) or die(mysql_error());
$row_select_regconsi = mysql_fetch_assoc($select_regconsi);
$totalRows_select_regconsi = mysql_num_rows($select_regconsi);
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
rechargerpage("liste_regconcigne.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/rename_f2.png" width="32" height="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre des consignations - Modifier un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" valign="middle" nowrap bgcolor="#CCCCFF" class="Style10"><table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                <td align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                <td class="Style10"><?php echo $row_select_regconsi['noordre_rolegeneral']; ?></td>
                </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Date de l'audience : </td>
                <td class="Style10">                  <?php echo Change_formatDate($row_select_regconsi['dateaudience_rolegeneral']); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Objet : </td>
                <td class="Style10">                  <?php echo $row_select_regconsi['objet_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Demandeur : </td>
                <td class="Style10"><?php echo $row_select_regconsi['demandeur_rolegeneral']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10"> Defendeur : </td>
                <td class="Style10"><?php echo $row_select_regconsi['defendeur_rolegeneral']; ?></td>
              </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="2" valign="top" nowrap class="Style10"><table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr class="Style10">
                    <td align="right" valign="top" nowrap class="Style10">N&deg; d'ordre : </td>
                    <td><input name="noordre_regconsign" type="text" id="noordre_regconsign" value="<?php echo $row_select_regconsi['noordre_regconsign']; ?>" size="15"></td>
                    <td>Date : </td>
                    <td><input name="date_regconsign" type="text" id="datepicker1" value="<?php echo Change_formatDate($row_select_regconsi['date_regconsign']); ?>" size="15"></td>
                    </tr>
                  <tr>
                    <td align="right" valign="top" class="Style10">Montant : </td>
                    <td class="Style10"><input name="montant_regconsign" type="text" id="montant_regconsign2" value="<?php echo $row_select_regconsi['montant_regconsign']; ?>" size="15"></td>
                    <td class="Style10">Decision : </td>
                    <td><select name="decision_regconsign" id="select">
                      <option value="En cours"></option>
                      <option value="Contradictoire">Contradictoire</option>
                      <option value="Incompetence">Incomp&eacute;tence</option>
                      <option value="Radiation">Radiation</option>
                      <option value="Defaut">D&eacute;faut</option>
                      </select></td>
                    </tr>
                  <tr class="Style10">
                    <td align="right" valign="top" nowrap class="Style10">Somme &agrave; r&eacute;clamer : </td>
                    <td><input name="somareclam_regconsign" type="text" id="somareclam_regconsign" value="<?php echo $row_select_regconsi['somareclam_regconsign']; ?>" size="15"></td>
                    <td nowrap>Somme &agrave; restituer : </td>
                    <td><input name="somarestit_regconsign" type="text" id="somarestit_regconsign2" value="<?php echo $row_select_regconsi['somarestit_regconsign']; ?>" size="15"></td>
                    </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Liquidation :</td>
                    <td colspan="3"><textarea name="liquidation_regconsign" cols="40" rows="2" id="liquidation_regconsign"><?php echo $row_select_regconsi['liquidation_regconsign']; ?></textarea></td>
                    </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                    <td colspan="3"><textarea name="observation_regconsign" cols="40" rows="5" id="observation_regconsign"><?php echo $row_select_regconsi['observation_regconsign']; ?></textarea></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    <input name="no_regconsign" type="hidden" id="no_regconsign" value="<?php echo $row_select_regconsi['no_regconsign']; ?>">
                    <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_regconsi['no_rolegeneral']; ?>"></td>
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

mysql_free_result($select_regconsi);
?>
