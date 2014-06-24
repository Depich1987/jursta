<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<table width="200" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td><table cellpadding="0" >
              <tr>
                <td><div id="Accordion1" class="Accordion" tabindex="0">
                    <?php if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Civile") || ($_SESSION['MM_UserGroup']=="AdminCivil")) {?>
                    <div class="AccordionPanel">
                      <div class="AccordionPanelTab">
                        <div align="left">Section Civile Commerciale et Administrative</div>
                      </div>
                      <div class="AccordionPanelContent">
                        <div align="left">
                          <table border="0" cellpadding="2" cellspacing="1">
                                    <tr valign="top">
                                      <td width="12" align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td width="169"><a href="liste_rolegeneral.php" class="fiche">R&ocirc;le g&eacute;n&eacute;ral</a></td>
                                    </tr>
                                    <tr valign="top" style="display:none">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Grand livre</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="liste_regconcigne.php" class="fiche">Registre des consignations</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre d'expertise </a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="liste_repjug.php" class="fiche">Repertoire des Jugements</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="liste_cahierdecharge.php" class="fiche">Registre des cahiers des charges</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="liste_repordpresi.php" class="fiche">Repertoire des ordonnances pr&eacute;sidentielles </a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="#" class="fiche" >Repertoire des actes du greffe</a></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td><table width="100%"  border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td><img src="images/spacer.gif" width="5" height="1" /></td>
                                          <td align="center" valign="top"><img src="images/sidenavover.png" width="7" height="7" /></td>
                                          <td valign="top"><a href="liste_repactenoto.php" class="fiche" >Actes de Notori&eacute;t&eacute;</a></td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                          <td align="center" valign="top"><img src="images/sidenavover.png" width="7" height="7" /></td>
                                          <td valign="top"><a href="liste_repacc.php" class="fiche">Attestation de la chambre civile </a></td>
                                        </tr>
                                      </table></td>
                                    </tr>
                                    <tr valign="top" style="display:none">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Livre journal </a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="liste_plumcivil.php" class="fiche">Plumitif </a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre des mises en etat </a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre des conciliations</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre des requ&ecirc;tes aux fins d'injonction de payer</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre de non opposition aux ordonnances  d&rsquo;injonction de payer&nbsp;</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre  de non appel ni opposition&nbsp;</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre des cessions et saisies des r&eacute;mun&eacute;rations&nbsp;</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="encours.php" class="fiche">Registre des commissions rogatoires  nationales et internationales&nbsp;</a></td>
                                    </tr>
                                    <tr valign="top">
                                      <td align="center" valign="top"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                      <td><a href="liste_regccm.php" class="fiche">Registres des rccm</a></td>
                                    </tr>
<tr valign="top">
                                    <td rowspan="2" align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="#" class="fiche">Registre des voies de recours</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center" valign="top"><table width="100%"  border="0" cellspacing="1" cellpadding="2">
                                      <tr>
                                        
                                        <td align="center" valign="top"><img src="images/sidenavover.png" width="7" height="7"/></td>
                                        <td valign="top"><a href="liste_regappelcivil.php" class="fiche">Appel</a></td>
                                      </tr>
                                      <tr>
                                        
                                        <td align="center" valign="top"><img src="images/sidenavover.png" width="7" height="7"/></td>
                                        <td valign="top"><a href="liste_regoppositioncivil.php" class="fiche">Opposition</a></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                  </table>
                        </div>
                      </div>
                    </div>
                     <?php }
