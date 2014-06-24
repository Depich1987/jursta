<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Sociale,Administrateur,Superviseur,AdminCivil";
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

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Sociale'";
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
  $colname_liste_juridiction = $_POST['id_typejuridiction'];
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", GetSQLValueString($colname_liste_juridiction, "int"));
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);

$datedebut=$_POST['annee_du']."-".$_POST['mois_du']."-".$_POST['jour_du'];
$datefin=$_POST['annee_au']."-".$_POST['mois_au']."-".$_POST['jour_au'];

$_SESSION['id_juridiction']=$_POST['id_juridiction'];
$_SESSION['datedebut']=$datedebut;
$_SESSION['datefin']=$datefin;
$datedeb=Change_formatDate($_SESSION['datedebut']);
$datef=Change_formatDate($_SESSION['datefin']);

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
          <td bgcolor="#FFFFFF">
            <table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                      <td width="100%" align="center"><p class="Style2">FICHE STATISTIQUE DES AFFAIRES SOCIALES
                            <?php echo("P&eacute;riode du ".$datedeb." au ".$datef); ?>
                         </p>
                      </td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" >
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">                
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
                        <option value="-1" <?php if (!(strcmp(-1, $_POST['id_juridiction']))) {echo "selected=\"selected\"";} ?>>Selectionner...</option>
                        <?php
