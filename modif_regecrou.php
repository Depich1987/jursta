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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE reg_ecrou SET noordre_ecrou=%s, datnaisdet_ecrou=%s, lieunaisdet_ecrou=%s, peredet_ecrou=%s, meredet_ecrou=%s, professiondet_ecrou=%s, domicildet_ecrou=%s, tailledet_ecrou=%s, frontdet_ecrou=%s, nezdet_ecrou=%s, bouchedet_ecrou=%s, teintdet_ecrou=%s, signepartdet_ecrou=%s, datenter_ecrou=%s, prolongdet_ecrou=%s, decisionjudic_ecrou=%s, datedebutpeine_ecrou=%s, dateexpirpeine_ecrou=%s, datsortidet_ecrou=%s, motifssortidet_ecrou=%s, observation_ecrou=%s, no_regcontrolnum=%s, no_regmandat=%s WHERE no_ecrou=%s",
                       GetSQLValueString($_POST['noordre_ecrou'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datnaisdet_ecrou']), "date"),
                       GetSQLValueString($_POST['lieunaisdet_ecrou'], "text"),
                       GetSQLValueString($_POST['peredet_ecrou'], "text"),
                       GetSQLValueString($_POST['meredet_ecrou'], "text"),
                       GetSQLValueString($_POST['professiondet_ecrou'], "text"),
                       GetSQLValueString($_POST['domicildet_ecrou'], "text"),
                       GetSQLValueString($_POST['tailledet_ecrou'], "text"),
                       GetSQLValueString($_POST['frontdet_ecrou'], "text"),
                       GetSQLValueString($_POST['nezdet_ecrou'], "text"),
                       GetSQLValueString($_POST['bouchedet_ecrou'], "text"),
                       GetSQLValueString($_POST['teintdet_ecrou'], "text"),
                       GetSQLValueString($_POST['signepartdet_ecrou'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datenter_ecrou']), "date"),
                       GetSQLValueString($_POST['prolongdet_ecrou'], "text"),
                       GetSQLValueString($_POST['decisionjudic_ecrou'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datedebutpeine_ecrou']), "date"),
                       GetSQLValueString(changedatefrus($_POST['dateexpirpeine_ecrou']), "date"),
                       GetSQLValueString(changedatefrus($_POST['datsortidet_ecrou']), "date"),
                       GetSQLValueString($_POST['motifssortidet_ecrou'], "date"),
                       GetSQLValueString($_POST['observation_ecrou'], "text"),
                       GetSQLValueString($_POST['no_regcontrolnum'], "int"),
                       GetSQLValueString($_POST['no_regmandat'], "int"),
                       GetSQLValueString($_POST['no_ecrou'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}


$colname_select_nodossier = "1";
if (isset($_GET[norege])) {
  $colname_select_nodossier = (get_magic_quotes_gpc()) ? $_GET[norege] : addslashes($_GET[norege]);
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_mandat, reg_controlnum, reg_ecrou WHERE ((no_ecrou = %s) AND (reg_controlnum.no_regcontrolnum=reg_ecrou.no_regcontrolnum))", $colname_select_nodossier);
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);


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
    $( "#datepicker1" ).datepicker();
	$( "#datepicker" ).datepicker();
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
<table width="100%" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre d'immatriculation - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" valign="top" nowrap class="Style10">                    <table border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">N&deg; d'Immatriculation :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['noordre_regcontrolnum']; ?></td>
                      
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Nom et pr&eacute;noms :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['nom_regmandat']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Nom du Procureur :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['magistra_regmandat']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Type de mandat :</td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['type_regmandat']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Par : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['magistra_regmandat']; ?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Pour : </td>
                      <td valign="top" nowrap class="Style10"><?php echo $row_select_nodossier['infraction_regmandat']; ?></td>
                    </tr>
                    
                                    </table></td></tr>
            <tr>
              <td width="100%" align="right" valign="top" nowrap class="Style10"><table cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td bgcolor="#6186AF"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#6186AF" class="Style10">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">N&deg; d'Ecrou:</td>
                      <td><input name="noordre_ecrou" type="text" id="noordre_ecrou" value="<?php echo $row_select_nodossier['noordre_regcontrolnum']; ?>" size="15"></td>
                      <td colspan="2" rowspan="2" valign="top"><table bgcolor="#6186AF">
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Date D'entr&eacute;e: </td>
                          <td><input name="datenter_ecrou" type="text" id="datenter_ecrou" size="15" value="<?php echo Change_formatDate($row_select_nodossier['datenter_ecrou']); ?>"></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Prolongation de la d&eacute;tention :</td>
                          <td><input value="<?php echo $row_select_nodossier['prolongdet_ecrou']; ?>" name="prolongdet_ecrou" type="text" id="prolongdet_ecrou" size="35"></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">D&eacute;cision judiciaire intervenue :</td>
                          <td><textarea name="decisionjudic_ecrou" cols="35" rows="2" id="decisionjudic_ecrou"><?php echo $row_select_nodossier['decisionjudic_ecrou']; ?></textarea></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10">Date d'ex&eacute;cution de la peine : </td>
                          <td><table class="Style10">
                              <tr>
                                <td>Commencement :</td>
                                <td><input value="<?php echo Change_formatDate($row_select_nodossier['datedebutpeine_ecrou']); ?>" name="datedebutpeine_ecrou" type="text" id="datedebutpeine_ecrou" size="11"></td>
                              </tr>
                              <tr>
                                <td>Expiration normale : </td>
                                <td><input value="<?php echo Change_formatDate($row_select_nodossier['dateexpirpeine_ecrou']); ?>" name="dateexpirpeine_ecrou" type="text" id="dateexpirpeine_ecrou" size="11"></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap class="Style10"> Sortie effective : </td>
                          <td><table class="Style10">
                              <tr>
                                <td>Date : </td>
                                <td><input value="<?php echo Change_formatDate($row_select_nodossier['datsortidet_ecrou']); ?>" name="datsortidet_ecrou" type="text" id="datsortidet_ecrou" size="11"></td>
                              </tr>
                              <tr>
                                <td>Motifs : </td>
                                <td><input value="<?php echo $row_select_nodossier['motifssortidet_ecrou']; ?>" name="motifssortidet_ecrou" type="text" id="motifssortidet_ecrou" size="11"></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr class="Style10">
                          <td align="right" valign="top" nowrap>Observation : </td>
                          <td><textarea name="observation_ecrou" cols="40" rows="7" id="observation_ecrou"><?php echo $row_select_nodossier['observation_ecrou']; ?></textarea></td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Identit&eacute; Compl&egrave;te et signalement : </td>
                      <td><table class="Style10">
  <td nowrap>Date de naissance :</td>
      <td><input value="<?php echo Change_formatDate($row_select_nodossier['datnaisdet_ecrou']); ?>" name="datnaisdet_ecrou" type="text" id="datnaisdet_ecrou" size="15"></td>
  </tr>
  <tr>
    <td>Lieu de naissance :</td>
    <td><input value="<?php echo $row_select_nodossier['lieunaisdet_ecrou']; ?>" name="lieunaisdet_ecrou" type="text" id="lieunaisdet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td>Nom du p&egrave;re : </td>
    <td><input value="<?php echo $row_select_nodossier['peredet_ecrou']; ?>" name="peredet_ecrou" type="text" id="peredet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td>Nom de la m&egrave;re : </td>
    <td><input value="<?php echo $row_select_nodossier['meredet_ecrou']; ?>" name="meredet_ecrou" type="text" id="meredet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td>Profession : </td>
    <td><input value="<?php echo $row_select_nodossier['professiondet_ecrou']; ?>" name="professiondet_ecrou" type="text" id="professiondet_ecrou2" size="35"></td>
  </tr>
  <tr>
    <td>Domicile : </td>
    <td><input value="<?php echo $row_select_nodossier['domicildet_ecrou']; ?>" name="domicildet_ecrou" type="text" id="domicildet_ecrou" size="35"></td>
  </tr>
  <tr>
    <td>Taille : </td>
    <td><input value="<?php echo $row_select_nodossier['tailledet_ecrou']; ?>" name="tailledet_ecrou" type="text" id="tailledet_ecrou" size="8"></td>
  </tr>
  <tr>
    <td>Front :</td>
    <td><input value="<?php echo $row_select_nodossier['frontdet_ecrou']; ?>" name="frontdet_ecrou" type="text" id="frontdet_ecrou" size="15"></td>
  </tr>
  <tr>
    <td>Nez : </td>
    <td><input value="<?php echo $row_select_nodossier['nezdet_ecrou']; ?>" name="nezdet_ecrou" type="text" id="nezdet_ecrou" size="15"></td>
  </tr>
  <tr>
    <td>Bouche : </td>
    <td><input value="<?php echo $row_select_nodossier['bouchedet_ecrou']; ?>" name="bouchedet_ecrou" type="text" id="bouchedet_ecrou" size="25"></td>
  </tr>
  <tr>
    <td>Teint :</td>
    <td><input value="<?php echo $row_select_nodossier['teintdet_ecrou']; ?>" name="teintdet_ecrou" type="text" id="teintdet_ecrou" size="15"></td>
  </tr>
  <tr>
    <td>Signe particulier : </td>
    <td><textarea name="signepartdet_ecrou" cols="25" rows="2" id="signepartdet_ecrou"><?php echo $row_select_nodossier['signepartdet_ecrou']; ?></textarea></td>
                      </table></td>
                      </tr>
                    <tr>
                      <td nowrap>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin2" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation2" value="<?php echo date("Y-m-d H:i:s"); ?>">
                        <input name="no_regmandat" type="hidden" id="no_regmandat" value="<?php echo $row_select_nodossier['no_regmandat']; ?>">                        
                        <input name="no_regcontrolnum" type="hidden" id="no_regcontrolnum" value="<?php echo $row_select_nodossier['no_regcontrolnum']; ?>">
                        <input name="no_ecrou" type="hidden" id="no_ecrou" value="<?php echo $row_select_nodossier['no_ecrou']; ?>"></td>
                      <td colspan="3" align="center"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                      </tr>
                  </table>
                  
                  <input type="hidden" name="MM_update" value="form2">
                </form>
                <?php } // Show if recordset not empty ?></td>
                  </tr>
              </table></td>
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

