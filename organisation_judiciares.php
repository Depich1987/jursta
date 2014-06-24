<?php require_once('Connections/jursta.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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

$currentPage = $_SERVER["PHP_SELF"];
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
    <td valign="top"><table width="100%" >
      <tr>
        <td bgcolor="#174F8A"><img border="0" src="images/fond-dec_09.jpg" title="" width="32"></td>
        <td width="100%" bgcolor="#174F8A" class="Style2">Organisation g&eacute;n&eacute;rale des juridictions</td>
      </tr>
    </table>
      <table width="100%" cellpadding="0" cellspacing="5" >
        <tr>
          <td align="left"><table>
            <tr>
              <td><a href="#" onClick="javascript:ouvre_popup('add_organisation.php',495,287)"><img src="images/rename_f2.png" width="16" border="0"></a> </td>
              <td class="Style10"><a href="#" onClick="javascript:ouvre_popup('add_organisation.php',495,287)">Ajouter</a></td>
              <td><a href="#" onClick="javascript:ouvre_popup('modif_organisation.php',495,287)"><img src="images/edit_f2.png" title="Ajouter" width="16" border="0"></a></td>
              <td class="Style10"><a href="#" onClick="javascript:ouvre_popup('modif_organisation.php',495,287)">Modifier</a></td>
              <td><a href="organisation_judiciaires" onClick="return(Confirm('Voulez-vous vraiment supprimer la selection?'))"><img src="images/cancel_f2.png" width="16" border="0"></a></td>
              <td class="Style10"><a href="organisation_judiciaires" onClick="return(Confirm('Voulez-vous vraiment supprimer la selection?'))">Supprimer</a></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          <td width="100%" rowspan="5" valign="top"><table width="100%"  border="0" cellpadding="3" cellspacing="2">
            <tr>
              <td nowrap bgcolor="#D0D9E0" class="Style26"><strong>Statistiques P&eacute;nales </strong></td>
              </tr>
            <tr>
              <td><table  border="0" cellspacing="5" cellpadding="5">
                <tr>
                  <td><img src="images/spacer.gif" width="20" height="8"></td>
                  <td><a href="stat_police.php"><img src="images/contentheading.png" width="31" height="14" border="0"></a></td>
                  <td> <a href="stat_police.php">Police/Gendarmerie/Saisine&nbsp;du&nbsp;Parquet</a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><a href="stat_oientationaffair.php"><img src="images/contentheading.png" width="31" height="14" border="0"></a></td>
                  <td> <a href="stat_oientationaffair.php">Orientation&nbsp;des&nbsp;Affaires&nbsp;du&nbsp;parquet</a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><a href="stat_jugeinstruction.php"><img src="images/contentheading.png" width="31" height="14" border="0"></a></td>
                  <td> <a href="stat_jugeinstruction.php">Activit&eacute;s&nbsp;des&nbsp;Juges</a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><img src="images/contentheading.png" width="31" height="14"></td>
                  <td> Condamnations&nbsp;apr&egrave;s&nbsp;d&eacute;tention&nbsp;provisoire</td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td bgcolor="#D0D9E0" class="Style26">Statistiques Civiles</td>
            </tr>
            <tr>
              <td><table  border="0" cellspacing="5" cellpadding="5">
                <tr>
                  <td><img src="images/spacer.gif" width="20" height="8"></td>
                  <td><a href="stat_police.php"><img src="images/contentheading.png" width="31" height="14" border="0"></a></td>
                  <td> <a href="stat_police.php">Civiles/Commerciales/Administratives</a></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td bgcolor="#D0D9E0" class="Style26">Statistiques Sociales </td>
            </tr>
            <tr>
              <td class="Style26"><table  border="0" cellspacing="5" cellpadding="5">
                <tr>
                  <td><img src="images/spacer.gif" width="20" height="8"></td>
                  <td><a href="stat_police.php"><img src="images/contentheading.png" width="31" height="14" border="0"></a></td>
                  <td nowrap> <a href="stat_police.php">Etats Sociales</a></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><iframe name="arbre" id="arbre" width="350" height="370" frameborder="0" scrolling="Auto" src="organisation.php">iFrame non pris en compte par la version de votre navigateur veuillez mettre à jour votre navigateur. </iframe></td>
        </tr>
        <tr>
          <td align="left"><table>
            <tr>
              <td><a href="#" onClick="javascript:ouvre_popup('add_organisation.php',495,287)"><img src="images/rename_f2.png" width="16" border="0"></a> </td>
              <td class="Style10"><a href="#" onClick="javascript:ouvre_popup('add_organisation.php',495,287)">Ajouter</a></td>
              <td><a href="#" onClick="javascript:ouvre_popup('modif_organisation.php',495,287)"><img src="images/edit_f2.png" title="Ajouter" width="16" border="0"></a></td>
              <td class="Style10"><a href="#" onClick="javascript:ouvre_popup('modif_organisation.php',495,287)">Modifier</a></td>
              <td><a href="organisation_judiciaires" onClick="return(Confirm('Voulez-vous vraiment supprimer la selection?'))"><img src="images/cancel_f2.png" width="16" border="0"></a></td>
              <td class="Style10"><a href="organisation_judiciaires" onClick="return(Confirm('Voulez-vous vraiment supprimer la selection?'))">Supprimer</a></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </td>
    <td width="50%" align="center" valign="top" background="images/continue.jpg">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
