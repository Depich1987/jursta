<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Civile,Penale,Administrateur,Sociale,Penitentiaire,Superviseur";
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
	ini_set ('max_execution_time', 0); // Aucune limite d'execution
	$maj_insertSQL_final_total="";
?>
<?php
$colname_juridiction = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_juridiction = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}

mysql_select_db($database_jursta, $jursta);
$query_juridiction = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = '%s') AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", $colname_select_juridiction);
$juridiction = mysql_query($query_juridiction, $jursta) or die(mysql_error());
$row_juridiction = mysql_fetch_assoc($juridiction);
$totalRows_juridiction = mysql_num_rows($juridiction);

mysql_select_db($database_jursta, $jursta);
$query_liste_typejuridiction = "SELECT * FROM type_juridiction WHERE (id_typejuridiction <> 5) ORDER BY lib_typejuridiction ASC";
$liste_typejuridiction = mysql_query($query_liste_typejuridiction, $jursta) or die(mysql_error());
$row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
$totalRows_liste_typejuridiction = mysql_num_rows($liste_typejuridiction);

$colname_liste_juridiction = "-1";
if (isset($_POST['id_typejuridiction'])) {
  $colname_liste_juridiction = (get_magic_quotes_gpc()) ? $_POST['id_typejuridiction'] : addslashes($_POST['id_typejuridiction']);
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", $colname_liste_juridiction);
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);
?>
<?php
if ((isset($_POST["Executer_cmd"])) && ($_POST["Executer_cmd"] == "Exécuter")) {
	if ((isset($_POST["action_chk2"])) && ($_POST["action_chk2"] == "EXP")) {
		if ((isset($_POST["stat_chk1"])) && ($_POST["stat_chk1"] == "PENALES")) {
			require_once('statistiquesmajpenales.php');	
		}
		if ((isset($_POST["stat_chk2"])) && ($_POST["stat_chk2"] == "CIVILS")) {
			require_once('statistiquesmajcivil.php');
		}
		if ((isset($_POST["stat_chk3"])) && ($_POST["stat_chk3"] == "SOCIALES")) {
			require_once('statistiquesmajsociales.php');		
		}
		if ((isset($_POST["stat_chk4"])) && ($_POST["stat_chk4"] == "PENITENTIAIRES")) {
			require_once('statistiquesmajpenitentiaires.php');		
		}
	}
}	
?>
<?php $fichier="STAT"; ?>
<?php if ($_POST['stat_chk1']=="PENALES"){ $fichier.="_PENALES"; } ?>
<?php if ($_POST['stat_chk2']=="CIVILS"){ $fichier.="_CIVILS"; } ?>
<?php if ($_POST['stat_chk3']=="SOCIALES"){ $fichier.="_SOCIALES"; } ?>
<?php if ($_POST['stat_chk4']=="PENITENTIAIRES"){ $fichier.="_PENITENTIAIRES"; } ?>
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

<body class="stat">
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td background="images/index_01.gif"><?php require_once('haut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuhaut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuidentity.php'); ?></td>
  </tr>
  <tr>
    <td><table width="940"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td bgcolor="#FFFFFF"><form action="transferedata.php" method="post" name="form1">
            <table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="100%" valign="middle" >
                  <table width="100%" >
                    <tr>
                      <td valign="top"><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                      <td width="100%"><span class="Style2">Mise &agrave; jour et Transfert de donn&eacute;es</span> </td>
                    </tr>
                    <tr>
                      <td valign="top">&nbsp;</td>
                      <td><table width="100%" cellpadding="3" cellspacing="0" >
                        <tr bgcolor="#EDF0F3" class="Style22">
                          <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
                          <td align="right" nowrap>Type de juridiction : </td>
                          <td nowrap><select name="id_typejuridiction" id="id_typejuridiction" onChange="document.form1.submit();">
                            <option value="-1" <?php if (!(strcmp(-1, $_POST['id_typejuridiction']))) {echo "SELECTED";} ?>>Selectionner... </option>
                            <?php
