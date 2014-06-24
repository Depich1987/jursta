<?php require_once('Connections/jursta.php'); ?><?php
$colname_select_admin = "1";
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

mm_menu_1018162239_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<script language="JavaScript1.2">mmLoadMenus();</script>
<form name="form1" method="POST">
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
          <td bgcolor="#6186AF"><a href="#" name="link5" id="link1" onMouseOver="MM_showMenu(window.mm_menu_1018160732_0,0,18,null,'link5')" onMouseOut="MM_startTimeout();">Param&eacute;trage de Base</a></span></td>
          <td bgcolor="#6186AF"><table cellpadding="0" cellspacing="0" >
            <tr>
              <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
            </tr>
          </table>            </td>
          <td bgcolor="#6186AF"><a href="#" name="link3" id="link3" onMouseOver="MM_showMenu(window.mm_menu_1018162239_0,0,18,null,'link3')" onMouseOut="MM_startTimeout();">Statistiques P&eacute;nales </a></span></td>
          <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
          <td bgcolor="#6186AF"><a href="#">Statistiques Civils et Commerciales</a> </span></td>
          <td><table cellpadding="0" cellspacing="0" >
              <tr>
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="1" height="20"></td>
              </tr>
          </table></td>
          <td><a href="#">Statistiques des administrations P&eacute;nitentiaires </a></span></td>
        </tr>
      </table></td>
    </tr>
  </table>
  
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
      <td width="100%" align="center" class="Style22"><strong>Bienvenue</strong> <span class="Style23"><?php echo $row_select_admin['Nom_admin']; ?><?php echo $row_select_admin['Prenoms_admin']; ?></span> </td>
      <td nowrap class="Style14 Style24"><?php echo date("Y-m-d H:i:s");?></span></td>
    </tr>
  </table>  
  <table width="100%" >
    <tr>
      <td width="250"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#677787"><table width="100%" border="0" cellpadding="0" cellspacing="1">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" cellpadding="5" >
                    <tr>
                      <td bgcolor="#EDF0F3"><table border="0" cellspacing="1" cellpadding="0">
                        <tr>
                          <td align="right" bordercolor="#FFFFFF" bgcolor="#677787" class="Style3">Section Civile &nbsp;&nbsp; </td>
                        </tr>
                        <tr>
                          <td bordercolor="#FFFFFF"><table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="liste_rolegeneral.php" class="fiche">Le r&ocirc;le g&eacute;n&eacute;ral</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le grand livre</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre de consignation </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre d'expertise </a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_repjug.php" class="fiche">Le repertoire des Jugements suppletifs </a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_repordpresi.php" class="fiche">Le repertoire des ordonnances pr&eacute;sidentielles </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le repertoire des actes </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le livre journal </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le plumitif </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre des mises en etat </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre des conciliations</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">le registre des requ&ecirc;tes aux frais d'injonction de payer </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">le rccm </a></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="right" bordercolor="#FFFFFF" bgcolor="#677787"><span class="Style3">Section P&eacute;nale &nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                          <td bordercolor="#FFFFFF"><table border="0" cellpadding="2" cellspacing="1">
                              <tr>
                                <td><a href="#" class="fiche">Le registre de plaintes (R.P)</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre de suivie des pi&egrave;ces &agrave; conviction</a> </td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre des scell&eacute;s </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre de l'ex&eacute;cution des peines</a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_repjugcor.php" class="fiche">Le repertoire des jugements correctionnels </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre des contraintes par corps </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre des d&eacute;pots l&eacute;gaux </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre d'instruction (R.I) </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre de simple police </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre d'audience </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le plumitif </a></td>
                              </tr>
                              <tr>
                                <td align="right" bgcolor="#677787"><span class="Style3">Service des activit&eacute;s du cabinet d'instruction </span></td>
                              </tr>
                              <tr>
                                <td><a href="liste_registrecomroginterne.php" class="fiche">Le registre des commissions rogatoire interne </a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_registrecomrogexterne.php" class="fiche">Le registre des commissions rogatoire externe</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">L'agenda du cabinet</a></td>
                              </tr>
                              <tr>
                                <td align="right" bgcolor="#677787"><span class="Style3">Chambre Social </span></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le r&ocirc;le g&eacute;n&eacute;ral </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Plumitif</a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre des conciliants </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le registre de r&eacute;ception des actes du tribunal de saisine </a></td>
                              </tr>
                              <tr>
                                <td><a href="#" class="fiche">Le r&eacute;pertoire des d&eacute;cisions </a></td>
                              </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr>
                <td valign="top"><span class="Style2"><a href="add_rolegeneral.php"><img src="images/forms48.png" width="32" border="0"></a></span></td>
                <td width="100%"><div align="center">
                  <p class="Style2">MOUVEMENT DES DETENUS AU TITRE DU MOIS </p>
                  </div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle" ><table width="940" cellpadding="3" cellspacing="0" >
              <tr bgcolor="#677787" class="Style15">
                <td align="right">Mois : </td>
                <td><select name="select3">
                    <option value="01">Janvier</option>
                    <option value="02">F&eacute;vrier</option>
                    <option value="03">Mars</option>
                    <option value="04">Avril</option>
                    <option value="05">Mai</option>
                    <option value="06">Juin</option>
                    <option value="07">Juillet</option>
                    <option value="08">Ao&ucirc;t</option>
                    <option value="09">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">D&eacute;cembre</option>
                </select></td>
                <td>                  Ann&eacute;e : 
                  <select name="select4">
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                  </select></td>
                <td><input type="submit" name="Submit" value="Afficher"></td>
              </tr>
            </table>
              <table width="940" cellpadding="3" cellspacing="0" >
                <tr>
                  <td><table width="100%" cellpadding="3" cellspacing="0" >
                    <tr>
                      <td width="200" bgcolor="#6186AF" class="Style3"><div align="center">Mouvements des D&eacute;tenus au titre du Mois</div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <table width="940" cellpadding="3" cellspacing="1" >
                <tr bgcolor="#6186AF" class="Style15">
                  <td align="center">#</td>
                  <td width="100%" align="center">Etablissement</td>
                  <td align="center"><div align="center">Nbre D&eacute;t. mois pr&eacute;c. </div>                    
                    <div align="center"></div></td>
                  <td align="center"><div align="center">Nbre D&eacute;t. Entr&eacute;s </div></td>
                  <td align="center"><div align="center">Nbre D&eacute;t. Sortis </div></td>
                  <td align="center"> <div align="center">Nbre D&eacute;t. Mois trim. </div></td>
                  <td align="center"> <div align="center">Nbre D&eacute;t. sur mois </div></td>
                  <td align="center"><p align="center">Nbre D&eacute;t. journalier moyen </p></td>
                  <td align="center">Cr&eacute;dit allou&eacute; </td>
                  <td align="center"> <div align="center">Ration<br>
                    Alimentaire<br>
                  /D&eacute;t.</div>                    </td>
                  <td align="center">Nbre.<br>
                  Evasions</td>
                  <td align="center">Nbre.<br>
                  D&eacute;c&egrave;s</td>
                  <td align="center">Taux<br>
                  Mortalit&eacute;</td>
                 
                </tr>
                <tr bgcolor="#EDF0F3">
                  <td align="center" bgcolor="#EDF0F3" class="Style22">&nbsp;</td>
                  <td class="Style15">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                  <td align="center" class="Style22">&nbsp;</td>
                 </tr>
                <tr bgcolor="#677787">
                  <td colspan="16" align="center" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
                </tr>
              </table>
              <table width="940" >
                <tr>
                  <td align="right"><input type="submit" name="Submit3" value="Imprimer"></td>
                </tr>
              </table>
             <p>&nbsp;</p></td>
        </tr>
      </table></td>
    </tr>
  </table>  
   <table width="100%" >
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
<?php
mysql_free_result($select_admin);
?>
