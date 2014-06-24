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
// à elle seule, la ligne suivante suffit à envoyer le résultat du script dans une feuille Excel
header("Content-type: application/vnd.ms-excel");

if ((isset($_POST["Executer_cmd"])) && ($_POST["Executer_cmd"] == "Exécuter")) {
	if ((isset($_POST["action_chk1"])) && ($_POST["action_chk1"] == "MAJ")) {
		if ((isset($_POST["stat_chk1"])) && ($_POST["stat_chk1"] == "PENALES")) {
			// la ligne suivante est facultative, elle sert à donner un nom au fichier Excel
  			header("Content-Disposition: attachment; filename=C:\Justice\statpenales.xls"); 
			require_once('statistiquesmajpenales.php');		
		}
		if ((isset($_POST["stat_chk2"])) && ($_POST["stat_chk2"] == "CIVILS")) {
			// la ligne suivante est facultative, elle sert à donner un nom au fichier Excel
  			header("Content-Disposition: attachment; filename=C:\Justice\statcivils.xls"); 
			require_once('statistiquesmajcivil.php');
		}
		if ((isset($_POST["stat_chk3"])) && ($_POST["stat_chk3"] == "SOCIALES")) {
			// la ligne suivante est facultative, elle sert à donner un nom au fichier Excel
  			header("Content-Disposition: attachment; filename=C:\Justice\statsociales.xls"); 
			require_once('statistiquesmajsociales.php');		
		}
		if ((isset($_POST["stat_chk4"])) && ($_POST["stat_chk4"] == "PENITENTIAIRES")) {
			// la ligne suivante est facultative, elle sert à donner un nom au fichier Excel
  			header("Content-Disposition: attachment; filename=C:\Justice\statpenitentiaires.xls"); 
			require_once('statistiquesmajpenitentiaires.php');		
		}
	}
	if ((isset($_POST["action_chk2"])) && ($_POST["action_chk2"] == "EXP")) {
		if ((isset($_POST["stat_chk1"])) && ($_POST["stat_chk1"] == "PENALES")) {
  			header("Content-Disposition: attachment; filename=C:\Justice\statpenales.xls"); 
			require_once('statistiquesexppenales.php');		
		}
		if ((isset($_POST["stat_chk2"])) && ($_POST["stat_chk2"] == "CIVILS")) {
  			header("Content-Disposition: attachment; filename=C:\Justice\statcivils.xls");
			require_once('statistiquesexpcivil.php');
		}
		if ((isset($_POST["stat_chk3"])) && ($_POST["stat_chk3"] == "SOCIALES")) {
  			header("Content-Disposition: attachment; filename=C:\Justice\statsociales.xls"); 
			require_once('statistiquesexpsociales.php');		
		}
		if ((isset($_POST["stat_chk4"])) && ($_POST["stat_chk4"] == "PENITENTIAIRES")) {
  			header("Content-Disposition: attachment; filename=C:\Justice\statpenitentiaires.xls"); 
			require_once('statistiquesexppenitentiaires.php');		
		}
	}
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
  </script>
<style type="text/css">
#preload {display:none;}
</style>

<script type="text/javascript">
function ShowHide(EltId,Action) {
var elt = document.getElementById(EltId); if (!elt) return;
Action = (typeof Action=="undefined" ) ? "" : Action.substring(0,1).toLowerCase();
with(elt.style) {
display = (Action=="" ) ? (display=="block" || display=="" ) ? "none" : "block" : (Action=="h" ) ? "none" : "block";
   }
}

</script>
</head>

<body class="stat" onload="ShowHide('preload','h');">
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
                      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><table cellpadding="1" cellspacing="0" >
                            <tr align="right" bgcolor="#6186AF">
                              <td><table cellpadding="5" cellspacing="1" >
                                <tr bgcolor="#677787" class="Style22">
                                  <td colspan="4" nowrap><strong>Selectionner les statistiques &agrave; Mettre &agrave; jour et/ou Exporter </strong></td>
                                </tr>
                                <tr bgcolor="#EDF0F3" class="Style22">
                                  <td colspan="4" valign="top" nowrap bgcolor="#EDF0F3"><table border="0" cellspacing="1" cellpadding="5">
                                      <tr>
                                        <td rowspan="4"><img src="images/spacer.gif" width="30" height="1"></td>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk1'],1))) {echo "checked=\"checked\"";} ?> name="stat_chk1" type="checkbox" id="stat_chk1" value="PENALES"></td>
                                        <td nowrap>Statistiques P&eacute;nales</td>
                                      </tr>
                                      <tr>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk2'],1))) {echo "checked=\"checked\"";} ?> name="stat_chk2" type="checkbox" id="stat_chk2" value="CIVILS"></td>
                                        <td nowrap>Statistiques Civils, Commerciales et administratives</td>
                                      </tr>
                                      <tr>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk3'],1))) {echo "checked=\"checked\"";} ?> name="stat_chk3" type="checkbox" id="stat_chk3" value="SOCIALES"></td>
                                        <td nowrap>Statistiques Sociales</td>
                                      </tr>
                                      <tr>
                                        <td><input <?php if (!(strcmp($_POST['stat_chk4'],1))) {echo "checked=\"checked\"";} ?> name="stat_chk4" type="checkbox" id="stat_chk4" value="PENITENTIAIRES"></td>
                                        <td nowrap>Statistiques des administrations P&eacute;nitentiaires</td>
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
                                        <td nowrap><input <?php if (!(strcmp($_POST['action_chk1'],1))) {echo "checked=\"checked\"";} ?> name="action_chk1" type="checkbox" id="action_chk1" value="MAJ"></td>
                                        <td nowrap>Mise &agrave; jour </td>
                                        <td nowrap><input <?php if (!(strcmp($_POST['action_chk2'],1))) {echo "checked=\"checked\"";} ?> name="action_chk2" type="checkbox" id="action_chk2" value="EXP"></td>
                                        <td nowrap>Exporter</td>
                                        <td width="100%" align="center"><input name="id_juridiction" type="hidden" id="id_juridiction" value="<?php echo $row_select_admin['id_juridiction']; ?>" size="3">
                                            <input name="Executer_cmd" type="submit" id="Executer_cmd6" value="Exécuter"></td>
                                      </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                          <td width="100%" valign="top"><div align="center"><img src="images/VST05040.gif" width="80" height="80">                           
                              </div><?php if ((isset($_POST["Executer_cmd"])) && ($_POST["Executer_cmd"] == "Exécuter")) { ?>
                            <strong>
                            <p align="center" class="Style22"><?php if ($_POST['action_chk1']==1){?>Mise &agrave; jour <?php } if (($_POST['action_chk1']==1) && ($_POST['action_chk2']==1)){ ?> et <?php } if ($_POST['action_chk2']==1){?>Exportation <?php } ?>des statistiques</p></strong>
                            <ul>
                              <?php if ($_POST['stat_chk1']==1){?><li class="Style22">Statistiques P&eacute;nales</li>
                              <?php } ?>
                              <?php if ($_POST['stat_chk2']==1){?><li class="Style22"> Statistiques Civils, Commerciales et administratives</li>
                              <?php } ?>
                              <?php if ($_POST['stat_chk3']==1){?><li class="Style22"> Statistiques Sociales</li>
                              <?php } ?>
                              <?php if ($_POST['stat_chk4']==1){?><li class="Style22">Statistiques des administrations P&eacute;nitentiaires</li>
                              <?php } ?>
                            </ul>
<?php } ?>                                                        
                            <div id="preload"> 
                            <table width="100%" border="0" cellpadding="5" cellspacing="5">
                              <tr>
                                <td>								  								
								<table width="100%" cellpadding="1" cellspacing="0" >
                                 <tr bgcolor="#6186AF">							  
                                    <td align="center" bgcolor="#FFFFFF"><p>&nbsp;</p>
                                      <p>&nbsp;</p>                                      <p>chargement ...<br>                                      
                                        <img src="images/loading6yt.gif" width="389" height="19">                                                                            </p>
                                      <p class="Style31">&nbsp;</p>
                                      <p>&nbsp;</p></td>
                                  </tr>
                                </table>
								</td>
                              </tr>
                            </table></div>
							<script language="javascript">ShowHide('preload','s');</script>
                            </td>
                        </tr>
                      </table>                        </td>
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
