<?php require_once('Connections/jursta.php'); ?>
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

$maxRows_liste_rolegeneral = 30;
$pageNum_liste_rolegeneral = 0;
if (isset($_GET['pageNum_liste_rolegeneral'])) {
  $pageNum_liste_rolegeneral = $_GET['pageNum_liste_rolegeneral'];
}
$startRow_liste_rolegeneral = $pageNum_liste_rolegeneral * $maxRows_liste_rolegeneral;

mysql_select_db($database_jursta, $jursta);
$query_liste_rolegeneral = "SELECT * FROM role_general ORDER BY no_rolegeneral ASC";
$query_limit_liste_rolegeneral = sprintf("%s LIMIT %d, %d", $query_liste_rolegeneral, $startRow_liste_rolegeneral, $maxRows_liste_rolegeneral);
$liste_rolegeneral = mysql_query($query_limit_liste_rolegeneral, $jursta) or die(mysql_error());
$row_liste_rolegeneral = mysql_fetch_assoc($liste_rolegeneral);

if (isset($_GET['totalRows_liste_rolegeneral'])) {
  $totalRows_liste_rolegeneral = $_GET['totalRows_liste_rolegeneral'];
} else {
  $all_liste_rolegeneral = mysql_query($query_liste_rolegeneral);
  $totalRows_liste_rolegeneral = mysql_num_rows($all_liste_rolegeneral);
}
$totalPages_liste_rolegeneral = ceil($totalRows_liste_rolegeneral/$maxRows_liste_rolegeneral)-1;

$queryString_liste_rolegeneral = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_rolegeneral") == false && 
        stristr($param, "totalRows_liste_rolegeneral") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_rolegeneral = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_rolegeneral = sprintf("&totalRows_liste_rolegeneral=%d%s", $totalRows_liste_rolegeneral, $queryString_liste_rolegeneral);
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Style2 {
	font-size: 24px;
	color: #6186AF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	color: #FFFFFF;
}
a:link {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-small;
	font-style: normal;
	font-weight: bold;
	font-variant: normal;
	color: #D0D9E0;
	text-decoration: none;
}
a:hover {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-small;
	font-style: normal;
	font-weight: bold;
	font-variant: normal;
	color: #3E5B7B;
	text-decoration: none;
}
a.fiche:link {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-small;
	font-style: normal;
	font-weight: bold;
	font-variant: normal;
	color: #677787;
	text-decoration: none;
}
a.fiche:hover {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-small;
	font-style: normal;
	font-weight: bold;
	font-variant: normal;
	color: #990000;
	text-decoration: none;
}

