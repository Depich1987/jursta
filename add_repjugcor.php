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


$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "int"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$select_inculpes='';
foreach ($_POST['select_inculpes'] as $value) {
	if ($select_inculpes!='') $select_inculpes.=',';
	$select_inculpes.=$value;
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO rep_jugementcorr (nojugement_repjugementcorr, datejugement_repjugementcorr, no_regplaintes, naturedecision_repjugementcorr, decisiontribunal_repjugementcorr, id_noms, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nojugement_repjugementsuppcorr'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datejugement_repjugementcorr']), "date"),
                       GetSQLValueString($_POST['no_regplaintes'], "int"),
                       GetSQLValueString($_POST['naturedecision_repjugementcorr'], "text"),
                       GetSQLValueString($_POST['decisiontribunal_repjugementcorr'], "text"),
                       GetSQLValueString($select_inculpes,"text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}


if ($_POST['Afficher']=="Afficher") { 
$colname_select_nodossier = "-1";
if (isset($_POST['nodordre_plaintes'])) {
  $colname_select_nodossier = $_POST['nodordre_plaintes'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_plaintes WHERE nodordre_plaintes = %s", GetSQLValueString($colname_select_nodossier, "text"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);$colname_select_nodossier = "-1";
if (isset($_POST['nodordre_plaintes'])) {
  $colname_select_nodossier = $_POST['nodordre_plaintes'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_plaintes_desc WHERE nodordre_plaintes = %s", GetSQLValueString($colname_select_nodossier, "text"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);

mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc d, reg_plaintes_noms n WHERE d.id_juridiction ='".$row_select_juridic['id_juridiction']."' AND d.cles_pivot = n.cles_pivot AND (d.nodordre_plaintes='".$row_select_nodossier['nodordre_plaintes']."') GROUP BY n.cles_pivot ORDER BY d.date_creation DESC";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);

$colname_verif_jugement = "-1";
if (isset($_POST['nodordre_plaintes'])) {
  $colname_verif_jugement = $_POST['nodordre_plaintes'];
}
mysql_select_db($database_jursta, $jursta);
$query_verif_jugement = sprintf("SELECT * FROM reg_plaintes_desc, rep_jugementcorr WHERE ((reg_plaintes_desc.nodordre_plaintes=%s) AND  (reg_plaintes_desc.no_regplaintes = rep_jugementcorr.no_regplaintes))", GetSQLValueString($colname_verif_jugement, "text"));
$verif_jugement = mysql_query($query_verif_jugement, $jursta) or die(mysql_error());
$row_verif_jugement = mysql_fetch_assoc($verif_jugement);
$totalRows_verif_jugement = mysql_num_rows($verif_jugement);

?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."-".$datefr{3}.$datefr{4}."-".$datefr{0}.$datefr{1};

return $dateus;
}
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
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
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_repjug.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="480" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="100%" valign="middle" ><table width="100%" >
          <tr bgcolor="#FFFFFF">
            <td><img src="images/forms48.png" width="32" border="0"></td>
            <td width="100%" class="Style2"><p>Le repertoire des jugements correctionnels- Ajouter un enregistrement</p></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
          <tr>
            <td align="right" valign="top" nowrap class="Style10"><form name="form1" method="post" action="add_repjugcor.php">
              <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                  <td width="40%" align="right" valign="top" nowrap class="Style10">N&deg; Dossier :</td>
                  <td width="21%"><input name="nodordre_plaintes" type="text" id="nodordre_plaintes" value="<?php echo $row_select_nodossier['nodordre_plaintes']; ?>" size="15"></td>
                  <td width="39%"><input type="submit" name="Afficher" value="Afficher"></td>
                </tr>
                <?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>
                <tr align="center">
                  <td colspan="3" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                </tr>
                <?php } ?>
                   <?php if (($totalRows_verif_jugement > 0) && ($_POST['Afficher']!="")) { // Show if recordset not empty ?>
  <tr align="center">
    <td colspan="3" valign="top" nowrap class="Style11">Ce Dossier à déja été jugé sous le numéros : <?php echo $row_verif_jugement['nojugement_repjugementcorr']; ?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
              </table>
            </form></td>
          </tr>
          <tr>
            <td width="100%" align="right" valign="top" nowrap class="Style10"><?php if (($totalRows_select_nodossier > 0) && ($totalRows_verif_jugement== 0)) { // Show if recordset not empty ?>
              <form action="<?php echo $editFormAction; ?>" name="form2" method="post">
                <table width="100%" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
                      <tr>
                        <td colspan="2" align="right" valign="top" nowrap class="Style10"><table width="100%" border="0" cellpadding="5" cellspacing="0">
                          <tr>
                            <td width="100%" align="center" valign="top" nowrap class="Style10">Nom des parties / Nature de l'infraction :</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" nowrap class="Style10"><table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" class="Style10">
                              <?php do { ?>
                              <tr>
                                <td><input type="checkbox" name="select_inculpes[]" id="select_inculpes_<?php echo $row_liste_plaintes['id_noms']; ?>" value="<?php echo $row_liste_plaintes['id_noms']; ?>"></td>
                                <td><?php echo $row_liste_plaintes['id_noms']; ?></td>
                                <td><?php echo $row_liste_plaintes['NomPreDomInculpes_plaintes']; ?></td>
                                <td><?php echo $row_liste_plaintes['NatInfraction_plaintes']; ?></td>
                              </tr>
                              <?php } while ($row_liste_plaintes = mysql_fetch_assoc($liste_plaintes)); ?>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" nowrap class="Style10">N&deg; du Jugement/Arr&ecirc;t  : </td>
                        <td><input name="nojugement_repjugementsuppcorr" type="text" id="nojugement_repjugementsuppcorrl" size="20"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" nowrap class="Style10">Date du jugement/Arr&ecirc;t : </td>
                        <td><input name="datejugement_repjugementcorr" type="text" id="datejugement_repjugementcorrl" size="15" value="<?php echo date("d-m-Y"); ?>"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" nowrap class="Style10">Nature de la d&eacute;cision :</td>
                        <td><label>
                          <select name="naturedecision_repjugementcorr" id="naturedecision_repjugementcorr">
                            <option value="Public">Public</option>
                            <option value="D&eacute;faut">D&eacute;faut</option>
                            <option value="Contradictoire">Contradictoire</option>
                            <option value="Chambre de Conseil">Chambre de Conseil</option>
                          </select>
                        </label></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" nowrap class="Style10">D&eacute;cision du tribunal  : </td>
                        <td><textarea name="decisiontribunal_repjugementcorr" cols="40" rows="5" id="decisiontribunal_repjugementcorr"></textarea></td>
                      </tr>
                      <tr>
                        <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                          <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                          <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>">
                          <input name="no_regplaintes" type="hidden" id="no_regplaintes" value="<?php echo $row_select_nodossier['no_regplaintes']; ?>"></td>
                        <td><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form2">
              </form>
              <?php } // Show if recordset not empty ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</BODY>
</HTML>
<?php
mysql_free_result($select_nodossier);

mysql_free_result($liste_plaintes);

mysql_free_result($verif_jugement);

mysql_free_result($select_juridic);
?>
