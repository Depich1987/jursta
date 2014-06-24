<?php require_once('Connections/jursta.php'); ?>
<?php require_once('fonctions/fonctions.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['norex'])) && ($_GET['norex'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_execpeine WHERE id_execpeine=%s",
                       GetSQLValueString($_GET['norex'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_execpeine (nodordre_execpeine, peine_execpeine, situation_execpeine, datemdpot_execpeine, datgrosse_execpeine, dateperson_execpeine, datetrxprison_execpeine, datetrxtresor_execpeine, datetrxcasier, datenvoipolice, datarrestation, sursisarrestation, sursiaexecution, causesretard, datexpirpeine, observation, no_repjugementcorr, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nodordre_execpeine'], "text"),
                       GetSQLValueString($_POST['peine_execpeine'], "text"),
                       GetSQLValueString($_POST['situation_execpeine'], "text"),
                       GetSQLValueString(Change_formatDate($_POST['datemdpot_execpeine']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datgrosse_execpeine']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['dateperson_execpeine']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datetrxprison_execpeine']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datetrxtresor_execpeine']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datetrxcasier']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datenvoipolice']), "date"),
                       GetSQLValueString(Change_formatDate($_POST['datarrestation']), "date"),
                       GetSQLValueString($_POST['sursisarrestation'], "text"),
                       GetSQLValueString($_POST['sursiaexecution'], "text"),
                       GetSQLValueString($_POST['causesretard'], "text"),
                       GetSQLValueString(Change_formatDate($_POST['datexpirpeine']), "date"),
                       GetSQLValueString($_POST['observation'], "text"),
                       GetSQLValueString($_POST['no_repjugementcorr'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());

  $insertGoTo = "liste_regpeine.php";
  /*
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  */
  header(sprintf("Location: %s", $insertGoTo));
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le paramètres donné--------------------------

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = '%s') AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", $colname_select_juridic);
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

if ($_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";

if (isset($_POST['nodordre_plaintes'])) {
  $colname_select_nodossier = $_POST['nodordre_plaintes'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_plaintes_desc WHERE nodordre_plaintes = %s", GetSQLValueString($colname_select_nodossier, "text"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);

mysql_select_db($database_jursta, $jursta);
$query_liste_idnom = "SELECT * FROM reg_plaintes_desc d, rep_jugementcorr j WHERE ((d.no_regplaintes=j.no_regplaintes) AND (j.id_juridiction ='".$row_select_juridic['id_juridiction']."') AND (d.nodordre_plaintes='".$row_select_nodossier['nodordre_plaintes']."')) ORDER BY j.date_creation DESC";
$liste_idnom = mysql_query($query_liste_idnom, $jursta) or die(mysql_error()); 
$row_liste_idnom = mysql_fetch_assoc($liste_idnom);
$totalRows_liste_idnom = mysql_num_rows($liste_idnom);

}
$maxRows_liste_regpeine = 30;
$pageNum_liste_regpeine = 0;
if (isset($_GET['pageNum_liste_regpeine'])) {
  $pageNum_liste_regpeine = $_GET['pageNum_liste_regpeine'];
}
$startRow_liste_regpeine = $pageNum_liste_regpeine * $maxRows_liste_regpeine;

mysql_select_db($database_jursta, $jursta);
$query_liste_regpeine = "SELECT * FROM reg_plaintes_desc d, rep_jugementcorr j, reg_execpeine e WHERE ((d.no_regplaintes=j.no_regplaintes) AND (j.no_repjugementcorr=e.no_repjugementcorr) AND (e.id_juridiction ='".$row_select_juridic['id_juridiction']."')) ORDER BY nodordre_execpeine DESC";
$query_limit_liste_regpeine = sprintf("%s LIMIT %d, %d", $query_liste_regpeine, $startRow_liste_regpeine, $maxRows_liste_regpeine);
$liste_regpeine = mysql_query($query_limit_liste_regpeine, $jursta) or die(mysql_error());
$row_liste_regpeine = mysql_fetch_assoc($liste_regpeine);

if (isset($_GET['totalRows_liste_regpeine'])) {
  $totalRows_liste_regpeine = $_GET['totalRows_liste_regpeine'];
} else {

  $all_liste_regpeine = mysql_query($query_liste_regpeine);
  $totalRows_liste_regpeine = mysql_num_rows($all_liste_regpeine);
}
$totalPages_liste_regpeine = ceil($totalRows_liste_regpeine/$maxRows_liste_regpeine)-1;
$queryString_liste_regpeine = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_regpeine") == false && 
        stristr($param, "totalRows_liste_regpeine") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_regpeine = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_regpeine = sprintf("&totalRows_liste_regpeine=%d%s", $totalRows_liste_regpeine, $queryString_liste_regpeine);
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
	$( "#datepicker2" ).datepicker();
	$( "#datepicker3" ).datepicker();
	$( "#datepicker4" ).datepicker();
	$( "#datepicker5" ).datepicker();
	$( "#datepicker6" ).datepicker();
	$( "#datepicke7" ).datepicker();
	$( "#datepicker8" ).datepicker();
  });
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_regpeine.php");
</script>
<?php
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/index_01.gif);
	background-repeat: repeat-x;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style></head>

<body>
<table width="100%"  align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td>&nbsp;</td>
    <td><?php require_once('haut.php'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td bgcolor="#6186AF">&nbsp;</td>
    <td><?php require_once('menuhaut.php'); ?></td>
    <td bgcolor="#6186AF">&nbsp;</td>
  </tr>
  <tr align="center">
    <td bgcolor="#FFFF00">&nbsp;</td>
    <td><?php require_once('menuidentity.php'); ?></td>
    <td bgcolor="#FFFF00">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center" valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
               <?php if ((!isset($_GET['act'])) || ($_GET['act']!="1")) {	?>
              <div id="listeregistre" style=" visibility:visible; display:block"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td width="100%" valign="middle"><table width="100%" >
                        <tr>
                          <td bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                            <a href="liste_regpeine.php?act=1" ><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                            <?php } else {?>
                              <img src="images/edit.png" width="32" height="32" border="0">
                              <?php } ?></td>
                          <td width="100%" align="left" bgcolor="#174F8A"><span class="Style2">Le registre d'ex&eacute;cution des peines</span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <?php if ($totalRows_liste_regpeine > 0) { // Show if recordset not empty ?>
                  <tr>
                    <td valign="middle"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                              <tr bgcolor="#677787" class="Style3">
                                <td rowspan="2">#</td>
                                <td colspan="2"><span class="Style10">Num&eacute;ros</span></td>
                                <td rowspan="2"><span class="Style10">Nom, pr&eacute;noms, &acirc;ges et <br>domiciles des condamn&eacute;s</span></td>
                                <td rowspan="2"><span class="Style10">Peine prononc&eacute;e</span></td>
                                <td rowspan="2"><span class="Style10">Nature du d&eacute;lit <br>ou de la <br>contravention</span></td>
                                <td rowspan="2"><span class="Style10">Date <br>du jugement</span></td>
                                <td rowspan="2"><span class="Style10">Situation au moment du jugement <br>date mandat de d&eacute;p&ocirc;t</span></td>
                                <td rowspan="2"><span class="Style10">Jugement <br>contradictoire</span></td>
                                <td colspan="2"><span class="Style10">Jugement par d&eacute;faut</span></td>
                                <td colspan="2">Date transmission extrait</td>
                                <td rowspan="2"><span class="Style10">Date de transmission des casiers judiciaires</span></td>
                                <td rowspan="2"><span class="Style10">Invitation &agrave; se constituer<br> date de l'envoi &agrave; la police ou &agrave; la gendarmerie</span></td>
                                <td rowspan="2"><span class="Style10">Date de l'arrestation</span></td>
                                <td rowspan="2"><span class="Style10">Sursis de l'arrestation</span></td>
                                <td rowspan="2"><span class="Style10">Sursis &agrave; ex&eacute;cution</span></td>
                                <td rowspan="2"><span class="Style10">Causes qui retardent l'ex&eacute;cution</span></td>
                                <td rowspan="2"><span class="Style10">Date de <br>l'expiration de la peine</span></td>
                                <td rowspan="2" ><span class="Style10">Observation </span></td>
                                <td rowspan="2">Op&eacute;rations</td>
                              </tr>
                              <tr bgcolor="#677787" class="Style3">
                                <td>D'ordre</td>
                                <td>Du parquet</td>
                                <td>Date remise <br>de la grosse <br>pour <br>signification</td>
                                <td>Date <br>signification &agrave; personne &agrave; <br>domicile ou <br>au parquet</td>
                                <td>Prison</td>
                                <td>Tr&eacute;sor</td>
                              </tr>
                              <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_regpeine*$pageNum_liste_regpeine;
		?>
                              <?php do { ?>

<?php
mysql_select_db($database_jursta, $jursta);
$query_liste_idnom = "SELECT * FROM reg_plaintes_desc d, rep_jugementcorr j WHERE ((d.no_regplaintes=j.no_regplaintes) AND (j.id_juridiction ='".$row_select_juridic['id_juridiction']."') AND (d.nodordre_plaintes='".$row_liste_regpeine['nodordre_plaintes']."')) ORDER BY j.date_creation DESC";
$liste_idnom = mysql_query($query_liste_idnom, $jursta) or die(mysql_error()); 
$row_liste_idnom = mysql_fetch_assoc($liste_idnom);
$totalRows_liste_idnom = mysql_num_rows($liste_idnom);

mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_noms n WHERE (n.id_noms IN (".$row_liste_idnom['id_noms']."))";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);
$nature = $row_liste_plaintes['NatInfraction_plaintes']; 
?>
                              <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                              <tr bgcolor="<?php echo $tabcolor ?>" class="Style11">
                                <td align="center" valign="middle" class="Style15"><strong><?php echo $i ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['nodordre_plaintes']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['nojugement_repjugementcorr']; ?></strong></td>
                                <td valign="middle" ><table border="0" align="center" cellpadding="5" cellspacing="1" class="Style11">
                                  <?php do { ?>
                                  <tr>
                                    <td nowrap scope="col"><strong><?php echo $row_liste_plaintes['NomPreDomInculpes_plaintes']; ?>-<?php echo $row_liste_plaintes['age']; ?>ans - <?php echo $row_liste_plaintes['Domicile']; ?>-(<?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?>)</strong></td>
                                    </tr>
                                  <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
                                </table></td>
                                <td valign="middle" ><strong><?php echo $row_liste_regpeine['peine_execpeine']; ?></strong></td>
                                <td valign="middle" ><strong><?php echo $nature; ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datejugement_repjugementcorr']); ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['situation_execpeine']; ?><?php if (($row_liste_regpeine['situation_execpeine']!='') && ($row_liste_regpeine['datemdpot_execpeine']!='')) { ?><br><?php } ?><?php echo Change_formatDate($row_liste_regpeine['datemdpot_execpeine']); ?></strong></td>
                                <td valign="middle">&nbsp;</td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datgrosse_execpeine']); ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['dateperson_execpeine']); ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datetrxprison_execpeine']); ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datetrxtresor_execpeine']); ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datetrxcasier']); ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datenvoipolice']); ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datarrestation']); ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['sursisarrestation']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['sursiaexecution']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['causesretard']; ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_regpeine['datexpirpeine']); ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_regpeine['observation']; ?></strong></td>
                                <td valign="middle" class="Style14"><table width="72" height="33" >
                                    <tr align="center" class="Style16">
                                      <td><strong>
                                        <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                          <a href="#" onClick="javascript:ouvre_popup('visual_regpeine.php?norex=<?php echo $row_liste_regpeine['id_execpeine']; ?>',480,425)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/mark.png" title="Visualiser" width="28">
                                          <?php } ?>
                                      </strong></td>
                                      <td><strong>
                                        <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                          <a href="#" onClick="javascript:ouvre_popup('modif_regpeine.php?norex=<?php echo $row_liste_regpeine['id_execpeine']; ?>',500,560)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/rename.png" title="Modifier" width="28">
                                          <?php } ?>
                                      </strong></td>
                                      <td><strong>
                                        <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                          <a href="liste_regpeine.php?norex=<?php echo $row_liste_regpeine['id_execpeine']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/cancel.png" title="Supprimer" width="28">
                                          <?php } ?>
                                      </strong></td>
                                    </tr>
                                </table></td>
                              </tr>
                              <?php } while ($row_liste_regpeine = mysql_fetch_assoc($liste_regpeine)); ?>
                          </table></td>
                        </tr>
                      </table>
                        <br>
                        <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                          <tr class="Style14">
                            <td><a href="<?php printf("%s?pageNum_liste_regpeine=%d%s", $currentPage, max(0, $pageNum_liste_regpeine - 1), $queryString_liste_regpeine); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                            <td><a href="<?php printf("%s?pageNum_liste_regpeine=%d%s", $currentPage, min($totalPages_liste_regpeine, $pageNum_liste_regpeine + 1), $queryString_liste_regpeine); ?>"><strong>Suivant&raquo;</strong></a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><strong>Page</strong></td>
                            <td><strong><?php echo $pageNum_liste_regpeine+1 ?>/<?php echo $totalPages_liste_regpeine+1; ?></strong></td>
                            <td>&nbsp;</td>
                            <td><strong>Enrg de <?php echo $startRow_liste_regpeine+1; ?> &agrave; 30 </strong></td>
                            <td><strong>Total </strong></td>
                            <td><strong><?php echo $totalRows_liste_regpeine ?> </strong></td>
                          </tr>
                      </table></td>
                  </tr>
                  <?php } // Show if recordset not empty ?>
                  <?php if ($totalRows_liste_regpeine == 0) { // Show if recordset empty ?>
                  <tr>
                    <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                  </tr>
                  <?php } // Show if recordset empty ?>
              </table></div>
              <?php } ?>
              </td>
            </tr>
        </table></td>
      </tr>
    </table>
 <?php if ($_GET['act']=="1"){	?>
	      <div id="add_regpeine"><table width="480" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" bgcolor="#FFFFFF" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" nowrap class="Style2"><p>Le r&eacute;pertoire des jugements correctionnels  - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="right" valign="top" bgcolor="#FFFFFF"  class="Style10"><form action="liste_regpeine.php?act=1" method="post" name="form1" id="form1">
                  <table width="100%" border="0" cellpadding="5" cellspacing="1">
                    <tr>
                      <td width="40%" align="right" valign="top" bgcolor="#6186AF"  class="Style10">N&deg; Dossier : </td>
                      <td width="21%" bgcolor="#6186AF"><input name="nodordre_plaintes" type="text" id="nodordre_plaintes" value="<?php echo $row_select_nodossier['nodordre_plaintes']; ?>" size="15"></td>
                      <td width="39%" bgcolor="#6186AF"><input type="submit" name="Afficher" value="Afficher"></td>
                    </tr>
<?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>                    
                    <tr align="center">
                      <td colspan="3" valign="top" bgcolor="#6186AF"  class="Style23">Aucun N&deg; de dossier ne correspond</td>
                    </tr>
<?php } ?>
                  </table>
              </form></td>
            </tr>
            <tr>
              <td width="100%" align="right" valign="top"  class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
              <?php if ($totalRows_liste_idnom > 0) { // Show if recordset not empty ?>
              <?php
mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_noms n WHERE (n.id_noms IN (".$row_liste_idnom['id_noms']."))";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);
?>                <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
                  <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="5">
              <tr>
                <td colspan="5" align="center" valign="top"  class="Style10"><table width="100%" border="0" cellpadding="5" cellspacing="1">			
<?php
mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_noms n WHERE (n.id_noms IN (".$row_liste_idnom['id_noms']."))";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);
?>
                    <tr>
                      <td align="center" valign="top"  bgcolor="#6186AF" class="Style10">Nom des parties / Nature du d&eacute;lit ou de la contravention:</td>
                      </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#6186AF"  class="Style10"><table border="0" align="center" cellpadding="5" cellspacing="1" class="Style10">
                <?php do { ?>
                  <tr bgcolor="#FFFFFF">
                    <td scope="col"><img src="images/contentheading.png" width="14" height="14"></td>
                    <td scope="col"><?php echo $row_liste_plaintes['NomPreDomInculpes_plaintes']; ?></td>
<td scope="col"><?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?></td>
                  </tr>
                  <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
              </table></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td align="right" valign="top"  class="Style10"><span class="Style10">N&deg; d'ordre </span> : </td>
                <td colspan="4"><input name="nodordre_execpeine" type="text" id="nojugement_repjugementsuppcorrl" size="20"></td>
                </tr>
              <tr>
                <td align="right" valign="top"  class="Style10"><span class="Style10">Peine prononc&eacute;e</span> : </td>
                <td colspan="4"><textarea name="peine_execpeine" cols="45" id="peine_execpeine"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="top"  class="Style10"><span class="Style10">Situation au<br> moment du jugement</span> :</td>
                <td><input name="situation_execpeine" type="text" id="situation_execpeine" value="" size="20"></td>
                <td align="right" valign="top"  class="Style10">Date mandat <br>de d&eacute;p&ocirc;t:</td>
                <td><input name="datemdpot_execpeine" type="text" id="datepicker" size="10" value="<?php echo date("d/m/Y"); ?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top"  class="Style10"><span class="Style10">Jugement <br>contradictoire</span> :</td>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5" align="center" valign="top"  bgcolor="#CCCCCC" class="Style10">Jugement par d&eacute;faut</td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Date remise de la grosse pour signification :</td>
                <td align="left" valign="middle" class="Style10"><input name="datgrosse_execpeine" type="text" id="datepicker1" size="10"></td>
                <td align="right" valign="middle" nowrap class="Style10">Date signification<br> 
                  &agrave; personne &agrave;<br> 
                  domicile /parquet :</td>
                <td colspan="2" align="left" valign="middle" ><input name="dateperson_execpeine" type="text" id="datepicker2" size="10"></td>
              </tr>
              <tr>
                <td colspan="5" align="center" valign="middle"  bgcolor="#CCCCCC" class="Style10">Date transmission extrait</td>
                </tr>
              <tr>
                <td align="right" valign="middle"  class="Style10">Prison :</td>
                <td align="left" valign="middle" class="Style10"><input name="datetrxprison_execpeine" type="text" id="datepicker3" size="10"></td>
                <td align="right" valign="middle" class="Style10">Tr&eacute;sor :</td>
                <td colspan="2" align="left" valign="middle" class="Style10"><input name="datetrxtresor_execpeine" type="text" id="datepicker4" size="10"></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Date de transmission des casiers judiciaires :</td>
                <td><input name="datetrxcasier" type="text" id="datepicker5" size="10"></td>
                <td align="right" valign="middle" class="Style10">date de l'envoi &agrave; la police ou a la gendarmerie :</td>
                <td colspan="2"><input name="datenvoipolice" type="text" id="datepicker6" size="10"></td>
                </tr>
              <tr>
                <td align="right" valign="top" class="Style10">Date de l'arrestation :</td>
                <td><input name="datarrestation" type="text" id="datepicker7" size="10"></td>
                <td align="right" valign="top" class="Style10">Sursis de l'arrestation :</td>
                <td colspan="2"><input name="sursisarrestation" type="text" id="sursisarrestation" size="25"></td>
                </tr>
              <tr>
                <td align="right" valign="top" class="Style10">Sursis &agrave; ex&eacute;cution :</td>
                <td><textarea name="sursiaexecution" cols="20" rows="3" id="sursiaexecution"></textarea></td>
                <td align="right" valign="top" class="Style10">Causes qui retardent l'ex&eacute;cution :</td>
                <td colspan="2"><textarea name="causesretard" cols="30" rows="3" id="causesretard"></textarea></td>
                </tr>
              <tr>
                <td align="right" valign="top" class="Style10">Date de l'expiration <br>de la peine :</td>
                <td colspan="4"><input name="datexpirpeine" type="text" id="datepicker8" size="10"></td>
              </tr>
              <tr>
                <td align="right" valign="top"  class="Style10"><span class="Style10">Observation </span> : </td>
                <td colspan="4"><textarea name="observation" cols="45" rows="5" id="observation"></textarea></td>
              </tr>
              <tr>
                <td ><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                  <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>">
                    <input name="no_repjugementcorr" type="hidden" id="no_repjugementcorr" value="<?php echo $row_liste_idnom['no_repjugementcorr']; ?>"></td>
                <td colspan="4"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
              </tr>
          </table></td>
        </tr>
      </table>
                  <input type="hidden" name="MM_insert" value="form2">
                </form>
                <?php } // Show if recordset not empty ?>
<?php } // Show if recordset not empty ?>
<?php if (($_POST['Afficher']!="") &&($totalRows_liste_idnom == 0)){ // Show if recordset is empty ?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr class="Style28">
    <th scope="col"  style="color:#FF0" >Ce dossier n'est pas encore passé en jugement. </th>
  </tr>
</table>
<?php } // Show if recordset is empty ?>
               </td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
      </div> <?php	} 	?></td>
    <td width="50%" align="center" valign="top" background="images/continue.jpg">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($select_admin);

mysql_free_result($liste_regpeine);

mysql_free_result($select_nodossier);

mysql_free_result($liste_plaintes);

?>
