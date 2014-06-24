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

if ((isset($_POST["Sauvegarder_cmd"])) && ($_POST["Sauvegarder_cmd"] == "Sauvegarder")) {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO t30_autresinfo (T30_DATE,annee, T30_MOIS, T30_NBCHAMBRE, T30_NBCHBSPEFAMILLE, T30_NBCHBSPETRAV, T30_NOMSOURCE, T30_SOURCECONTACT, T30_NBJI) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['T30_DATE'], "date"),
                       GetSQLValueString($_POST['T06_ANNEE'], "int"),
                       GetSQLValueString($_POST['T30_MOIS'], "int"),
                       GetSQLValueString($_POST['T30_NBCHAMBRE'], "int"),
                       GetSQLValueString($_POST['T30_NBCHBSPEFAMILLE'], "int"),
                       GetSQLValueString($_POST['T30_NBCHBSPETRAV'], "int"),
                       GetSQLValueString($_POST['T30_NOMSOURCE'], "text"),
                       GetSQLValueString($_POST['T30_SOURCECONTACT'], "text"),
                       GetSQLValueString($_POST['T30_NBJI'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}
}

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Civile'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);

mysql_select_db($database_jursta, $jursta);
$query_liste_typejuridiction = "SELECT * FROM type_juridiction WHERE (id_typejuridiction <> 5) ORDER BY lib_typejuridiction ASC";
$liste_typejuridiction = mysql_query($query_liste_typejuridiction, $jursta) or die(mysql_error());
$row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
$totalRows_liste_typejuridiction = mysql_num_rows($liste_typejuridiction);

$colname_liste_juridiction = "-1";
if (isset($_POST['id_typejuridiction'])) {
  $colname_liste_juridiction = (get_magic_quotes_gpc()) ? $_POST['id_typejuridiction'] : addslashes($_POST['id_typejuridiction']);
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", $colname_liste_juridiction);
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
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
  </script></head>

<body class="stat">
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td background="images/index_01.gif"><?php require_once('haut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuhaut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuidentity.php'); ?></td>
  </tr>
  <tr>
    <td><table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                      <td width="100%"><span class="Style2">FICHE STATISTIQUE DES AFFAIRES SOCIALES
                            <?php if ((isset($_POST['mois'])) && (isset($_POST['annee']))) echo("PERIODE DE ".$_POST['mois']."/".$_POST['annee']) ?>
                      </span> </td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" >
                  <table width="940" cellpadding="3" cellspacing="0" >
                    <tr bgcolor="#EDF0F3" class="Style22">
                      <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
                      <td align="right" nowrap>Type de juridiction : </td>
                      <td nowrap><select name="id_typejuridiction" id="select" onChange="document.form1.submit()">
								<option value="">  </option>
                          <?php
do {  
?>
                          <option value="<?php echo $row_liste_typejuridiction['id_typejuridiction']?>"<?php if (!(strcmp($row_liste_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "SELECTED";} ?>><?php echo $row_liste_typejuridiction['lib_typejuridiction']?></option>
                          <?php
} while ($row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction));
  $rows = mysql_num_rows($liste_typejuridiction);
  if($rows > 0) {
      mysql_data_seek($liste_typejuridiction, 0);
	  $row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
  }
?>
                      </select></td>
                      <td align="center" nowrap>Juridiction : </td>
                      <td nowrap><select name="id_juridiction" id="id_juridiction">
                          <?php
do {  
?>
                          <option value="<?php echo $row_liste_juridiction['id_juridiction']?>"<?php if (!(strcmp($row_liste_juridiction['id_juridiction'], $_POST['id_juridiction']))) {echo "SELECTED";} ?>><?php echo $row_liste_juridiction['lib_juridiction']?></option>
                          <?php
} while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction));
  $rows = mysql_num_rows($liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($liste_juridiction, 0);
	  $row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
  }
