<?php require_once('Connections/jursta.php'); ?>
<?php
mysql_select_db($database_jursta, $jursta);
$query_insert_plum = "SELECT * FROM plum_civil";
$insert_plum = mysql_query($query_insert_plum, $jursta) or die(mysql_error());
$row_insert_plum = mysql_fetch_assoc($insert_plum);
$totalRows_insert_plum = mysql_num_rows($insert_plum);
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
<table align="center" cellpadding="0" cellspacing="0">
  <tr align="center">

    <td>&nbsp;</td>
    <td><TABLE WIDTH=768 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
  <TR>
    <TD ROWSPAN=4> <IMG SRC="images/index_01.gif" WIDTH=18 HEIGHT=122 title=""></TD>
    <TD> <a href="connect.php"><IMG SRC="images/index_02.jpg" title="" WIDTH=178 HEIGHT=25 border="0"></a></TD>
    <TD COLSPAN=2> <IMG SRC="images/index_03.gif" WIDTH=572 HEIGHT=25 title=""></TD>
  </TR>

  <TR>
    <TD> <a href="connect.php"><IMG SRC="images/index_04.gif" title="" WIDTH=178 HEIGHT=57 border="0"></a></TD>
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
</TABLE></td>
    <td>&nbsp;</td>

  </tr>
  <tr align="center">
    <td bgcolor="#6186AF">&nbsp;</td>
    <td><script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_1018160732_0) return;
      window.mm_menu_1018160732_0 = new Menu("root",164,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018160732_0.addMenuItem("Modifier&nbsp;mot&nbsp;de&nbsp;passe","location='liste_compte.php'");
  mm_menu_1018160732_0.addMenuItem("Créer&nbsp;un&nbsp;compte","location='add_compte.php'");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;droits","location='liste_compte.php'");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;cours&nbsp;d'appel","location='coursappel.php'");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;le&nbsp;tribunaux");
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;villes");
  mm_menu_1018160732_0.addMenuItem("Exporter&nbsp;les&nbsp;statistiques","location='transferedata.php'");
   mm_menu_1018160732_0.hideOnMouseOut=true;
   mm_menu_1018160732_0.bgColor='#555555';
   mm_menu_1018160732_0.menuBorder=1;
   mm_menu_1018160732_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1018160732_0.menuBorderBgColor='#777777';
      window.mm_menu_1018162239_0 = new Menu("root",278,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018162239_0.addMenuItem("Police/Gendarmerie/Saisine&nbsp;du&nbsp;Parquet","location='stat_police.php'");
  mm_menu_1018162239_0.addMenuItem("Orientation&nbsp;des&nbsp;Affaires&nbsp;du&nbsp;parquet","location='stat_oientationaffair.php'");
  mm_menu_1018162239_0.addMenuItem("Activités&nbsp;des&nbsp;Juges","location='stat_jugeinstruction.php'");
  mm_menu_1018162239_0.addMenuItem("Condamnations&nbsp;après&nbsp;détention&nbsp;provisoire","location='#'");
   mm_menu_1018162239_0.hideOnMouseOut=true;
   mm_menu_1018162239_0.bgColor='#555555';
   mm_menu_1018162239_0.menuBorder=1;
   mm_menu_1018162239_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1018162239_0.menuBorderBgColor='#777777';

  window.mm_menu_1124011501_0 = new Menu("root",316,18,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1124011501_0.addMenuItem("Actes&nbsp;de&nbsp;Notoriété&nbsp;suppléant&nbsp;l'acte&nbsp;de&nbsp;naissance","location='liste_repactenoto.php'");
  mm_menu_1124011501_0.addMenuItem("Attestation&nbsp;de&nbsp;la&nbsp;Chambre&nbsp;Civil","location='liste_repacc.php'");
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
<script language="JavaScript1.2">mmLoadMenus();</script>
<div align="center"></div>
<table width="100%" cellpadding="0" cellspacing="0" >
  <tr>

    <td nowrap bgcolor="#6186AF"><table border="0" align="center" cellpadding="3" cellspacing="1">
        <tr bgcolor="#6186AF">
          		  <td><a href="#" name="link5" class="Style21" id="link1" onMouseOver="MM_showMenu(window.mm_menu_1018160732_0,0,18,null,'link5')" onMouseOut="MM_startTimeout();">Param&eacute;trage de Base</a></td>
	                        <td>

		  <table cellpadding="0" cellspacing="0" >
            <tr>
              <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>

            </tr>
          </table>            </td>
		  <td bgcolor="#6186AF"><a href="#" name="link3" id="link3" onMouseOver="MM_showMenu(window.mm_menu_1018162239_0,0,18,null,'link3')" onMouseOut="MM_startTimeout();">Stat. P&eacute;nales </a></span></td>
                    
		  <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>

          </table></td>
		  <td><a href="stat_affaircivil.php">Stat. Civils, Com et admin</a> </span></td>
                            <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		  <td><a href="stat_affairsocial.php">Stat. Sociales </a></td>

          		  
          <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		  <td><a href="stat_penitentier1-1.php">Stat. des admin P&eacute;nitentiaires </a></span></td>
          		  
        <td><table cellpadding="0" cellspacing="0" >
              <tr>

                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
		<td><a href="/jursta/connect.php?doLogout=true" onClick="return confirmdelete('Voulez-vous vous déconnecter ?');">D&eacute;connection</a></td></tr>
    </table></td>
  </tr>
</table>
</td>
    <td bgcolor="#6186AF">&nbsp;</td>

  </tr>
  <tr align="center">
    <td bgcolor="#FFFF00">&nbsp;</td>
    <td>

<table width="100%" border="0" cellpadding="3" cellspacing="0"> 
  <tr bgcolor="#FFFF00">
    <td width="100%" align="center" class="Style22"><strong>Bienvenue</strong> <span class="Style23">Diomande Lassina    </span>
      <strong>- Cour suprème</strong>

    </td>
    <td nowrap class="Style14 Style24">2011-02-28 08:47:49</span></td>
  </tr>
</table>
</td>
    <td bgcolor="#FFFF00">&nbsp;</td>
  </tr>
  <tr align="center">
    <td valign="top" background="images/continue.jpg"><script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>

<table width="200" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td><table cellpadding="0" >
              <tr>
                <td><div id="Accordion1" class="Accordion" tabindex="0">
                                        <div class="AccordionPanel">
                      <div class="AccordionPanelTab">

                        <div align="left">Section Civile Commerciale et Administrative</div>
                      </div>
                      <div class="AccordionPanelContent">
                        <div align="left">
                          <table border="0" cellpadding="2" cellspacing="1">
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="liste_rolegeneral.php" class="fiche">R&ocirc;le g&eacute;n&eacute;ral</a></td>

                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Grand livre</a> * </td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>

                              <td><a href="liste_regconcigne.php" class="fiche">Registre des consignations</a></td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Registre d'expertise </a>*</td>
                            </tr>
                            <tr valign="top">

                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="liste_repjug.php" class="fiche">Repertoire des Jugements</a></td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="liste_repordpresi.php" class="fiche">Repertoire des ordonnances pr&eacute;sidentielles </a></td>
                            </tr>

                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="#" class="fiche" >Repertoire des actes </a></td>
                            </tr>
                            <tr>
                              <td align="center" valign="top">&nbsp;</td>
                              <td><table width="100%"  border="0" cellspacing="1" cellpadding="2">
                                <tr>

                                  <td><img src="images/spacer.gif" width="5" height="1"></td>
                                  <td align="center" valign="top"><img src="images/sidenavover.png" width="7" height="7"></td>
                                  <td valign="top"><a href="liste_repactenoto.php" class="fiche" >Actes de Notori&eacute;t&eacute;</a></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="center" valign="top"><img src="images/sidenavover.png" width="7" height="7"></td>
                                  <td valign="top"><a href="liste_repacc.php" class="fiche">Attestation de la chambre civile </a></td>

                                </tr>
                                </table></td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Livre journal </a>*</td>
                            </tr>
                            <tr valign="top">

                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="liste_plumcivil.php" class="fiche">Plumitif </a></td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Registre des mises en etat </a>*</td>
                            </tr>

                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Registre des conciliations</a> *</td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Registre des requ&ecirc;tes aux fins d'injonction de payer</a> *</td>

                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Registres des ccm</a> *</td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>

                              <td><a href="encours.php" class="fiche">Registre des voies de recours</a></td>
                            </tr>
                            <tr valign="top">
                              <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12"></td>
                              <td><a href="encours.php" class="fiche">Registre sign&eacute; aux trait&eacute;s de l'OHADA</a> * </td>

                            </tr>
                            </table>
                        </div>
                      </div>
                    </div>
                                        <div class="AccordionPanel">
                      <div class="AccordionPanelTab">Section P&eacute;nale</div>
                      <div class="AccordionPanelContent">

                        <table border="0" cellpadding="2" cellspacing="1">
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regplaintes.php" class="fiche">Registre de plaintes (R.P)</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre de suivie des pi&egrave;ces &agrave; conviction</a> </td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regscelle.php" class="fiche">Registre de transmissions des scell&eacute;s</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre de l'ex&eacute;cution des peines</a>*</td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_repjugcor.php" class="fiche">Repertoire des jugements correctionnels </a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des contraintes par corps </a>*</td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des d&eacute;pots l&eacute;gaux </a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="encours.php" class="fiche">Registre de simple police </a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre d'audience</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="encours.php" class="fiche">Plumitif </a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des voies de recours</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="encours.php" class="fiche">Registre d'Expertise</a></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="AccordionPanel">
                      <div class="AccordionPanelTab">Service des activit&eacute;s du cabinet d'instruction</div>

                      <div class="AccordionPanelContent">
                        <table border="0" cellpadding="2" cellspacing="1">
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre d'instruction (R.I) </a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="liste_registrecomroginterne.php" class="fiche">Le registre des commissions rogatoires internationales</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_registrecomrogexterne.php" class="fiche">Le registre des commissions rogatoires nationales</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="encours.php" class="fiche">L'agenda du cabinet</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre d'Expertise</a></td>
                          </tr>
                        </table>
                      </div>

                    </div>
                                        <div class="AccordionPanel">
                      <div class="AccordionPanelTab">Chambre sociale</div>
                      <div class="AccordionPanelContent">
                        <table border="0" cellpadding="2" cellspacing="1">
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_rgsocial.php" class="fiche">R&ocirc;le g&eacute;n&eacute;ral </a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Plumitif</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des conciliations</a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des requ&ecirc;tes des actes du tribunal de saisine </a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_repdecision.php" class="fiche">R&eacute;pertoire des d&eacute;cisions </a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des voies de recours</a></td>
                          </tr>
                        </table>
                      </div>
                    </div>

                                        <div class="AccordionPanel">
                      <div class="AccordionPanelTab">Administration p&eacute;nitentiaire</div>
                      <div class="AccordionPanelContent">
                        <table border="0" cellpadding="2" cellspacing="1">
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regecrou.php" class="fiche">Registre des Ecrous</a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regalphadet.php" class="fiche">Registre alphab&eacute;tique des d&eacute;tenus</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="liste_regima.php" class="fiche">Registre du contr&ocirc;le num&eacute;rique et nominatif des entrants et des sortants</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regobjdep.php" class="fiche">Registre des sommes et objets d&eacute;pos&eacute;s par les d&eacute;t&eacute;nus aux greffes</a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regmandat.php" class="fiche">Registre des mandats et des recommand&eacute;s</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des p&eacute;cules des d&eacute;t&eacute;nus</a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des punitions et recompenses</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des visites m&eacute;dicales</a></td>

                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des d&eacute;c&egrave;s</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>

                            <td align="left"><a href="encours.php" class="fiche">Registre des lib&eacute;rations conditionnelles</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des &eacute;vasions</a></td>
                          </tr>
                          <tr valign="top">

                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des transferments</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des voies de recours</a></td>
                          </tr>
                        </table>

                      </div>
                    </div>
                                    </div></td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>

<script type="text/javascript">
<!--
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
//-->
</script></td>
    <td valign="top"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table border="0" cellpadding="0" cellspacing="0" id="Tableau_01">
      <tr>
        <td colspan="28"><img border="0" src="images/fond-dec_01.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>		
        </tr>
      <tr>
        <td colspan="2" rowspan="4"><img border="0" src="images/fond-dec_02.jpg"></td>
        <td colspan="2" rowspan="4"><img border="0" src="images/fond-dec_03.jpg"></td>
        <td colspan="24"><img border="0" src="images/fond-dec_04.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="20"><img border="0" src="images/fond-dec_05.jpg"></td>
        <td colspan="2" rowspan="2"><img border="0" src="images/fond-dec_06.jpg"></td>
        <td colspan="2" rowspan="2"><img border="0" src="images/fond-dec_07.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>

        <td colspan="9" rowspan="2"><img border="0" src="images/fond-dec_08.jpg" title=""></td>
        <td colspan="2" rowspan="4"><a href="organisation_judiciares.php"><img border="0" src="images/fond-dec_09.jpg" title="Organisation des juridictions"></a></td>
        <td colspan="9"><img border="0" src="images/fond-dec_10.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="8" rowspan="3"><img border="0" src="images/fond-dec_11.jpg"></td>
        <td colspan="4" rowspan="3"><img border="0" src="images/fond-dec_12.jpg"></td>
        <td rowspan="18" valign="top"><img border="0" src="images/fond-dec_13.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>

      <tr>
        <td rowspan="17" valign="top"><img border="0" src="images/fond-dec_14.jpg"></td>
        <td colspan="5"><img border="0" src="images/fond-dec_15.jpg"></td>
        <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_16.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>		
        </tr>
      <tr>
        <td colspan="5" rowspan="4"><img border="0" src="images/fond-dec_17.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>

        <td colspan="3" rowspan="2"><img border="0" src="images/fond-dec_18.jpg"></td>
        <td colspan="11"><a href="organisation_judiciares.php"><img border="0" src="images/fond-dec_19.jpg"></a></td>
        <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_20.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="11"><img border="0" src="images/fond-dec_21.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td valign="top"><img border="0" src="images/fond-dec_22.jpg"></td>
        <td colspan="2" valign="top"><a href="param_base.php"><img border="0" src="images/fond-dec_23.jpg" title="Paramètres de base"></a></td>
        <td colspan="10" rowspan="3" valign="top"><img border="0" src="images/fond-dec_24.jpg"></td>
        <td colspan="3" valign="top"><a href="admin_penitentiaires.php"><img border="0" src="images/fond-dec_25.jpg" title="Administration pénitentiaires"></a></td>
        <td colspan="5"><a href="admin_penales.php"><img border="0" src="images/fond-dec_26.jpg"></a></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="2" rowspan="12" valign="top"><img border="0" src="images/fond-dec_27.jpg"></td>
        <td colspan="6" valign="top"><a href="param_base.php"><img border="0" src="images/fond-dec_28.jpg"></a></td>
        <td colspan="7" valign="top"><a href="admin_penitentiaires.php"><img border="0" src="images/fond-dec_29.jpg"></a></td>
        <td rowspan="12" valign="top"><img border="0" src="images/fond-dec_30.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="6"><img border="0" src="images/fond-dec_31.jpg"></td>
        <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_32.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_33.jpg"></td>
        <td colspan="2" rowspan="2"><a href="etats_edition.php"><img border="0" src="images/fond-dec_34.jpg" title="Etats et Editions"></a></td>
        <td colspan="9"><img border="0" src="images/fond-dec_35.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="7"><img border="0" src="images/fond-dec_36.jpg"></td>
        <td colspan="4" rowspan="2"><a href="autresdonneestat.php"><img border="0" src="images/fond-dec_37.jpg" title="Autres Données Statistiques"></a></td>
        <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_38.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>		
        </tr>
      <tr>
        <td colspan="2" rowspan="6" valign="top"><img border="0" src="images/fond-dec_39.jpg"></td>
        <td colspan="6" rowspan="2" valign="top"><a href="etats_edition.php"><img border="0" src="images/fond-dec_40.jpg" title="" width="194" height="34"></a></td>
        <td colspan="6"><img border="0" src="images/fond-dec_41.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_42.jpg"></td>
        <td colspan="9"><a href="autresdonneestat.php"><img border="0" src="images/fond-dec_43.jpg" width="318" height="31" title=""></a></td>
        <td rowspan="7" valign="top"><img border="0" src="images/fond-dec_44.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="6" rowspan="2"><img border="0" src="images/fond-dec_45.jpg"></td>
        <td colspan="9" rowspan="2"><img border="0" src="images/fond-dec_46.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td><img border="0" src="images/fond-dec_47.jpg"></td>
        <td colspan="2"><a href="maj_data.php"><img border="0" src="images/fond-dec_48.jpg" title="Mise à Jour des Données"></a></td>
        <td colspan="2"><img border="0" src="images/fond-dec_49.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="4" rowspan="2" valign="top"><img border="0" src="images/fond-dec_50.jpg"></td>
        <td colspan="9"><a href="maj_data.php"><img border="0" src="images/fond-dec_51.jpg"></a></td>
        <td colspan="7" rowspan="2" valign="top"><img border="0" src="images/fond-dec_52.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="9" valign="top"><img border="0" src="images/fond-dec_53.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td rowspan="2" valign="top"><img border="0" src="images/fond-dec_54.jpg"></td>
        <td colspan="20"><img border="0" src="images/fond-dec_55.jpg"></td>
        <td rowspan="2" valign="top"><img border="0" src="images/fond-dec_56.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td colspan="20" valign="top"><img border="0" src="images/fond-dec_57.jpg"></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>
        </tr>
      <tr>
        <td><img border="0" src="images/spacer.gif" width="28" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="46" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="42" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="71" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="33" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="23" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="29" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="31" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="51" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="25" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="35" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="22" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="16" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="115" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="12" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="8" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="53" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="12" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="16" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="20" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="38" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="23" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="51" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="52" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="53" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="39" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="61" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="19" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>		
        </tr>

    </table>
      <p>&nbsp;</p>
      <table width="0%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="28"><img border="0" src="images/fond-dec_01.jpg"></td>
          </tr>
        <tr>
          <td colspan="2" rowspan="4"><img border="0" src="images/fond-dec_02.jpg"></td>
          <td colspan="2" rowspan="4"><img border="0" src="images/fond-dec_03.jpg"></td>
          <td colspan="24"><img border="0" src="images/fond-dec_04.jpg"></td>
          </tr>
        <tr>
          <td colspan="20"><img border="0" src="images/fond-dec_05.jpg"></td>
          <td colspan="2" rowspan="2"><img border="0" src="images/fond-dec_06.jpg"></td>
          <td colspan="2" rowspan="2"><img border="0" src="images/fond-dec_07.jpg"></td>
          </tr>
        <tr>
          <td colspan="9" rowspan="2"><img border="0" src="images/fond-dec_08.jpg" title=""></td>
          <td colspan="2" rowspan="4"><a href="organisation_judiciares.php"><img border="0" src="images/fond-dec_09.jpg" title="Organisation des juridictions"></a></td>
          <td colspan="9"><img border="0" src="images/fond-dec_10.jpg"></td>
          </tr>
        <tr>
          <td colspan="8" rowspan="3"><img border="0" src="images/fond-dec_11.jpg"></td>
          <td colspan="4" rowspan="3"><img border="0" src="images/fond-dec_12.jpg"></td>
          <td rowspan="18"><img border="0" src="images/fond-dec_13.jpg"></td>
        </tr>
        <tr>
          <td rowspan="17"><img border="0" src="images/fond-dec_14.jpg"></td>
          <td colspan="5"><img border="0" src="images/fond-dec_15.jpg"></td>
          <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_16.jpg"></td>
          </tr>
        <tr>
          <td colspan="5" rowspan="4"><img border="0" src="images/fond-dec_17.jpg"></td>
          </tr>
        <tr>
          <td colspan="3" rowspan="2"><img border="0" src="images/fond-dec_18.jpg"></td>
          <td colspan="11"><a href="organisation_judiciares.php"><img border="0" src="images/fond-dec_19.jpg"></a></td>
          <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_20.jpg"></td>
          </tr>
        <tr>
          <td colspan="11"><img border="0" src="images/fond-dec_21.jpg"></td>
          </tr>
        <tr>
          <td><img border="0" src="images/fond-dec_22.jpg"></td>
          <td colspan="2"><a href="param_base.php"><img border="0" src="images/fond-dec_23.jpg" title="Param&egrave;tres de base"></a></td>
          <td colspan="10" rowspan="3"><img border="0" src="images/fond-dec_24.jpg"></td>
          <td colspan="3"><a href="admin_penitentiaires.php"><img border="0" src="images/fond-dec_25.jpg" title="Administration p&eacute;nitentiaires"></a></td>
          <td colspan="5"><a href="admin_penales.php"><img border="0" src="images/fond-dec_26.jpg"></a></td>
          </tr>
        <tr>
          <td colspan="2" rowspan="12"><img border="0" src="images/fond-dec_27.jpg"></td>
          <td colspan="6"><a href="param_base.php"><img border="0" src="images/fond-dec_28.jpg"></a></td>
          <td colspan="7"><a href="admin_penitentiaires.php"><img border="0" src="images/fond-dec_29.jpg"></a></td>
          <td rowspan="12"><img border="0" src="images/fond-dec_30.jpg"></td>
          </tr>
        <tr>
          <td colspan="6"><img border="0" src="images/fond-dec_31.jpg"></td>
          <td colspan="7" rowspan="2"><img border="0" src="images/fond-dec_32.jpg"></td>
          </tr>
        <tr>
          <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_33.jpg"></td>
          <td colspan="2" rowspan="2"><a href="etats_edition.php"><img border="0" src="images/fond-dec_34.jpg" title="Etats et Editions"></a></td>
          <td colspan="9"><img border="0" src="images/fond-dec_35.jpg"></td>
          </tr>
        <tr>
          <td colspan="7"><img border="0" src="images/fond-dec_36.jpg"></td>
          <td colspan="4" rowspan="2"><a href="autresdonneestat.php"><img border="0" src="images/fond-dec_37.jpg" title="Autres Donn&eacute;es Statistiques"></a></td>
          <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_38.jpg"></td>
          </tr>
        <tr>
          <td colspan="2" rowspan="6"><img border="0" src="images/fond-dec_39.jpg"></td>
          <td colspan="6" rowspan="2"><a href="etats_edition.php"><img border="0" src="images/fond-dec_40.jpg" title="" width="194" height="34"></a></td>
          <td colspan="6"><img border="0" src="images/fond-dec_41.jpg"></td>
          </tr>
        <tr>
          <td colspan="5" rowspan="2"><img border="0" src="images/fond-dec_42.jpg"></td>
          <td colspan="9"><a href="autresdonneestat.php"><img border="0" src="images/fond-dec_43.jpg" width="318" height="31" title=""></a></td>
          <td rowspan="7"><img border="0" src="images/fond-dec_44.jpg"></td>
          </tr>
        <tr>
          <td colspan="6" rowspan="2"><img border="0" src="images/fond-dec_45.jpg"></td>
          <td colspan="9" rowspan="2"><img border="0" src="images/fond-dec_46.jpg"></td>
          </tr>
        <tr>
          <td><img border="0" src="images/fond-dec_47.jpg"></td>
          <td colspan="2"><a href="maj_data.php"><img border="0" src="images/fond-dec_48.jpg" title="Mise &agrave; Jour des Donn&eacute;es"></a></td>
          <td colspan="2"><img border="0" src="images/fond-dec_49.jpg"></td>
          </tr>
        <tr>
          <td colspan="4" rowspan="2"><img border="0" src="images/fond-dec_50.jpg"></td>
          <td colspan="9"><a href="maj_data.php"><img border="0" src="images/fond-dec_51.jpg"></a></td>
          <td colspan="7" rowspan="2">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="9"><img border="0" src="images/fond-dec_53.jpg"></td>
          </tr>
        <tr>
          <td rowspan="2"><img border="0" src="images/fond-dec_54.jpg"></td>
          <td colspan="20"><img border="0" src="images/fond-dec_55.jpg"></td>
          <td rowspan="2"><img border="0" src="images/fond-dec_56.jpg"></td>
          </tr>
        <tr>
          <td colspan="20"><img border="0" src="images/fond-dec_57.jpg"></td>
          </tr>
      <tr>
        <td><img border="0" src="images/spacer.gif" width="28" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="46" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="42" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="71" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="33" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="23" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="29" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="31" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="51" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="25" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="35" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="22" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="16" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="115" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="12" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="8" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="53" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="12" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="16" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="20" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="23" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="51" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="52" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="53" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="39" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="61" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="19" height="1" title=""></td>
        <td><img border="0" src="images/spacer.gif" width="1" height="1" title=""></td>		
        </tr>
      </table>      <p>&nbsp;</p></td>
  </tr>
</table></td>
    <td valign="top" background="images/continue.jpg"><table  cellspacing="5" cellpadding="5">
      <tr class="Style22">
        <td><p align="center"><strong>Pr&eacute;sentation du Logiciel.</strong></p>
            <p> le logiciel est compos&eacute; de trois grandes parties &agrave; savoir:</p>

          <ul>
              <li>Les Registre qui traite en tout 33 diff&eacute;rents Registre </li>
            <li>Les diff&eacute;rents Statistiques </li>
            <li>l'Exportation des donn&eacute;es vers la Base de donn&eacute;es de l'inspection des services judiciares et penitentiaires</li>
          </ul>

          <p>Vous pouvez aussi exporter les donn&eacute;es vers la base de donn&eacute;es globale de l'inspection g&eacute;n&eacute;rale des services judiciaires et penitentiaires <a href="exportation_data.php" class="fiche">Cliquez-ici</a> pour param&egrave;trer votre exportation des donn&eacute;es</p></td>
      </tr>
    </table></td>
  </tr>

  <tr align="center">
    <td colspan="3" background="images/continue.jpg"><table width="100%" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</td>
  </tr>

</table>
<img border="0" src="images/fond-dec_52.jpg">

</body>
</html>
<?php
mysql_free_result($insert_plum);
?>
