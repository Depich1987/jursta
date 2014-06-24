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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_consignations (noordre_regconsign, date_regconsign, montant_regconsign, decision_regconsign, somareclam_regconsign, somarestit_regconsign, liquidation_regconsign, observation_regconsign, Id_admin, date_creation, no_rolegeneral, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
					   GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

if (isset($_POST['Afficher']) && $_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";
if (isset($_POST['noordre_rolegeneral'])) {
  $colname_select_nodossier = (get_magic_quotes_gpc()) ? $_POST['noordre_rolegeneral'] : addslashes($_POST['noordre_rolegeneral']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM role_general WHERE noordre_rolegeneral = '%s'", $colname_select_nodossier);
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

mysql_free_result($select_admin);
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
<table align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le registre des consignations - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="top" nowrap class="Style10"><form name="form1" method="post" action="add_regconsigne.php">
                  <table width="0%" border="0" align="center" cellpadding="5" cellspacing="0">
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
                        <td colspan="2"><input name="dateaudience_repjugementsupp" type="text" disabled id="dateaudience_repjugementsupp" value="<?php echo Change_formatDate($row_select_nodossier['date_rolegeneral']); ?>" size="15">
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" nowrap class="Style10">Objet :</td>
                        <td colspan="2">
                        <textarea name="objet_repjugementsupp" cols="40" rows="5" id="objet_repjugementsupp" disabled><?php echo $row_select_nodossier['objet_rolegeneral']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" nowrap class="Style10">Demandeur :</td>
                        <td colspan="2"><input name="demandeur_repjugementsupp" type="text" disabled id="demandeur_repjugementsupp" value="<?php echo $row_select_nodossier['demandeur_rolegeneral']; ?>" size="35"></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" nowrap class="Style10">Defendeur :</td>
                        <td colspan="2"><input name="defendeur_repjugementsupp" type="text" disabled id="defendeur_repjugementsupp" value="<?php echo $row_select_nodossier['defendeur_rolegeneral']; ?>" size="35">                        </td>
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
                      <td align="right" valign="top" nowrap class="Style10">N&deg; d'ordre : </td>
                      <td><input name="noordre_regconsign" type="text" id="noordre_regconsign" size="20"></td>
                      <td>Date : </td>
                      <td><input name="date_regconsign" type="text" value="<?php echo date("d-m-Y")?>"id="datepicker1" size="15"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Montant : </td>
                      <td class="Style10"><input name="montant_regconsign" type="text" id="montant_regconsign2" size="15"></td>
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
                      <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Somme &agrave; r&eacute;clamer</span> : </td>
                      <td><input name="somareclam_regconsign" type="text" id="somareclam_regconsign" size="15"></td>
                      <td>Somme &agrave; restituer : </td>
                      <td><input name="somarestit_regconsign" type="text" id="somarestit_regconsign2" size="15"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Liquidation :</span></td>
                      <td colspan="3"><textarea name="liquidation_regconsign" cols="40" rows="2" id="liquidation_regconsign"></textarea></td>
                      </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                      <td colspan="3"><textarea name="observation_regconsign" cols="40" rows="5" id="observation_regconsign"></textarea></td>
                      </tr>
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                        <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_nodossier['no_rolegeneral']; ?>">
                        <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                      <td colspan="3"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
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
//mysql_free_result($select_admin);
?>