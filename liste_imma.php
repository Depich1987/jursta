<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
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
if ((isset($_GET['noregima'])) && ($_GET['noregima'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_controlnum WHERE no_regcontrolnum=%s",
                       GetSQLValueString($_GET['noregima'], "int"));

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


$maxRows_liste_regima = 30;
$pageNum_liste_regima = 0;
if (isset($_GET['pageNum_liste_regima'])) {
  $pageNum_liste_regima = $_GET['pageNum_liste_regima'];
}
$startRow_liste_regima = $pageNum_liste_regima * $maxRows_liste_regima;

mysql_select_db($database_jursta, $jursta);
$query_liste_regima = "SELECT * FROM reg_controlnum, reg_mandat WHERE ((reg_mandat.no_regmandat=reg_controlnum.no_regmandat) AND (reg_mandat.id_juridiction =".$row_select_juridic['id_juridiction'].") AND ((reg_controlnum.noordre_regcontrolnum LIKE '".$_GET['wrdkey']."%') OR (reg_mandat.nom_regmandat LIKE '".$_GET['wrdkey']."%'))) ORDER BY reg_controlnum.noordre_regcontrolnum DESC";
$query_limit_liste_regima = sprintf("%s LIMIT %d, %d", $query_liste_regima, $startRow_liste_regima, $maxRows_liste_regima);
$liste_regima = mysql_query($query_limit_liste_regima, $jursta) or die(mysql_error());
$row_liste_regima = mysql_fetch_assoc($liste_regima);

if (isset($_GET['totalRows_liste_regima'])) {
  $totalRows_liste_regima = $_GET['totalRows_liste_regima'];
} else {
  $all_liste_regima = mysql_query($query_liste_regima);
  $totalRows_liste_regima = mysql_num_rows($all_liste_regima);
}
$totalPages_liste_regima = ceil($totalRows_liste_regima/$maxRows_liste_regima)-1;

$queryString_liste_regima = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_regima") == false && 
        stristr($param, "totalRows_liste_regima") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_regima = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_regima = sprintf("&totalRows_liste_regima=%d%s", $totalRows_liste_regima, $queryString_liste_regima);
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
                              <?php if ($totalRows_liste_regima > 0) { // Show if recordset not empty ?>
                              <tr>
                                <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                          <tr bgcolor="#677787" class="Style3">
                                            <td>#</td>
                                            <td><span class="Style11">N&deg; d'ordre </span></td>
                                            <td align="center"><span class="Style11">Sexe</span></td>
                                            <td><span class="Style11">Date</span></td>
                                            <td><span class="Style11">Nom et Pr&eacute;noms </span></td>
                                            <td nowrap><span class="Style11">Nom du Procureur </span></td>
                                            <td align="center" nowrap><span class="Style11">Nature D&eacute;lit </span></td>
                                            <td>Op&eacute;rations</td>
                                          </tr>
                                          <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_regima*$pageNum_liste_regima;
		?>
                                          <?php do { ?>
                                          <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                                          <tr bgcolor="<?php echo $tabcolor ?>" class="Style14">
                                            <td align="center" valign="middle" class="Style11"><?php echo $i ?></td>
                                            <td valign="middle" class="Style11"><span class="Style25"><?php echo $row_liste_regima['noordre_regcontrolnum']; ?></span></td>
                                            <td align="center" valign="middle" nowrap class="Style11"><?php echo $row_liste_regima['sexe_regcontrolnum']; ?></td>
                                            <td valign="middle" nowrap class="Style11"><strong><?php echo Change_formatDate($row_liste_regima['date_regcontrolnum']); ?></strong></td>
                                            <td valign="middle" nowrap class="Style11"><strong><?php echo $row_liste_regima['nom_regmandat']; ?></strong></td>
                                            <td valign="middle" class="Style11"><?php echo $row_liste_regima['magistra_regmandat']; ?></td>
                                            <td align="center" valign="middle" class="Style11"><?php echo $row_liste_regima['infraction_regmandat']; ?></td>
                                            <td valign="middle"><table >
                                                <tr align="center" class="Style16">
                                                  <td nowrap><?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                                      <a href="#" onClick="javascript:ouvre_popup('visual_regima.php?noregima=<?php echo $row_liste_regima['no_regcontrolnum']; ?>',480,420)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                                      <?php } else {?>
                                                    <img src="images/mark.png" title="Visualiser" width="28" height="8">
                                                      <?php } ?></td>
                                                  <td nowrap><?php if ($row_select_admin['modifier_admin']==1) { ?>
                                                      <a href="#" onClick="javascript:ouvre_popup('modif_regima.php?noregima=<?php echo $row_liste_regima['no_regcontrolnum']; ?>',485,290)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                                      <?php } else {?>
                                                      <img src="images/rename.png" title="Modifier" width="28" height="8">
                                                      <?php } ?></td>
                                                  <td nowrap><?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                                      <a href="liste_regima.php?noregima=<?php echo $row_liste_regima['no_regcontrolnum']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                                      <?php } else {?>
                                                      <img src="images/cancel.png" title="Supprimer" width="28">
                                                      <?php } ?></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                          <?php } while ($row_liste_regima = mysql_fetch_assoc($liste_regima)); ?>
                                      </table></td>
                                    </tr>
                                  </table>
                                    <br>
                                    <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                      <tr class="Style14">
                                        <td><a href="<?php printf("%s?pageNum_liste_regima=%d%s", $currentPage, max(0, $pageNum_liste_regima - 1), $queryString_liste_regima); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                                        <td><a href="<?php printf("%s?pageNum_liste_regima=%d%s", $currentPage, min($totalPages_liste_regima, $pageNum_liste_regima + 1), $queryString_liste_regima); ?>"><strong>Suivant&raquo;</strong></a></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><strong>Page</strong></td>
                                        <td><strong><?php echo $pageNum_liste_regima+1 ?>/<?php echo $totalPages_liste_regima+1; ?></strong></td>
                                        <td>&nbsp;</td>
                                        <td><strong>Enrg de <?php echo $startRow_liste_regima+1; ?> &agrave; 30 </strong></td>
                                        <td><strong>Total </strong></td>
                                        <td><strong><?php echo $totalRows_liste_regima ?> </strong></td>
                                      </tr>
                                  </table></td>
                              </tr>
                              <?php } // Show if recordset not empty ?>
                              <?php if ($totalRows_liste_regima == 0) { // Show if recordset empty ?>
                              <tr>
                                <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                              </tr>
                              <?php } // Show if recordset empty ?>
                          </table>