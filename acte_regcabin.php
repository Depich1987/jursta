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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO acte_regcabin (num_acteregcabin, date_acteregcabin, nature_acteregcabin, lien_acte, id_regcabin, Id_admin, date_creation, id_juridiction) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['num_acteregcabin'], "text"),
                       GetSQLValueString(Change_formatDate($_POST['date_acteregcabin']), "date"),
                       GetSQLValueString($_POST['nature_acteregcabin'], "text"),
                       GetSQLValueString($_POST['num_acteregcabin'], "text"),
                       GetSQLValueString($_POST['id_regcabin'], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['id_juridiction'], "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
}


$colname_select_nodossier = "-1";
if (isset($_GET['idrca'])) {
  $colname_select_nodossier = $_GET['idrca'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_nodossier = sprintf("SELECT * FROM reg_cabin WHERE id_regcabin = %s", GetSQLValueString($colname_select_nodossier, "int"));
$select_nodossier = mysql_query($query_select_nodossier, $jursta) or die(mysql_error());
$row_select_nodossier = mysql_fetch_assoc($select_nodossier);
$totalRows_select_nodossier = mysql_num_rows($select_nodossier);


$currentPage = $_SERVER["PHP_SELF"];

$colname_select_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_admin = sprintf("SELECT * FROM administrateurs WHERE login_admin = %s", GetSQLValueString($colname_select_admin, "text"));
$select_admin = mysql_query($query_select_admin, $jursta) or die(mysql_error());
$row_select_admin = mysql_fetch_assoc($select_admin);
$totalRows_select_admin = mysql_num_rows($select_admin);
?>
<?php
function Change_formatDate($date, $format = 'en')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'fr')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}
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
  });
  </script>
  <?php
if ((isset($_POST["Valider_cmd"])) && ($_POST["Valider_cmd"] != "")) {

?>
<script language="javascript">
rechargerpage("liste_regcabin.php");
</script>
<?php
$dossier = 'documents/';
$fichier = basename($_FILES['lien_acte']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['lien_acte']['tmp_name']);
$extensions = array('.doc', '.docx', '.pdf');
$extension = strrchr($_FILES['lien_acte']['name'], '.'); 
//D�but des v�rifications de s�curit�...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type pdf, docx, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          '����������������������������������������������������', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['lien_acte']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que �a a fonctionn�...
     {
          echo 'Upload effectu� avec succ�s !';
		  
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
?>

<?php
}
?>

<link href="css/popup.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<table width="480" align="center" >
  <tr>
    <td align="center" bgcolor="#6186AF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100%" valign="middle" >
            <table width="100%" >
              <tr bgcolor="#FFFFFF">
                <td><img src="images/forms48.png" width="32" border="0"></td>
                <td width="100%" class="Style2"><p>Registre du service des activit&eacute;s du Cabinet d'Instruction  - Ajouter un acte</p></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="middle"><table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="top" nowrap class="Style10"><table width="100%" border="0" cellpadding="5" cellspacing="0">
 
  <tr>
    <td width="19%" align="right" valign="middle" nowrap class="Style10">N&deg; du dossier :</td>
    <td width="81%"><input name="numodre_regcabin" type="text" disabled id="numodre_regcabin" value="<?php echo $row_select_nodossier['numodre_regcabin']; ?>" size="15" ></td>
  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="100%" align="right" valign="top" nowrap class="Style10"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form2">
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                  <tr class="Style10">
                    <td align="right" valign="middle" nowrap class="Style10">Date de l'acte :</td>
                    <td colspan="2"><input name="date_acteregcabin" type="text" id="datepicker" value="<?php echo date("d/m/y");?>" size="15"></td>
                  </tr>
                  <tr class="Style10">
                    <td align="right" valign="middle" nowrap class="Style10">N&deg; de l'acte : </td>
                    <td colspan="2"><input name="num_acteregcabin" type="text" id="num_acteregcabin" size="30"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" nowrap class="Style10">Nature de l'acte : </td>
                    <td colspan="2"><select name="nature_acteregcabin" id="nature_acteregcabin">
                      <option value="Convocation">Convocation</option>
                      <option value="PV_police/gendarmerie">PV_police/gendarmerie</option>
                      <option value="Requisitoire Introductif">Requisitoire Introductif</option>
                      <option value="Pv_interogatoire / 1&egrave;re comparution">Pv_interogatoire / 1&egrave;re comparution</option>
                      <option value="Pv_audition t&eacute;moin">Pv_audition t&eacute;moin</option>
                      <option value="Pv_carrence">Pv_carrence</option>
                      <option value="Pv_difficult&eacute;">Pv_difficult&eacute;</option>
                      <option value="Pv_Transport sur les lieux">Pv_Transport sur les lieux</option>
                      <option value="Rapport d'expertise">Rapport d'expertise</option>
                      <option value="Mandat de d&eacute;p&ocirc;t">Mandat de d&eacute;p&ocirc;t</option>
                      <option value="Mandat d'arr&ecirc;t / amen&eacute;">Mandat d'arr&ecirc;t / amen&eacute;</option>
                      <option value="Mandat de comparution">Mandat de comparution</option>
                      <option value="Demande de mise en libert&eacute; provisoire">Demande de mise en libert&eacute; provisoire</option>
                      <option value="Ordre de mise en libert&eacute;">Ordre de mise en libert&eacute;</option>
                      <option value="Bulletin casier judiciaire">Bulletin casier judiciaire</option>
                      <option value="Ordonnance de soit communiqu&eacute;">Ordonnance de soit communiqu&eacute;</option>
                      <option value="R&eacute;quisitoire d&eacute;finitif aux fins de renvoi en police correctionnel">R&eacute;quisitoire d&eacute;finitif aux fins de renvoi en police correctionnel</option>
                      <option value="Ordonnance de renvoi en police correctionnel">Ordonnance de renvoi en police correctionnel</option>
                      <option value="inventaire de pi&egrave;ces">inventaire de pi&egrave;ces</option>
                      <option value="etat de liquidation des frais">etat de liquidation des frais</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" nowrap class="Style10">Fichier : </td>
                    <td colspan="2"><label>
                      <input name="lien_acte" type="file" id="lien_acte" size="36">
                    </label></td>
                  </tr>
                  <tr>
                    <td nowrap><input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_select_admin['Id_admin']; ?>">
                      <input name="date_creation" type="hidden" id="date_creation" value="<?php echo date("Y-m-d H:i:s"); ?>">
                      <input name="id_regcabin" type="hidden" id="id_regcabin" value="<?php echo $row_select_nodossier['id_regcabin']; ?>">
                      <input name="id_juridiction" type="hidden" value="<?php echo $row_select_admin['id_juridiction']; ?>"></td>
                    <td colspan="2"><input type="submit" name="Valider_cmd" value="   Ajouter l'enregistrement   "></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form2">
              </form></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</BODY>
</HTML>
<?php
mysql_free_result($select_nodossier);

mysql_free_result($select_admin);

mysql_free_result($select_nodossier);
?>
