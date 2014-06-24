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
</head>

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
    <td>
<?php
function Change_formatDate($datedeb, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $datedeb);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $datedeb);
}
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
	$t1 = $row_liste_ville['surface_dortoire']; 
	$t2 = $row_liste_ville['surface_dortoire']/9; 
	$t3 = $row_liste_ville['surface_dortoire']/5; 
	$t4 = $row_liste_ville['surface_dortoire']/2.5; 
}


$datedebut=$_POST['annee_du']."-".$_POST['mois_du']."-".$_POST['jour_du'];
$datefin=$_POST['annee_au']."-".$_POST['mois_au']."-".$_POST['jour_au'];

$_SESSION['datedebut']=$datedebut;
$_SESSION['datefin']=$datefin;
$datedeb=Change_formatDate($_SESSION['datedebut']);
$datef=Change_formatDate($_SESSION['datefin']);

?>    
    <table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td width="100%" valign="middle" >
                <table width="100%" >
                  <tr>
                    <td colspan="2" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td valign="top"><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                    <td width="100%" align="left"><span class="Style2">Les&nbsp;effectifs&nbsp;en&nbsp;fin&nbsp;du&nbsp;mois <?php echo ("P&eacute;riode du ".$datedeb." au ".$datef); ?>
                    </span> </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td align="center" valign="middle" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" align="center" ><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">                
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
              <table width="940" cellpadding="3" cellspacing="0" >
                <tr>
                  <td><table width="100%" cellpadding="3" cellspacing="0" >
                    <tr>
                      <td width="200" bgcolor="#6186AF" class="Style3"><div align="center">Les effectifs en fin du mois </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <table width="940" cellpadding="3" cellspacing="1" >
                <tr class="Style22">
                  <td colspan="2"></td>
                  <td align="center" bgcolor="#FFFFFF" class="Style15"><p></p></td>
                  <td colspan="3" align="center" valign="middle" bgcolor="#677787">
                  Les pr&eacute;venus </td>
                  <td colspan="3" align="center" valign="middle" bgcolor="#677787">Les condamn&eacute;s </td>
                  <td colspan="7" align="center" valign="middle" bgcolor="#677787" class="Style15">&nbsp;</td>
                </tr>
                <tr bgcolor="#6186AF" class="Style22">
                  <td align="center">#</td>
                  <td width="100%" align="center">Etablissement</td>
                  <td align="center"><div align="center">Surface Dortoire (m2) </div>                    <div align="center"></div></td>
                  <td align="center"><div align="center">Hommes</div></td>
                  <td align="center"><div align="center">Femmes</div></td>
                  <td align="center"> <div align="center">Mineurs</div></td>
                  <td align="center"> <div align="center">Hommes</div></td>
                  <td align="center"><p align="center">Femmes</p></td>
                  <td align="center">Mineurs</td>
                  <td align="center"> <div align="center">C.P.C</div>                    </td>
                  <td align="center">Total</td>
                  <td align="center">Capacit&eacute; accueil 9m2 par d&eacute;t. </td>
                  <td align="center">Capacit&eacute; accueil 5m2 par d&eacute;t. </td>
                  <td align="center">Capacit&eacute; accueil 2.5 m2 par d&eacute;t. </td>
                  <td align="center">D&eacute;tention pr&eacute;v. % </td>
                  <td align="center">Dur&eacute;e moyenne D&eacute;t. pr&eacute;v. </td>
                </tr>
                 <?php $h=0; ?>               
                <?php do { ?>
				<?php $h++;	
				
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
$query_liste_detenue = "SELECT count(*) as listedetenuM FROM reg_controlnum, administrateurs WHERE ((administrateurs.Id_admin=reg_controlnum.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (reg_controlnum.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_controlnum.sexe_regcontrolnum='Masculin'))";
$liste_detenue = mysql_query($query_liste_detenue, $jursta) or die(mysql_error());
$row_liste_detenue = mysql_fetch_assoc($liste_detenue); 
$totalRows_liste_detenue = mysql_num_rows($liste_detenue);

mysql_select_db($database_jursta, $jursta);
$query_listecondamne = "SELECT count(*) as listecondamneM FROM reg_ecrou,reg_controlnum, administrateurs WHERE ((administrateurs.Id_admin=reg_ecrou.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (reg_ecrou.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_ecrou.no_regcontrolnum=reg_controlnum.no_regcontrolnum) AND (reg_controlnum.sexe_regcontrolnum='Masculin'))";
$listecondamne = mysql_query($query_listecondamne, $jursta) or die(mysql_error());
$row_listecondamne = mysql_fetch_assoc($listecondamne);
$totalRows_listecondamne = mysql_num_rows($listecondamne);

mysql_select_db($database_jursta, $jursta);
$query_liste_detenueF = "SELECT count(*) as listedetenuF FROM reg_controlnum, administrateurs WHERE ((administrateurs.Id_admin=reg_controlnum.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (reg_controlnum.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_controlnum.sexe_regcontrolnum='Feminin'))";
$liste_detenueF = mysql_query($query_liste_detenueF, $jursta) or die(mysql_error());
$row_liste_detenueF = mysql_fetch_assoc($liste_detenueF); 
$totalRows_liste_detenueF = mysql_num_rows($liste_detenueF);

mysql_select_db($database_jursta, $jursta);
$query_listecondamneF = "SELECT count(*) as listecondamneF FROM reg_ecrou,reg_controlnum, administrateurs WHERE ((administrateurs.Id_admin=reg_ecrou.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (reg_ecrou.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (reg_ecrou.no_regcontrolnum=reg_controlnum.no_regcontrolnum) AND (reg_controlnum.sexe_regcontrolnum='Feminin'))";
$listecondamneF = mysql_query($query_listecondamneF, $jursta) or die(mysql_error());
$row_listecondamneF = mysql_fetch_assoc($listecondamneF); $row_listecondamneF['listecondamneF'];
$totalRows_listecondamneF = mysql_num_rows($listecondamneF);
?>
                
                  <tr bgcolor="#EDF0F3" class="Style22">
                    <td align="center" bgcolor="#EDF0F3" class="Style22"><?php echo $h; ?></td>
                    <td nowrap class="Style10"><?php echo $row_liste_ville['lib_penitentier']; ?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_liste_ville['surface_dortoire']; ?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_liste_detenue['listedetenuM'];?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_liste_detenueF['listedetenuF'];?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10">0</td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_listecondamne['listecondamneM'];?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_listecondamneF['listecondamneF'];?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10">0</td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10">0</td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo ($row_listecondamne['listecondamneM'] + $row_liste_detenue['listedetenuM'] + $row_listecondamneF['listecondamneF'] + $row_liste_detenueF['listedetenuF']);?> </td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo round($row_liste_ville['surface_dortoire']/9,2); ?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_liste_ville['surface_dortoire']/5; ?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10"><?php echo $row_liste_ville['surface_dortoire']/2.5; ?></td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10">0</td>
                    <td align="center" bgcolor="#EDF0F3" class="Style10">0</td>
                  </tr>
                  <?php } while ($row_liste_ville = mysql_fetch_assoc($liste_ville)); ?>
