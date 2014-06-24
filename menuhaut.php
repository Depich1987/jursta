<?php

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
  session_unregister('errorconnect');
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?><?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_1018160732_0) return;
  window.mm_menu_1018160732_0 = new Menu("root",200,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018160732_0.addMenuItem("Gérer&nbsp;les&nbsp;Comptes","location='liste_compte.php'");
  mm_menu_1018160732_0.addMenuItem("Organisation&nbsp;des&nbsp;juridictions","location='organisation_judiciares.php'");
  mm_menu_1018160732_0.addMenuItem("Mise&nbsp;&aacute;&nbsp;jour&nbsp;des&nbsp;Données","location='maj_data.php'");
  mm_menu_1018160732_0.hideOnMouseOut=true;
  mm_menu_1018160732_0.bgColor='#555555';
  mm_menu_1018160732_0.menuBorder=1;
  mm_menu_1018160732_0.menuLiteBgColor='#FFFFFF';
  mm_menu_1018160732_0.menuBorderBgColor='#777777';

  window.mm_menu_1018162239_0 = new Menu("root",278,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018162239_0.addMenuItem("Police/Gendarmerie/Saisine&nbsp;du&nbsp;Parquet","location='stat_police.php'");
  mm_menu_1018162239_0.addMenuItem("Orientation&nbsp;des&nbsp;Affaires&nbsp;du&nbsp;parquet","location='stat_oientationaffair.php'");
  mm_menu_1018162239_0.addMenuItem("Activités&nbsp;des&nbsp;Juges","location='stat_jugeinstruction.php'");
  mm_menu_1018162239_0.addMenuItem("Condamnations&nbsp;après&nbsp;détention&nbsp;provisoire","location='stat_cdppenal.php'");
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

  window.mm_menu_1018162270_0 = new Menu("root",290,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018162270_0.addMenuItem("Les&nbsp;effectifs&nbsp;en&nbsp;fin&nbsp;du&nbsp;mois","location='stat_penitentier1-1.php'");
  mm_menu_1018162270_0.addMenuItem("Mouvements&nbsp;des&nbsp;d&eacute;tenus&nbsp;au&nbsp;titre&nbsp;du&nbsp;mois","location='stat_penitentier1-2.php'");
  mm_menu_1018162270_0.addMenuItem("Etats&nbsp;des&nbsp;d&eacute;tenus&nbsp;au&nbsp;titre&nbsp;du&nbsp;mois","location='stat_penitentier1-3.php'");
  mm_menu_1018162270_0.hideOnMouseOut=true;
  mm_menu_1018162270_0.bgColor='#555555';
  mm_menu_1018162270_0.menuBorder=1;
  mm_menu_1018162270_0.menuLiteBgColor='#FFFFFF';
  mm_menu_1018162270_0.menuBorderBgColor='#777777';
  
  mm_menu_1018162270_0.writeMenus();

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
        <?php if ($_SESSION['MM_UserGroup']=="Superviseur") {?>
        <td nowrap><a href="#" name="link1" class="Style21" id="link1" onMouseOver="MM_showMenu(window.mm_menu_1018160732_0,0,18,null,'link1')" onMouseOut="MM_startTimeout();">Param&eacute;trage de Base</a></td>
        <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penale") || ($_SESSION['MM_UserGroup']=="AdminPenal") || ($_SESSION['MM_UserGroup']=="CabinetInstruction") || ($_SESSION['MM_UserGroup']=="CabinetJugEnfant") || ($_SESSION['MM_UserGroup']=="Superviseur"))
{?>
        <td><table cellpadding="0" cellspacing="0" >
          <tr>
            <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20" /></td>
          </tr>
        </table></td>
        <td nowrap bgcolor="#6186AF"><a href="#" name="link2" id="link2" onMouseOver="MM_showMenu(window.mm_menu_1018162239_0,0,18,null,'link2')" onMouseOut="MM_startTimeout();">Stat. P&eacute;nales </a></td>
        <?php } 
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Civile") || ($_SESSION['MM_UserGroup']=="AdminCivil") || ($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="ChambreTutelle"))
{?>
        <td><table cellpadding="0" cellspacing="0" >
          <tr>
            <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20" /></td>
          </tr>
        </table></td>
        <td nowrap><a href="stat_affaircivil.php">Stat. Civils, Com et admin</a> </td>
        <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Sociale")  || ($_SESSION['MM_UserGroup']=="AdminCivil") || ($_SESSION['MM_UserGroup']=="Superviseur"))
{?>
        <td><table cellpadding="0" cellspacing="0" >
          <tr>
            <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20" /></td>
          </tr>
        </table></td>
        <td nowrap><a href="stat_affairsocial.php">Stat. Sociales </a></td>
        <?php }
if (($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penitentiaire") || ($_SESSION['MM_UserGroup']=="Superviseur"))
{?>
        <td><table cellpadding="0" cellspacing="0" >
          <tr>
            <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20" /></td>
          </tr>
        </table></td>
        <td nowrap><a href="#" name="link3" id="link3" onMouseOver="MM_showMenu(window.mm_menu_1018162270_0,0,18,null,'link3')" onMouseOut="MM_startTimeout();">Stat. des admin P&eacute;nitentiaires </a></td>
        <?php } ?>
        <?php if ($_SESSION['MM_UserGroup']!="Superviseur") {?>
        <td><table cellpadding="0" cellspacing="0" >
          <tr>
            <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20" /></td>
          </tr>
        </table></td>
        <td nowrap><a href="maj_data.php">Mise&nbsp;&agrave;&nbsp;jour&nbsp;des&nbsp;Données</a></td>
        <?php } ?>
        <td><table cellpadding="0" cellspacing="0" >
          <tr>
            <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20" /></td>
          </tr>
        </table></td>
        <td nowrap><a href="<?php echo $logoutAction ?>" onClick="return confirmdelete('Voulez-vous vous déconnecter ?');">D&eacute;connection</a></td>
      </tr>
    </table></td>
  </tr>
</table>
