<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Civile,Sociale,Superviseur,Admincivil";
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
$currentPage = $_SERVER["PHP_SELF"];

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
//----------------------------------- requete de suppression de l'enregistrement avec le paramètres donné--------------------------
if ((isset($_GET['norg'])) && ($_GET['norg'] != "")) {
  $deleteSQL = sprintf("DELETE FROM role_general WHERE no_rolegeneral=%s",
                       GetSQLValueString($_GET['norg'], "int"));

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
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "text"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);


$maxRows_liste_rolegeneral = 30;
$pageNum_liste_rolegeneral = 0;
if (isset($_GET['pageNum_liste_rolegeneral'])) {
  $pageNum_liste_rolegeneral = $_GET['pageNum_liste_rolegeneral'];
}
$startRow_liste_rolegeneral = $pageNum_liste_rolegeneral * $maxRows_liste_rolegeneral;

mysql_select_db($database_jursta, $jursta);
$query_liste_rolegeneral = "SELECT * FROM role_general, categorie_affaire WHERE ((categorie_affaire.id_categorieaffaire= role_general.id_categorieaffaire) AND (role_general.id_juridiction =".$row_select_juridic['id_juridiction'].")) ORDER BY noordre_rolegeneral DESC";
$query_limit_liste_rolegeneral = sprintf("%s LIMIT %d, %d", $query_liste_rolegeneral, $startRow_liste_rolegeneral, $maxRows_liste_rolegeneral);
$liste_rolegeneral = mysql_query($query_limit_liste_rolegeneral, $jursta) or die(mysql_error());
$row_liste_rolegeneral = mysql_fetch_assoc($liste_rolegeneral);

if (isset($_GET['totalRows_liste_rolegeneral'])) {
  $totalRows_liste_rolegeneral = $_GET['totalRows_liste_rolegeneral'];
} else {
  $all_liste_rolegeneral = mysql_query($query_liste_rolegeneral);
  $totalRows_liste_rolegeneral = mysql_num_rows($all_liste_rolegeneral);
}
$totalPages_liste_rolegeneral = ceil($totalRows_liste_rolegeneral/$maxRows_liste_rolegeneral)-1;

