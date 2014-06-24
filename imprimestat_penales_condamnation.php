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

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Penale'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);

mysql_select_db($database_jursta, $jursta);
$query_liste_typejuridiction = "SELECT * FROM type_juridiction WHERE (id_typejuridiction <> 5) ORDER BY lib_typejuridiction ASC";
$liste_typejuridiction = mysql_query($query_liste_typejuridiction, $jursta) or die(mysql_error());
$row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
$totalRows_liste_typejuridiction = mysql_num_rows($liste_typejuridiction);

$colname_liste_juridiction = "1";
if (isset($_POST['type_juridiction'])) {
  $colname_liste_juridiction = (get_magic_quotes_gpc()) ? $_POST['type_juridiction'] : addslashes($_POST['type_juridiction']);
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", $colname_liste_juridiction);
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
  </script></head>

<body class="imprime">
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span class="Style2"><a href="stat_cdppenal.php"><img src="images/forms48.png" width="32" border="0"></a></span></td>
                      <td width="100%" align="center"><p class="Style2"><?php echo $row_select_juridiction['lib_typejuridiction']; ?> DE <?php echo substr($row_select_juridiction['lib_juridiction'],2,10); ?></p>
                        <p class="Style2">STATISTIQUE DES CONDAMNATIONS APRES DETENTIONS PROVISOIRES  
                          <?php 
if ($row_select_juridiction['id_juridiction'] == 55) {
	if ((isset($_GET['du'])) && (isset($_GET['au']))) {
		echo("PERIODE DU ".$_GET['du']." au ".$_GET['au']);
	}
}
else { 
	switch ($_POST['mois']) {
		case "01": $mois="Janvier";
		break;
			case "02": $mois="Fevrier";
		break;
			case "03": $mois="Mars";
		break;
			case "04": $mois="Avril";
		break;
			case "05": $mois="Mai";
		break;
			case "06": $mois="Juin";
		break;
			case "07": $mois="Juillet";
		break;
			case "08": $mois="Août";
		break;
			case "09": $mois="Septembre";
		break;
			case "10": $mois="Octobre";
		break;
			case "11": $mois="Novembre";
		break;
			case "12": $mois="Décembre";
	}
	echo Change_formatDate("PERIODE DE ".$mois." ".$_POST['annee']);
}
?>
                         </p></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" ><p>&nbsp;</p>
                  <table>
                    <tr>
                      <td bgcolor="#000000"><table width="940" cellpadding="3" cellspacing="1" >
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td colspan="2"><p></p></td>
                          <td colspan="6" align="center" valign="middle" class="Style10"> CONDAMNATIONS APRES DETENTIONS PROVISOIRES POUR CRIME</td>
                          <td colspan="9" align="center" valign="middle" class="Style10">CONDAMNATIONS APRES DETENTIONS PROVISOIRES POUR DELIT</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center">#</td>
                          <td align="center">Nature
                              <div align="center"></div>
                            <div align="center"></div></td>
                          <td align="center"><div align="center">Cond.<br>
        Apr&egrave;s D.P.</div></td>
                          <td align="center" nowrap><div align="center">DP<br>
        [0 &agrave; 1[<br>
        an</div></td>
                          <td align="center" nowrap>
                            <div align="center">DP<br>
        [1 &agrave; 2[<br>
        ans</div></td>
                          <td align="center" nowrap>
                            <div align="center">DP<br>
        [2 &agrave; 3[<br>
        ans</div></td>
                          <td align="center" nowrap><p align="center">DP<br>
        [3 &agrave; +[</p></td>
                          <td align="center">Dur&eacute;e Moy.<br>
      D.P.<br>
      Criminelle</td>
                          <td align="center">
                            <div align="center">Condam-<br>
        nation<br>
        Apr&egrave;s D.P.</div></td>
                          <td align="center" nowrap>DP<br>
      [0 &agrave; 2[<br>
      mois</td>
                          <td align="center" nowrap>DP<br>
      [2 &agrave; 4[<br>
      mois</td>
                          <td align="center" nowrap>DP<br>
      [4 &agrave; 8[<br>
      mois</td>
                          <td align="center" nowrap>DP<br>
      [8 &agrave; 1[<br>
      an</td>
                          <td align="center" nowrap>DP<br>
      [1 &agrave; 2[<br>
      ans</td>
                          <td align="center" nowrap>DP<br>
      [2 &agrave; 3[<br>
      ans</td>
                          <td align="center" nowrap>DP<br>
      [3 &agrave; +[</td>
                          <td align="center">Dur&eacute;e Moy.<br>
      D.P.<br>
      D&eacute;lictuelle</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center" class="Style22">1</td>
                          <td nowrap >Vol,Recels, Desctructions</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center" class="Style22">2</td>
                          <td nowrap >Viol, Agression sexuelle</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center" class="Style22">3</td>
                          <td nowrap >Coups et Blessures volontaires</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center" class="Style22">5</td>
                          <td nowrap >Escroqueries, Abus de Confiance</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center" class="Style22">7</td>
                          <td nowrap >Atteintes aux moeurs</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                        </tr>
                        <tr bgcolor="#FFFFFF" class="Style22">
                          <td align="center" class="Style22">8</td>
                          <td nowrap >Circulation Routi&egrave;re</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                          <td align="center" class="Style22">0</td>
                        </tr>
                        <tr bgcolor="#677787">
                          <td colspan="17" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                </td>
              </tr>
          </table></td>
        </tr>
        </table></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($liste_nature);

mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);

mysql_free_result($crimes_constates);

mysql_free_result($crimes_poursuivis);

mysql_free_result($pvdedenonciation);

mysql_free_result($pvauteurinconnus);

mysql_free_result($pvcrimes);

mysql_free_result($pvdelit);

mysql_free_result($pvcontraventions);

mysql_free_result($affairepenals);

mysql_free_result($affaireautresparquet);
?>