do {  
?>
                            <option value="<?php echo $row_liste_typejuridiction['id_typejuridiction']?>"<?php if (!(strcmp($row_liste_typejuridiction['id_typejuridiction'], $_POST['id_typejuridiction']))) {echo "SELECTED";} ?>><?php echo $row_liste_typejuridiction['lib_typejuridiction']?></option>
                            <?php
} while ($row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction));
  $rows = mysql_num_rows($liste_typejuridiction);
  if($rows > 0) {
      mysql_data_seek($liste_typejuridiction, 0);
	  $row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
  }
?>
                          </select></td>
                          <?php if (($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))){ ?>
                          <td align="center" nowrap>Juridiction : </td>
                          <td nowrap><select name="id_juridiction1" id="id_juridiction1" onChange="document.form1.submit();">
                            <option value="-1" <?php if (!(strcmp(-1, $_POST['id_juridiction1']))) {echo "SELECTED";} ?>>Selectionner...</option>
                            <?php
do {  
?>
                            <option value="<?php echo $row_liste_juridiction['id_juridiction']?>"<?php if (!(strcmp($row_liste_juridiction['id_juridiction'], $_POST['id_juridiction1']))) {echo "SELECTED";} ?>><?php echo $row_liste_juridiction['lib_juridiction']?></option>
                            <?php
} while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction));
  $rows = mysql_num_rows($liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($liste_juridiction, 0);
	  $row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
  }
