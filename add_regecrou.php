<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Penitentiaire,Superviseur";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_ecrou (noordre_ecrou, datenter_ecrou, prolongdet_ecrou, decisionjudic_ecrou, datedebutpeine_ecrou, dateexpirpeine_ecrou, datsortidet_ecrou, motifssortidet_ecrou, observation_ecrou, no_regmandat, no_regcontrolnum, id_juridiction, Id_admin, date_creation) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['noordre_ecrou'], "text"),
                       GetSQLValueString(Change_formatDate($_POST['datenter_ecrou']), "date"),
                       GetSQLValueString($_POST['prolongdet_ecrou'], "text"),
                       GetSQLValueString($_POST['decisionjudic_ecrou'], "text"),
                       GetSQLValueString(Change_formatDate($_POST['datedebutpeine_ecrou']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['dateexpirpeine_ecrou']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datsortidet_ecrou']), "date"),
                       GetSQLValueString($_POST['motifssortidet_ecrou'], "date"),
                       GetSQLValueString($_POST['observation_ecrou'], "text"),
                       GetSQLValueString($_POST['no_regmandat'], "int"),
                       GetSQLValueString($_POST['no_regcontrolnum'], "int"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}


if ($_POST['Afficher']=="Afficher") { 
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = "SELECT * FROM reg_mandat, reg_controlnum WHERE (reg_mandat.no_regmandat=reg_controlnum.no_regcontrolnum)";
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
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
    $( "#datepicker" ).datepicker();
	$( "#datepicker1" ).datepicker();
	$( "#datepicker2" ).datepicker();
	$( "#datepicker3" ).datepicker();
	$( "#datepicker4" ).datepicker();
	$( "#datepicker5" ).datepicker();
	$( "#datepicker6" ).datepicker();
	$( "#datepicker7" ).datepicker();
  });
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_regecrou.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre d'ecrou - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" valign="top" nowrap bgcolor="#CCE3FF" class="Style10"><form name="form1" method="post" action="add_regecrou.php">
                  <table border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">N&deg; d'Immatriculation :</td>
                      <td><input name="noordre_regcontrolnum" type="text" id="noordre_regcontrolnum2" value="<?php echo $row_select_nodossier['noordre_regcontrolnum']; ?>" size="15">
                        <input type="submit" name="Afficher" value="Afficher"></td>
                      <td width="100" colspan="2">&nbsp;</td>
                    </tr>
                    <?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>
                    <tr align="center">
                      <td colspan="4" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                    </tr>
                    <?php } ?>
                    <?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Nom et pr&eacute;noms :</td>
                      <td colspan="3"><input name="nom_regmandat" type="text" disabled id="nom_regmandat2" value="<?php echo $row_select_nodossier['nom_regmandat']; ?>" size="35">
                      </td>
                      </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Type de mandat :</td>
                      <td colspan="3"><input name="type_regmandat" type="text" disabled="disabled" id="type_regmandat2" value="<?php echo $row_select_nodossier['type_regmandat']; ?>" size="35"></td>
                      </tr>
                    <?php } // Show if recordset not empty ?>
                  </table>
              </form></td>
              </tr>
            <tr>
              <td width="100%" align="center" valign="top" nowrap bgcolor="#CCE3FF" class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                    <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#CCE3FF" class="Style10">
                        <tr>
                          <td colspan="3" align="left" valign="middle" nowrap class="Style10"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" bgcolor="#CCE3FF">
                            <tr class="Style10">
                              <td width="153" align="left" valign="top" nowrap class="Style10">N&deg; d'Ecrou :</td>
                              <td><input name="noordre_ecrou" type="text" id="noordre_ecrou" size="15"></td>
                              </tr>
                            <tr class="Style10">
                              <td align="left" valign="top" nowrap class="Style10">Date D'entr&eacute;e : </td>
                              <td width="371"><input name="datenter_ecrou" type="text" id="datepicker1" size="15" value="<?php echo date("d/m/Y"); ?>"></td>
                              </tr>
                            <tr class="Style10">
                              <td align="left" valign="top" class="Style10">Prolongation <br>
                                de la d&eacute;tention :</td>
                              <td><input name="prolongdet_ecrou" type="text" id="prolongdet_ecrou" size="35"></td>
                              </tr>
                            <tr class="Style10">
                              <td align="left" valign="top" class="Style10">D&eacute;cision <br>
                                judiciaire intervenue :</td>
                              <td><textarea name="decisionjudic_ecrou" cols="35" rows="2" id="decisionjudic_ecrou"></textarea></td>
                              </tr>
                            <tr class="Style10">
                              <td align="left" valign="middle" class="Style10">Date d'ex&eacute;cution <br>
                                de la peine</td>
                              <td><table class="Style10">
                                <tr>
                                  <td>Commencement :</td>
                                  <td><input name="datedebutpeine_ecrou" type="text" id="datepicker2" size="11"></td>
                                  </tr>
                                <tr>
                                  <td>Expiration normale : </td>
                                  <td><input name="dateexpirpeine_ecrou" type="text" id="datepicker3" size="11"></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr class="Style10">
                              <td align="left" valign="middle" class="Style10"> Sortie effective </td>
                              <td><table class="Style10">
                                <tr>
                                  <td>Date : </td>
                                  <td><input name="datsortidet_ecrou" type="text" id="datepicker4" size="11"></td>
                                  </tr>
                                <tr>
                                  <td>Motifs : </td>
                                  <td><input name="motifssortidet_ecrou" type="text" id="motifssortidet_ecrou" size="28"></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr class="Style10">
                              <td align="left" valign="top">Observation : </td>
                              <td><textarea name="observation_ecrou" cols="40" rows="7" id="observation_ecrou"></textarea></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td width="101" nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                            <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                            <input name="no_regmandat" type="hidden" id="no_regmandat" value="<?php echo $row_select_nodossier['no_regmandat']; ?>">
                            <input name="no_regcontrolnum" type="hidden" id="no_regcontrolnum" value="<?php echo $row_select_nodossier['no_regcontrolnum']; ?>">
                            <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                          <td width="421" colspan="2" align="center"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
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

