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
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	

$idadmin = 	$_POST['nodordre_plaintes']."-".$_POST['date_creation'];
$cles_pivot = $idadmin;
$idjuridiction = 	$_POST['id_juridiction'];
	
	
  $insertSQL = sprintf("INSERT INTO reg_plaintes_desc (nodordre_plaintes, Pautosaisi_plaintes, Red_plaintes, dateparquet_plaintes, suite_plaintes, MotifClass_plaintes, observations_plaintes, Id_admin, date_creation, DatInfraction_plaintes, LieuInfraction_plaintes, id_categorieaffaire, PVdat_plaintes, naturesuite_plaintes, typepv_plaintes, naturecrimes_plaintes, procedureautreparquet_plaintes, typesaisine_plaintes, id_juridiction, cles_pivot) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nodordre_plaintes'], "text"),
                       GetSQLValueString($_POST['Pautosaisi_plaintes'], "text"),
                       GetSQLValueString($_POST['Red_plaintes'], "text"),
                       GetSQLValueString(Change_formatDat($_POST['dateparquet_plaintes']), "date"),
                       GetSQLValueString($_POST['suite_plaintes'], "text"),
                       GetSQLValueString($_POST['MotifClass_plaintes'], "text"),
                       GetSQLValueString($_POST['observations_plaintes'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString(Change_formatDat($_POST['DatInfraction_plaintes']), "date"),
                       GetSQLValueString($_POST['LieuInfraction_plaintes'], "text"),
                       GetSQLValueString($_POST['id_categorieaffaire'], "int"),
                       GetSQLValueString(Change_formatDat($_POST['PVdat_plaintes']), "date"),
					   GetSQLValueString($_POST['PVnum_plaintes'], "int"),
                       GetSQLValueString($_POST['naturesuite_plaintes'], "text"),
                       GetSQLValueString($_POST['typepv_plaintes'], "text"),
                       GetSQLValueString($_POST['naturecrimes_plaintes'], "text"),
                       GetSQLValueString($_POST['procedureautreparquet_plaintes'], "int"),
                       GetSQLValueString($_POST['typesaisine_plaintes'], "text"),
                       GetSQLValueString($_POST['id_juridiction'], "int"),
					   GetSQLValueString($cles_pivot, "text"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
  
  $_SESSION['cles_pivot_sess'] = $cles_pivot;
  $_SESSION['id_admin_sess'] = $idadmin;
  $_SESSION['id_juridiction_sess'] = $idjuridiction;
  
  header("Location: add_regplaintes_page1.php?option=addname");
}

if ((isset($_POST["MM_insert_noms"])) && ($_POST["MM_insert_noms"] == "form1")  ) {
	
	$cles_pivot = $_SESSION['cles_pivot_sess'];
	$idadmin = $_SESSION['id_admin_sess'];
    $idjuridiction = $_SESSION['id_juridiction_sess'];
	
	$insertSQL = sprintf("INSERT INTO reg_plaintes_noms  (NomPreDomInculpes_plaintes, Domicile, age, NatInfraction_plaintes, cles_pivot, Id_admin,  id_juridiction) 
						VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NomPreDomInculpes_plaintes'], "text"),
					   GetSQLValueString($_POST['Domicile'], "text"),
					   GetSQLValueString($_POST['age'], "text"),
                       GetSQLValueString($_POST['NatInfraction_plaintes'], "text"),
					   GetSQLValueString($cles_pivot, "text"),
					   GetSQLValueString($idadmin, "int"),
					   GetSQLValueString($idjuridiction, "int"));
		 
	mysql_select_db($database_jursta, $jursta);
  	$Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
	
	if( ($_POST["Valider_cmd"] == "Ajouter et quitter") )
	{
		header("Location: liste_regplaintes.php");
	}
	else
	{
		header("Location: add_regplaintes_page1.php?option=addname");
	}
}

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_jursta, $jursta);
$query_liste_affaires = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Penale' ORDER BY id_categorieaffaire ASC";
$liste_affaires = mysql_query($query_liste_affaires, $jursta) or die(mysql_error());
$row_liste_affaires = mysql_fetch_assoc($liste_affaires);
$totalRows_liste_affaires = mysql_num_rows($liste_affaires);

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE (Login_admin = '%s')", $colname_select_admin);
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
?>
<?php
function Change_formatDat($date, $format = 'en')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'fr')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}