?>
                      </select></td>
                      <?php } // Show if recordset empty ?>
                      <td align="right" nowrap>Mois : </td>
                      <td nowrap><select name="mois" id="mois">
                          <option value="01" <?php if (!(strcmp('01', $_POST['mois']))) {echo "SELECTED";} ?>>Janvier</option>
                          <option value="02" <?php if (!(strcmp('02', $_POST['mois']))) {echo "SELECTED";} ?>>F&eacute;vrier</option>
                          <option value="03" <?php if (!(strcmp('03', $_POST['mois']))) {echo "SELECTED";} ?>>Mars</option>
                          <option value="04" <?php if (!(strcmp('04', $_POST['mois']))) {echo "SELECTED";} ?>>Avril</option>
                          <option value="05" <?php if (!(strcmp('05', $_POST['mois']))) {echo "SELECTED";} ?>>Mai</option>
                          <option value="06" <?php if (!(strcmp('06', $_POST['mois']))) {echo "SELECTED";} ?>>Juin</option>
                          <option value="07" <?php if (!(strcmp('07', $_POST['mois']))) {echo "SELECTED";} ?>>Juillet</option>
                          <option value="08" <?php if (!(strcmp('08', $_POST['mois']))) {echo "SELECTED";} ?>>Ao&ucirc;t</option>
                          <option value="09" <?php if (!(strcmp('09', $_POST['mois']))) {echo "SELECTED";} ?>>Septembre</option>
                          <option value="10" <?php if (!(strcmp('10', $_POST['mois']))) {echo "SELECTED";} ?>>Octobre</option>
                          <option value="11" <?php if (!(strcmp('11', $_POST['mois']))) {echo "SELECTED";} ?>>Novembre</option>
                          <option value="12" <?php if (!(strcmp('12', $_POST['mois']))) {echo "SELECTED";} ?>>D&eacute;cembre</option>
                      </select></td>
                      <td nowrap>Ann&eacute;e</td>
                      <td nowrap><select name="annee" id="annee">
                          <option value="2010" <?php if (!(strcmp(2010, $_POST['annee']))) {echo "SELECTED";} ?>>2010</option>