if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="ChambreTutelle")  || ($_SESSION['MM_UserGroup']=="AdminCivil"))
{?>
                            <div class="AccordionPanel">
                              <div align="left" class="AccordionPanelTab">Chambre des Tutelles</div>
                              <div class="AccordionPanelContent">
                                <table border="0" cellpadding="2" cellspacing="1">
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_plumtutelle.php" class="fiche">Plumitif</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_reptutelle.php" class="fiche">Repertoire de décisions</a></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                    <?php }
if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Sociale") || ($_SESSION['MM_UserGroup']=="AdminCivil"))
{?>
                            <div class="AccordionPanel">
                              <div align="left" class="AccordionPanelTab">Chambre sociale</div>
                              <div class="AccordionPanelContent">
                                <table border="0" cellpadding="2" cellspacing="1">
                                  <tr valign="top">
                                    <td width="12" align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="liste_rgsocial.php" class="fiche">R&ocirc;le g&eacute;n&eacute;ral </a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="liste_plumsociale.php" class="fiche">Plumitif</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="encours.php" class="fiche">Registre des requ&ecirc;tes des actes du tribunal de saisine </a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="liste_repdecision.php" class="fiche">R&eacute;pertoire des d&eacute;cisions</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="#" class="fiche">Registre des conciliations&nbsp;</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="#" class="fiche">Registre des non appel&nbsp; ni opposition&nbsp;</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td rowspan="3" align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td colspan="2" align="left"><a href="#" class="fiche">Registre des voies de recours</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td width="12" align="left"><img src="images/sidenavover.png" width="7" height="7" /></td>
                                    <td width="152" align="left"><a href="liste_regappelsocial.php" class="fiche">Appel</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="left"><img src="images/sidenavover.png" width="7" height="7" /></td>
                                    <td align="left"><a href="liste_regoppositionsocial.php" class="fiche">Opposition</a></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
<?php }
if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penale") || ($_SESSION['MM_UserGroup']=="AdminPenal"))
{?>
                    <div class="AccordionPanel">
                      <div align="left" class="AccordionPanelTab">Section P&eacute;nale</div>
                      <div class="AccordionPanelContent">
                        <table border="0" cellpadding="2" cellspacing="1">
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_regplaintes.php" class="fiche">Registre de plaintes (R.P)</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_plumpenale.php" class="fiche">Registre d'audience</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_regpieces_convictions.php" class="fiche">Registre de suivie des pi&egrave;ces &agrave; conviction</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_regscelle.php" class="fiche">Registre de transmissions des scell&eacute;s</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_regpeine.php" class="fiche">Registre de l'ex&eacute;cution des peines</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_repjugcor.php" class="fiche">Repertoire des jugements correctionnels </a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre des contraintes par corps </a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_deplego.php" class="fiche">Registre des d&eacute;pots l&eacute;gaux</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre de simple police </a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre des consignations  p&eacute;nales&nbsp;</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre  des non appels ni oppositions&nbsp;</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre des voies de recours</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre d'Expertise</a></td>
                                  </tr>
                                </table>
                      </div>
                    </div>
				<?php }
if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="AdminPenal") || ($_SESSION['MM_UserGroup']=="CabinetInstruction"))
{?>
                    <div class="AccordionPanel">
                      <div align="left" class="AccordionPanelTab"> Cabinet d'instruction</div>
                      <div class="AccordionPanelContent">
                       <table border="0" cellpadding="2" cellspacing="1">
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_regcabin.php" class="fiche">Registre d'instruction (R.I)</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Le registre des commissions rogatoires envoyés</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Le registre des commissions rogatoires reçues</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_agendacabin.php" class="fiche">L'agenda du cabinet</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre des d&eacute;tenus&nbsp;</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre des ordonnances rendues&nbsp;</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Repertoire des ordonnances de consignation et de restitution des fonds</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="encours.php" class="fiche">Registre d'Expertise</a></td>
                                  </tr>
                                </table>
                      </div>
                    </div>
            <?php }
if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="AdminPenal") || ($_SESSION['MM_UserGroup']=="CabinetJugEnfant"))
{?>
                    <div class="AccordionPanel">
                      <div align="left" class="AccordionPanelTab">Cabinet  du Juge des Enfants</div>
                      <div class="AccordionPanelContent">
                       <table border="0" cellpadding="2" cellspacing="1">
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_plum_penal_enfant.php" class="fiche">Plumitif d'audience</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_regenfant.php" class="fiche">Registre d'instruction pour Enfants(R.E)</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_cr_national.php" class="fiche">Le registre des commissions rogatoires envoyées</a></td>
                                  </tr>
                                  <tr valign="top">
                                    <td align="center"><img src="images/tbottomh3.png" width="12" height="12" /></td>
                                    <td align="left"><a href="liste_cr_international.php" class="fiche">Le registre des commissions rogatoires reçues</a></td>
                                  </tr>
                                </table>
                      </div>
                    </div>
                    <?php }
if (($_SESSION['MM_UserGroup']=="Superviseur") || ($_SESSION['MM_UserGroup']=="Administrateur") || ($_SESSION['MM_UserGroup']=="Penitentiaire"))
{?>
                    <div class="AccordionPanel">
                      <div align="left" class="AccordionPanelTab">Administration p&eacute;nitentiaire</div>
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
                            <td align="left"><a href="liste_reglevecrou.php" class="fiche">Registre des lev&eacute;es d'ecrou</a></td>
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
                            <td align="left"><a href="liste_regdeces.php" class="fiche">Registre des d&eacute;c&egrave;s</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_reglibcond.php" class="fiche">Registre des lib&eacute;rations conditionnelles</a></td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regevasion.php" class="fiche">Registre des &eacute;vasions</a> </td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="liste_regtransfert.php" class="fiche">Registre des transferments</a> </td>
                          </tr>
                          <tr valign="top">
                            <td align="center"><img src="images/tbottomh3.png" width="12" height="12"></td>
                            <td align="left"><a href="encours.php" class="fiche">Registre des voies de recours</a></td>
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
</table>
<script type="text/javascript">
<!--
var Accordion1 = new Spry.Widget.Accordion("Accordion1", { useFixedPanelHeights: false, defaultPanel: -1});
//-->
</script>