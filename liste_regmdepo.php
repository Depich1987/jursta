<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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
//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['noregma'])) && ($_GET['noregma'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_mdepot WHERE no_regmdepot=%s",
                       GetSQLValueString($_GET['noregma'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le paramètres donné--------------------------

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = '%s'", $colname_select_admin);
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


$maxRows_liste_regmdepo = 30;
$pageNum_liste_regmdepo = 0;
if (isset($_GET['pageNum_liste_regmdepo'])) {
  $pageNum_liste_regmdepo = $_GET['pageNum_liste_regmdepo'];
}
$startRow_liste_regmdepo = $pageNum_liste_regmdepo * $maxRows_liste_regmdepo;

mysql_select_db($database_jursta, $jursta);
$query_liste_regmdepo = "SELECT * FROM reg_mdepot WHERE (reg_mdepot.id_juridiction =".$row_select_juridic['id_juridiction'].") ORDER BY no_regmdepot DESC";
$query_limit_liste_regmdepo = sprintf("%s LIMIT %d, %d", $query_liste_regmdepo, $startRow_liste_regmdepo, $maxRows_liste_regmdepo);
$liste_regmdepo = mysql_query($query_limit_liste_regmdepo, $jursta) or die(mysql_error());
$row_liste_regmdepo = mysql_fetch_assoc($liste_regmdepo);

if (isset($_GET['totalRows_liste_regmdepo'])) {
  $totalRows_liste_regmdepo = $_GET['totalRows_liste_regmdepo'];
} else {
  $all_liste_regmdepo = mysql_query($query_liste_regmdepo);
  $totalRows_liste_regmdepo = mysql_num_rows($all_liste_regmdepo);
}
$totalPages_liste_regmdepo = ceil($totalRows_liste_regmdepo/$maxRows_liste_regmdepo)-1;

$queryString_liste_regmdepo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_regmdepo") == false && 
        stristr($param, "totalRows_liste_regmdepo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_regmdepo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_regmdepo = sprintf("&totalRows_liste_regmdepo=%d%s", $totalRows_liste_regmdepo, $queryString_liste_regmdepo);
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
    <td valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="100%" valign="middle"><table width="100%" >
            <tr>
              <td bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                  <a href="#" onClick="javascript:ouvre_popup('add_regmdepo.php',485,310)"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                <?php } else {?>
                <img src="images/edit.png" width="32" height="32" border="0">
                <?php } ?></td>
              <td width="100%" bgcolor="#174F8A"><span class="Style2">Le registre des Mandats de D&eacute;p&ocirc;ts </span></td>
            </tr>
        </table></td>
      </tr>
      <?php if ($totalRows_liste_regmdepo > 0) { // Show if recordset not empty ?>
      <tr>
        <td valign="middle"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                  <tr bgcolor="#677787" class="Style3">
                    <td width="16%">#</td>
                    <td width="16%"><span class=" Style11">N&deg; d'ordre </span></td>
                    <td width="8%"><span class=" Style11">Date</span></td>
                    <td width="8%" nowrap><span class=" Style11">Nom et pr&eacute;noms</span></td>
                    <td width="17%"><span class=" Style11">Nom du Magistrat </span></td>
                    <td width="15%"><span class="Style11">Infraction</span></td>
                    <td width="18%">Op&eacute;rations</td>
                  </tr>
                  <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_regmdepo*$pageNum_liste_regmdepo;
		?>
                  <?php do { ?>
                  <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                  <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                    <td align="center" valign="middle" class="Style15"><?php echo $i ?></td>
                    <td valign="middle" bgcolor="<?php echo $tabcolor ?>" class="Style11"><?php echo $row_liste_regmdepo['noordre_regmdepot']; ?></td>
                    <td valign="middle" nowrap bgcolor="<?php echo $tabcolor ?>" class="Style11"><?php echo Change_formatDate($row_liste_regmdepo['date_regmdepot']); ?></td>
                    <td valign="middle" nowrap bgcolor="<?php echo $tabcolor ?>" class="Style11"><?php echo $row_liste_regmdepo['nom_regmdepot']; ?></td>
                    <td valign="middle" nowrap bgcolor="<?php echo $tabcolor ?>" class="Style11"><?php echo $row_liste_regmdepo['magistra_regmdepot']; ?></td>
                    <td valign="middle" nowrap bgcolor="<?php echo $tabcolor ?>" class="Style11"><?php echo $row_liste_regmdepo['infraction_regmdepot']; ?></td>
                    <td valign="middle"><table width="72" height="33" >
                        <tr align="center" class="Style16">
                          <td><?php if ($row_select_admin['visualiser_admin']==1) { ?>
                              <a href="#" onClick="javascript:ouvre_popup('visual_regmdepo.php?noregma=<?php echo $row_liste_regmdepo['no_regmdepot']; ?>',480,380)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                              <?php } else {?>
                            <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                              <?php } ?></td>
                          <td><?php if ($row_select_admin['modifier_admin']==1) { ?>
                              <a href="#" onClick="javascript:ouvre_popup('modif_regmdepo.php?noregma=<?php echo $row_liste_regmdepo['no_regmdepot']; ?>',485,310)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                              <?php } else {?>
                              <img src="images/rename.png" title="Modifier" width="28">
                              <?php } ?></td>
                          <td><?php if ($row_select_admin['supprimer_admin']==1) { ?>
                              <a href="liste_regmdepo.php?noregma=<?php echo $row_liste_regmdepo['no_regmdepot']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                              <?php } else {?>
                              <img src="images/cancel.png" title="Supprimer" width="28">
                              <?php } ?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <?php } while ($row_liste_regmdepo = mysql_fetch_assoc($liste_regmdepo)); ?>
              </table></td>
            </tr>
          </table>
            <br>
            <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
              <tr class="Style14">
                <td><a href="<?php printf("%s?pageNum_liste_regmdepo=%d%s", $currentPage, max(0, $pageNum_liste_regmdepo - 1), $queryString_liste_regmdepo); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                <td><a href="<?php printf("%s?pageNum_liste_regmdepo=%d%s", $currentPage, min($totalPages_liste_regmdepo, $pageNum_liste_regmdepo + 1), $queryString_liste_regmdepo); ?>"><strong>Suivant&raquo;</strong></a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>Page</strong></td>
                <td><strong><?php echo $pageNum_liste_regmdepo+1 ?>/<?php echo $totalPages_liste_regmdepo+1; ?></strong></td>
                <td>&nbsp;</td>
                <td><strong>Enrg de <?php echo $startRow_liste_regmdepo+1; ?> &agrave; 30 </strong></td>
                <td><strong>Total </strong></td>
                <td><strong><?php echo $totalRows_liste_regmdepo ?> </strong></td>
              </tr>
          </table></td>
      </tr>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_liste_regmdepo == 0) { // Show if recordset empty ?>
      <tr>
        <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
      </tr>
      <?php } // Show if recordset empty ?>
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

mysql_free_result($liste_regmdepo);
?>
