<?php require_once('Connections/jursta.php'); ?>

<?php include_once("fonctions/fonctions.php"); ?>
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

//-------------------------------------------------- SUPPRESSION ---------------------------------------------------------
if ((isset($_GET['noregpl'])) && ($_GET['noregpl'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_plaintes WHERE no_regplaintes=%s",
                       GetSQLValueString($_GET['noregpl'], "int"));

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

$maxRows_liste_plaintes = 30;
$pageNum_liste_plaintes = 0;
if (isset($_GET['pageNum_liste_plaintes'])) {
  $pageNum_liste_plaintes = $_GET['pageNum_liste_plaintes'];
}
$startRow_liste_plaintes = $pageNum_liste_plaintes * $maxRows_liste_plaintes;

mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc d, reg_plaintes_noms n WHERE (d.id_juridiction =".$row_select_juridic['id_juridiction'].") AND d.cles_pivot = n.cles_pivot GROUP BY n.cles_pivot ORDER BY d.date_creation DESC";
$query_limit_liste_plaintes = sprintf("%s LIMIT %d, %d", $query_liste_plaintes, $startRow_liste_plaintes, $maxRows_liste_plaintes);
$liste_plaintes = mysql_query($query_limit_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);

if (isset($_GET['totalRows_liste_plaintes'])) {
  $totalRows_liste_plaintes = $_GET['totalRows_liste_plaintes'];
} else {
  $all_liste_plaintes = mysql_query($query_liste_plaintes);
  $totalRows_liste_plaintes = mysql_num_rows($all_liste_plaintes);
}
$totalPages_liste_plaintes = ceil($totalRows_liste_plaintes/$maxRows_liste_plaintes)-1;

$queryString_liste_plaintes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_plaintes") == false && 
        stristr($param, "totalRows_liste_plaintes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_plaintes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_plaintes = sprintf("&totalRows_liste_plaintes=%d%s", $totalRows_liste_plaintes, $queryString_liste_plaintes);
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
    <td><?php require_once('menuidentity.php'); ?></td>
    <td bgcolor="#FFFF00">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center" valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td width="100%" valign="middle" bordercolor="#677787"><table width="100%" cellpadding="0" cellspacing="1" >
                        <tr>
                          <td nowrap bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                              <a href="#" onClick="javascript:ouvre_popup('add_regplaintes_page1.php',690,700)"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0">
                              <?php } else {?>
                              </a> <img src="images/edit.png" width="32" height="32" border="0">
                              <?php } ?></td>
                          <td width="100%" align="left" bgcolor="#174F8A"><span class="Style2">Le registre des plaintes </span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <?php if ($totalRows_liste_plaintes > 0) { // Show if recordset not empty ?>
                  <tr>
                    <td valign="middle"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                              <tr bgcolor="#677787" class="Style3">
                                <td align="center">#</td>
                                <td align="center">N&deg; d'ordre</td>
                                <td align="center">1&egrave;re Autorit&eacute; Saisie </td>
                                <td align="center">Redacteur et date du 1er PV de la plainte</td>
                                <td>Nom et pr&eacute;noms et domicile des inculp&eacute;s</td>
                                <td align="center">Date d'entr&eacute;e au parquet </td>
                                <td>Nature date et lieu de l'infraction</td>
                                <td>Suite donn&eacute;e &agrave; l'affaire </td>
                                <td>Motif du classement </td>
                                <td>Observations</td>
                                <td>Op&eacute;rations</td>
                              </tr>
                              <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_plaintes*$pageNum_liste_plaintes;
		?>
                              <?php do { ?>
                              <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                              <tr bgcolor="<?php echo $tabcolor ?>" class="Style11">
                                <td align="center" valign="middle"><?php echo $row_liste_plaintes['no_regplaintes']; ?></td>
                                <td align="center" valign="middle"><?php echo $row_liste_plaintes['nodordre_plaintes']; ?></td>
                                <td align="center" valign="middle"><?php echo $row_liste_plaintes['Pautosaisi_plaintes']; ?></td>
                                <td align="center" valign="middle"><?php echo $row_liste_plaintes['Red_plaintes']; ?><span class="Style22"><br>
                                    </span><?php echo Change_formatDate($row_liste_plaintes['PVdat_plaintes']); ?></td>
                                <td valign="middle">
                                <?php 
								
								
								$tablo[] = listerNoms($row_liste_plaintes['cles_pivot']);
								
								foreach ($tablo as $elem)
								{
									foreach ($elem as $el)
									{
										echo $el;
										echo "<br /><br />";
									}
								}
								
								?>
                                </td>
                                <td align="center" valign="middle"><?php echo Change_formatDate($row_liste_plaintes['dateparquet_plaintes']); ?></td>
                                <td valign="middle"><?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?><br>
                                  le <?php echo Change_formatDate($row_liste_plaintes['DatInfraction_plaintes']); ?><br>
                                  &agrave; <?php echo $row_liste_plaintes['LieuInfraction_plaintes']; ?></td>
                                <td valign="middle"><?php echo $row_liste_plaintes['suite_plaintes']; ?></td>
                                <td valign="middle"><?php echo $row_liste_plaintes['MotifClass_plaintes']; ?></td>
                                <td valign="middle"><?php echo $row_liste_plaintes['observations_plaintes']; ?></td>
                                <td valign="middle"><table width="72" height="33" >
                                    <tr align="center" class="Style16">
                                      <td><?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                          <a href="#" onClick="javascript:ouvre_popup('visual_regplaintes.php?noregpl=<?php echo $row_liste_plaintes['no_regplaintes']; ?>',670,560)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                          <?php } ?></td>
                                      <td><?php if ($row_select_admin['modifier_admin']==1) { ?>
                                          <a href="#" onClick="javascript:ouvre_popup('modif_regplaintes_page.php?noregpl=<?php echo $row_liste_plaintes['no_regplaintes']; ?>',670,700)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/rename.png" title="Modifier" width="28">
                                          <?php } ?></td>
                                      <td><?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                          <a href="liste_regplaintes.php?noregpl=<?php echo $row_liste_plaintes['no_regplaintes']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/cancel.png" title="Supprimer" width="28">
                                          <?php } ?></td>
                                    </tr>
                                </table></td>
                              </tr>
                              <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
                          </table></td>
                        </tr>
                      </table>
                        <br>
                        <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                          <tr class="Style22">
                            <td><a href="<?php printf("%s?pageNum_liste_plaintes=%d%s", $currentPage, max(0, $pageNum_liste_plaintes - 1), $queryString_liste_plaintes); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                            <td><a href="<?php printf("%s?pageNum_liste_plaintes=%d%s", $currentPage, min($totalPages_liste_plaintes, $pageNum_liste_plaintes + 1), $queryString_liste_plaintes); ?>"><strong>Suivant&raquo;</strong></a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><strong>Page</strong></td>
                            <td><strong><?php echo $pageNum_liste_plaintes+1 ?>/<?php echo $totalPages_liste_plaintes+1; ?></strong></td>
                            <td>&nbsp;</td>
                            <td><strong>Enrg de <?php echo $startRow_liste_plaintes+1; ?> &agrave; 30 </strong></td>
                            <td><strong>Total </strong></td>
                            <td><strong><?php echo $totalRows_liste_plaintes ?> </strong></td>
                          </tr>
                      </table></td>
                  </tr>
                  <?php } // Show if recordset not empty ?>
                  <?php if ($totalRows_liste_plaintes == 0) { // Show if recordset empty ?>
                  <tr>
                    <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                  </tr>
                  <?php } // Show if recordset empty ?>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
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

mysql_free_result($liste_plaintes);

mysql_free_result($liste_repacc);
?>