<option value="2011" <?php if (!(strcmp(2011, $_POST['annee']))) {echo "SELECTED";} ?>>2011</option>
<option value="2012" <?php if (!(strcmp(2012, $_POST['annee']))) {echo "SELECTED";} ?>>2012</option>
<option value="2013" <?php if (!(strcmp(2013, $_POST['annee']))) {echo "SELECTED";} ?>>2013</option>
<option value="2014" <?php if (!(strcmp(2014, $_POST['annee']))) {echo "SELECTED";} ?>>2014</option>
<option value="2015" <?php if (!(strcmp(2015, $_POST['annee']))) {echo "SELECTED";} ?>>2015</option>
<option value="2016" <?php if (!(strcmp(2016, $_POST['annee']))) {echo "SELECTED";} ?>>2016</option>
<option value="2017" <?php if (!(strcmp(2017, $_POST['annee']))) {echo "SELECTED";} ?>>2017</option>
<option value="2018" <?php if (!(strcmp(2018, $_POST['annee']))) {echo "SELECTED";} ?>>2018</option>
<option value="2019" <?php if (!(strcmp(2019, $_POST['annee']))) {echo "SELECTED";} ?>>2019</option>
<option value="2020" <?php if (!(strcmp(2020, $_POST['annee']))) {echo "SELECTED";} ?>>2020</option>
<option value="2010" <?php if (!(strcmp(2021, $_POST['annee']))) {echo "SELECTED";} ?>>2021</option>
<option value="2011" <?php if (!(strcmp(2022, $_POST['annee']))) {echo "SELECTED";} ?>>2022</option>
<option value="2012" <?php if (!(strcmp(2023, $_POST['annee']))) {echo "SELECTED";} ?>>2023</option>
<option value="2013" <?php if (!(strcmp(2024, $_POST['annee']))) {echo "SELECTED";} ?>>2024</option>
<option value="2014" <?php if (!(strcmp(2025, $_POST['annee']))) {echo "SELECTED";} ?>>2025</option>
<option value="2015" <?php if (!(strcmp(2026, $_POST['annee']))) {echo "SELECTED";} ?>>2026</option>
<option value="2016" <?php if (!(strcmp(2027, $_POST['annee']))) {echo "SELECTED";} ?>>2027</option>
<option value="2017" <?php if (!(strcmp(2028, $_POST['annee']))) {echo "SELECTED";} ?>>2028</option>
<option value="2018" <?php if (!(strcmp(2030, $_POST['annee']))) {echo "SELECTED";} ?>>2029</option>
<option value="2019" <?php if (!(strcmp(2031, $_POST['annee']))) {echo "SELECTED";} ?>>2030</option>
<option value="2020" <?php if (!(strcmp(2032, $_POST['annee']))) {echo "SELECTED";} ?>>2031</option>
                      </select></td>
                      <td width="100%" nowrap><input name="Afficher_cmd" type="submit" id="Afficher_cmd" value="Afficher">
                      </td>
                    </tr>
                  </table>
                  <table width="940" cellpadding="3" cellspacing="0" >
                    <tr>
                      <td><table cellpadding="3" cellspacing="0" >
                          <tr>
                            <td width="200" bgcolor="#6186AF" class="Style28">Autres informations </td>
                            <td width="246">&nbsp;</td>
                          </tr>
                          <tr bgcolor="#677787">
                            <td colspan="2" bgcolor="#6186AF"><table cellpadding="5" cellspacing="1" >
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td nowrap>Date : </td>
                                  <td><input name="T30_DATE" type="text" id="T30_DATE"></td>
                                  <td nowrap>Nb. juge d'instruction : </td>
                                  <td><input name="T30_NBJI" type="text" id="T30_NBJI2" size="3"></td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td nowrap>Source : </td>
                                  <td><textarea name="T30_SOURCECONTACT" id="textarea2"></textarea></td>
                                  <td nowrap>Nb. chambre : </td>
                                  <td><input name="T30_NBCHAMBRE" type="text" id="T30_NBCHAMBRE2" size="3"></td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td rowspan="2" valign="top" nowrap bgcolor="#EDF0F3">Contacts :                                      <br>
                                      <br>
                                      <br>                                    </td>
                                  <td rowspan="2" bgcolor="#EDF0F3"><input name="T30_NOMSOURCE" type="text" id="T30_NOMSOURCE5"></td>
                                  <td nowrap class="Style22">Ch sp&eacute;ciale famille : </td>
                                  <td class="Style22"><input name="T30_NBCHBSPEFAMILLE" type="text" id="T30_NBCHBSPEFAMILLE2" size="3"></td>
                                </tr>
                                <tr>
                                  <td valign="top" nowrap bgcolor="#EDF0F3" class="Style22">Ch Sp&eacute;ciale de travail : </td>
                                  <td valign="top" bgcolor="#EDF0F3" class="Style22"><input name="T30_NBCHBSPETRAV" type="text" id="T30_NBCHBSPETRAV2" size="3"></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr align="right" bgcolor="#6186AF">
                            <td height="31" colspan="2"><input name="T30_MOIS" type="hidden" id="T30_MOIS3" value="<?php echo $_POST['mois']; ?>" size="10">
                            <input name="T06_ANNEE" type="hidden" id="T06_ANNEE3" value="<?php echo $_POST['annee']; ?>" size="10">
                            <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_admin['id_juridiction']; ?>" size="3">                            <input name="Sauvegarder_cmd" type="submit" id="Sauvegarder_cmd" value="Sauvegarder"></td>
                          </tr>
                      </table></td>
                      <td valign="top"><table cellpadding="3" cellspacing="0" >
                          <tr>
                            <td width="200" nowrap bgcolor="#6186AF" class="Style28">Statistiques personnels</td>
                            <td width="246">&nbsp;</td>
                          </tr>
                          <tr bgcolor="#677787">
                            <td colspan="2" bgcolor="#6186AF">
                              <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                <tr bgcolor="#677787" class="Style3">
                                  <td width="100%"><span class="Style10">Fonction membre de l'ordre </span></td>
                                  <td width="8%" align="center"><span class="Style10">Effectif id&eacute;al </span></td>
                                  <td width="17%" align="center"><span class="Style10">Effectif actuel </span></td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td width="100%" valign="middle"> Nombre de Juges d'instruction : </td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td valign="middle"> Nombre de Chambres : </td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td valign="middle"> Dont Chambres sp&eacute;ciale Famille : </td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td valign="middle"> Dont Chambres sp&eacute;ciale Travail : </td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                  <td align="center" valign="middle" nowrap>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td valign="middle">&nbsp;</td>
                                  <td valign="middle" nowrap></td>
                                  <td valign="middle" nowrap></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form2">
                  <table width="940" cellpadding="2" cellspacing="1" >
                    <tr>
                      <td colspan="4">&nbsp;</td>
                      <td colspan="9" align="center" bgcolor="#677787" class="Style15"><table width="100%"  border="0" cellspacing="0" cellpadding="8">
                          <tr>
                            <td align="center" class="Style11">JUGEMENTS RENDUES </td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr class="Style15">
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td colspan="2" align="center" bgcolor="#6186AF" class="Style11">Statuant sur la demande </td>
                      <td colspan="4" align="center" bgcolor="#6186AF" class="Style11">Autres Jugements rendus </td>
                      <td colspan="3" align="center" bgcolor="#6186AF" class="Style11">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#6186AF" class="Style11">
                      <td align="center"><strong>#</strong></td>
                      <td width="100%" align="center"><strong>Nature</strong></td>
                      <td align="center"><strong>Affaires pr&eacute;c&eacute;dentes </strong></td>
                      <td align="center"><strong>Nouvelle affaires enrol&eacute;es </strong></td>
                      <td align="center" nowrap><div align="center"><strong>Accueillant<br>
              la demande </strong></div></td>
                      <td align="center" nowrap><div align="center"><strong>Rejet de la<br>
              demande </strong></div></td>
                      <td align="center"><div align="center"><strong>Contradictoire</strong></div></td>
                      <td align="center"><div align="center"><strong>Incomp&eacute;tence</strong></div></td>
                      <td align="center">
                        <div align="center"><strong>Radiation</strong></div></td>
                      <td align="center">
                        <div align="center"><strong>D&eacute;faut</strong></div></td>
                      <td align="center" nowrap><p align="center"><strong>Affaire en<br>
              cours en<br>
              fin du mois </strong></p></td>
                      <td align="center">
                        <div align="center"><strong>Dur&eacute;e moy<br>
              affaire trait&eacute;e </strong></div></td>
                      <td align="center"><p align="center"><strong>Nombre actes greffe </strong></p></td>
                    </tr>
                    <?php do { ?>
                    <?php
$categorie = $row_liste_nature['id_categorieaffaire'];
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_POST['id_juridiction'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_POST['id_juridiction'] : addslashes($_POST['id_juridiction']);
	}
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
}

