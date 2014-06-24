<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "CabinetJugEnfant,Administrateur,Superviseur,AdminPenal";
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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reg_jugenfant(numodre_regjugenfant, datefait, daterequisitoire, datordcloture, decisionord, observation, no_regplaintes, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numodre_regjugenfant'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datefait']), "date"),
                       GetSQLValueString(changedatefrus($_POST['daterequisitoire']), "date"),
                       GetSQLValueString(changedatefrus($_POST['datordcloture']), "date"),
                       GetSQLValueString($_POST['decisionord'], "text"),
                       GetSQLValueString($_POST['observation'], "text"),
                       GetSQLValueString($_POST['no_regplaintes'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}


$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);



mysql_select_db($database_jursta, $jursta);
$query_liste_plaintes = "SELECT * FROM reg_plaintes_desc ORDER BY date_creation DESC";
$liste_plaintes = mysql_query($query_liste_plaintes, $jursta) or die(mysql_error());
$row_liste_plaintes = mysql_fetch_assoc($liste_plaintes);
$totalRows_liste_plaintes = mysql_num_rows($liste_plaintes);

$colname_select_juridic = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridic = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridic = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridic, "int"));
$select_juridic = mysql_query($query_select_juridic, $jursta) or die(mysql_error());
$row_select_juridic = mysql_fetch_assoc($select_juridic);
$totalRows_select_juridic = mysql_num_rows($select_juridic);

$colname_select_nodossier = "-1";
if (isset($_POST['nodordre_plaintes'])) {
  $colname_select_nodossier = $_POST['nodordre_plaintes'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_plaintes_desc WHERE reg_plaintes_desc.nodordre_plaintes = %s", GetSQLValueString($colname_select_nodossier, "text"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);

mysql_select_db($database_jursta, $jursta);
$query_select_cabin = "SELECT max(numodre_regjugenfant)  FROM reg_jugenfant";
$select_cabin = mysql_query($query_select_cabin, $jursta) or die(mysql_error());
$row_select_cabin = mysql_fetch_assoc($select_cabin);
$totalRows_select_cabin = mysql_num_rows($select_cabin);

mysql_select_db($database_jursta, $jursta);
$query_listenomplainte_plainte = "SELECT * FROM reg_plaintes_noms WHERE cles_pivot = '".$row_liste_plaintes['cles_pivot']."'";
$listenomplainte_plainte = mysql_query($query_listenomplainte_plainte, $jursta) or die(mysql_error());
$row_listenomplainte_plainte = mysql_fetch_assoc($listenomplainte_plainte);
$totalRows_listenomplainte_plainte = mysql_num_rows($listenomplainte_plainte);                              
?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."-".$datefr{3}.$datefr{4}."-".$datefr{0}.$datefr{1};

return $dateus;
}
?>
<?php 
	$ri= substr($row_select_cabin['max(numodre_regjugenfant)'], 2, 2);
	$tr="RE";
?>
<?php  if ($ri+1<10) {
	$tr="RE0";
	$ri=$ri+1 ;
	}
	else {
		$tr="RE";
		$ri=$ri+1 ;
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
	$( "#datepicker2" ).datepicker();
  });
  </script><?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {
?>
<script language="javascript">
rechargerpage("liste_regenfant.php");
</script>
<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="0" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td class="Style2"><p>Le Registre du service des activit&eacute;s du Cabinet d'Instruction - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="top" nowrap class="Style10"><form name="form1" method="post" action="add_regenfant.php">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td width="39%" align="right" valign="middle" nowrap class="Style10">N&deg; Dossier :</td>
                      <td width="21%"><input name="nodordre_plaintes" type="text" id="nodordre_plaintes" value="<?php echo $row_select_nodossier['nodordre_plaintes']; ?>" size="15"></td>
                      <td width="40%"><input type="submit" name="Afficher" value="Afficher" ></td>
                    </tr>
<?php if (($totalRows_select_nodossier == 0) && ($_POST['Afficher']!="")) { // Show if recordset empty ?>                    
                    <tr align="center">
                      <td colspan="3" valign="top" nowrap class="Style11">Aucun N&deg; de dossier ne correspond</td>
                    </tr>
<?php } ?>					
<?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" nowrap class="Style10">Nom des parties / Nature de l'infraction :
                        <input type="hidden" name="hiddenField" id="hiddenField" value="">
                        <?php echo $row_select_cabin['max(numodre_regjugenfant)']; ?></td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center" valign="middle" nowrap class="Style10"><table bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="2" class="Style10">
                        <?php do { ?>

                  <tr>
                    <td scope="col"><?php echo $row_listenomplainte_plainte['NomPreDomInculpes_plaintes']; ?></td>
                    <td scope="col"><?php echo $row_listenomplainte_plainte['NatInfraction_plaintes']; ?></td>
                  </tr>
                  <?php } while ($row_listenomplainte_plainte = mysql_fetch_assoc($liste_plaintes)); ?>
              </table></td>
                    </tr>
                    <?php } // Show if recordset not empty ?>
                  </table>
              </form></td>
            </tr>
            <tr>
              <td align="center" valign="top" nowrap class="Style10"><?php if ($totalRows_select_nodossier > 0) { // Show if recordset not empty ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="form2">
                  <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">N&deg; du Cabinet d'instruction</span> : </td>
              <td><input name="numodre_regjugenfant" type="text" id="numodre_regjugenfant" size="15" value="<?php  echo ($tr);?><?php  echo ($ri);?>/<?php echo date('y');?>"></td>
              </tr>
            <tr>
              <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">Date du fait</span> : </td>
              <td><input name="datefait" type="text" id="datepicker" value="<?php echo date("d/m/Y"); ?>" size="15"></td>
              </tr>
            <tr>
              <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">Date du r&eacute;quisitoire </span>:</td>
              <td><input name="daterequisitoire" type="text" id="datepicker1" size="15"></td>
              </tr>
            <tr>
              <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">Date Ordonnance de cl&ocirc;tu</span>re :</td>
              <td><input name="datordcloture" type="text" id="datepicker3" size="15"></td>
              </tr>
            <tr>
              <td align="right" valign="top" nowrap class="Style10"><span class="Style10">D&eacute;cision</span> Ordonnance de cl&ocirc;ture:</td>
              <td><label>
                <textarea name="decisionord" cols="35" rows="4" id="decisionord"></textarea>
                </label></td>
              </tr>
            <tr>
              <td align="right" valign="top" nowrap class="Style10"><span class="Style10">Observation </span> : </td>
              <td><textarea name="observation" cols="35" rows="4" id="observation"></textarea></td>
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
mysql_free_result($select_admin);

mysql_free_result($select_nodossier);

mysql_free_result($select_cabin);

mysql_free_result($liste_plaintes);

mysql_free_result($select_juridic);

?>