function Change_formatDate($date, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}
?>
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<script src="js/common.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
  <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#datepicker1" ).datepicker();
	$( "#datepicker" ).datepicker();
	$( "#datepicker2" ).datepicker();
  });
  </script>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<div style="display:<?php echo (!isset($_GET['option']))?("block"):("none") ; ?>">
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="670" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Registre des plaintes  - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td align="right" valign="middle" class="Style10"><span class="Style10">N&deg; d'ordre</span> : </td>
                <td><input name="nodordre_plaintes" type="text" id="nodordre_plaintes" size="15"></td>
              </tr>
              <tr valign="middle">
                <td colspan="2" align="right" class="Style10"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="Style10">
                  <tr>
                    <th width="37%" align="right" scope="col">1&egrave;re Autorit&eacute; Saisie : </th>
                    <td width="63%" align="left" scope="col"><p>
                      <input type="radio" name="Pautosaisi_plaintes" value="Police" onClick="cacher('typesaisine');">
                      Police
                      <input type="radio" name="Pautosaisi_plaintes" value="Gendarmerie" onClick="cacher('typesaisine');">
                      Gendarmerie
  <input type="radio" name="Pautosaisi_plaintes" value="Douanes" onClick="cacher('typesaisine');">
                      Douanes <br>
                        <input type="radio" name="Pautosaisi_plaintes" value="Eaux et Forêts" onClick=";cacher('typesaisine');">
                        Eaux et Forêts
                        <input type="radio" name="Pautosaisi_plaintes" value="Parquet" onClick="afficher('typesaisine');">
                        Parquet</p></td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="Style10"><span class="Style10">Redacteur du PV </span>: </td>
                <td>                  <input name="Red_plaintes" type="text" id="Red_plaintes" size="35"></td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap class="Style10"><span class="Style10">Date du P V : </span></td>
                <td><input name="PVdat_plaintes" type="text" id="datepicker" size="15"></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="Style10"><strong>Num&eacute;ro du PV :</strong></td>
                <td><span class="Style10">
                  <input name="PVnum_plaintes" type="text" id="PVnum_plaintes" size="15">
                </span></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Nature : </td>
                <td><span class="Style10">
                  <select onChange="afficher_autre('autre','id_categorieaffaire',11);" name="id_categorieaffaire" size="1" id="id_categorieaffaire">
                    <?php
do {  
?>
                    <option  value="<?php echo $row_liste_affaires['id_categorieaffaire']?>"> <?php echo $row_liste_affaires['lib_categorieaffaire']?></option>
                    <?php
} while ($row_liste_affaires = mysql_fetch_assoc($liste_affaires));
  $rows = mysql_num_rows($liste_affaires);
  if($rows > 0) {
      mysql_data_seek($liste_affaires, 0);
	  $row_liste_affaires = mysql_fetch_assoc($liste_affaires);
  }
?>
                  </select>
                </span></td>
              </tr>
              <tr valign="middle">
                <td colspan="2" align="right" class="Style10" ><div id="autre" style="display:none; visibility:hidden">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">
					<table width="100%"  border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td width="37%" align="right" class="Style10">&nbsp;</td>
                        <td width="63%"><input name="Autre_nature" type="text" id="Autre_nature" size="35"></td>
                      </tr>
                    </table>
					</td>
                    </tr>
				</table>
                  </div>
                </td>
                </tr>
              
              <tr>
                <td align="right" valign="middle" class="Style10">Date de l'infraction : </td>
                <td><input name="DatInfraction_plaintes" type="text" id="datepicker1" maxlength="15"></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Lieu de l'infraction : </td>
                <td><input name="LieuInfraction_plaintes" type="text" id="LieuInfraction_plaintes" size="35"></td>
              </tr>
              
              <tr valign="middle">
                <td colspan="2" align="right" class="Style10"><div id="naturecrime" style="visibility:hidden; display:none">
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="288"  align="right" valign="top" nowrap class="Style10"><span class="Style10">Nature du crime ou du d&eacute;lit</span> :</td>
                    <td class="Style10"><input type="radio" name="naturecrimes_plaintes" value="Constatée">
      Constat&eacute;e
      <input name="naturecrimes_plaintes" type="radio" value="Poursuivis" checked>
      Poursuivis</td>
                  </tr>
                </table></div></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Date d'entr&eacute;e au parquet : </td>
                <td><input name="dateparquet_plaintes" type="text" id="datepicker2" size="15"></td>
              </tr>
              <tr valign="middle">
                <td colspan="2" align="right" class="Style10"><div id="typesaisine" style="display:none; visibility:hidden">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="295" align="right" valign="top" nowrap class="Style10">Type de saisine : </td>
                    <td width="365" nowrap class="Style10"><input type="radio" name="typesaisine_plaintes" value="Procès Verbal" onClick="afficher('typepv');cacher('autreparquet');">

      Lettres
      <input type="radio" name="typesaisine_plaintes" value="Autres affaires pénales" onClick="afficher('autreparquet');cacher('typepv');">
      Autres affaires p&eacute;nales </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right" valign="top" nowrap class="Style10">
					<div id="typepv">
                      <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td width="45%" align="right" class="Style10">Mode de saisine : </td>
                        <td width="55%"><select name="typepv_plaintes">
                          <option value="1">Plaintes et d&eacute;nonciation</option>
                          <option value="3">Plaintes avec constitution de partie civile</option>
                        </select></td>
                      </tr>
                    </table>
					</div>
					</td>
                    </tr>
					<tr><td colspan="2">
					<div id="autreparquet">
                      <table width="100%"  border="0" cellspacing="0" cellpadding="5"><tr>
                    <td width="291" align="right" valign="top" nowrap class="Style10">Procedure provenant d'autre parquet ? </td>
                    <td width="359" class="Style10"><input type="radio" name="procedureautreparquet_plaintes" value="1">
      Oui
        <input type="radio" name="procedureautreparquet_plaintes" value="0" checked>
      Non</td>
                  </tr></table>
				  </div>
				  </td></tr>
                </table>
                </div></td>
                </tr>
              <tr>
                <th align="right" valign="middle" class="Style10">Suite de l'affaire  : </th>
                <td><select name="naturesuite_plaintes" id="naturesuite_plaintes">