body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-image: url(images/index_01.gif);
	background-repeat: repeat-x;
}
input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #677787;
	background-color: #FFFFFF;
	border: 1px solid #677787;
}
.Style14 {font-size: xx-small}
.Style21 {font-size: x-small; font-weight: bold; color: #D0D9E0; }
.Style22 {font-size: x-small}
.Style23 {
	color: #FF0000;
	font-weight: bold;
}
.Style24 {color: #FF0000}
.Style25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
.Style15 {font-size: xx-small; font-weight: bold; }
.Style16 {font-size: xx-small; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Style17 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_1018160732_0) return;
      window.mm_menu_1018160732_0 = new Menu("root",164,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018160732_0.addMenuItem("Modifier&nbsp;mot&nbsp;de&nbsp;passe");
  mm_menu_1018160732_0.addMenuItem("Cr�er&nbsp;un&nbsp;compte");
  mm_menu_1018160732_0.addMenuItem("G�rer&nbsp;les&nbsp;droits");
  mm_menu_1018160732_0.addMenuItem("G�rer&nbsp;les&nbsp;cours&nbsp;d'appel");
  mm_menu_1018160732_0.addMenuItem("G�rer&nbsp;le&nbsp;tribunaux");
  mm_menu_1018160732_0.addMenuItem("G�rer&nbsp;les&nbsp;villes");
   mm_menu_1018160732_0.hideOnMouseOut=true;
   mm_menu_1018160732_0.bgColor='#555555';
   mm_menu_1018160732_0.menuBorder=1;
   mm_menu_1018160732_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1018160732_0.menuBorderBgColor='#777777';
      window.mm_menu_1018162239_0 = new Menu("root",278,24,"",12,"#D0D9E0","#6186AF","#6186AF","#EDF0F3","left","middle",6,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1018162239_0.addMenuItem("Police/Gendarmerie/Saisine&nbsp;du&nbsp;Parquet","location='#'");
  mm_menu_1018162239_0.addMenuItem("Orientation&nbsp;des&nbsp;Affaires&nbsp;du&nbsp;parquet","location='#'");
  mm_menu_1018162239_0.addMenuItem("Activit�s&nbsp;des&nbsp;Juges","location='#'");
  mm_menu_1018162239_0.addMenuItem("Condamnations&nbsp;apr�s&nbsp;d�tention&nbsp;provisoire","location='#'");
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
                                <td><a href="liste_registrecomroginterne.php" class="fiche">Le registre des commissions rogatoire interne </a></td>
                              </tr>
                              <tr>
                                <td><a href="liste_registrecomrogexterne.php" class="fiche">Le registre des commissions rogatoire externe</a></td>
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
                <td><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                <td width="100%"><span class="Style2">Le r&ocirc;le g&eacute;n&eacute;ral</span> </td>
              </tr>
          </table></td>
        </tr>
        <?php if ($totalRows_liste_rolegeneral > 0) { // Show if recordset not empty ?>
        <tr>
          <td valign="middle" ><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#6186AF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                    <tr bgcolor="#677787" class="Style3">
                      <td width="16%">#</td>
                      <td width="16%"><span class="Style10">N&deg; d'ordre </span></td>
                      <td width="8%"><span class="Style10">Date</span></td>
                      <td width="17%"><span class="Style10">Demandeur</span></td>
                      <td width="15%"><span class="Style10">Defendeur</span></td>
                      <td width="26%" nowrap><span class="Style10">Objet &amp; Audience </span></td>
                      <td width="18%"><span class="Style10">Observation</span></td>
                      <td width="18%">Op&eacute;rations</td>
                    </tr>
		<?php $tabcolor="#D0E0F0"; 
		$i=$page
		?>			
        			
       <?php do { ?>
                    <tr bgcolor="<?php $tabcolor ?>" class="Style14">
                      <td align="center" valign="middle" class="Style15">1</td>
                      <td valign="middle"><span class="Style25"><?php echo $row_liste_rolegeneral['noordre_rolegeneral']; ?></span></td>
                      <td valign="middle" nowrap><?php echo $row_liste_rolegeneral['date_rolegeneral']; ?></td>
                      <td valign="middle" nowrap><?php echo $row_liste_rolegeneral['demandeur_rolegeneral']; ?></td>
                      <td valign="middle" nowrap><?php echo $row_liste_rolegeneral['defendeur_rolegeneral']; ?></td>
                      <td valign="middle"><?php echo $row_liste_rolegeneral['objet_rolegeneral']; ?></td>
                      <td valign="middle"><?php echo $row_liste_rolegeneral['observation_rolegeneral']; ?></td>
                      <td valign="middle"><table width="72" height="33" >
                          <tr align="center" class="Style16">
                            <td>V</td>
                            <td>M</td>
                            <td>S</td>
                          </tr>
                      </table></td>
                    </tr>
                    <?php } while ($row_liste_rolegeneral = mysql_fetch_assoc($liste_rolegeneral)); ?>
                </table></td>
              </tr>
          </table>
                        <br>
            <table border="0" align="center" cellpadding="3" cellspacing="0" class="Style10">
              <tr class="Style14">
                <td><a href="<?php printf("%s?pageNum_liste_rolegeneral=%d%s", $currentPage, max(0, $pageNum_liste_rolegeneral - 1), $queryString_liste_rolegeneral); ?>"><strong>&laquo; Pr&eacute;c&eacute;dent</strong></a> </td>
                <td><a href="<?php printf("%s?pageNum_liste_rolegeneral=%d%s", $currentPage, min($totalPages_liste_rolegeneral, $pageNum_liste_rolegeneral + 1), $queryString_liste_rolegeneral); ?>"><strong>Suivant&raquo;</strong></a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>Page</strong></td>
                <td><strong><?php echo $pageNum_liste_rolegeneral ?>/<?php echo $totalPages_liste_rolegeneral; ?></strong></td>
                <td>&nbsp;</td>
                <td><strong>Enrg de <?php echo $startRow_liste_rolegeneral; ?> &agrave; 30 </strong></td>
                <td><strong>Total </strong></td>
                <td><strong><?php echo $totalRows_liste_rolegeneral ?> </strong></td>
              </tr>
            </table></td>
        </tr>
        <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_liste_rolegeneral == 0) { // Show if recordset empty ?>
        <tr>
          <td align="center" valign="middle"  class="Style23 Style22">Aucun enregistrement dans la base de donn&eacute;es </td>
        </tr>
        <?php } // Show if recordset empty ?>
      </table></td>
    </tr>
  </table>  
  �
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

mysql_free_result($liste_rolegeneral);
?>