$annee = "-1";
if (isset($_POST['annee'])) {
  $annee = (get_magic_quotes_gpc()) ? $_POST['annee'] : addslashes($_POST['annee']);
}
$mois = "-1";
if (isset($_POST['mois'])) {
  $mois = (get_magic_quotes_gpc()) ? $_POST['mois'] : addslashes($_POST['mois']);
}

mysql_select_db($database_jursta, $jursta);
$query_affairesenrolees = "SELECT count(*) as affairesenrolees FROM role_general, administrateurs WHERE ((administrateurs.Id_admin=role_general.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(role_general.date_creation,0,4)='".$annee."') AND (substr(role_general.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie."))";
$affairesenrolees = mysql_query($query_affairesenrolees, $jursta) or die(mysql_error());
$row_affairesenrolees = mysql_fetch_assoc($affairesenrolees);
$totalRows_affairesenrolees = mysql_num_rows($affairesenrolees); 


mysql_select_db($database_jursta, $jursta);
$query_affairesprecedent = "SELECT count(*) as affairesprecedent FROM rep_actesnot, administrateurs WHERE ((administrateurs.Id_admin=rep_actesnot.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (substr(rep_actesnot.date_creation,0,4)<='".$annee."') AND (substr(rep_actesnot.date_creation,5,2)<='".$mois."') AND (rep_actesnot.id_categorieaffaire=".$categorie."))";
$affairesprecedent = mysql_query($query_affairesprecedent, $jursta) or die(mysql_error());
$row_affairesprecedent = mysql_fetch_assoc($affairesprecedent);
$totalRows_affairesprecedent = mysql_num_rows($affairesprecedent);

mysql_select_db($database_jursta, $jursta);
$query_liste_acte = "SELECT count(*) as nbacte FROM rep_actesnot, administrateurs WHERE ((administrateurs.Id_admin=rep_actesnot.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_actesnot.date_creation,0,4)='".$annee."') AND (substr(rep_actesnot.date_creation,5,2)='".$mois."') AND (rep_actesnot.id_categorieaffaire=".$categorie."))";
$liste_acte = mysql_query($query_liste_acte, $jursta) or die(mysql_error());
$row_liste_acte = mysql_fetch_assoc($liste_acte);
$totalRows_liste_acte = mysql_num_rows($liste_acte);