<option value="Non Poursuivable">Information</option>
<option value="Poursuivable">Flagrant d&eacute;lit</option>
<option value="Poursuivable">Citation directe</option>
<option value="Class&eacute;e">Classement sans suite</option>
                </select></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="Style10">Transmis au : </td>
                <td><select name="suite_plaintes" id="suite_plaintes">
				<option value="" selected></option>
                  <option value="Juge d'intruction">Juge d'intruction</option>
                  <option value="Juge des enfants">Juge des enfants</option>
                  <option value="Tribunal correctionnel">Tribunal correctionnel</option>
                  </select></td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap class="Style10">Motif du classement :  </td>
                <td><textarea name="MotifClass_plaintes" cols="38" id="MotifClass_plaintes"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap class="Style10">Observations : </td>
                <td><textarea name="observations_plaintes" cols="38" id="observations_plaintes"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="Style10"><input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>">
                <input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                
                  <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>"></td>
                <td><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
              </tr>
          </table>
            </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
  
  
  
  
  
  <input type="hidden" name="MM_insert" value="form1">
</form>
</div>
<div style="display:<?php echo (!isset($_GET['option']))?("none"):("block") ; ?>">
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="670" align="center" >
    <tr>
      <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Registre des plaintes  - Ajouter un enregistrement</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr valign="middle">
                <td colspan="2" align="right" class="Style10" ><div id="autre" style="display:none; visibility:hidden">
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align="right" valign="top" nowrap class="Style10">
                        <div id="typepv">
                          <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                            <tr>
                              <td width="37%" align="right" class="Style10">&nbsp;</td>
                              <td width="63%"><input name="Autre_nature" type="text" id="Autre_nature" size="35"></td>
                              </tr>
                            </table>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  </td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Nom et pr&eacute;noms  de l'inculp&eacute; : </td>
                <td><input name="NomPreDomInculpes_plaintes" type="text" id="textarea" size="38"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Age :</td>
                <td><input name="age" type="text" id="age" size="8"></td>
              </tr>
              <tr>
                <td align="right" valign="top" nowrap class="Style10">Domicile :</td>
                <td><input name="Domicile" type="text" id="Domicile" size="38"></td>
              </tr>
              <tr>
                <td width="300" align="right" valign="top" nowrap class="Style10">Infraction :</td>
                <td><span class="Style10">
                  <textarea name="NatInfraction_plaintes" id="NatInfraction_plaintes" cols="38" rows="3"></textarea>
                </span></td>
              </tr>
              <tr valign="middle">
                <td colspan="2" align="right" class="Style10"><div id="naturecrime" style="visibility:hidden; display:none">
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="288"  align="right" valign="top" nowrap class="Style10"><span class="Style10">Nature du crime ou du d&eacute;lit</span> :</td>
                    <td class="Style10"><input type="radio" name="naturecrimes_plaintes" value="Constatée">
      Constat&eacute;e
      <input type="radio" name="naturecrimes_plaintes" value="Poursuivis">
      Poursuivis</td>
                  </tr>
                </table></div></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="Style10"><input type="submit" name="Valider_cmd2" value=" Ajouter et continuer"></td>
                <td><input type="submit" name="Valider_cmd" value="Ajouter et quitter"></td>
              </tr>
          </table>
            </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
  <input name="MM_insert_noms" type="hidden" id="MM_insert_noms" value="form1">
</form>
</div>
</BODY>
</HTML>
<?php
mysql_free_result($liste_affaires);

mysql_free_result($select_admin);
?>
