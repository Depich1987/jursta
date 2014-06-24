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


$currentPage = $_SERVER["PHP_SELF"];

//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['idrca'])) && ($_GET['idrca'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_cabin WHERE id_regcabin=%s",
                       GetSQLValueString($_GET['idrca'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le paramètres donné--------------------------

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = '%s') AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", $colname_select_juridic);
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

$maxRows_liste_cabin = 30;
$pageNum_liste_cabin = 0;
if (isset($_GET['pageNum_liste_cabin'])) {
  $pageNum_liste_cabin = $_GET['pageNum_liste_cabin'];
}
$startRow_liste_cabin = $pageNum_liste_cabin * $maxRows_liste_cabin;

mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc  ORDER BY date_creation ASC";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);


mysql_select_db($database_jursta, $jursta);
$query_liste_cabin = "SELECT * FROM reg_cabin, rep_jugementcorr, reg_plaintes_desc WHERE ((reg_plaintes_desc.no_regplaintes=rep_jugementcorr.no_regplaintes) AND (rep_jugementcorr.no_repjugementcorr=reg_cabin.no_repjugementcorr)AND (reg_cabin.id_juridiction =".$row_select_juridic['id_juridiction'].")) ORDER BY id_regcabin DESC";
$query_limit_liste_cabin = sprintf("%s LIMIT %d, %d", $query_liste_cabin, $startRow_liste_cabin, $maxRows_liste_cabin);
$liste_cabin = mysql_query($query_limit_liste_cabin, $jursta) or die(mysql_error());
$row_liste_cabin = mysql_fetch_assoc($liste_cabin);

if (isset($_GET['totalRows_liste_cabin'])) {
  $totalRows_liste_cabin = $_GET['totalRows_liste_cabin'];
} else {
  $all_liste_cabin = mysql_query($query_liste_cabin);
  $totalRows_liste_cabin = mysql_num_rows($all_liste_cabin);
}
$totalPages_liste_cabin = ceil($totalRows_liste_cabin/$maxRows_liste_cabin)-1;
$queryString_liste_cabin = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_cabin") == false && 
        stristr($param, "totalRows_liste_cabin") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_cabin = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_cabin = sprintf("&totalRows_liste_cabin=%d%s", $totalRows_liste_cabin, $queryString_liste_cabin);
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
  </script><style type="text/css">
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
    <td><?php require_once('menuidentity.php'); ?>
    </td>
    <td bgcolor="#FFFF00">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center" valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td bgcolor="#174F8A" class="Style28"><table width="100%" cellpadding="2" cellspacing="1" >
                        <tr bgcolor="#FFFFFF">
                          <td width="5%" nowrap bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                              <a href="#" onClick="javascript:ouvre_popup('add_regcabin.php',620,620)"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                              <?php } else {?>
                              <img src="images/edit.png" width="32" height="32" border="0">
                              <?php } ?></td>
                          <td width="60%" align="left" bgcolor="#174F8A"><div align="left"><span class="Style2">Registre du service des activit&eacute;s du Cabinet d'Instruction</span></div></td>
                          <td width="35%" align="right" bgcolor="#174F8A"><span class="Style2">rechercher :</span> <input name="search_txt" type="text" class="Style30" id="search_txt" onKeyUp="getBlock('wrdkey='+this.value,'listedossiersearch','liste_cabin.php')"/></td>
                          </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><div id="listedossiersearch"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                              <?php if ($totalRows_liste_cabin > 0) { // Show if recordset not empty ?>
                              <tr>
                                <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                          <tr bgcolor="#677787" class="Style3">
                                            <td rowspan="2">#</td>
                                            <td colspan="2" align="center"><span class="Style11">N&deg; d'ordre : </span></td>
                                            <td rowspan="2"><span class="Style11">Nom et Pr&eacute;noms des parties / Nature de l'affaire</span></td>
                                            <td colspan="2">Dates</td>
                                            <td colspan="2" rowspan="2" align="center" nowrap>Date des actes /Nature des actes</td>
                                            <td colspan="2">Ordonnances de cl&ocirc;tures</td>
                                            <td rowspan="2">Observation</td>
                                            <td rowspan="2">Op&eacute;rations</td>
                                          </tr>
                                          <tr bgcolor="#677787" class="Style3">
                                            <td align="center">Du cabinet d'instruction</td>
                                            <td align="center">Du parquet</td>
                                            <td><span class="Style11">du fait</span></td>
                                            <td><span class="Style11">du r&eacute;quisitoire introductif</span></td>
                                            <td>Date</td>
                                            <td>D&eacute;cision</td>
                                          </tr>
                                          <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_cabin*$pageNum_liste_cabin;
		?>
                                          <?php do { ?>
     <?php                              
mysql_select_db($database_jursta, $jursta);
$query_listenomplainte_plainte = "SELECT * FROM reg_plaintes_noms WHERE cles_pivot = '".$row_liste_plaintes['cles_pivot']."'";
$listenomplainte_plainte = mysql_query($query_listenomplainte_plainte, $jursta) or die(mysql_error());
$row_listenomplainte_plainte = mysql_fetch_assoc($listenomplainte_plainte);
$totalRows_listenomplainte_plainte = mysql_num_rows($listenomplainte_plainte);                              
 ?>
 <?php
mysql_select_db($database_jursta, $jursta);
$query_liste_acte = "SELECT * FROM acte_regcabin WHERE id_regcabin= '".$row_liste_cabin['id_regcabin']."' ORDER BY acte_regcabin.date_acteregcabin DESC";
$liste_acte = mysql_query($query_liste_acte, $jursta) or die(mysql_error());
$row_liste_acte = mysql_fetch_assoc($liste_acte);
$totalRows_liste_acte = mysql_num_rows($liste_acte);
?>
										  <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                          <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                            <td align="center" valign="middle" class="Style11"><strong><?php echo $i ?></strong></td>
                                            <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_cabin['numodre_regcabin']; ?></strong></td>
                                            <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_cabin['nojugement_repjugementcorr']; ?></strong></td>
                                            <td valign="middle" nowrap class="Style11">

                                            <table border="0" cellpadding="3" cellspacing="1" class="Style10">
                                              <?php do { ?>
                                              <tr>
                                                <td scope="col"><strong><?php echo $row_listenomplainte_plainte['NomPreDomInculpes_plaintes']; ?></strong></td>
                                                <td scope="col"><strong><?php echo $row_listenomplainte_plainte['NatInfraction_plaintes']; ?></strong></td>
                                              </tr>
                                              <?php } while ($row_listenomplainte_plainte = mysql_fetch_assoc($liste_plaintes)); ?>
                                            </table></td>
                                            <td valign="middle" nowrap class="Style11"><strong><?php echo Change_formatDate($row_liste_cabin['datefait']); ?></strong></td>
                                            <td colspan="2" valign="middle" nowrap class="Style11"><strong><?php echo Change_formatDate($row_liste_cabin['daterequisitoire']); ?></strong></td>
                                            <td valign="middle" class="Style11"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                              <?php do { ?>
                                                <tr>
                                                  <td scope="col"><strong><?php echo Change_formatDate($row_liste_acte['date_acteregcabin']); ?></strong></td>
                                                  <td scope="col"><strong><?php echo $row_liste_acte['nature_acteregcabin']; ?></strong></td>
                                                </tr>
                                                <?php } while ($row_liste_acte = mysql_fetch_assoc($liste_acte)); ?>
                                            </table></td>
                                            <td valign="middle" class="Style11"><strong><?php echo Change_formatDate($row_liste_cabin['datordcloture']); ?></strong></td>
                                            <td valign="middle" class="Style11"><strong><?php echo $row_liste_cabin['decisionord']; ?></strong></td>
                                            <td valign="middle" class="Style11"><strong><?php echo $row_liste_cabin['observation']; ?></strong></td>
                                            <td valign="middle"><table >
                                                <tr align="center" class="Style16">
                                                  <td nowrap><strong>
                                                    <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                      <a href="#" onClick="javascript:ouvre_popup('visual_regcabin.php?idrca=<?php echo $row_liste_cabin['id_regcabin']; ?>',470,500)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                      <?php } else {?>
                                                    <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                                      <?php } ?>
                                                  </strong></td>
                                                  <td nowrap><strong>
                                                    <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                      <a href="#" onClick="javascript:ouvre_popup('modif_regcabin.php?idrca=<?php echo $row_liste_cabin['id_regcabin']; ?>',520,590)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                      <?php } else {?>
                                                      <img src="images/rename.png" title="Modifier" width="28">
                                                      <?php } ?>
                                                  </strong></td>
                                                  <td nowrap><strong>
                                                    <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                      <a href="liste_regcabin.php?idrca=<?php echo $row_liste_cabin['id_regcabin']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                      <?php } else {?>
                                                      <img src="images/cancel.png" title="Supprimer" width="28">
                                                      <?php } ?>
                                                  </strong></td>
                                                  <td nowrap><strong>
                                                    <?php if ($row_select_admin['ajouter_admin']==1) { ?>
                                                    <a href="#" onClick="javascript:ouvre_popup('acte_regcabin.php?idrca=<?php echo $row_liste_cabin['id_regcabin']; ?>',600,310)"><img src="images/acte.png" width="32" height="32" border="0"></a>
                              <?php } else {?>
                              <img src="images/acte_f2.png" width="32" height="32" border="0">
                              <?php } ?>
                                                  </strong></td>
                                                  <div id="ordonnace" style="display:none"><td style="display:none" nowrap><strong>
                                                    <?php if ($row_select_admin['ajouter_admin']==1) { ?>
                                                    <a href="#" onClick="javascript:ouvre_popup('ordonnance_regcabin.php?idrca=<?php echo $row_liste_cabin['id_regcabin']; ?>',480,610)"><img src="images/ordonance.png" width="32" height="32" border="0"></a>
                              <?php } else {?>
                              <img src="images/ordonance_f2.png" width="32" height="32" border="0">
                              <?php } ?>
                                                  </strong></td>
                                                  </div>
                                                </tr>
                                            </table></td>
                                          </tr>
                                          <?php } while ($row_liste_cabin = mysql_fetch_assoc($liste_cabin)); ?>
                                      </table></td>
                                    </tr>
                                  </table>
                                    <br>
                                    <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                      <tr class="Style14">
                                        <td><a href="<?php printf("%s?pageNum_liste_cabin=%d%s", $currentPage, max(0, $pageNum_liste_cabin - 1), $queryString_liste_cabin); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                        <td><a href="<?php printf("%s?pageNum_liste_cabin=%d%s", $currentPage, min($totalPages_liste_cabin, $pageNum_liste_cabin + 1), $queryString_liste_cabin); ?>"><strong>Suivant&raquo;</strong></a></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><strong>Page</strong></td>
                                        <td><strong><?php echo $pageNum_liste_cabin+1 ?>/<?php echo $totalPages_liste_cabin+1; ?></strong></td>
                                        <td>&nbsp;</td>
                                        <td><strong>Enrg de <?php echo $startRow_liste_cabin+1; ?> &agrave; 30 </strong></td>
                                        <td><strong>Total </strong></td>
                                        <td><strong><?php echo $totalRows_liste_cabin ?> </strong></td>
                                      </tr>
                                  </table></td>
                              </tr>
                              <?php } // Show if recordset not empty ?>
                              <?php if ($totalRows_liste_cabin == 0) { // Show if recordset empty ?>
                              <tr>
<td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                              </tr>
                              <?php } // Show if recordset empty ?>
                          </table></td>
                        </tr>
                    </table></div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table>
    </td>
    <td width="50%" align="center" valign="top" background="images/continue.jpg">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
<?php

mysql_free_result($liste_cabin);

mysql_free_result($liste_acte);

mysql_free_result($select_admin);

mysql_free_result($liste_plaintes);
?>
