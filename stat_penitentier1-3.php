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
function Change_formatDate($datedeb, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $datedeb);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $datedeb);
}
?>
<?php /*
mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Penale'";
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

mysql_select_db($database_jursta, $jursta);
$query_liste_ville = "SELECT distinct commune.lib_commune FROM commune ORDER BY commune.lib_commune";
$liste_ville = mysql_query($query_liste_ville, $jursta) or die(mysql_error());
$row_liste_ville = mysql_fetch_assoc($liste_ville);
$totalRows_liste_ville = mysql_num_rows($liste_ville);
*/
?>

<?php
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty 
	mysql_select_db($database_jursta, $jursta);
$query_liste_typejuridiction = "SELECT * FROM type_juridiction WHERE (id_typejuridiction <> 5) ORDER BY lib_typejuridiction ASC";
$liste_typejuridiction = mysql_query($query_liste_typejuridiction, $jursta) or die(mysql_error());
$row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
$totalRows_liste_typejuridiction = mysql_num_rows($liste_typejuridiction);

	$colname_liste_juridiction = "-1";
if (isset($_POST['id_typejuridiction'])) {
  $colname_liste_juridiction = $_POST['id_typejuridiction'];
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", GetSQLValueString($colname_liste_juridiction, "int"));
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);
}

if ((isset($_POST['Afficher_cmd'])) && ($_POST['Afficher_cmd']=="Afficher")){ 
	mysql_select_db($database_jursta, $jursta);
	$idjuridiction=$_POST['id_juridiction'];
	if ($row_select_juridiction['id_juridiction']!=55) $idjuridiction=$row_select_juridiction['id_juridiction'];
	if ($idjuridiction==0) {	
		$query_liste_ville = "SELECT * FROM penitentier ORDER BY lib_penitentier ASC";
	}
	else {
		$query_liste_ville = "SELECT * FROM penitentier WHERE id_juridiction =".$idjuridiction.";";
	}
	$liste_ville = mysql_query($query_liste_ville, $jursta) or die(mysql_error());
	$row_liste_ville = mysql_fetch_assoc($liste_ville);
	$totalRows_liste_ville = mysql_num_rows($liste_ville);
}

$datedebut=$_POST['annee_du']."-".$_POST['mois_du']."-".$_POST['jour_du'];
$datefin=$_POST['annee_au']."-".$_POST['mois_au']."-".$_POST['jour_au'];

$_SESSION['datedebut']=$datedebut;
$_SESSION['datefin']=$datefin;
$datedeb=Change_formatDate($_SESSION['datedebut']);
$datef=Change_formatDate($_SESSION['datefin']);

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
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td width="100%" valign="middle" >
                <table width="100%" >
                  <tr>
                    <td valign="top">&nbsp;</td>
                    <td align="right"><span class="Style2"><a href="stat_penitentier1-1.php">Page 1</a></span> - <span class="Style2"><a href="stat_penitentier1-2.php">Page 2</a></span> -<span class="Style2"> <a href="stat_penitentier1-3.php">Page 3</a></span></td>
                  </tr>
                  <tr>
                    <td valign="top"><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                    <td width="100%" align="left"><span class="Style2">Etats&nbsp;des&nbsp;d&eacute;tenus&nbsp;au&nbsp;titre&nbsp;du&nbsp;mois
                      <?php if ((isset($_POST['mois'])) && (isset($_POST['annee']))) echo("de ".$_POST['mois']."/".$_POST['annee']) ?>
                    </span> </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td align="center" valign="middle" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" align="center" ><form name="form1" method="post" action="stat_penitentier1-3.php">
            <table align="center" cellpadding="3" cellspacing="0" >
              <tr bgcolor="#EDF0F3" class="Style22">
                <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
                <td align="right" nowrap>Type de juridiction : </td>
                <td nowrap><select name="id_typejuridiction" id="id_typejuridiction" onChange="document.form1.submit();">
                  <option value="-1" <?php if (!(strcmp(-1, $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>>Selectionner... </option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_liste_typejuridiction['id_typejuridiction']?>"<?php if (!(strcmp($row_liste_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_liste_typejuridiction['lib_typejuridiction']?></option>
                  <?php
} while ($row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction));
  $rows = mysql_num_rows($liste_typejuridiction);
  if($rows > 0) {
      mysql_data_seek($liste_typejuridiction, 0);
	  $row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
  }
?>
                </select></td>
                <?php if (($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))){ ?>
                <td align="center" nowrap>Juridiction : </td>
                <td nowrap><select name="id_juridiction" id="id_juridiction" onChange="document.form1.submit();">
                  <option value="0" <?php if (!(strcmp(0, $_POST['id_juridiction']))) {echo "selected=\"selected\"";} ?>>Tous</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_liste_juridiction['id_juridiction']?>"<?php if (!(strcmp($row_liste_juridiction['id_juridiction'], $_POST['id_juridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_liste_juridiction['lib_juridiction']?></option>
                  <?php
} while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction));
  $rows = mysql_num_rows($liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($liste_juridiction, 0);
	  $row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
  }
