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
  $insertSQL = sprintf("INSERT INTO rep_jugementsupp (nojugement_repjugementsupp, dispositif_repjugementsupp, observation_repjugementsupp, Id_admin, date_creation, no_rolegeneral, statut_jugementsupp, id_juridiction, decision_repjugementsupp, signature_greffier) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nojugement_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['dispositif_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['observation_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['no_rolegeneral'], "int"),
                       GetSQLValueString($_POST['statut_jugementsupp'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString($_POST['decision_repjugementsupp'], "text"),
                       GetSQLValueString($_POST['signature_greffier'], "text"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "text"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

if ($_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";
if (isset($_POST['noordre_rolegeneral'])) {
  $colname_select_nodossier = $_POST['noordre_rolegeneral'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM role_general WHERE ((noordre_rolegeneral = %s) AND (role_general.id_juridiction =".$row_select_juridic['id_juridiction']."))", GetSQLValueString($colname_select_nodossier, "text"));
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

mysql_select_db($database_jursta, $jursta);
$query_select_dispositif = "SELECT libellé FROM dispositifs";
$select_dispositif = mysql_query($query_select_dispositif, $jursta) or die(mysql_error());
$row_select_dispositif = mysql_fetch_assoc($select_dispositif);
$totalRows_select_dispositif = mysql_num_rows($select_dispositif);

$colname_verif_jugement = "-1";
if (isset($_POST['noordre_rolegeneral'])) {
  $colname_verif_jugement = $_POST['noordre_rolegeneral'];
}
mysql_select_db($database_jursta, $jursta);
$query_verif_jugement = sprintf("SELECT * FROM role_general, rep_jugementsupp WHERE ((role_general.noordre_rolegeneral=%s) AND  (role_general.no_rolegeneral = rep_jugementsupp.no_rolegeneral))", GetSQLValueString($colname_verif_jugement, "text"));
$verif_jugement = mysql_query($query_verif_jugement, $jursta) or die(mysql_error());
$row_verif_jugement = mysql_fetch_assoc($verif_jugement);
$totalRows_verif_jugement = mysql_num_rows($verif_jugement);
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
rechargerpage("liste_repjug.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="480" align="center" >
  <tr>
    <td align="center" bgcolor="#CCE3FF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Le r&eacute;pertoire des jugements - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td align="right" valign="top" nowrap class="Style10"><form name="form1" method="post" action="add_repjug.php">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
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
<?php /*
<?php <?php  if (($totalRows_verif_jugement > 0) && ($_POST['Afficher']!="")) { // Show if recordset not empty ?>
  <tr align="center">
    <td colspan="3" valign="top"  class="Style11">Ce Dossier à déja été jugé sous le numéros : <?php echo $row_verif_jugement['nojugement_repjugementsupp']; ?></td>
  </tr>
  <?php } // Show if recordset not empty ?>				
*/
?>
<?php if (($totalRows_select_nodossier > 0)){ // Show if recordset not empty ?>
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
              <td width="100%" align="right" valign="top" nowrap class="Style10"><?php if (($totalRows_select_nodossier > 0)) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td width="32%" align="right" valign="top" nowrap class="Style10">N&deg; du Jugement : </td>
                      <td colspan="2"><input name="nojugement_repjugementsupp" type="text" id="nojugement_repjugementsupp" size="20"></td>
                    </tr>
                    <tr class="Style10">
                      <td align="right" valign="top" nowrap class="Style10">Dispositif :</td>
                      <td colspan="2"><input type="radio" name="decision_repjugementsupp" id="radio" value="Fondé"> 
                        Fond&eacute; 
                          <input type="radio" name="decision_repjugementsupp" id="radio2" value="Mal Fond&eacute;"> 
                          Mal Fond&eacute; 
                          <input type="radio" name="decision_repjugementsupp" id="radio3" value="Partiellement Fond&eacute;"> 
                          Partiellement Fond&eacute;</td>
                    </tr>
                    <td colspan="3" align="right" valign="top" nowrap class="Style10">
                    <div id="statut" style="display:none; visibility:hidden">
                    <table>
                    <tr class="Style10">
                      <td align="right" valign="top" nowrap class="Style10">Pour Statistique : </td>
                      <td colspan="2"><input name="statut_jugementsupp" type="radio" value="Acceptée" checked>
Accept&eacute;e
<input type="radio" name="statut_jugementsupp" value="Rejetée">
Rejet&eacute;e</td>
                    </tr>
                    </table> 
                    </div>
                    </td>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Caract&egrave;re :</td>
                      <td width="8%"><select onChange="afficher_autre('autre','dispositif_repjugementsupp',5);" name="dispositif_repjugementsupp" id="dispositif_repjugementsupp">
                        <?php
do {  
?>
                        <option value="<?php echo $row_select_dispositif['libellé']?>"><?php echo $row_select_dispositif['libellé']?></option>
                        <?php
} while ($row_select_dispositif = mysql_fetch_assoc($select_dispositif));
  $rows = mysql_num_rows($select_dispositif);
  if($rows > 0) {
      mysql_data_seek($select_dispositif, 0);
	  $row_select_dispositif = mysql_fetch_assoc($select_dispositif);
  }
?>
                      </select></td>
                      <td width="60%"><div id="autre" style="display:none; visibility:hidden"><table><tr><input name="lib_dispositif" type="text" id="lib_dispositif" size="30"></tr></table></div></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Observation : </td>
                      <td colspan="2"><textarea name="observation_repjugementsupp" cols="40" rows="7" id="textarea5"></textarea></td>
                     
                      </tr>
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">Signature Greffier :</td>
                      <td colspan="2"><textarea name="signature_greffier" cols="40" rows="2" readonly="readonly" id="signature_greffier">Approuvée par <?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?> le : <?php echo Change_formatDate(date("Y-m-d H:i:s")); ?></textarea></td>
                    </tr>
                    <tr>
                      <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                        <input name="date_creation" type="hidden" id="date_creation" value="<?php echo Change_formatDate(date("Y-m-d H:i:s")); ?>">
                        <input name="no_rolegeneral" type="hidden" id="no_rolegeneral" value="<?php echo $row_select_nodossier['no_rolegeneral']; ?>">
                        <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                      <td colspan="2"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form2">
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
mysql_free_result($select_admin);

mysql_free_result($select_dispositif);

mysql_free_result($verif_jugement);

mysql_free_result($select_nodossier);
?>