mysql_select_db($database_jursta, $jursta);
$query_demandeaccepte = "SELECT count(*) as demandeaccepte FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (left(replace(role_general.date_creation,'-',''),6)='".$annee.$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.statut_jugementsupp='Accept&eacute;e')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$demandeaccepte = mysql_query($query_demandeaccepte, $jursta) or die(mysql_error());
$row_demandeaccepte = mysql_fetch_assoc($demandeaccepte);
$totalRows_demandeaccepte = mysql_num_rows($demandeaccepte);

mysql_select_db($database_jursta, $jursta);
$query_demanderejete = "SELECT count(*) as demanderejete FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (left(replace(role_general.date_creation,'-',''),6)='".$annee.$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.statut_jugementsupp='Rejet&eacute;e')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$demanderejete = mysql_query($query_demanderejete, $jursta) or die(mysql_error());
$row_demanderejete = mysql_fetch_assoc($demanderejete);
$totalRows_demanderejete = mysql_num_rows($demanderejete);

mysql_select_db($database_jursta, $jursta);
$query_jug_contradictoires = "SELECT count(*) as jugcontradictoires FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (left(replace(role_general.date_creation,'-',''),6)='".$annee.$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Contradictoire')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jug_contradictoires = mysql_query($query_jug_contradictoires, $jursta) or die(mysql_error());
$row_jug_contradictoires = mysql_fetch_assoc($jug_contradictoires);
$totalRows_jug_contradictoires = mysql_num_rows($jug_contradictoires);

mysql_select_db($database_jursta, $jursta);
$query_jugincompetence = "SELECT count(*) as jugincompetence FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (left(replace(role_general.date_creation,'-',''),6)='".$annee.$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Incompetence')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jugincompetence = mysql_query($query_jugincompetence, $jursta) or die(mysql_error());
$row_jugincompetence = mysql_fetch_assoc($jugincompetence);
$totalRows_jugincompetence = mysql_num_rows($jugincompetence);

mysql_select_db($database_jursta, $jursta);
$query_jugradiatiation = "SELECT count(*) as jugradiatiation FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (left(replace(role_general.date_creation,'-',''),6)='".$annee.$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Radiation')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jugradiatiation = mysql_query($query_jugradiatiation, $jursta) or die(mysql_error());
$row_jugradiatiation = mysql_fetch_assoc($jugradiatiation);
$totalRows_jugradiatiation = mysql_num_rows($jugradiatiation);

mysql_select_db($database_jursta, $jursta);
$query_jugdefaut = "SELECT count(*) as jugdefaut FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (left(replace(role_general.date_creation,'-',''),6)='".$annee.$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Defaut')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jugdefaut = mysql_query($query_jugdefaut, $jursta) or die(mysql_error());
$row_jugdefaut = mysql_fetch_assoc($jugdefaut);
$totalRows_jugdefaut = mysql_num_rows($jugdefaut);
?>
                    <tr bgcolor="#EDF0F3">
                      <td align="center" bgcolor="#EDF0F3" class="Style22"><?php echo $row_liste_nature['id_categorieaffaire']; ?></td>
                      <td class="Style22"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
                      <td align="center" class="Style22 Style22 Style22"><?php echo $row_affairesprecedent['affairesprecedent']; ?></td>
                      <td align="center" class="Style22 Style22 Style22"><?php echo $row_affairesenrolees['affairesenrolees']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_demandeaccepte['demandeaccepte']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_demanderejete['demanderejete']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_jug_contradictoires['jugcontradictoires']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_jugincompetence['jugincompetence']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_jugradiatiation['jugradiatiation']; ?></td>
                      <td align="center" class="Style22"><?php echo $row_jugdefaut['jugdefaut']; ?></td>
                      <td align="center" class="Style22">0</td>
                      <td align="center" class="Style22">0</td>
                      <td align="center" class="Style22"><?php echo $row_liste_acte['nbacte']; ?></td>
                    </tr>
                    <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
                    <tr bgcolor="#677787">
                      <td colspan="13" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
                    </tr>
                  </table>
                  <table width="940" >
                    <tr>
                      <td align="right"><input type="submit" name="Submit3" value="Imprimer"></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          </td>
        </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($liste_nature);

mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);

mysql_free_result($liste_acte);

mysql_free_result($jug_contradictoires);

mysql_free_result($jugincompetence);

mysql_free_result($jugradiatiation);

mysql_free_result($jugdefaut);

mysql_free_result($demanderejete);

mysql_free_result($affairesprecedent);

mysql_free_result($affairesenrolees);
?>