$queryString_liste_rolegeneral = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_rolegeneral") == false && 
        stristr($param, "totalRows_liste_rolegeneral") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_rolegeneral = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_rolegeneral = sprintf("&totalRows_liste_rolegeneral=%d%s", $totalRows_liste_rolegeneral, $queryString_liste_rolegeneral);
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
<script src="js/ajax_xhr_dossiersearch.js" type="text/javascript"></script>
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
              <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td bgcolor="#174F8A" class="Style28"><table width="100%" cellpadding="2" cellspacing="1" >
                        <tr bgcolor="#FFFFFF">
                          <td nowrap bgcolor="#174F8A"><?php if ($row_select_admin['ajouter_admin']==1) { ?>
                              <a href="#" onClick="javascript:ouvre_popup('add_rolegeneral.php',540,560)"><img src="images/edit_f2.png" title="Ajouter" width="32" height="32" border="0"></a>
                              <?php } else {?>
                              <img src="images/edit.png" width="32" height="32" border="0">
                              <?php } ?></td>
                          <td width="50%" align="left" bgcolor="#174F8A"><div align="left"><span class="Style2">Le r&ocirc;le g&eacute;n&eacute;ral</span> </div></td>
                          <td align="right" bgcolor="#174F8A" class="Style2"><span class="Style2">rechercher :</span>                            <input name="search_txt" type="text" class="Style30" id="search_txt" onKeyUp="getBlock('wrdkey='+this.value,'listedossiersearch','liste_rg.php')"/></td>
                          </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><div id="listedossiersearch">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100%"><?php if ($totalRows_liste_rolegeneral > 0) { // Show if recordset not empty ?>
                            <tr>
                              <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                    <tr bgcolor="#677787" class="Style3">
                                      <td>#</td>
                                      <td>&nbsp;</td>
                                      <td>N&deg; d'ordre </td>
                                      <td align="center">Date d'enrolement </td>
                                      <td bgcolor="#677787">Demandeur</td>
                                      <td>Defendeur</td>
                                      <td nowrap>Objet </td>
                                      <td align="center" nowrap>1<sup>&egrave;re</sup>date d'audience</td>
                                      <td>Observation</td>
                                      <td>Nature</td>
                                      <td>Op&eacute;rations</td>
                                      </tr>
                                    <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_rolegeneral*$pageNum_liste_rolegeneral;
		?>
                                    <?php do { ?>
                                      <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
<?php
mysql_select_db($database_jursta, $jursta);
$query_liste_plumitif = "SELECT * FROM plum_civil WHERE no_rolegeneral ='".$row_liste_rolegeneral['no_rolegeneral']."' ORDER BY id_plumcivil ASC";
$liste_plumitif = mysql_query($query_liste_plumitif, $jursta) or die(mysql_error());
$row_liste_plumitif = mysql_fetch_assoc($liste_plumitif);
$totalRows_liste_plumitif = mysql_num_rows($liste_plumitif);

mysql_select_db($database_jursta, $jursta);
$query_liste_repjuge = "SELECT * FROM rep_jugementsupp WHERE no_rolegeneral = '".$row_liste_rolegeneral['no_rolegeneral']."' ORDER BY no_repjugementsupp ASC";
$liste_repjuge = mysql_query($query_liste_repjuge, $jursta) or die(mysql_error());
$row_liste_repjuge = mysql_fetch_assoc($liste_repjuge);
$totalRows_liste_repjuge = mysql_num_rows($liste_repjuge);
?>
                                      <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                        <td align="center" valign="middle" class="Style11"><?php echo $i ?></td>
                                        <td valign="middle" class="Style11"><a href="javascript:DivStatus('info_','<?php echo $row_liste_rolegeneral['no_rolegeneral'];?>','img_');">
  <?php if (($totalRows_liste_plumitif>0) || ($totalRows_liste_repjuge>0))  { ?>                                        
                                         <img src="images/VST01605.gif" alt="Visualiser détail du dossier" width="14" height="14" name="img_<?php echo $row_liste_rolegeneral['no_rolegeneral']; ?>" border="0" id="img_<?php echo $row_liste_rolegeneral['no_rolegeneral'];?>" title="Visualiser détail du dossier">
                                        </a>
                                        <?php } else { ?>                                         
                                        <img src="images/VST01600.gif" width="14" height="14" alt="Aucun détails" title="Aucun détails">
                                        <?php } ?>
                                        </td>
                                        <td valign="middle" class="Style11"><span class="Style25"><?php echo $row_liste_rolegeneral['noordre_rolegeneral']; ?></span></td>
                                        <td align="center" valign="middle" nowrap class="Style11"><?php echo Change_formatDate($row_liste_rolegeneral['date_rolegeneral']); ?></td>
                                        <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_rolegeneral['demandeur_rolegeneral']; ?></strong></td>
                                        <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_rolegeneral['defendeur_rolegeneral']; ?></strong></td>
                                        <td valign="middle" class="Style11"><?php echo $row_liste_rolegeneral['objet_rolegeneral']; ?></td>
                                        <td align="center" valign="middle" class="Style11"><?php echo Change_formatDate($row_liste_rolegeneral['dateaudience_rolegeneral']); ?></td>
                                        <td valign="middle" class="Style11"><?php echo $row_liste_rolegeneral['observation_rolegeneral']; ?></td>
                                        <td valign="middle" class="Style11"><?php echo $row_liste_rolegeneral['lib_categorieaffaire']; ?></td>
                                        <td valign="middle"><table >
                                          <tr align="center" class="Style16">
                                            <td nowrap><?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                              <a href="#" onClick="javascript:ouvre_popup('visual_RG.php?norg=<?php echo $row_liste_rolegeneral['no_rolegeneral']; ?>',470,500)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                              <?php } else {?>
                                              <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                              <?php } ?></td>
                                            <td nowrap><?php if ($row_select_admin['modifier_admin']==1) { ?>
                                              <a href="#" onClick="javascript:ouvre_popup('modif_rolegeneral.php?norg=<?php echo $row_liste_rolegeneral['no_rolegeneral']; ?>',470,500)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                              <?php } else {?>
                                              <img src="images/rename.png" title="Modifier" width="28">
                                              <?php } ?></td>
                                            <td nowrap><?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                              <a href="liste_rolegeneral.php?norg=<?php echo $row_liste_rolegeneral['no_rolegeneral']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                              <?php } else {?>
                                              <img src="images/cancel.png" title="Supprimer" width="28">
                                              <?php } ?></td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                      <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                        <td colspan="11" class="Style11"><div id="info_<?php echo $row_liste_rolegeneral['no_rolegeneral'];?>" class="cachediv1"> 
  <?php if ($totalRows_liste_plumitif > 0) {  ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
      <td colspan="6" bgcolor="#F3F3F3">PLUMITIF</td>
      </tr>
        <tr>
          <td>Pr&eacute;sident</td>
          <td>Greffier</td>
          <td>Subtitut</td>
          <td>Observation</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
  <?php do { ?>
    <tr>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['nojugement_repjugementsupp']; ?></td>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['dispositif_repjugementsupp']; ?></td>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['statut_jugementsupp']; ?></td>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['observation_repjugementsupp']; ?></td>
      <td bgcolor="#F3F3F3">&nbsp;</td>
      <td bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
    <?php } while ($row_liste_repjuge = mysql_fetch_assoc($liste_repjuge)); ?>          
  </table>
  <?php }  ?>

  <?php if ($totalRows_liste_repjuge > 0) {  ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
      <td colspan="6" bgcolor="#F3F3F3">Repertoire des jujements supplétifs</td>
      </tr>
    <tr>
          <td>Pr&eacute;sident</td>
          <td>Greffier</td>
          <td>Subtitut</td>
          <td>Observation</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
      </tr>
  <?php do { ?>
    <tr>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['nojugement_repjugementsupp']; ?></td>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['dispositif_repjugementsupp']; ?></td>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['statut_jugementsupp']; ?></td>
      <td bgcolor="#F3F3F3"><?php echo $row_liste_repjuge['observation_repjugementsupp']; ?></td>
      <td bgcolor="#F3F3F3">&nbsp;</td>
      <td bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
    <?php } while ($row_liste_repjuge = mysql_fetch_assoc($liste_repjuge)); ?>          
  </table>
  <?php }  ?>

                                     </div></td>
                                        </tr>
                                      <?php } while ($row_liste_rolegeneral = mysql_fetch_assoc($liste_rolegeneral)); ?>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                  <tr class="Style14">
                                    <td><a href="<?php printf("%s?pageNum_liste_rolegeneral=%d%s", $currentPage, max(0, $pageNum_liste_rolegeneral - 1), $queryString_liste_rolegeneral); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                    <td><a href="<?php printf("%s?pageNum_liste_rolegeneral=%d%s", $currentPage, min($totalPages_liste_rolegeneral, $pageNum_liste_rolegeneral + 1), $queryString_liste_rolegeneral); ?>"><strong>Suivant&raquo;</strong></a></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>Page</strong></td>
                                    <td><strong><?php echo $pageNum_liste_rolegeneral+1 ?>/<?php echo $totalPages_liste_rolegeneral+1; ?></strong></td>
                                    <td>&nbsp;</td>
                                    <td><strong>Enrg de <?php echo $startRow_liste_rolegeneral+1; ?> &agrave; 30 </strong></td>
                                    <td><strong>Total </strong></td>
                                    <td><strong><?php echo $totalRows_liste_rolegeneral ?> </strong></td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <?php } // Show if recordset not empty ?>
                              <?php if ($totalRows_liste_rolegeneral == 0) { // Show if recordset empty ?>
                            <tr>
<td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                              </tr>
                              <?php } // Show if recordset empty ?>
                          </table>                    
                    </div></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
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
mysql_free_result($liste_rolegeneral);

mysql_free_result($liste_plumitif);

mysql_free_result($liste_repjuge);

mysql_free_result($select_juridic);

mysql_free_result($select_admin);
?>
