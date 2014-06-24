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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO administrateurs (nom_admin, prenoms_admin, email_admin, sexe_admin, datenais_admin, login_admin, pwd_admin, type_admin, id_juridiction, ajouter_admin, modifier_admin, supprimer_admin, visualiser_admin, id_admincreation, date_creation) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nom_admin'], "text"),
                       GetSQLValueString($_POST['prenoms_admin'], "text"),
                       GetSQLValueString($_POST['email_admin'], "text"),
                       GetSQLValueString($_POST['sexe_admin'], "text"),
                       GetSQLValueString($_POST['datenais_admin'], "date"),
                       GetSQLValueString($_POST['login_admin'], "text"),
                       GetSQLValueString($_POST['pwd_admin'], "text"),
                       GetSQLValueString($_POST['type_admin'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
                       GetSQLValueString(isset($_POST['ajouter_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['modifier_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['supprimer_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['visualiser_admin']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_admincreation'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());

  $insertGoTo = "liste_compte.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
                          <td bgcolor="#174F8A"><a href="liste_compte.php"><img src="images/forms48.png" width="32" border="0"></a></td>
                          <td width="100%" align="left" nowrap bgcolor="#174F8A"><span class="Style2">Cr&eacute;ation d'un compte </span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td width="100%"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
                              <table width="100%" border="0" cellpadding="5" cellspacing="3" class="Style15">
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Nom :</strong></td>
                                  <td nowrap><input name="nom_admin" type="text" id="nom_admin" value="<?php echo $_POST['nom_admin']; ?>" size="25"></td>
                                  <td width="100%" rowspan="12" align="center" valign="top"><img src="images/addusers.png" width="150"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Pr&eacute;noms : </strong></td>
                                  <td nowrap><input name="prenoms_admin" type="text" id="prenoms_admin" value="<?php echo $_POST['prenoms_admin']; ?>" size="30"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Sexe : </strong></td>
                                  <td nowrap class="Style10"><input <?php if (!(strcmp($_POST['sexe_admin'],"M"))) {echo "checked=\"checked\"";} ?> type="radio" name="sexe_admin" value="M">
                                    Masculin
                                    <input <?php if (!(strcmp($_POST['sexe_admin'],"F"))) {echo "checked=\"checked\"";} ?> type="radio" name="sexe_admin" value="F">
                                    F&eacute;minin</td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Date de naissance : </strong></td>
                                  <td nowrap><input name="datenais_admin" type="text" id="datenais_admin" value="<?php echo $_POST['datenais_admin']; ?>" size="15"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>E-mail : </strong></td>
                                  <td nowrap><input name="email_admin" type="text" id="email_admin" value="<?php echo $_POST['email_admin']; ?>" size="30"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Login : </strong></td>
                                  <td nowrap><input name="login_admin" type="text" id="login_admin" value="<?php echo $_POST['login_admin']; ?>" size="20"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Mot de passe : </strong></td>
                                  <td nowrap><input name="pwd_admin" type="password" id="pwd_admin" value="<?php echo $_POST['pwd_admin']; ?>" size="20"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Section Administrateur : </strong></td>
                                  <td nowrap><select name="type_admin" id="type_admin">
                                    <option value="Civile" <?php if (!(strcmp("Civile", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Civile</option>
                                    <option value="Penale" <?php if (!(strcmp("Penale", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Penale</option>
                                    <option value="Sociale" <?php if (!(strcmp("Sociale", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Sociale</option>
<option value="Penitentiaire" <?php if (!(strcmp("Penitentiaire", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Penitentiaire</option>
                                    <option value="ChambreTutelle" <?php if (!(strcmp("ChambreTutelle", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>ChambreTutelle</option>
                                    <option value="Inspection" <?php if (!(strcmp("Inspection", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Inspection</option>
                                    <option value="Superviseur" <?php if (!(strcmp("Superviseur", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Superviseur</option>
                                    <option value="Administrateur" <?php if (!(strcmp("Administrateur", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Administrateur</option>
                                    <option value="AdminCivil" <?php if (!(strcmp("AdminCivil", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Admin Civil</option>
                                    <option value="AdminPenal" <?php if (!(strcmp("AdminPenal", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Admin Penal</option>
                                    <option value="CabinetInstruction" <?php if (!(strcmp("CabinetInstruction", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Cabinet Instruction</option>
                                    <option value="CabinetJugEnfant" <?php if (!(strcmp("CabinetJugEnfant", $_POST['type_admin']))) {echo "selected=\"selected\"";} ?>>Cabinet Juge des Enfants</option>
                                  </select></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong> Type de juridiction: </strong></td>
                                  <td nowrap><select name="id_typejuridiction" onChange="document.form1.submit();">
                                    <option value="0" <?php if (!(strcmp(0, $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>>Tous types</option>
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_typejuridiction['id_typejuridiction']; ?>" value="<?php echo $row_typejuridiction['id_typejuridiction']; ?>"<?php if (!(strcmp($row_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?> <?php if (!(strcmp($row_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>>
                                    <?php echo $row_typejuridiction['lib_typejuridiction']; ?>
                                    </option>
                                    <?php
} while ($row_typejuridiction = mysql_fetch_assoc($typejuridiction));
  $rows = mysql_num_rows($typejuridiction);
  if($rows > 0) {
      mysql_data_seek($typejuridiction, 0);
	  $row_typejuridiction = mysql_fetch_assoc($typejuridiction);
  }
?>
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_typejuridiction['id_typejuridiction']?>"<?php if (!(strcmp($row_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "selected=\"selected\"";} ?>><?php echo $row_typejuridiction['id_typejuridiction']?></option>
<?php
} while ($row_typejuridiction = mysql_fetch_assoc($typejuridiction));
  $rows = mysql_num_rows($typejuridiction);
  if($rows > 0) {
      mysql_data_seek($typejuridiction, 0);
	  $row_typejuridiction = mysql_fetch_assoc($typejuridiction);
  }
?>
                                  </select></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><strong>Juridiction d'exploitation :</strong></td>
                                  <td nowrap><select name="id_juridiction" id="id_juridiction">
<?php if ($totalRows_liste_juridiction==0) { ?>
                                    <option value="0">Toutes juridictions</option>
<?php } else { ?>									
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_liste_juridiction['id_juridiction']?>"><?php echo $row_liste_juridiction['lib_juridiction']?></option>
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
                                        <td bgcolor="#E9F2FB"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="Style10">
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
                                              <td><input <?php if (!(strcmp($_POST['ajouter_admin'],1))) {echo "checked=\"checked\"";} ?> name="ajouter_admin" type="checkbox" id="ajouter_admin" value="1"></td>
                                              <td><input <?php if (!(strcmp($_POST['modifier_admin'],1))) {echo "checked=\"checked\"";} ?> name="modifier_admin" type="checkbox" id="modifier_admin" value="1"></td>
                                              <td><input <?php if (!(strcmp($_POST['visualiser_admin'],1))) {echo "checked=\"checked\"";} ?> name="visualiser_admin" type="checkbox" id="visualiser_admin" value="1"></td>
                                              <td><input <?php if (!(strcmp($_POST['supprimer_admin'],1))) {echo "checked=\"checked\"";} ?> name="supprimer_admin" type="checkbox" id="supprimer_admin" value="1"></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" nowrap class="Style22"><input name="id_admincreation" type="hidden" id="id_admincreation" value="<?php echo $row_select_admin['Id_admin']; ?>">
                                    <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>"></td>
                                  <td nowrap><input name="ajouter_cmd" type="submit" id="ajouter_cmd" value="Ajouter l'administrateur"></td>
                                </tr>
                              </table>
                            <input type="hidden" name="MM_insert" value="form1">
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

mysql_free_result($typejuridiction);
?>