<tr bgcolor="#677787" class="Style11">
  <td align="center" class="Style22">&nbsp;</td>
                  <td class="Style10"><strong>Total</strong></td>
                  <td align="center" class="Style10"><?php echo $t1; ?></td>
                  <td align="center" class="Style10"><strong><?php echo $row_liste_detenue['listedetenuM'];?></strong></td>
                  <td align="center" class="Style10"><strong><?php echo $row_liste_detenueF['listedetenuF'];?></strong></td>
                  <td align="center" class="Style10"><strong>0</strong></td>
                  <td align="center" class="Style10"><strong><?php echo $row_listecondamne['listecondamneM'];?></strong></td>
                  <td align="center" class="Style10"><strong><?php echo $row_listecondamneF['listecondamneF'];?></strong></td>
                  <td align="center" class="Style10"><strong>0</strong></td>
                  <td align="center" class="Style10"><strong>0</strong></td>
                  <td align="center" class="Style10"><strong><?php echo ($row_listecondamne['listecondamneM'] + $row_liste_detenue['listedetenuM'] + $row_listecondamneF['listecondamneF'] + $row_liste_detenueF['listedetenuF']);?></strong></td>
                  <td align="center" class="Style10"><strong><?php echo round($t2,2); ?></strong></td>
                  <td align="center" class="Style10"><strong><?php echo $t3; ?></strong></td>
                  <td align="center" class="Style10"><strong><?php echo $t4; ?></strong></td>
                  <td align="center" class="Style10"><strong>0</strong></td>
                  <td align="center" class="Style10"><strong>0</strong></td>
                </tr>				
                <tr bgcolor="#677787">
                  <td colspan="16" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
                </tr>
              </table>              </td>
        </tr>
      </table>
                <?php } ?></td>
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
mysql_free_result($liste_ville);

mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);

mysql_free_result($liste_detenue);

mysql_free_result($listecondamne);
?>
