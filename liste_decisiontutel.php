<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ChambreTutelle,Administrateur,Superviseur,AdminCivil";
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
if ((isset($_GET['idrpt'])) && ($_GET['idrpt'] != "")) {
  $deleteSQL = sprintf("DELETE FROM rep_decisiontutel WHERE no_dectutel=%s",
                       GetSQLValueString($_GET['idrpt'], "int"));

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

mysql_select_db($database_jursta, $jursta);
$query_liste_decisiontutel = "SELECT * FROM rep_decisiontutel, role_general WHERE ((role_general.no_rolegeneral=rep_decisiontutel.no_rolegeneral) AND (rep_decisiontutel.id_juridiction =".$row_select_juridic['id_juridiction'].") AND ((rep_decisiontutel.nodec_dectutel LIKE '".$_GET['wrdkey']."%') OR (role_general.demandeur_rolegeneral LIKE '".$_GET['wrdkey']."%') OR (role_general.defendeur_rolegeneral LIKE '".$_GET['wrdkey']."%'))) ORDER BY no_dectutel DESC";
$liste_decisiontutel = mysql_query($query_liste_decisiontutel, $jursta) or die(mysql_error());
$row_liste_decisiontutel = mysql_fetch_assoc($liste_decisiontutel);
$totalRows_liste_decisiontutel = mysql_num_rows($liste_decisiontutel);
$queryString_liste_decisiontutel = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_decisiontutel") == false && 
        stristr($param, "totalRows_liste_decisiontutel") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_decisiontutel = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_decisiontutel = sprintf("&totalRows_liste_decisiontutel=%d%s", $totalRows_liste_decisiontutel, $queryString_liste_decisiontutel);
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                            <?php if ($totalRows_liste_decisiontutel > 0) { // Show if recordset not empty ?>
                            <tr>
                              <td width="100%" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                                    <tr bgcolor="#677787" class="Style3">
                                      <td>#</td>
                                      <td align="center">N&deg; d&eacute;cision</td>
                                      <td>Date</td>
                                      <td>Nom des parties</td>
                                      <td>Nature de l'Acte</td>
                                      <td>D&eacute;cision</td>
                                      <td>Observation</td>
                                      <td>Op&eacute;rations</td>
                                    </tr>
                                    <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_decisiontutel*$pageNum_liste_decisiontutel;
		?>
                                    <?php do { ?>
                                    <?php
mysql_select_db($database_jursta, $jursta);
$query_liste_acte = "SELECT * FROM acte_repdectutel WHERE no_dectutel = ".$row_liste_decisiontutel['no_dectutel']." ORDER BY id_actetutel DESC";
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
                                      <td align="center" valign="middle" nowrap="nowrap" class="Style11"><strong><?php echo $row_liste_decisiontutel['nodec_dectutel']; ?></strong></td>
                                      <td valign="middle" nowrap="nowrap" class="Style11"><strong><?php echo Change_formatDate($row_liste_decisiontutel['date_dectutel']); ?></strong></td>
                                      <td valign="middle" nowrap="nowrap" class="Style11"><p><strong><?php echo $row_liste_decisiontutel['demandeur_rolegeneral']; ?></strong></p>
                                        <p><strong>&nbsp;<?php echo $row_liste_decisiontutel['defendeur_rolegeneral']; ?></strong></p></td>
                                      <td valign="middle" nowrap="nowrap" class="Style11"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                        <?php do { ?>
                                        <tr>
                                          <td scope="col"><strong><?php echo $row_liste_acte['nature_actetutel']; ?></strong></td>
                                        </tr>
                                        <?php } while ($row_liste_acte = mysql_fetch_assoc($liste_acte)); ?>
                                      </table></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_decisiontutel['decision_dectutel']; ?></strong></td>
                                      <td valign="middle" class="Style11"><strong><?php echo $row_liste_decisiontutel['observation_dectutel']; ?></strong></td>
                                      <td colspan="2" valign="middle" class="Style11"><table align="center" >
                                        <tr align="center" class="Style16">
                                          <td nowrap="nowrap"><strong>
                                            <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                            <a href="#" onclick="javascript:ouvre_popup('visual_reptutelle.php?idrpt=<?php echo $row_liste_decisiontutel['no_dectutel']; ?>',500,450)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0" /></a>
                                            <?php } else {?>
                                            <img src="images/mark.png" /><img src="images/mark.png" title="Visualiser" width="28" />
                                            <?php } ?>
                                          </strong></td>
                                          <td nowrap="nowrap"><strong>
                                            <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                            <a href="#" onclick="javascript:ouvre_popup('modif_reptutelle.php?idrpt=<?php echo $row_liste_decisiontutel['no_dectutel']; ?>',550,460)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0" /></a>
                                            <?php } else {?>
                                            <img src="images/rename.png" title="Modifier" width="28" />
                                            <?php } ?>
                                          </strong></td>
                                          <td nowrap="nowrap"><strong>
                                            <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                            <a href="liste_reptutelle.php?idrpt=<?php echo $row_liste_decisiontutel['no_dectutel']; ?>" onclick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0" /></a>
                                            <?php } else {?>
                                            <img src="images/cancel.png" title="Supprimer" width="28" />
                                            <?php } ?>
                                          </strong></td>
                                          <td nowrap="nowrap"><strong>
                                            <?php if ($row_select_admin['ajouter_admin']==1) { ?>
                                            <a href="#" onclick="javascript:ouvre_popup('acte_repdectutel.php?idrpt=<?php echo $row_liste_decisiontutel['no_dectutel']; ?>',600,310)"><img src="images/acte.png"  title="Ajouter un Acte" width="32" height="32" border="0" /></a>
                                            <?php } else {?>
                                            <img src="images/acte_f2.png" width="32" height="32" border="0" />
                                            <?php } ?>
                                          </strong></td>
                                          <div id="ordonnace" style="display:none">
                                            <td style="display:none" nowrap="nowrap"><strong>
                                              <?php if ($row_select_admin['ajouter_admin']==1) { ?>
                                              <a href="#" onclick="javascript:ouvre_popup('ordonnance_regcabin.php?idrpt=<?php echo $row_liste_decisiontutel['no_dectutel']; ?>',480,610)"><img src="images/ordonance.png" width="32" height="32" border="0" /></a>
                                              <?php } else {?>
                                              <img src="images/ordonance_f2.png" width="32" height="32" border="0" />
                                              <?php } ?>
                                            </strong></td>
                                          </div>
                                        </tr>
                                      </table></td>
                                    </tr>
                                    <?php } while ($row_liste_decisiontutel = mysql_fetch_assoc($liste_decisiontutel)); ?>
                                  </table></td>
                                </tr>
                              </table>
                                <br />
                                <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                                  <tr class="Style14">
                                    <td><a href="<?php printf("%s?pageNum_liste_decisiontutel=%d%s", $currentPage, max(0, $pageNum_liste_decisiontutel - 1), $queryString_liste_decisiontutel); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a></td>
                                    <td><a href="<?php printf("%s?pageNum_liste_decisiontutel=%d%s", $currentPage, min($totalPages_liste_decisiontutel, $pageNum_liste_decisiontutel + 1), $queryString_liste_decisiontutel); ?>"><strong>Suivant&raquo;</strong></a></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>Page</strong></td>
                                    <td><strong><?php echo $pageNum_liste_decisiontutel+1 ?>/<?php echo $totalPages_liste_decisiontutel+1; ?></strong></td>
                                    <td>&nbsp;</td>
                                    <td><strong>Enrg de <?php echo $startRow_liste_decisiontutel+1; ?> &agrave; 30 </strong></td>
                                    <td><strong>Total </strong></td>
                                    <td><strong><?php echo $totalRows_liste_decisiontutel ?></strong></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <?php } // Show if recordset not empty ?>
                            <?php if ($totalRows_liste_decisiontutel == 0) { // Show if recordset empty ?>
                            <tr>
                              <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                            </tr>
                            <?php } // Show if recordset empty ?>
                          </table></td>
                        </tr>
                    </table>