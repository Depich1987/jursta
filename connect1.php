<?php require_once('Connections/jursta.php'); ?>
<?php
//initialize the session
session_start();

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
//session_start();
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
$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE Login_admin = '%s'", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_1018160732_0) return;
      window.mm_menu_1018160732_0 = new Menu("root",164,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018160732_0.addMenuItem("Modifier&nbsp;mot&nbsp;de&nbsp;passe");
  mm_menu_1018160732_0.addMenuItem("Créer&nbsp;un&nbsp;compte");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;droits");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;cours&nbsp;d'appel");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;le&nbsp;tribunaux");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;villes");
   mm_menu_1018160732_0.hideOnMouseOut=true;
   mm_menu_1018160732_0.bgColor='#555555';
   mm_menu_1018160732_0.menuBorder=1;
   mm_menu_1018160732_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1018160732_0.menuBorderBgColor='#777777';
      window.mm_menu_1018162239_0 = new Menu("root",278,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018162239_0.addMenuItem("Police/Gendarmerie/Saisine&nbsp;du&nbsp;Parquet","location='#'");
  mm_menu_1018162239_0.addMenuItem("Orientation&nbsp;des&nbsp;Affaires&nbsp;du&nbsp;parquet","location='#'");
  mm_menu_1018162239_0.addMenuItem("Activités&nbsp;des&nbsp;Juges","location='#'");
  mm_menu_1018162239_0.addMenuItem("Condamnations&nbsp;après&nbsp;détention&nbsp;provisoire","location='#'");
   mm_menu_1018162239_0.hideOnMouseOut=true;
   mm_menu_1018162239_0.bgColor='#555555';
   mm_menu_1018162239_0.menuBorder=1;
   mm_menu_1018162239_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1018162239_0.menuBorderBgColor='#777777';

  window.mm_menu_1124011501_0 = new Menu("root",316,18,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1124011501_0.addMenuItem("Actes&nbsp;de&nbsp;Notoriété&nbsp;suppléant&nbsp;l'acte&nbsp;de&nbsp;naissance","location='liste_repactenoto.php'");
  mm_menu_1124011501_0.addMenuItem("Attestation&nbsp;de&nbsp;la&nbsp;Chambre&nbsp;Civil","location='liste_acc.php'");
   mm_menu_1124011501_0.fontWeight="bold";
   mm_menu_1124011501_0.hideOnMouseOut=true;
   mm_menu_1124011501_0.bgColor='#555555';
   mm_menu_1124011501_0.menuBorder=1;
   mm_menu_1124011501_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1124011501_0.menuBorderBgColor='#777777';

mm_menu_1124011501_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Style26 {font-size: 18px; color: #6186AF; font-family: Arial, Helvetica, sans-serif;}
-->
</style>
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<script language="JavaScript1.2">mmLoadMenus();</script>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <div align="center"></div>
  <TABLE WIDTH=768 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
    <TR>
      <TD ROWSPAN=4> <IMG SRC="images/index_01.gif" WIDTH=18 HEIGHT=122 title=""></TD>
      <TD> <IMG SRC="images/index_02.jpg" WIDTH=178 HEIGHT=25 title=""></TD>
      <TD COLSPAN=2> <IMG SRC="images/index_03.gif" WIDTH=572 HEIGHT=25 title=""></TD>
    </TR>
    <TR>
      <TD> <IMG SRC="images/index_04.gif" WIDTH=178 HEIGHT=57 title=""></TD>
      <TD> <IMG SRC="images/index_05.gif" WIDTH=8 HEIGHT=57 title=""></TD>
      <TD> <IMG SRC="images/spacer.gif" WIDTH=564 HEIGHT=57 title=""></TD>
    </TR>
    <TR>
      <TD> <IMG SRC="images/index_07.gif" WIDTH=178 HEIGHT=7 title=""></TD>
      <TD> <IMG SRC="images/index_08.gif" WIDTH=8 HEIGHT=7 title=""></TD>
      <TD> <IMG SRC="images/spacer.gif" WIDTH=564 HEIGHT=7 title=""></TD>
    </TR>
    <TR>
      <TD COLSPAN=3> <IMG SRC="images/index_10.gif" WIDTH=750 HEIGHT=33 title=""></TD>
    </TR>
  </TABLE>
  <table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
      <td bgcolor="#6186AF"><table border="0" align="center" cellpadding="3" cellspacing="1">
        <tr bgcolor="#6186AF">
          <?php if ($_SESSION['MM_UserGroup']=="Administrateur") {?>
		  <td bgcolor="#6186AF"><a href="#" name="link5" class="Style21" id="link1" onMouseOver="MM_showMenu(window.mm_menu_1018160732_0,0,18,null,'link5')" onMouseOut="MM_startTimeout();">Param&eacute;trage de Base</a></td>
          <td bgcolor="#6186AF">
		            <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penale"))
{?>
		  <table cellpadding="0" cellspacing="0" >
            <tr>
              <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
            </tr>
          </table>            </td>
		  <td background="stat_police.php" bgcolor="#6186AF"><a href="#" name="link3" id="link3" onMouseOver="MM_showMenu(window.mm_menu_1018162239_0,0,18,null,'link3')" onMouseOut="MM_startTimeout();">Statistiques P&eacute;nales </a></span></td>
          <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
          <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Civile"))
{?>
<td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		  <td bgcolor="#6186AF"><a href="stat_affaircivil.php">Statistiques Civils, Commerciales et administratives</a> </span></td>
          <td bgcolor="#6186AF"><table cellpadding="0" cellspacing="0" >
            <tr>
              <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
            </tr>
          </table></td>
                    <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Sociale"))
{?>
		  <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		  <td bgcolor="#6186AF"><a href="stat_affairsocial.php">Statistiques Sociales </a></td>
          <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
          <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penitentiaire"))
{?>
		  <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		  <td><a href="stat_adminpenit.php">Statistiques des administrations P&eacute;nitentiaires </a></span></td>
        <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		<?php } ?>
		<td><a href="<?php echo $logoutAction ?>" onClick="return confirmdelete('Voulez-vous vous déconnecter ?');">D&eacute;connection</a></td></tr>
      </table></td>
    </tr>
  </table>
  
  <table width="100%" border="0" cellpadding="3" cellspacing="0"> 
    <tr>
      <td width="100%" align="center" class="Style22"><strong>Bienvenue</strong> <span class="Style23"><?php echo $row_select_admin['nom_admin']; ?> <?php echo $row_select_admin['prenoms_admin']; ?></span> </td>
      <td nowrap class="Style14 Style24"><?php echo date("Y-m-d H:i:s");?></span></td>
    </tr>
  </table>  
  <table width="100%" >
    <tr>
      <td width="250" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#677787"><table width="100%" border="0" cellpadding="0" cellspacing="1">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" cellpadding="5" >
                    <tr>
                      <td bgcolor="#EDF0F3"><div id="Accordion1" class="Accordion" tabindex="0">
                        <?php if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Civile")) {?>                        
                        <div class="AccordionPanel">
                          <div class="AccordionPanelTab">Section Civile Commerciale et Administrative</div>
                          <div class="AccordionPanelContent">
                            <table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="liste_rolegeneral.php" class="fiche">R&ocirc;le g&eacute;n&eacute;ral</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Grand livre</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des consignations</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre d'expertise </a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_repjug.php" class="fiche">Repertoire des Jugements suppletifs </a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_repordpresi.php" class="fiche">Repertoire des ordonnances pr&eacute;sidentielles </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" name="link2" class="fiche" id="link2" onMouseOver="MM_showMenu(window.mm_menu_1124011501_0,185,15,null,'link2')" onMouseOut="MM_startTimeout();">Repertoire des actes </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Livre journal </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Plumitif </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des mises en etat </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des conciliations</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des requ&ecirc;tes aux fins d'injonction de payer</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registres des ccm</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des voies de recours</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre sign&eacute; aux trait&eacute;s de l'OHADA</a></td>
                              </tr>
                            </table>
                          </div>
                        </div>
<?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penale"))
{?>
                        <div class="AccordionPanel">
                          <div class="AccordionPanelTab">Section P&eacute;nale</div>
                          <div class="AccordionPanelContent">
                            <table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="liste_regplaintes.php" class="fiche">Registre de plaintes (R.P)</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre de suivie des pi&egrave;ces &agrave; conviction</a> </td>
                              </tr>
                              <tr>
                                <td><a href="liste_regscelle.php" class="fiche">Registre de transmissions des scell&eacute;s</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre de l'ex&eacute;cution des peines</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_repjugcor.php" class="fiche">Repertoire des jugements correctionnels </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des contraintes par corps </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des d&eacute;pots l&eacute;gaux </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre de simple police </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre d'audience</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Plumitif </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des voies de recours</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre d'Expertise</a></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        <div class="AccordionPanel">
                          <div class="AccordionPanelTab">Service des activit&eacute;s du cabinet d'instruction</div>
                          <div class="AccordionPanelContent">
                            <table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="#" class="fiche">Registre d'instruction (R.I) </a></td>
                              </tr>                            
                              <tr>
                                <td><a href="liste_registrecomroginterne.php" class="fiche">Le registre des commissions rogatoires internationales</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_registrecomrogexterne.php" class="fiche">Le registre des commissions rogatoires nationales</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">L'agenda du cabinet</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre d'Expertise</a></td>
                              </tr>
                            </table>
                          </div>
                        </div>
<?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Sociale"))
{?>						
                        <div class="AccordionPanel">
                          <div class="AccordionPanelTab">Chambre sociale</div>
                          <div class="AccordionPanelContent">
                            <table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="liste_rgsociale.php" class="fiche">R&ocirc;le g&eacute;n&eacute;ral </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Plumitif</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des conciliations</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des requ&ecirc;tes des actes du tribunal de saisine </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">R&eacute;pertoire des d&eacute;cisions </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des voies de recours</a></td>
                              </tr>
                            </table>
                          </div>
                        </div>
<?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penitentiaire"))
{?>						
                        <div class="AccordionPanel">
                          <div class="AccordionPanelTab">Administration p&eacute;nitentiaire</div>
                          <div class="AccordionPanelContent">
                            <table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="#" class="fiche">Registre des Ecrou</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_regalphadet.php" class="fiche">Registre alphab&eacute;tique des d&eacute;tenus</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_regima.php" class="fiche">Registre du contr&ocirc;le num&eacute;rique et nominatif des entrants et des sortants</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_regobjdep.php" class="fiche">Registre des sommes et objets d&eacute;pos&eacute;s par les d&eacute;t&eacute;nus aux greffes</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_regmdepo.php" class="fiche">Registre des mandats et des recommand&eacute;s</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des p&eacute;cules des d&eacute;t&eacute;nus</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des punitions et recompenses</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des visites m&eacute;dicales</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des d&eacute;c&egrave;s</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des lib&eacute;rations conditionnelles</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des &eacute;vasions</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des transferments</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Registre des voies de recours</a></td>
                              </tr>
                            </table>
                          </div>
                        </div>
<?php } ?>						
                      </div></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle">
            <table width="100%" >
              <tr>
                <td><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                <td width="100%"><span class="Style2"><span class="Style2">Bienvenue sur l'espace de collecte des informations judiciaires et P&eacute;nitentiaires</span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="98%" border="0" align="center" cellpadding="5" cellspacing="3">
            <tr>
              <td valign="top"><p class="Style22">Texte de Pr&eacute;sentation du Logiciel.</p>
                  <p class="Style22"> le logiciel est compos&eacute; de trois grandes parties &agrave; savoir:<img src="images/jursta.jpg" width="216" height="172" align="left"></p>
                  <ul>
                    <li class="Style22">Les Registre qui traite en tout 33 diff&eacute;rents Registre </li>
                    <li class="Style22">Les diff&eacute;rents Statistiques </li>
                    <li class="Style22">l'Exportation des donn&eacute;es vers la Base de donn&eacute;es de l'inspection des services judiciares et penitentiaires</li>
                  </ul>
                  <p class="Style22">Vous pouvez aussi exporter les donn&eacute;es vers la base de donn&eacute;es globale de l'inspection g&eacute;n&eacute;rale des services judiciaires et penitentiaires <a href="exportation_data.php" class="fiche">Cliquez-ici</a> pour param&egrave;trer votre exportation des donn&eacute;es </p></td>
              <td valign="top">
			  <?php if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Civile")) {?>
			  <table border="0" cellpadding="2" cellspacing="1">
                  <tr>
                    <td align="left" nowrap class="Style15">R&ocirc;le g&eacute;n&eacute;ral</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Grand livre</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registe des consignations</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registre d'expertise </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Repertoire des Jugements suppletifs </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Repertoire des ordonnances pr&eacute;sidentielles </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Repertoire des actes </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Livre journal </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Plumitif </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registre des mises en etat </td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registre des conciliations</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registre des requ&ecirc;tes aux fins d'injonction de payer</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registres des ccm</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registre des voies de recours</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" nowrap class="Style15">Registre sign&eacute; aux trait&eacute;s de l'OHADA</td>
                    <td align="left" nowrap class="Style15">&nbsp;</td>
                  </tr>
              </table>
			  <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penale"))
{?>
			  <table border="0" cellpadding="2" cellspacing="1" class="Style15">
                              <tr>
                                <td class="Style15">Registre de plaintes (R.P)</td>
                                <td class="Style15">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="Style15">Registre de suivie des pi&egrave;ces &agrave; conviction </td>
                                <td class="Style15">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="Style15">Registre de transmissions des scell&eacute;s</td>
                                <td class="Style15">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre de l'ex&eacute;cution des peines</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Repertoire des jugements correctionnels </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des contraintes par corps </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des d&eacute;pots l&eacute;gaux </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre de simple police </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre d'audience</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Plumitif </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des voies de recours</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre d'Expertise</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre d'instruction (R.I) </td>
                                <td>&nbsp;</td>
                              </tr>                            
                              <tr>
                                <td>Le registre des commissions rogatoires internationales</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Le registre des commissions rogatoires nationales</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>L'agenda du cabinet</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre d'Expertise</td>
                                <td>&nbsp;</td>
                              </tr>
                    </table>
			  <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Sociale"))
{?>
			  <table border="0" cellpadding="2" cellspacing="1" class="Style15">
                              <tr>
                                <td>R&ocirc;le g&eacute;n&eacute;ral </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Plumitif</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des conciliations</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des requ&ecirc;tes des actes du tribunal de saisine </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>R&eacute;pertoire des d&eacute;cisions </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des voies de recours</td>
                                <td>&nbsp;</td>
                              </tr>
                    </table>
			  <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penitentiaire"))
{?>	
<table border="0" cellpadding="2" cellspacing="1" class="Style15">
                              <tr>
                                <td>Registre des Ecrou</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre alphab&eacute;tique des d&eacute;tenus</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre du contr&ocirc;le num&eacute;rique et nominatif des entrants et des sortants</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des sommes et objets d&eacute;pos&eacute;s par les d&eacute;t&eacute;nus aux greffes</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des mandats et des recommand&eacute;s</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des p&eacute;cules des d&eacute;t&eacute;nus</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des punitions et recompenses</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des visites m&eacute;dicales</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des d&eacute;c&egrave;s</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des lib&eacute;rations conditionnelles</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des &eacute;vasions</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des transferments</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Registre des voies de recours</td>
                                <td>&nbsp;</td>
                              </tr>
                    </table>			 
<?php } ?> </td>
            </tr>
            <tr>
              <td valign="top">&nbsp;                </td>
              <td valign="top">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>  
   
  <table width="100%" >
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<script type="text/javascript">
<!--
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
//-->
</script>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);
?>
