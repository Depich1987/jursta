<?php require_once('Connections/jursta.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrateur,Penitentiaire,Superviseur,AdminPenal";
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
//----------------------------------- requete de suppression de l'enregistrement avec le param�tres donn�--------------------------
if ((isset($_GET['noregev'])) && ($_GET['noregev'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_evasion WHERE id_regevasion=%s",
                       GetSQLValueString($_GET['noregev'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());
}
//----------------------------------- fin de la requete de suppression de l'enregistrement avec le param�tres donn�--------------------------


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


$maxRows_liste_regevasion = 30;
$pageNum_liste_regevasion = 0;
if (isset($_GET['pageNum_liste_regevasion'])) {
  $pageNum_liste_regevasion = $_GET['pageNum_liste_regevasion'];
}
$startRow_liste_regevasion = $pageNum_liste_regevasion * $maxRows_liste_regevasion;

mysql_select_db($database_jursta, $jursta);
$query_liste_regevasion = "SELECT * FROM reg_evasion,reg_ecrou, reg_controlnum, reg_mandat WHERE ((reg_ecrou.no_ecrou=reg_evasion.no_ecrou) AND (reg_controlnum.no_regcontrolnum=reg_ecrou.no_regcontrolnum) AND (reg_controlnum.no_regcontrolnum=reg_mandat.no_regmandat) AND (reg_evasion.id_juridiction =".$row_select_juridic['id_juridiction'].") AND ((reg_evasion.numordre_regevasion LIKE '".$_GET['wrdkey']."%') OR (reg_ecrou.noordre_ecrou LIKE '".$_GET['wrdkey']."%') OR (reg_mandat.nom_regmandat LIKE '".$_GET['wrdkey']."%') OR (reg_evasion.datevasion_regevasion LIKE '".Change_formatDate($_GET ['wrdkey'])."%'))) ORDER BY reg_evasion.id_regevasion DESC";
$query_limit_liste_regevasion = sprintf("%s LIMIT %d, %d", $query_liste_regevasion, $startRow_liste_regevasion, $maxRows_liste_regevasion);
$liste_regevasion = mysql_query($query_limit_liste_regevasion, $jursta) or die(mysql_error());
$row_liste_regevasion = mysql_fetch_assoc($liste_regevasion);

if (isset($_GET['totalRows_liste_regevasion'])) {
  $totalRows_liste_regevasion = $_GET['totalRows_liste_regevasion'];
} else {
  $all_liste_regevasion = mysql_query($query_liste_regevasion);
  $totalRows_liste_regevasion = mysql_num_rows($all_liste_regevasion);
}
$totalPages_liste_regevasion = ceil($totalRows_liste_regevasion/$maxRows_liste_regevasion)-1;

$queryString_liste_regevasion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_regevasion") == false && 
        stristr($param, "totalRows_liste_regevasion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_regevasion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_regevasion = sprintf("&totalRows_liste_regevasion=%d%s", $totalRows_liste_regevasion, $queryString_liste_regevasion);
//$peine = <?php echo $row_liste_regevasion['datedebutpeine_ecrou']; echo $row_liste_regevasion['dateexpirpeine_ecrou'];
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
<table width="100%" border="0" cellpadding="2" cellspacing="2">
                              <?php if ($totalRows_liste_regevasion > 0) { // Show if recordset not empty ?>
                              <tr>
                                <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                          <tr bgcolor="#677787" class="Style3">
                                            <td>#</td>
                                            <td align="center">N� d'ordre</td>
                                            <td align="center">N� d'Ecrou</td>
                                            <td align="center"><span class="Style11">Identit&eacute; du  d�tenu </span></td>
                                            <td align="center">Situation carc&eacute;rale</td>
                                            <td align="center"><span class="Style11">Date et Lieu <br>d'evasion</span></td>
                                            <td align="center"><span class="Style11">Circonstance<br>d'evasion</span></td>
                                            <td align="center">Date et Lieu <br>
                                              de reprise</td>
<td align="center">Observation</td>
                                            <td><span class="Style11">Op&eacute;rations</span></td>
                                          </tr>
                                          <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_regevasion*$pageNum_liste_regevasion;
		?>
                                          <?php do { ?>
                                          <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                          <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                            <td align="center" valign="middle" class="Style11"><?php echo $i ?></td>
                                            <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_regevasion['numordre_regevasion']; ?></strong></td>
                                            <td align="center" valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_regevasion['noordre_ecrou']; ?></strong></td>
                                            <td align="left" valign="middle">Nom : <strong><?php echo $row_liste_regevasion['nom_regmandat']; ?>
                                              <br>
                                              </strong>N&eacute;(e) le :<strong> <?php echo Change_formatDate($row_liste_regevasion['datnaisdet_ecrou']); ?>
                                              <br>
                                              </strong>A :<strong> <?php echo $row_liste_regevasion['lieunaisdet_ecrou']; ?>
                                              <br>
                                              </strong>Domiciliation : <strong><?php echo $row_liste_regevasion['domicildet_ecrou']; ?>
                                              <br>
                                              </strong>Nationnalit&eacute; :</td>
                                            <td align="center" valign="middle" nowrap class="Style14">Date d'&eacute;crou : <strong><br>
                                              <?php echo Change_formatDate($row_liste_regevasion['datenter_ecrou']); ?><br> 
                                              </strong><br><u>Titre de d�tention:</u><strong> <br><?php echo $row_liste_regevasion['type_regmandat']; ?><br> 
                                              </strong><br><u>Jugement :</u><strong> <br> <?php echo $row_liste_regevasion['decisionjudic_ecrou']; ?><br>
                                              </strong><br><u>Peine Restante :</u><strong> <br>
<br>
<?php echo $peine ?>                                              </strong></td>
                                            <td align="center" valign="middle" class="Style11"><p><strong><?php echo Change_formatDate($row_liste_regevasion['datevasion_regevasion']); ?><br><?php echo $row_liste_regevasion['lieuevasion_regevasion']; ?></strong></p>                                                </td>
                                            <td valign="middle" class="Style11"><strong><?php echo $row_liste_regevasion['circonstance_regevasion']; ?></strong></td>
                                            <td valign="middle" class="Style11"><strong><?php echo Change_formatDate($row_liste_regevasion['dateretour_regevasion']); ?><br>
                                              <?php echo $row_liste_regevasion['lieureintegration_regevasion']; ?></strong></td>
<td valign="middle" class="Style11"><strong><?php echo $row_liste_regevasion['obs_regevasion']; ?></strong></td>
                                            <td valign="middle"><table >
                                                <tr align="center" class="Style16">
                                                  <td nowrap><?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                      <a href="#" onClick="javascript:ouvre_popup('visual_regevasion.php?noregev=<?php echo $row_liste_regevasion['noordre_ecrou']; ?>',470,500)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                      <?php } else {?>                                                      <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                                      <?php } ?></td>
                                                  <td nowrap><?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                      <a href="#" onClick="javascript:ouvre_popup('modif_regevasion.php?noregev=<?php echo $row_liste_regevasion['noordre_ecrou']; ?>',1140,630)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                      <?php } else {?>
                                                      <img src="images/rename.png" title="Modifier" width="28">
                                                      <?php } ?></td>
                                                  <td nowrap><?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                      <a href="liste_regevasion.php?noregev=<?php echo $row_liste_regevasion['noordre_ecrou']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                      <?php } else {?>
                                                      <img src="images/cancel.png" title="Supprimer" width="28">
                                                      <?php } ?></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                          <?php } while ($row_liste_regevasion = mysql_fetch_assoc($liste_regevasion)); ?>
                                      </table></td>
                                    </tr>
                                  </table>
                                    <br>
                                    <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                      <tr class="Style14">
                                        <td><a href="<?php printf("%s?pageNum_liste_regevasion=%d%s", $currentPage, max(0, $pageNum_liste_regevasion - 1), $queryString_liste_regevasion); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                        <td><a href="<?php printf("%s?pageNum_liste_regevasion=%d%s", $currentPage, min($totalPages_liste_regevasion, $pageNum_liste_regevasion + 1), $queryString_liste_regevasion); ?>"><strong>Suivant&raquo;</strong></a></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><strong>Page</strong></td>
                                        <td><strong><?php echo $pageNum_liste_regevasion+1 ?>/<?php echo $totalPages_liste_regevasion+1; ?></strong></td>
                                        <td>&nbsp;</td>
                                        <td><strong>Enrg de <?php echo $startRow_liste_regevasion+1; ?> &agrave; 30 </strong></td>
                                        <td><strong>Total </strong></td>
                                        <td><strong><?php echo $totalRows_liste_regevasion ?> </strong></td>
                                      </tr>
                                  </table></td>
                              </tr>
                              <?php } // Show if recordset not empty ?>
                              <?php if ($totalRows_liste_regevasion == 0) { // Show if recordset empty ?>
                              <tr>
                                <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                              </tr>
                              <?php } // Show if recordset empty ?>
                          </table>