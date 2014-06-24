<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Administrateur,Superviseur";
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
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && (isset($_POST["modifier_cmd"])) && ($_POST["modifier_cmd"] != "")) {
  $updateSQL = sprintf("UPDATE administrateurs SET nom_admin=%s, prenoms_admin=%s, email_admin=%s, sexe_admin=%s, datenais_admin=%s, login_admin=%s, pwd_admin=%s, type_admin=%s, id_juridiction=%s, ajouter_admin=%s, modifier_admin=%s, supprimer_admin=%s, visualiser_admin=%s WHERE Id_admin=%s",
                       GetSQLValueString($_POST['nom_admin'], "text"),
                       GetSQLValueString($_POST['prenoms_admin'], "text"),
                       GetSQLValueString($_POST['email_admin'], "text"),
                       GetSQLValueString($_POST['sexe_admin'], "text"),
                       GetSQLValueString(changedatefrus($_POST['datenais_admin']), "date"),
                       GetSQLValueString($_POST['login_admin'], "text"),
                       GetSQLValueString($_POST['pwd_admin'], "text"),
                       GetSQLValueString($_POST['type_admin'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString(isset($_POST['ajouter_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['modifier_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['supprimer_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['visualiser_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Id_admin'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($updateSQL, $jursta) or die(mysql_error());

  $updateGoTo = "liste_compte.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_select_compte = "-1";
if (isset($_GET['id'])) {
  $colname_select_compte = $_GET['id'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_compte = sprintf("SELECT * FROM administrateurs WHERE Id_admin = %s", GetSQLValueString($colname_select_compte, "int"));
$select_compte = mysql_query($query_select_compte, $jursta) or die(mysql_error());
$row_select_compte = mysql_fetch_assoc($select_compte);
$totalRows_select_compte = mysql_num_rows($select_compte);

mysql_select_db($database_jursta, $jursta);
$query_retrouve_typejur = "SELECT * FROM juridiction WHERE id_juridiction =".$row_select_compte['id_juridiction'];
$retrouve_typejur = mysql_query($query_retrouve_typejur, $jursta) or die(mysql_error());
$row_retrouve_typejur = mysql_fetch_assoc($retrouve_typejur);
$totalRows_retrouve_typejur = mysql_num_rows($retrouve_typejur);

mysql_select_db($database_jursta, $jursta);
$query_typejuridiction = "SELECT * FROM type_juridiction ORDER BY lib_typejuridiction ASC";
$typejuridiction = mysql_query($query_typejuridiction, $jursta) or die(mysql_error());
$row_typejuridiction = mysql_fetch_assoc($typejuridiction);
$totalRows_typejuridiction = mysql_num_rows($typejuridiction);

$colname_liste_juridiction = -1;
if (isset($_POST['id_typejuridiction'])) {
  $colname_liste_juridiction = $_POST['id_typejuridiction'];
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s ORDER BY lib_juridiction ASC", GetSQLValueString($colname_liste_juridiction, "int"));
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);
?>
<?php
function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."/".$datefr{3}.$datefr{4}."/".$datefr{0}.$datefr{1};

return $dateus;
}
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
     <?php if (($row_select_juridiction['id_juridiction'] != 55) && ($row_select_juridiction['id_juridiction'] != 0)) { ?>
   <td valign="top" background="images/continue.jpg"><?php require_once('menudroit.php'); ?></td>
   <?php } else  {?>
   <td valign="top" background="images/continue.jpg" width="50%">&nbsp;</td>
   <?php } ?>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td bgcolor="#677787" class="Style28"><table width="100%" cellpadding="2" cellspacing="1" >
                        <tr bgcolor="#FFFFFF">
                          <td bgcolor="#174F8A"><span class="Style2"><a href="liste_compte.php"><img src="images/forms48.png" width="32" border="0"></a></span></td>
                          <td width="100%" align="left" nowrap bgcolor="#174F8A"><span class="Style2">Modification  d'un compte </span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td width="100%"><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
                              <table width="100%" border="0" cellpadding="5" cellspacing="3" class="Style15">
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Nom :</strong></td>
                                  <td align="left" nowrap><input name="nom_admin" type="text" id="nom_admin" value="<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { echo $_POST['nom_admin']; } else { echo $row_select_compte['nom_admin']; } ?>" size="25"></td>
                                  <td width="100%" rowspan="12" align="center" valign="top"><img src="images/addusers.png" width="150"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Pr&eacute;noms : </strong></td>
                                  <td align="left" nowrap><input name="prenoms_admin" type="text" id="prenoms_admin" value="<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { echo $_POST['prenoms_admin']; } else { echo $row_select_compte['prenoms_admin']; }?>" size="30"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Sexe : </strong></td>
                                  <td align="left" nowrap class="Style10"><input <?php if (!(strcmp($row_select_compte['sexe_admin'],"M"))) {echo "checked=\"checked\"";} if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['sexe_admin'],"M"))) {echo "checked=\"checked\"";} } ?> type="radio" name="sexe_admin" value="M">
                                    Masculin
                                    <input <?php if (!(strcmp($row_select_compte['sexe_admin'],"F"))) {echo "checked=\"checked\"";} if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['sexe_admin'],"F"))) {echo "checked=\"checked\"";} } ?> type="radio" name="sexe_admin" value="F">
                                    F&eacute;minin</td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Date de naissance : </strong></td>
                                  <td align="left" nowrap><input name="datenais_admin" type="text" id="datenais_admin" value="<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { echo Change_formatDate($_POST['datenais_admin']); } else { echo Change_formatDate($row_select_compte['datenais_admin']); } ?>" size="15"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>E-mail : </strong></td>
                                  <td align="left" nowrap><input name="email_admin" type="text" id="email_admin" value="<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { echo $_POST['email_admin']; } else { echo $row_select_compte['email_admin']; } ?>" size="30"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Login : </strong></td>
                                  <td align="left" nowrap><input name="login_admin" type="text" id="login_admin" value="<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { echo $_POST['login_admin']; } else { echo $row_select_compte['login_admin']; } ?>" size="20"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Mot de passe : </strong></td>
                                  <td align="left" nowrap><input name="pwd_admin" type="password" id="pwd_admin" value="<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { echo $_POST['nom_admin']; } else { echo $row_select_compte['nom_admin']; } ?>" size="20"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Section Administrateur : </strong></td>
                                  <td align="left" nowrap><select name="type_admin" id="type_admin">
                                    <option value="Administrateur" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['type_admin'],"Administrateur"))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_select_compte['type_admin'],"Administrateur"))) {echo "selected=\"selected\"";} }?>>Administrateur</option>
                                    <option value="Civile" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['type_admin'],"Civile"))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_select_compte['type_admin'],"Civile"))) {echo "selected=\"selected\"";} }?>>Civile</option>
                                    <option value="Penale" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['type_admin'],"Penale"))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_select_compte['type_admin'],"Penale"))) {echo "selected=\"selected\"";} }?>>Penale</option>
                                    <option value="Sociale" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['type_admin'],"Sociale"))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_select_compte['type_admin'],"Sociale"))) {echo "selected=\"selected\"";} }?>>Sociale</option>
                                    <option value="Superviseur" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['type_admin'],"Superviseur"))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_select_compte['type_admin'],"Superviseur"))) {echo "selected=\"selected\"";} }?>>Superviseur</option>
                                  </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong> Type de juridiction: </strong></td>
                                  <td align="left" nowrap><select name="id_typejuridiction" onChange="document.form1.submit();">
                                    <option value="0" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['id_typejuridiction'],$row_typejuridiction['id_typejuridiction']))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_retrouve_typejur['id_typejuridiction'],$row_typejuridiction['id_typejuridiction']))) {echo "selected=\"selected\"";} }?>>Tous types</option>								  
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_typejuridiction['id_typejuridiction']; ?>" <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['id_typejuridiction'],$row_typejuridiction['id_typejuridiction']))) {echo "selected=\"selected\"";} } else {if (!(strcmp($row_retrouve_typejur['id_typejuridiction'],$row_typejuridiction['id_typejuridiction']))) {echo "selected=\"selected\"";} }?>><?php echo $row_typejuridiction['lib_typejuridiction']; ?></option>
<?php
} while ($row_typejuridiction = mysql_fetch_assoc($typejuridiction));
  $rows = mysql_num_rows($typejuridiction);
  if($rows > 0) {
      mysql_data_seek($typejuridiction, 0);
	  $row_typejuridiction = mysql_fetch_assoc($typejuridiction);
  }