?>
                </select></td>
                <?php } ?>
                <?php } // Show if recordset empty ?>
                <?php if ((($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))) || ($row_select_juridiction['id_juridiction'] != 55)){ ?>
                <td align="right" nowrap><table  border="0" cellpadding="5" cellspacing="1">
                  <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
                  <?php } // Show if recordset empty ?>
                  <tr>
                    <td align="right" nowrap="nowrap" class="Style10">Du :</td>
                    <td nowrap="nowrap"><select name="jour_du" id="jour_du">
                      <option value="01" <?php if (!(strcmp(01, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>01</option>
                      <option value="02" <?php if (!(strcmp(02, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>02</option>
                      <option value="03" <?php if (!(strcmp(03, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>03</option>
                      <option value="04" <?php if (!(strcmp(04, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>04</option>
                      <option value="05" <?php if (!(strcmp(05, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>05</option>
                      <option value="06" <?php if (!(strcmp(06, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>06</option>
                      <option value="07" <?php if (!(strcmp(07, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>07</option>
                      <option value="08" <?php if (!(strcmp(08, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>08</option>
                      <option value="09" <?php if (!(strcmp(09, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>09</option>
                      <option value="10" <?php if (!(strcmp(10, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>10</option>
                      <option value="11" <?php if (!(strcmp(11, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>11</option>
                      <option value="12" <?php if (!(strcmp(12, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>12</option>
                      <option value="13" <?php if (!(strcmp(13, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>13</option>
                      <option value="14" <?php if (!(strcmp(14, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>14</option>
                      <option value="15" <?php if (!(strcmp(15, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>15</option>
                      <option value="16" <?php if (!(strcmp(16, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>16</option>
                      <option value="17" <?php if (!(strcmp(17, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>17</option>
                      <option value="18" <?php if (!(strcmp(18, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>18</option>
                      <option value="19" <?php if (!(strcmp(19, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>19</option>
                      <option value="20" <?php if (!(strcmp(20, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>20</option>
                      <option value="21" <?php if (!(strcmp(21, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>21</option>
                      <option value="22" <?php if (!(strcmp(22, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>22</option>
                      <option value="23" <?php if (!(strcmp(23, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>23</option>
                      <option value="24" <?php if (!(strcmp(24, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>24</option>
                      <option value="25" <?php if (!(strcmp(25, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>25</option>
                      <option value="26" <?php if (!(strcmp(26, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>26</option>
                      <option value="27" <?php if (!(strcmp(27, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>27</option>
                      <option value="28" <?php if (!(strcmp(28, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>28</option>
                      <option value="29" <?php if (!(strcmp(29, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>29</option>
                      <option value="30" <?php if (!(strcmp(30, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>30</option>
                      <option value="31" <?php if (!(strcmp(31, $_POST['jour_du']))) {echo "selected=\"selected\"";} ?>>31</option>
                    </select>
                      <select name="mois_du" id="mois_du">
                        <option value="01" <?php if (!(strcmp(01, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Janvier</option>
                        <option value="02" <?php if (!(strcmp(02, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>F&eacute;vrier</option>
                        <option value="03" <?php if (!(strcmp(03, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Mars</option>
                        <option value="04" <?php if (!(strcmp(04, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Avril</option>
                        <option value="05" <?php if (!(strcmp(05, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Mai</option>
                        <option value="06" <?php if (!(strcmp(06, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Juin</option>
                        <option value="07" <?php if (!(strcmp(07, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Juillet</option>
                        <option value="08" <?php if (!(strcmp(08, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Ao&ucirc;t</option>
                        <option value="09" <?php if (!(strcmp(09, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Septembre</option>
                        <option value="10" <?php if (!(strcmp(10, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Octobre</option>
                        <option value="11" <?php if (!(strcmp(11, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>Novembre</option>
                        <option value="12" <?php if (!(strcmp(12, $_POST['mois_du']))) {echo "selected=\"selected\"";} ?>>D&eacute;cembre</option>
                      </select>
                      <select name="annee_du" id="annee_du">
                        <option value="2011" <?php if (!(strcmp(2011, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2011</option>
                        <option value="2012" <?php if (!(strcmp(2012, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2012</option>
                        <option value="2013" <?php if (!(strcmp(2013, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2013</option>
                        <option value="2014" <?php if (!(strcmp(2014, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2014</option>
                        <option value="2015" <?php if (!(strcmp(2015, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2015</option>
                        <option value="2016" <?php if (!(strcmp(2016, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2016</option>
                        <option value="2017" <?php if (!(strcmp(2017, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2017</option>
                        <option value="2018" <?php if (!(strcmp(2018, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2018</option>
                        <option value="2019" <?php if (!(strcmp(2019, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2019</option>
                        <option value="2020" <?php if (!(strcmp(2020, $_POST['annee_du']))) {echo "selected=\"selected\"";} ?>>2020</option>
                      </select></td>
                    <td align="right" nowrap="nowrap" class="Style10">Au : </td>
                    <td colspan="8" nowrap="nowrap"><select name="jour_au" id="select14">
                      <option value="01" <?php if (!(strcmp(01, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>01</option>
                      <option value="02" <?php if (!(strcmp(02, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>02</option>
                      <option value="03" <?php if (!(strcmp(03, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>03</option>
                      <option value="04" <?php if (!(strcmp(04, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>04</option>
                      <option value="05" <?php if (!(strcmp(05, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>05</option>
                      <option value="06" <?php if (!(strcmp(06, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>06</option>
                      <option value="07" <?php if (!(strcmp(07, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>07</option>
                      <option value="08" <?php if (!(strcmp(08, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>08</option>
                      <option value="09" <?php if (!(strcmp(09, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>09</option>
                      <option value="10" <?php if (!(strcmp(10, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>10</option>
                      <option value="11" <?php if (!(strcmp(11, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>11</option>
                      <option value="12" <?php if (!(strcmp(12, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>12</option>
                      <option value="13" <?php if (!(strcmp(13, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>13</option>
                      <option value="14" <?php if (!(strcmp(14, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>14</option>
                      <option value="15" <?php if (!(strcmp(15, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>15</option>
                      <option value="16" <?php if (!(strcmp(16, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>16</option>
                      <option value="17" <?php if (!(strcmp(17, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>17</option>
                      <option value="18" <?php if (!(strcmp(18, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>18</option>
                      <option value="19" <?php if (!(strcmp(19, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>19</option>
                      <option value="20" <?php if (!(strcmp(20, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>20</option>
                      <option value="21" <?php if (!(strcmp(21, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>21</option>
                      <option value="22" <?php if (!(strcmp(22, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>22</option>
                      <option value="23" <?php if (!(strcmp(23, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>23</option>
                      <option value="24" <?php if (!(strcmp(24, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>24</option>
                      <option value="25" <?php if (!(strcmp(25, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>25</option>
                      <option value="26" <?php if (!(strcmp(26, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>26</option>
                      <option value="27" <?php if (!(strcmp(27, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>27</option>
                      <option value="28" <?php if (!(strcmp(28, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>28</option>
                      <option value="29" <?php if (!(strcmp(29, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>29</option>
                      <option value="30" <?php if (!(strcmp(30, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>30</option>
                      <option value="31" <?php if (!(strcmp(31, $_POST['jour_au']))) {echo "selected=\"selected\"";} ?>>31</option>
                    </select>
                      <select name="mois_au" id="select15">
                        <option value="01" <?php if (!(strcmp(01, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Janvier</option>
                        <option value="02" <?php if (!(strcmp(02, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>F&eacute;vrier</option>
                        <option value="03" <?php if (!(strcmp(03, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Mars</option>
                        <option value="04" <?php if (!(strcmp(04, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Avril</option>
                        <option value="05" <?php if (!(strcmp(05, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Mai</option>
                        <option value="06" <?php if (!(strcmp(06, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Juin</option>
                        <option value="07" <?php if (!(strcmp(07, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Juillet</option>
                        <option value="08" <?php if (!(strcmp(08, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Ao&ucirc;t</option>
                        <option value="09" <?php if (!(strcmp(09, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Septembre</option>
                        <option value="10" <?php if (!(strcmp(10, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Octobre</option>
                        <option value="11" <?php if (!(strcmp(11, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>Novembre</option>
                        <option value="12" <?php if (!(strcmp(12, $_POST['mois_au']))) {echo "selected=\"selected\"";} ?>>D&eacute;cembre</option>
                      </select>
                      <select name="annee_au" id="select16">
                        <option value="2011" <?php if (!(strcmp(2011, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2011</option>
                        <option value="2012" <?php if (!(strcmp(2012, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2012</option>
                        <option value="2013" <?php if (!(strcmp(2013, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2013</option>
                        <option value="2014" <?php if (!(strcmp(2014, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2014</option>
                        <option value="2015" <?php if (!(strcmp(2015, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2015</option>
                        <option value="2016" <?php if (!(strcmp(2016, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2016</option>
                        <option value="2017" <?php if (!(strcmp(2017, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2017</option>
                        <option value="2018" <?php if (!(strcmp(2018, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2018</option>
                        <option value="2019" <?php if (!(strcmp(2019, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2019</option>
                        <option value="2020" <?php if (!(strcmp(2020, $_POST['annee_au']))) {echo "selected=\"selected\"";} ?>>2020</option>
                      </select></td>
                  </tr>
                </table></td>
                <td width="100%" align="left" nowrap><input name="Afficher_cmd" type="submit" id="Afficher_cmd" value="Afficher"></td>
                <?php } ?>
              </tr>
            </table>
          </form>
              <?php if ((isset($_POST['Afficher_cmd'])) && ($_POST['Afficher_cmd']=="Afficher")){  ?>
              <table width="100%" cellpadding="3" cellspacing="0" >
                <tr>
                  <td><table width="100%" cellpadding="3" cellspacing="0" >
                    <tr>
                      <td bgcolor="#6186AF" class="Style3"><div align="center">MOUVEMENT DES DETENUS AU TITRE DU MOIS </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <table width="100%" cellpadding="3" cellspacing="1" >
                <tr bgcolor="#6186AF" class="Style11">
                  <td align="center" bgcolor="#6186AF"><strong>#</strong></td>
                  <td width="180" align="center"><strong>Listing des Etablissements</strong></td>
                  <td colspan="2" align="center" bgcolor="#6186AF">&nbsp;</td>
                </tr>
                <tr bgcolor="#EDF0F3" class="Style11">
                  <td valign="top" bgcolor="#EDF0F3" class="Style22"><table width="100%" cellpadding="0" cellspacing="0" class="Style15">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="180" valign="top">
					<iframe name="etablissement" id="etablissement" width="180" height="370" frameborder="0" scrolling="Auto" src="etablissement.php" allowtransparency="15%">iFrame non pris en compte par la version de votre navigateur veuillez mettre à jour votre navigateur. </iframe></td>
                  <td width="100%" valign="top" bgcolor="#FFFFFF"><table width="100%" cellpadding="3" cellspacing="1" >
                    <tr bgcolor="#6186AF" class="Style11">
                      <td colspan="2" align="center"><strong>Effectif du personnel</strong></td>
                    </tr>
                    <tr bgcolor="#EDF0F3" class="Style11">
                      <td align="right" valign="top" bgcolor="#FFFFFF"><table width="100%" cellpadding="2" cellspacing="2">
                          <tr align="center" bgcolor="#CCCCCC" class="Style11">
                            <td><strong>D&eacute;signation</strong></td>
                            <td><strong>Abr&eacute;viation</strong></td>
                            <td nowrap><strong>Eff. Id&eacute;al</strong></td>
                            <td nowrap><strong>Eff. actuel</strong></td>
                            <td nowrap><strong>Poste &agrave; Lib&eacute;rer<br>
            pour retraite</strong></td>
                            <td nowrap bgcolor="#CCCCCC" class="Style11"><strong>Poste &agrave; Lib&eacute;rer<br>
            pour Cause Temp.</strong></td>
                          </tr>
                          <tr align="center">
                            <td align="left" nowrap><strong>Regisseur des E.P</strong></td>
                            <td>REG</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>

                          <tr align="center" bgcolor="#EDF0F3">
                            <td align="left" nowrap><strong>Surveillant chef des E.P</strong></td>
                            <td>S/C</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
                          <tr align="center">
                            <td align="left" nowrap><strong>Surveillante chef des E/P</strong></td>
                            <td>STE/C</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
                          <tr align="center" bgcolor="#EDF0F3">
                            <td align="left" nowrap><strong>Surveillant des E/P</strong></td>
                            <td>S</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
                          <tr align="center">
                            <td align="left" nowrap><strong>Surveillante des E/P</strong>
                            <td>STE
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
                          <tr align="center" bgcolor="#EDF0F3">
                            <td align="left" nowrap><strong>Infirmer(e)</strong></td>
                            <td>INF</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
                          <tr align="center">
                            <td align="left" nowrap><strong>Medecin</strong></td>
                            <td>MED</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr bgcolor="#6186AF">
                      <td colspan="2" align="center" class="Style11"><strong>Statistiques des Pathologies en Milieu Carc&eacute;ral</strong></td>
                    </tr>
                    <tr bgcolor="#EDF0F3">
                      <td colspan="2" align="right" bgcolor="#EDF0F3"><table width="100%" cellpadding="2" cellspacing="2">
                          <tr align="center" bgcolor="#CCCCCC" class="Style11">
                            <td><strong>Pathologie</strong></td>
                            <td><strong>Nbre. Cas</strong></td>
                            <td nowrap><strong>Nbre. Hommes</strong></td>
                            <td nowrap><strong>Nbre.Femmes </strong></td>
                            <td nowrap><strong>Nbre Mineurs</strong></td>
                            <td nowrap bgcolor="#CCCCCC" class="Style11"><strong>Nbre. D&eacute;c&egrave;s</strong></td>
                          </tr>
                          <tr align="center" class="Style11">
                            <td align="left" nowrap class="Style11"><strong>HIV/SIDA</strong></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
				  <tr align="center" bgcolor="#FFFFFF" class="Style11">
                            <td align="left" nowrap class="Style11"><strong>CHOLERA</strong></td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                          </tr>
				  <tr align="center" class="Style11">
                            <td align="left" nowrap class="Style11"><strong>PALUDISME</strong></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
				  <tr align="center" bgcolor="#FFFFFF" class="Style11">
                            <td align="left" nowrap class="Style11"><strong>DROGUE</strong></td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                          </tr>
				  <tr align="center" class="Style11">
                            <td align="left" nowrap class="Style11"><strong>INTOXICATION</strong></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                          </tr>
				  <tr align="center" bgcolor="#FFFFFF" class="Style11">
                            <td align="left" nowrap class="Style11"><strong>FIEVRE TYPHOIDE</strong></td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                            <td bgcolor="#FFFFFF">0</td>
                          </tr>
				  </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr bgcolor="#677787">
                  <td colspan="7" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
                </tr>
              </table>
              </td>
        </tr>
      </table>                <?php } ?></td>
            </tr>
          </table></td>
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

mysql_free_result($liste_ville);
?>
