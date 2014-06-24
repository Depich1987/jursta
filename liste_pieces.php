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
if ((isset($_GET['nopi'])) && ($_GET['nopi'] != "")) {
  $deleteSQL = sprintf("DELETE FROM reg_piece  WHERE reg_piece.id_regpiece=%s", GetSQLValueString($_GET['nopi'], "int"));

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

$maxRows_liste_piece = 10;
$pageNum_liste_piece = 0;
if (isset($_GET['pageNum_liste_piece'])) {
  $pageNum_liste_piece = $_GET['pageNum_liste_piece'];
}
$startRow_liste_piece = $pageNum_liste_piece * $maxRows_liste_piece;

mysql_select_db($database_jursta, $jursta);
$query_liste_piece = "SELECT * FROM reg_piece WHERE ((reg_piece.nordre_regpiece LIKE '".$_GET['wrdkey']."%') OR (reg_piece.nomprevenus LIKE '".$_GET['wrdkey']."%')) ORDER BY nordre_regpiece DESC";
$query_limit_liste_piece = sprintf("%s LIMIT %d, %d", $query_liste_piece, $startRow_liste_piece, $maxRows_liste_piece);
$liste_piece = mysql_query($query_limit_liste_piece, $jursta) or die(mysql_error());
$row_liste_piece = mysql_fetch_assoc($liste_piece);

if (isset($_GET['totalRows_liste_piece'])) {
  $totalRows_liste_piece = $_GET['totalRows_liste_piece'];
} else {
  $all_liste_piece = mysql_query($query_liste_piece);
  $totalRows_liste_piece = mysql_num_rows($all_liste_piece);
}
$totalPages_liste_piece = ceil($totalRows_liste_piece/$maxRows_liste_piece)-1;

$queryString_liste_piece = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_piece") == false && 
        stristr($param, "totalRows_liste_piece") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_piece = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_piece = sprintf("&totalRows_liste_piece=%d%s", $totalRows_liste_piece, $queryString_liste_piece);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php if ($totalRows_liste_piece > 0) { // Show if recordset not empty ?>
                  <tr>
                    <td valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                              <tr bgcolor="#677787" class="Style3">
                                <td rowspan="2" align="center">#</td>
                                <td rowspan="2" align="center">N&deg; d'ordre</td>
                                <td rowspan="2" align="center">Autorit&eacute; d'origine</td>
                                <td rowspan="2" align="center">N&deg; / date du P.V</td>
                                <td rowspan="2" align="center">Pr&eacute;venus</td>
                                <td rowspan="2" align="center">Nature du scell&eacute;</td>
                                <td rowspan="2" align="center">Lieu de conservation</td>
                                <td rowspan="2" align="center">N&deg; du jugement  <br>de d&eacute;cision</td>
                                <td colspan="2" align="center">Num&eacute;ros de l'ordonnance</td>
                                <td colspan="3" align="center">Restitution</td>
                                <td rowspan="2" align="center">Observations</td>
                                <td rowspan="2" align="center">Op&eacute;rations</td>
                              </tr>
                              <tr bgcolor="#677787" class="Style3">
                                <td align="center">Destruction</td>
                                <td align="center">Remise <br>au domaine</td>
                                <td align="center">Date</td>
                                <td align="center">Num&eacute;ros de la C.N.I ou C.S</td>
                                <td align="center">Emargement.</td>
                                </tr>
                              <?php 
		$tabcolor="#D0E0F0"; 
		$i=$maxRows_liste_piece*$pageNum_liste_piece;
		?>
                              <?php do { ?>

 <?php
	$i++;
	$tabcolor=="#D0E0F0"?$tabcolor="#FFFFFF":$tabcolor="#D0E0F0";
?>
                              <tr bgcolor="<?php echo $tabcolor ?>" class="Style11">
<td align="center" valign="middle"><strong><?php echo $i ?></strong></td>
<td align="center" valign="middle"><strong><?php echo $row_liste_piece['nordre_regpiece']; ?></strong></td>
<td align="center" valign="middle"><strong><?php echo $row_liste_piece['autorigine']; ?></strong></td>
<td align="center" valign="middle"><strong><span><?php echo $row_liste_piece['Nopv']; ?><br>du <?php echo Change_formatDate($row_liste_piece['datepv']); ?><br>
                                    </span></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['nomprevenus']; ?></strong></td>
                                <td align="center" valign="middle"><strong><?php echo $row_liste_piece['naturescelle']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['lieuconserv']; ?><br>
                                </strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['nojugdecision']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['nordestruction']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['nordremise']; ?></strong></td>
                                <td valign="middle"><strong><?php echo Change_formatDate($row_liste_piece['daterestitution']); ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['nocni']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['emargement']; ?></strong></td>
                                <td valign="middle"><strong><?php echo $row_liste_piece['observation']; ?></strong></td>
                                <td valign="middle"><table height="33" >
                                    <tr align="center" class="Style16">
                                      <td><strong>
                                        <?php if ($row_select_admin['visualiser_admin']==1) { ?>
                                          <a href="#" onClick="javascript:ouvre_popup('visual_regpieces.php?nopi=<?php echo $row_liste_piece['id_regpiece']; ?>',670,560)"><img src="images/mark_f2.png" title="Visualiser" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/mark.png"><img src="images/mark.png" title="Visualiser" width="28">
                                          <?php } ?>
                                      </strong></td>
                                      <td><strong>
                                        <?php if ($row_select_admin['modifier_admin']==1) { ?>
                                          <a href="#" onClick="javascript:ouvre_popup('modif_regpieces.php?nopi=<?php echo $row_liste_piece['id_regpiece']; ?>',670,700)"><img src="images/rename_f2.png" title="Modifier" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/rename.png" title="Modifier" width="28">
                                          <?php } ?>
                                      </strong></td>
                                      <td><strong>
                                        <?php if ($row_select_admin['supprimer_admin']==1) { ?>
                                          <a href="liste_regpieces_convictions.php?nopi=<?php echo $row_liste_piece['id_regpiece']; ?>" onClick="return confirmdelete('Voulez-vous supprimer ?')"><img src="images/cancel_f2.png" title="Supprimer" width="28" border="0"></a>
                                          <?php } else {?>
                                          <img src="images/cancel.png" title="Supprimer" width="28">
                                          <?php } ?>
                                      </strong></td>
                                    </tr>
                                </table></td>
                              </tr>
<?php } while ($row_liste_piece = mysql_fetch_assoc($liste_piece)); ?>
                          </table></td>
                        </tr>
                      </table>
                        <br>
                        <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
                          <tr class="Style22">
                            <td><a href="<?php printf("%s?pageNum_liste_piece=%d%s", $currentPage, max(0, $pageNum_liste_piece - 1), $queryString_liste_piece); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                            <td><a href="<?php printf("%s?pageNum_liste_piece=%d%s", $currentPage, min($totalPages_liste_piece, $pageNum_liste_piece + 1), $queryString_liste_piece); ?>"><strong>Suivant&raquo;</strong></a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><strong>Page</strong></td>
                            <td><strong><?php echo $pageNum_liste_piece+1 ?>/<?php echo $totalPages_liste_piece+1; ?></strong></td>
                            <td>&nbsp;</td>
                            <td><strong>Enrg de <?php echo $startRow_liste_piece+1; ?> &agrave; <?php echo $totalPages_liste_piece+1 ?> </strong></td>
                            <td><strong>Total </strong></td>
                            <td><strong><?php echo $totalRows_liste_piece ?></strong></td>
                          </tr>
                      </table></td>
                  </tr>
                  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_liste_piece == 0) { // Show if recordset empty ?>
                  <tr>
<td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
                  </tr>
                  <?php } // Show if recordset empty ?>
              </table>