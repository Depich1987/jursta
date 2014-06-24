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
  $updateSQL = sprintf("UPDATE reg_plaintes SET nodordre_plaintes=%s, Pautosaisi_plaintes=%s, Red_plaintes=%s, NomPreDomInculpes_plaintes=%s, dateparquet_plaintes=%s, NatInfraction_plaintes=%s, suite_plaintes=%s, MotifClass_plaintes=%s, observations_plaintes=%s, Id_admin=%s, date_creation=%s, DatInfraction_plaintes=%s, LieuInfraction_plaintes=%s, id_categorieaffaire=%s, PVdat_plaintes=%s, naturesuite_plaintes=%s, typepv_plaintes=%s, naturecrimes_plaintes=%s, procedureautreparquet_plaintes=%s, typesaisine_plaintes=%s WHERE no_regplaintes=%s",
                       GetSQLValueString($_POST['nodordre_plaintes'], "text"),
                       GetSQLValueString($_POST['Pautosaisi_plaintes'], "text"),
                       GetSQLValueString($_POST['Red_plaintes'], "text"),
                       GetSQLValueString($_POST['NomPreDomInculpes_plaintes'], "text"),
                       GetSQLValueString(changedatefrus($_POST['dateparquet_plaintes']), "date"),
                       GetSQLValueString($_POST['NatInfraction_plaintes'], "text"),
                       GetSQLValueString($_POST['suite_plaintes'], "text"),
                       GetSQLValueString($_POST['MotifClass_plaintes'], "text"),
                       GetSQLValueString($_POST['observations_plaintes'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['DatInfraction_plaintes'], "date"),
                       GetSQLValueString($_POST['LieuInfraction_plaintes'], "text"),
                       GetSQLValueString($_POST['id_categorieaffaire'], "int"),
                       GetSQLValueString(changedatefrus($_POST['PVdat_plaintes']), "date"),
                       GetSQLValueString($_POST['naturesuite_plaintes'], "text"),
                       GetSQLValueString($_POST['typepv_plaintes'], "text"),
                       GetSQLValueString($_POST['naturecrimes_plaintes'], "text"),
                       GetSQLValueString($_POST['procedureautreparquet_plaintes'], "int"),
                       GetSQLValueString($_POST['typesaisine_plaintes'], "text"),
                       GetSQLValueString($_POST['no_regplaintes'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_jursta, $jursta);
$query_liste_affaires = "SELECT * FROM categorie_affaire ORDER BY id_categorieaffaire ASC";
$liste_affaires = mysql_query($query_liste_affaires, $jursta) or die(mysql_error());
$row_liste_affaires = mysql_fetch_assoc($liste_affaires);
$totalRows_liste_affaires = mysql_num_rows($liste_affaires);

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE (Login_admin = '%s')", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

$colname_select_plaintes = "1";
if (isset($_GET['noregpl'])) {
  $colname_select_plaintes = (get_magic_quotes_gpc()) ? $_GET['noregpl'] : addslashes($_GET['noregpl']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_plaintes = sprintf("SELECT * FROM reg_plaintes WHERE no_regplaintes = %s", $colname_select_plaintes);
$select_plaintes = mysql_query($query_select_plaintes, $jursta) or die(mysql_error());
$row_select_plaintes = mysql_fetch_assoc($select_plaintes);
$totalRows_select_plaintes = mysql_num_rows($select_plaintes);
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
rechargerpage("liste_regplaintes.php");
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
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Registre des plaintes  - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10"><span class="Style10">N&deg; d'ordre</span> : </td>
                <td><input name="nodordre_plaintes" type="text" id="noordre_regcontrolnuml" value="<?php echo $row_select_plaintes['nodordre_plaintes']; ?>" size="15"></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">1&egrave;re Autorit&eacute; Saisie : </td>
                <td nowrap class="Style10"><input <?php if (!(strcmp($row_select_plaintes['Pautosaisi_plaintes'],"Police"))) {echo "CHECKED";} ?> type="radio" name="Pautosaisi_plaintes" value="Police" onClick="afficher('naturecrime');cacher('typesaisine');">                  
                  Police
                    <input <?php if (!(strcmp($row_select_plaintes['Pautosaisi_plaintes'],"Gendarmerie"))) {echo "CHECKED";} ?> type="radio" name="Pautosaisi_plaintes" value="Gendarmerie" onClick="afficher('naturecrime');cacher('typesaisine');">
                  Gendarmerie
                  <input <?php if (!(strcmp($row_select_plaintes['Pautosaisi_plaintes'],"Douanes"))) {echo "CHECKED";} ?> type="radio" name="Pautosaisi_plaintes" value="Douanes" onClick="afficher('naturecrime');cacher('typesaisine');">
                  Douanes 
                  <input <?php if (!(strcmp($row_select_plaintes['Pautosaisi_plaintes'],"Eaux et forêts"))) {echo "CHECKED";} ?> type="radio" name="Pautosaisi_plaintes" value="Eaux et forêts" onClick="afficher('naturecrime');cacher('typesaisine');"> 
                  Eaux et for&ecirc;ts
                  <input <?php if (!(strcmp($row_select_plaintes['Pautosaisi_plaintes'],"Parquet"))) {echo "CHECKED";} ?> type="radio" name="Pautosaisi_plaintes" value="Parquet" onClick="afficher('typesaisine');cacher('naturecrime');">
                  Parquet </td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10"><span class="Style10">Redacteur </span>: </td>
                <td>                  <input name="Red_plaintes" type="text" id="Red_plaintes" value="<?php echo $row_select_plaintes['Red_plaintes']; ?>" size="35"></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10"><span class="Style10">Date </span>du 1er Proc&egrave;s Verbal : </td>
                <td><input name="PVdat_plaintes" type="text" id="PVdat_plaintes" value="<?php echo Change_formatDate($row_select_plaintes['PVdat_plaintes']); ?>" size="15"></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Nature : </td>
                <td><select name="id_categorieaffaire" size="1" id="id_categorieaffaire">
                  <?php
do {  
?>
                  <option value="<?php echo $row_liste_affaires['id_categorieaffaire']?>"<?php if (!(strcmp($row_liste_affaires['id_categorieaffaire'], $row_select_plaintes['id_categorieaffaire']))) {echo "SELECTED";} ?>><?php echo $row_liste_affaires['lib_categorieaffaire']?></option>
                  <?php
} while ($row_liste_affaires = mysql_fetch_assoc($liste_affaires));
  $rows = mysql_num_rows($liste_affaires);
  if($rows > 0) {
      mysql_data_seek($liste_affaires, 0);
	  $row_liste_affaires = mysql_fetch_assoc($liste_affaires);
  }
?>
                                </select></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Infraction : </td>
                <td><textarea name="NatInfraction_plaintes" id="NatInfraction_plaintes" cols="38" rows="3"><?php echo $row_select_plaintes['NatInfraction_plaintes']; ?></textarea></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Date de l'infraction : </td>
                <td><input name="DatInfraction_plaintes" type="text" id="DatInfraction_plaintes" value="<?php echo Change_formatDate($row_select_plaintes['DatInfraction_plaintes']); ?>" maxlength="15"></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Lieu de l'infraction : </td>
                <td><input name="LieuInfraction_plaintes" type="text" id="LieuInfraction_plaintes" value="<?php echo $row_select_plaintes['LieuInfraction_plaintes']; ?>" size="38"></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Nom, pr&eacute;noms et domicile des inculp&eacute;s :</td>
                <td>                  <textarea name="NomPreDomInculpes_plaintes" cols="38" rows="5" id="textarea"><?php echo $row_select_plaintes['NomPreDomInculpes_plaintes']; ?></textarea></td>
              </tr>
              <tr>
                <td colspan="2" align="right" valign="top" nowrap class="Style10"><div id="naturecrime" <?php if ($row_select_plaintes['Pautosaisi_plaintes']=="Parquet") { echo "style='visibility:hidden; display:none'"; } ?>>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="288"  align="right" valign="top" nowrap class="Style10"><span class="Style10">Nature du crime ou du d&eacute;lit</span> :</td>
                    <td class="Style10"><input <?php if (!(strcmp($row_select_plaintes['naturecrimes_plaintes'],"Constatée"))) {echo "CHECKED";} ?> type="radio" name="naturecrimes_plaintes" value="Constatée">
      Constat&eacute;e
      <input <?php if (!(strcmp($row_select_plaintes['naturecrimes_plaintes'],"Poursuivis"))) {echo "CHECKED";} ?> type="radio" name="naturecrimes_plaintes" value="Poursuivis">
      Poursuivis</td>
                  </tr>
                </table></div></td>
                </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Date d'entr&eacute;e au parquet : </td>
                <td><input name="dateparquet_plaintes" type="text" id="dateparquet_plaintes" value="<?php echo $row_select_plaintes['dateparquet_plaintes']; ?>" size="15"></td>
              </tr>
              <tr>
                <td colspan="2" align="right" valign="top" nowrap class="Style10"><div id="typesaisine" <?php if ($row_select_plaintes['Pautosaisi_plaintes']!="Parquet") { echo "style='visibility:hidden; display:none'"; } ?>>
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="300" align="right" valign="top" nowrap class="Style10">Type de saisine : </td>
                    <td nowrap class="Style10"><input <?php if (!(strcmp($row_select_plaintes['typesaisine_plaintes'],"Procès Verbal"))) {echo "CHECKED";} ?> type="radio" name="typesaisine_plaintes" value="Procès Verbal" onClick="afficher('typepv');cacher('autreparquet');">
      Proc&egrave;s Verbal
      <input <?php if (!(strcmp($row_select_plaintes['typesaisine_plaintes'],"Autres affaires pénales"))) {echo "CHECKED";} ?> type="radio" name="typesaisine_plaintes" value="Autres affaires pénales" onClick="afficher('autreparquet');cacher('typepv');">
      Autres affaires p&eacute;nales </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right" valign="top" nowrap class="Style10"><div id="typepv" <?php if ($row_select_plaintes['typesaisine_plaintes']!="Procès Verbal") { echo "style='visibility:hidden; display:none'"; } ?>>
                   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="300" align="right" class="Style10">Type de Proc&egrave;s Verbal : </td>
                        <td><select name="typepv_plaintes">
                          <option value="1" <?php if (!(strcmp(1, $row_select_plaintes['typepv_plaintes']))) {echo "SELECTED";} ?>>Plaintes et d&eacute;nonciation</option>
                          <option value="3" <?php if (!(strcmp(3, $row_select_plaintes['typepv_plaintes']))) {echo "SELECTED";} ?>>Crimes</option>
                          <option value="4" <?php if (!(strcmp(4, $row_select_plaintes['typepv_plaintes']))) {echo "SELECTED";} ?>>Delits</option>
                          <option value="5" <?php if (!(strcmp(5, $row_select_plaintes['typepv_plaintes']))) {echo "SELECTED";} ?>>Contraventions et infractions non pr&eacute;cises</option>
                        </select></td>
                      </tr>
                    </table></div>                      </td>
                    </tr>
                  <tr>
                    <td colspan="2" align="right" valign="top" nowrap class="Style10"><div id="autreparquet" <?php if ($row_select_plaintes['typesaisine_plaintes']=="Procès Verbal") { echo "style='visibility:hidden; display:none'"; } ?>>
                      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="300" align="right" class="Style10">Procedure provenant d'autre parquet ? </td>
                          <td class="Style10"> <input <?php if (!(strcmp($row_select_plaintes['procedureautreparquet_plaintes'],"1"))) {echo "CHECKED";} ?> type="radio" name="procedureautreparquet_plaintes" value="1">
Oui
  <input <?php if (!(strcmp($row_select_plaintes['procedureautreparquet_plaintes'],"0"))) {echo "CHECKED";} ?> type="radio" name="procedureautreparquet_plaintes" value="0" checked>
Non</td>
                        </tr>
                      </table>
                    </div></td>
                    </tr>
                </table>
                </div></td>
                </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Suite de l'affaire  ? </td>
                <td><select name="naturesuite_plaintes" id="naturesuite_plaintes">
                  <option value="" selected <?php if (!(strcmp("", $row_select_plaintes['naturesuite_plaintes']))) {echo "SELECTED";} ?>></option>
                  <option value="Classée" <?php if (!(strcmp("Classée", $row_select_plaintes['naturesuite_plaintes']))) {echo "SELECTED";} ?>>Class&eacute;e</option>
                  <option value="Poursuivable" <?php if (!(strcmp("Poursuivable", $row_select_plaintes['naturesuite_plaintes']))) {echo "SELECTED";} ?>>Poursuivable</option>
                  <option value="Non Poursuivable" <?php if (!(strcmp("Non Poursuivable", $row_select_plaintes['naturesuite_plaintes']))) {echo "SELECTED";} ?>>Non Poursuivable</option>
                                                                                                                </select></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Transmis au : </td>
                <td><select name="suite_plaintes" id="suite_plaintes">
                  <option value="" selected <?php if (!(strcmp("", $row_select_plaintes['suite_plaintes']))) {echo "SELECTED";} ?>></option>
                  <option value="Juge d'intruction" <?php if (!(strcmp("Juge d\'intruction", $row_select_plaintes['suite_plaintes']))) {echo "SELECTED";} ?>>Juge d'intruction</option>
                  <option value="Juge des enfants" <?php if (!(strcmp("Juge des enfants", $row_select_plaintes['suite_plaintes']))) {echo "SELECTED";} ?>>Juge des enfants</option>
                  <option value="Tribunal correctionnel" <?php if (!(strcmp("Tribunal correctionnel", $row_select_plaintes['suite_plaintes']))) {echo "SELECTED";} ?>>Tribunal correctionnel</option>
                                                </select></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Motif du classement :  </td>
                <td><textarea name="MotifClass_plaintes" cols="38" id="MotifClass_plaintes"><?php echo $row_select_plaintes['MotifClass_plaintes']; ?></textarea></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Observations : </td>
                <td><textarea name="observations_plaintes" cols="38" id="observations_plaintes"><?php echo $row_select_plaintes['observations_plaintes']; ?></textarea></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10"><input name="no_regplaintes" type="hidden" id="no_regplaintes" value="<?php echo $row_select_plaintes['no_regplaintes']; ?>">
                  <input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>"></td>
                <td><input type="submit" name="Valider_cmd" value="   Modifier l'enregistrement   "></td>
              </tr>
          </table>
            </td>
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
mysql_free_result($liste_affaires);

mysql_free_result($select_admin);

mysql_free_result($select_plaintes);
?>