do {  
?><option value="<?php echo $row_liste_juridiction['id_juridiction']?>"<?php if (!(strcmp($row_liste_juridiction['id_juridiction'], $_POST['id_juridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_liste_juridiction['lib_juridiction']?></option>
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
<table width="940" cellpadding="2" cellspacing="1" >
  <tr>
    <td colspan="4"><?php echo Change_formatDate($query_affairesenrolees); ?></td>
    <td colspan="7" align="center" bgcolor="#677787" class="Style15"><table width="100%"  border="0" cellspacing="0" cellpadding="8">
      <tr>
        <td align="center" class="Style11">JUGEMENTS RENDUS </td>
      </tr>
    </table></td>
  </tr>
  <tr class="Style15">
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2" align="center" bgcolor="#6186AF" class="Style11">Statuant sur la demande </td>
    <td colspan="2" align="center" bgcolor="#6186AF" class="Style11">Autres Jugements rendus </td>
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
    <td align="center"><div align="center"><strong>D&eacute;faut</strong></div></td>
    <td align="center" nowrap><p align="center"><strong>Affaire en<br>
      cours en<br>
      fin du mois </strong></p></td>
    <td align="center"><div align="center"><strong>Dur&eacute;e moy<br>
      affaire trait&eacute;e </strong></div></td>
    <td align="center"><p align="center"><strong>Nombre actes greffe </strong></p></td>
  </tr>
  <?php $h=0; ?>
  <?php do { ?>
  <?php
$h++;
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

mysql_select_db($database_jursta, $jursta);

$query_affairesenrolees = "SELECT count(*) as affairesenrolees FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND 
(rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie."))";
$affairesenrolees = mysql_query($query_affairesenrolees, $jursta) or die(mysql_error());
$row_affairesenrolees = mysql_fetch_assoc($affairesenrolees);
$totalRows_affairesenrolees = mysql_num_rows($affairesenrolees);


mysql_select_db($database_jursta, $jursta);
$query_affairesprecedent = "SELECT count(*) as affairesprecedent FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (rg_social.date_creation< '".$datedebut."') AND (rg_social.id_categorieaffaire=".$categorie."))";
$affairesprecedent = mysql_query($query_affairesprecedent, $jursta) or die(mysql_error());
$row_affairesprecedent = mysql_fetch_assoc($affairesprecedent);
$totalRows_affairesprecedent = mysql_num_rows($affairesprecedent);


mysql_select_db($database_jursta, $jursta);
$query_liste_acte = "SELECT count(*) as nbacte FROM rep_actesnot, administrateurs WHERE ((administrateurs.Id_admin=rep_actesnot.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rep_actesnot.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_actesnot.id_categorieaffaire=".$categorie."))";
$liste_acte = mysql_query($query_liste_acte, $jursta) or die(mysql_error());
$row_liste_acte = mysql_fetch_assoc($liste_acte);
$totalRows_liste_acte = mysql_num_rows($liste_acte);


mysql_select_db($database_jursta, $jursta);
$query_liste_actecc = "SELECT count(*) as nbactecc FROM rep_actesacc, administrateurs WHERE ((administrateurs.Id_admin=rep_actesacc.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rep_actesacc.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_actesacc.id_categorieaffaire=".$categorie."))";
$liste_actecc = mysql_query($query_liste_actecc, $jursta) or die(mysql_error());
$row_liste_actecc = mysql_fetch_assoc($liste_actecc);
$totalRows_liste_actecc = mysql_num_rows($liste_actecc);


mysql_select_db($database_jursta, $jursta);
$query_demandeaccepte = "SELECT count(*) as demandeaccepte FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_decision.statut_decision='Acceptée')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$demandeaccepte = mysql_query($query_demandeaccepte, $jursta) or die(mysql_error());
$row_demandeaccepte = mysql_fetch_assoc($demandeaccepte);
$totalRows_demandeaccepte = mysql_num_rows($demandeaccepte);


mysql_select_db($database_jursta, $jursta);
$query_demanderejete = "SELECT count(*) as demanderejete FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_decision.statut_decision='Rejet&eacute;e')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$demanderejete = mysql_query($query_demanderejete, $jursta) or die(mysql_error());
$row_demanderejete = mysql_fetch_assoc($demanderejete);
$totalRows_demanderejete = mysql_num_rows($demanderejete);

mysql_select_db($database_jursta, $jursta);
$query_jug_contradictoires = "SELECT count(*) as jugcontradictoires FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_decision.dispositif_decision='Contradictoire')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$jug_contradictoires = mysql_query($query_jug_contradictoires, $jursta) or die(mysql_error());
$row_jug_contradictoires = mysql_fetch_assoc($jug_contradictoires);
$totalRows_jug_contradictoires = mysql_num_rows($jug_contradictoires);

mysql_select_db($database_jursta, $jursta);
$query_jugdefaut = "SELECT count(*) as jugdefaut FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_decision.dispositif_decision='Defaut')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$jugdefaut = mysql_query($query_jugdefaut, $jursta) or die(mysql_error());
$row_jugdefaut = mysql_fetch_assoc($jugdefaut);
$totalRows_jugdefaut = mysql_num_rows($jugdefaut);

mysql_select_db($database_jursta, $jursta);
$query_total_affairesprecedent = "SELECT count(*) as affairesprecedent FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (rg_social.date_creation< '".$datedebut."'))";
$total_affairesprecedent = mysql_query($query_total_affairesprecedent, $jursta) or die(mysql_error());
$row_total_affairesprecedent = mysql_fetch_assoc($total_affairesprecedent);
$totalRows_total_affairesprecedent = mysql_num_rows($total_affairesprecedent);

mysql_select_db($database_jursta, $jursta);
$query_total_affairesenrolees = "SELECT count(*) as affairesenrolees FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') )";
$total_affairesenrolees = mysql_query($query_total_affairesenrolees, $jursta) or die(mysql_error());
$row_total_affairesenrolees = mysql_fetch_assoc($total_affairesenrolees);
$totalRows_total_affairesenrolees = mysql_num_rows($total_affairesenrolees);

mysql_select_db($database_jursta, $jursta);
$query_total_demandeaccepte = "SELECT count(*) as demandeaccepte FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_decision.statut_decision='Accept&eacute;e')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$total_demandeaccepte = mysql_query($query_total_demandeaccepte, $jursta) or die(mysql_error());
$row_total_demandeaccepte = mysql_fetch_assoc($total_demandeaccepte);
$totalRows_total_demandeaccepte = mysql_num_rows($total_demandeaccepte);

mysql_select_db($database_jursta, $jursta);
$query_total_demanderejete = "SELECT count(*) as demanderejete FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_decision.statut_decision='Rejet&eacute;e')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$total_demanderejete = mysql_query($query_total_demanderejete, $jursta) or die(mysql_error());
$row_total_demanderejete = mysql_fetch_assoc($total_demanderejete);
$totalRows_total_demanderejete = mysql_num_rows($total_demanderejete);

mysql_select_db($database_jursta, $jursta);
$query_total_jugcontradictoires = "SELECT count(*) as jugcontradictoires FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_decision.dispositif_decision='Contradictoire')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$total_jugcontradictoires = mysql_query($query_total_jugcontradictoires, $jursta) or die(mysql_error());
$row_total_jugcontradictoires = mysql_fetch_assoc($total_jugcontradictoires);
$totalRows_total_jugcontradictoires = mysql_num_rows($total_jugcontradictoires);

mysql_select_db($database_jursta, $jursta);
$query_total_jugdefaut = "SELECT count(*) as jugdefaut FROM administrateurs, rep_decision, rg_social WHERE ((administrateurs.Id_admin=rep_decision.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."')  AND (rep_decision.dispositif_decision='Defaut')  AND (rg_social.no_rgsocial=rep_decision.no_rgsocial))";
$total_jugdefaut = mysql_query($query_total_jugdefaut, $jursta) or die(mysql_error());
$row_total_jugdefaut = mysql_fetch_assoc($total_jugdefaut);
$totalRows_total_jugdefaut = mysql_num_rows($total_jugdefaut);

mysql_select_db($database_jursta, $jursta);
$query_total_nbactecc = "SELECT count(*) as nbactecc FROM rep_actesacc, administrateurs WHERE ((administrateurs.Id_admin=rep_actesacc.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rep_actesacc.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_nbactecc = mysql_query($query_total_nbactecc, $jursta) or die(mysql_error());
$row_total_nbactecc = mysql_fetch_assoc($total_nbactecc);
$totalRows_total_nbactecc = mysql_num_rows($total_nbactecc);

mysql_select_db($database_jursta, $jursta);
$query_dure_moyenne = "select avg (a.duree) as moy, count(*) as nobre from ( SELECT ifnull(datediff(rg_social.dateaudience_rgsocial,rg_social.date_rgsocial),0) AS duree FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rg_social.dateaudience_rgsocial<> '0000-00-00 00:00:00'))) a LIMIT 0 , 30";
$dure_moyenne = mysql_query($query_dure_moyenne, $jursta) or die(mysql_error());
$row_dure_moyenne = mysql_fetch_assoc($dure_moyenne);
$totalRows_dure_moyenne = mysql_num_rows($dure_moyenne);


?>
<?php
$moyenne=0;
while ($myrow = mysql_fetch_array($dure_moyenne)) 
{
$moyenne +=$myrow['moy'];   
echo $moyenne;
}

?>
  <tr bgcolor="#EDF0F3">
    <td align="center" bgcolor="#EDF0F3" class="Style22"><?php echo $h; ?></td>
    <td class="Style22"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
    <td align="center" class="Style22 Style22 Style22"><?php echo $row_affairesprecedent['affairesprecedent']; ?></td>
    <td align="center" class="Style22 Style22 Style22"><?php echo $row_affairesenrolees['affairesenrolees']; ?></td>
    <td align="center" class="Style22"><?php echo $row_demandeaccepte['demandeaccepte']; ?></td>
    <td align="center" class="Style22"><?php echo $row_demanderejete['demanderejete']; ?></td>
    <td align="center" class="Style22"><?php echo $row_jug_contradictoires['jugcontradictoires']; ?></td>
    <td align="center" class="Style22"><?php echo $row_jugdefaut['jugdefaut']; ?></td>
    <td align="center" class="Style22"><?php echo Change_formatDate($row_affairesprecedent['affairesprecedent']+$row_affairesenrolees['affairesenrolees']-($row_jug_contradictoires['jugcontradictoires']+$row_jugdefaut['jugdefaut'])); //+$row_jugincompetence['jugincompetence']+$row_jugradiatiation['jugradiatiation']+$row_demandeaccepte['demandeaccepte']+$row_demanderejete['demanderejete']?></td>
    <td align="center" class="Style22"><?php echo round($row_dure_moyenne['moy']/30,2); ?></td>
    <td align="center" class="Style22"><?php echo $row_liste_acte['nbacte']+$row_liste_actecc['nbactecc']; ?></td>
  </tr>
  <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
  <tr align="center" bgcolor="#677787" class="Style11">
    <td colspan="2" class="Style22"><strong>Total</strong></td>
    <td class="Style22"><strong><?php echo $row_total_affairesprecedent['affairesprecedent']; ?></strong></td>
    <td class="Style22"><strong><?php echo $row_total_affairesenrolees['affairesenrolees']; ?></strong></td>
    <td class="Style22"><strong><?php echo $row_total_demandeaccepte['demandeaccepte']; ?></strong></td>
    <td class="Style22"><strong><?php echo $row_total_demanderejete['demanderejete']; ?></strong></td>
    <td class="Style22"><strong><?php echo $row_total_jugcontradictoires['jugcontradictoires']; ?></strong></td>
    <td class="Style22"><strong><?php echo $row_total_jugdefaut['jugdefaut']; ?></strong></td>
    <td class="Style22"><strong><?php echo Change_formatDate($row_total_affairesprecedent['affairesprecedent']+$row_total_affairesenrolees['affairesenrolees']-($row_total_jugcontradictoires['jugcontradictoires']+$row_total_jugdefaut['jugdefaut'])); //+$row_total_jugincompetence['jugincompetence']+$row_total_jugradiatiation['jugradiatiation']+$row_demandeaccepte['demandeaccepte']+$row_demanderejete['demanderejete']?></strong></td>
    <td class="Style22"><strong>0</strong></td>
    <td class="Style22"><strong>0</strong></td>
  </tr>
  <tr bgcolor="#677787">
    <td colspan="11" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<form action="statistiquesocialpdf.php" method="post" name="form2" id="form2">
  <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
  <input name="id_typejuridiction" type="hidden" id="id_typejuridiction" value="<?php echo $_POST['id_typejuridiction']; ?>">
  <?php if (($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))){ ?>
  <input type="hidden" name="id_juridiction" id="id_juridiction" value="<?php echo $_POST['id_juridiction']; ?>">
  <?php } ?>
  <?php } // Show if recordset empty ?>
          <input type="hidden" name="jour_du" id="jour_du" value="<?php echo $_POST['jour_du']; ?>">
          <input type="hidden" name="mois_du" id="mois_du" value="<?php echo $_POST['mois_du']; ?>">
          <input type="hidden" name="annee_du" id="annee_du" value="<?php echo $_POST['annee_du']; ?>">
          <input type="hidden" name="jour_au" id="jour_au" value="<?php echo $_POST['jour_au']; ?>">
          <input type="hidden" name="mois_au" id="mois_au" value="<?php echo $_POST['mois_au']; ?>">
          <input type="hidden" name="annee_au" id="annee_au" value="<?php echo $_POST['annee_au']; ?>"> 
  <table width="940" ><tr><td align="right"><table width="940" >
    <tr>
      <td align="right"><input type="submit" name="Submit3" value="Imprimer"></td>
    </tr>
  </table></td>
                    </tr>
</table>
</form>				  
<?php } ?>                  
                </td>
              </tr>
            </table>
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

mysql_free_result($affairesprecedent);

mysql_free_result($total_affairprecedente);

mysql_free_result($totaldemanderejete);

mysql_free_result($totalaffairesenrolees);

mysql_free_result($totaldemandeaccepte);

mysql_free_result($Total_jugcontradictoires);

mysql_free_result($total_jugincompetence);

mysql_free_result($total_jugradiatiation);

mysql_free_result($total_jugdefaut);

mysql_free_result($total_affairesenrolees);

mysql_free_result($total_affairesprecedent);

mysql_free_result($total_nbacte);

mysql_free_result($select_nactcc);

mysql_free_result($liste_actecc);

mysql_free_result($affairesenrolees);

mysql_free_result($demanderejete);

mysql_free_result($liste_acte);

mysql_free_result($jugdefaut);

mysql_free_result($jugradiatiation);

mysql_free_result($jugincompetence);

mysql_free_result($jug_contradictoires);

mysql_free_result($demandeaccepte);
?>