?>
                                  </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Juridiction d'exploitation :</strong></td>
                                  <td align="left" nowrap><select name="id_juridiction" id="id_juridiction">
<?php if ($totalRows_liste_juridiction==0) { ?>
                                    <option value="0">Toutes juridictions</option>
<?php } else { ?>		
                                    <?php
do {  
?><option value="<?php echo $row_liste_juridiction['id_juridiction']?>" <?php if (!(strcmp($row_liste_juridiction['id_juridiction'], $row_select_compte['id_juridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_liste_juridiction['lib_juridiction']?></option>
                                    <?php
} while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction));
  $rows = mysql_num_rows($liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($liste_juridiction, 0);
	  $row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
  }
?>
<?php } ?>
                                  </select></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Droits : </strong></td>
                                  <td nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td align="left" bgcolor="#E9F2FB"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="2" class="Style10">
                                            <tr bgcolor="#6186AF">
                                              <td colspan="4"><div align="center">Droits sur les R&eacute;gistres </div></td>
                                            </tr>
                                            <tr align="center">
                                              <td>Ajouter</td>
                                              <td>Modifier</td>
                                              <td>Visualiser</td>
                                              <td>Supprimer</td>
                                            </tr>
                                            <tr align="center">
                                              <td><input  <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['ajouter_admin'],1))) {echo "checked=\"checked\"";} } else {if (!(strcmp($row_select_compte['ajouter_admin'],1))) {echo "checked=\"checked\"";} }?> name="ajouter_admin" type="checkbox" id="ajouter_admin" value="1"></td>
                                              <td><input <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['modifier_admin'],1))) {echo "checked=\"checked\"";} } else {if (!(strcmp($row_select_compte['modifier_admin'],1))) {echo "checked=\"checked\"";} }?> name="modifier_admin" type="checkbox" id="modifier_admin" value="1"></td>
                                              <td><input <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['visualiser_admin'],1))) {echo "checked=\"checked\"";} } else {if (!(strcmp($row_select_compte['visualiser_admin'],1))) {echo "checked=\"checked\"";} }?> name="visualiser_admin" type="checkbox" id="visualiser_admin" value="1"></td>
                                              <td><input <?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { if (!(strcmp($_POST['supprimer_admin'],1))) {echo "checked=\"checked\"";} } else {if (!(strcmp($row_select_compte['supprimer_admin'],1))) {echo "checked=\"checked\"";} }?> name="supprimer_admin" type="checkbox" id="supprimer_admin" value="1"></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><input name="Id_admin" type="hidden" id="Id_admin" value="<?php echo $row_select_compte['Id_admin']; ?>"></td>
                                  <td nowrap><input name="modifier_cmd" type="submit" id="ajouter_cmd" value="Modifier l'administrateur"></td>
                                </tr>
                              </table>
                            <input type="hidden" name="MM_update" value="form1">
                          </form></td>
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
mysql_free_result($liste_juridiction);

mysql_free_result($select_compte);

mysql_free_result($retrouve_typejur);

mysql_free_result($typejuridiction);
?>