?>
                          </select></td>
                          <td width="100%" nowrap>&nbsp;</td>
                          <?php } ?>
                          <?php } // Show if recordset empty ?>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td valign="top">&nbsp;</td>
                      <td>
                          <?php if (((($_POST['id_typejuridiction']!=-1) && (isset($_POST['id_typejuridiction']))) && (($_POST['id_juridiction1']!=-1) && (isset($_POST['id_juridiction1'])))) || ($row_select_juridiction['id_juridiction'] != 55)) { ?>	
                          <?php if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty ?>
						  <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $_POST['id_juridiction1']; ?>" size="3">
						  <?php }
						  else {
						  ?>
						  <input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_admin['id_juridiction']; ?>" size="3">						  
						  <?php } ?>					  
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><div align="center"><img src="images/VST05040.gif" width="100">
                          </div>
                            <table cellpadding="1" cellspacing="0" >
                            <tr align="right" bgcolor="#6186AF">
                              <td><table cellpadding="5" cellspacing="1" >
                                <tr bgcolor="#677787" class="Style22">
                                  <td colspan="4" nowrap><strong>Selectionner les statistiques &agrave; Mettre &agrave; jour et/ou Exporter </strong></td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td colspan="4" valign="top" nowrap bgcolor="#EDF0F3"><table border="0" cellspacing="1" cellpadding="5">
                                      <tr>
                                        <td rowspan="4"><img src="images/spacer.gif" width="30" height="1"></td>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk1'],"PENALES"))) {echo "checked=\"checked\"";} ?> name="stat_chk1" type="checkbox" id="stat_chk1" value="PENALES"></td>
                                        <td align="left" nowrap>Statistiques P&eacute;nales</td>
                                      </tr>
                                      <tr>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk2'],"CIVILS"))) {echo "checked=\"checked\"";} ?> name="stat_chk2" type="checkbox" id="stat_chk2" value="CIVILS"></td>
                                        <td align="left" nowrap>Statistiques Civils, Commerciales et administratives</td>
                                      </tr>
                                      <tr>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk3'],"SOCIALES"))) {echo "checked=\"checked\"";} ?> name="stat_chk3" type="checkbox" id="stat_chk3" value="SOCIALES"></td>
                                        <td align="left" nowrap>Statistiques Sociales</td>
                                      </tr>
                                      <tr>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk4'],"PENITENTIAIRES"))) {echo "checked=\"checked\"";} ?> name="stat_chk4" type="checkbox" id="stat_chk4" value="PENITENTIAIRES"></td>
                                        <td align="left" nowrap>Statistiques des administrations P&eacute;nitentiaires</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr bgcolor="#677787" class="Style22">
                                  <td colspan="4" valign="top" nowrap><strong>Action &agrave; effectuer </strong></td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td height="26" colspan="4" nowrap bgcolor="#EDF0F3"><table width="100%"  border="0" cellpadding="5" cellspacing="1">
                                      <tr>
                                        <td nowrap><img src="images/spacer.gif" width="30" height="1"></td>
                                        <td nowrap><input <?php if (!(strcmp($_POST['action_chk1'],"MAJ"))) {echo "checked=\"checked\"";} ?> name="action_chk1" type="checkbox" id="action_chk1" value="MAJ"></td>
                                        <td nowrap>Mise &agrave; jour </td>
                                        <td nowrap><input <?php if (!(strcmp($_POST['action_chk2'],"EXP"))) {echo "checked=\"checked\"";} ?> name="action_chk2" type="checkbox" id="action_chk2" value="EXP"></td>
                                        <td nowrap>Exporter</td>
                                        <td width="100%" align="center">                                              <input name="Executer_cmd" type="submit" id="Executer_cmd6" value="Exécuter"></td></tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>                            </td>
                          <td width="100%" valign="top"><?php if ((isset($_POST["Executer_cmd"])) && ($_POST["Executer_cmd"] == "Exécuter")) { ?>
                            <strong>
                            <p align="center" class="Style22"><?php if ($_POST['action_chk1']=="MAJ"){?>Mise &agrave; jour <?php } if (($_POST['action_chk1']=="MAJ") && ($_POST['action_chk2']=="EXP")){ ?> et <?php } if ($_POST['action_chk2']=="EXP"){?>Exportation <?php } ?>des statistiques</p></strong>
                            <ul>
                              <?php if ($_POST['stat_chk1']=="PENALES"){?><li class="Style22">Statistiques P&eacute;nales<br>
                              </li>
                              <?php } ?>
                              <?php if ($_POST['stat_chk2']=="CIVILS"){?><li class="Style22"> Statistiques Civils, Commerciales et administratives<br>
                              </li>
                              <?php } ?>
                              <?php if ($_POST['stat_chk3']=="SOCIALES"){?><li class="Style22"> Statistiques Sociales<br>
                              </li>
                              <?php } ?>
                              <?php if ($_POST['stat_chk4']=="PENITENTIAIRES"){?><li class="Style22">Statistiques des administrations P&eacute;nitentiaires                                
                                <br><?php } ?>
                              </li>
                              <li class="Style22"><span class="Style22">informations compl&eacute;mentaires<br></span>
                                <textarea name="Sql_text" cols="55" rows="15" class="Style11" id="Sql_text" readonly="readonly"><?php echo $maj_insertSQL_final_total; ?></textarea>
                                </li>
                              </ul>	
<?php
if ((isset($_POST["Executer_cmd"])) && ($_POST["Executer_cmd"] == "Exécuter") && (isset($_POST["action_chk1"])) && ($_POST["action_chk1"] == "MAJ")) {
$hostname_majjursta = "127.0.0.1";
$database_majjursta = "db_jursta1";
$username_majjursta = "root";
$password_majjursta = "";
$majjursta = mysql_pconnect($hostname_majjursta, $username_majjursta, $password_majjursta) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_majjursta, $majjursta);
$majdata = @mysql_query($maj_insertSQL_final_total, $majjursta) or die(mysql_error());
echo "La Mise à jour des données à distance s'est déroulée correctement";
}

?>							  					  
                                  <?php } ?>
                              </td>
                        </tr>
                      </table>
                        <?php } ?>                        </td>
                    </tr>
                </table></td>
              </tr>
            </table>
            
          </form>          </td>
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
if ($_POST['action_chk2']=="EXP"){
	$fichier.="_".$juridiction.".TXT";
	header('Content-type: text/plain');
	header("Content-Disposition: application/force-download; name=".$fichier."");
	header("Content-Disposition: attachment; filename=".$fichier."");
	echo $maj_insertSQL_final_total;
}
?>							 
<?php
mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);
?>
