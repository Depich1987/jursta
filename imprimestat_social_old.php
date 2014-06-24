<?php require_once('Connections/jursta.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "Civile,Administrateur,Superviseur,AdminCivil";
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
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$colname_select_juridiction = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_select_juridiction = $_SESSION['MM_Username'];
}
mysql_select_db($database_jursta, $jursta);
$query_select_juridiction = sprintf("SELECT * FROM administrateurs, juridiction, type_juridiction WHERE ((Login_admin = %s) AND (administrateurs.id_juridiction=juridiction.id_juridiction) AND (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($colname_select_juridiction, "text"));
$select_juridiction = mysql_query($query_select_juridiction, $jursta) or die(mysql_error());
$row_select_juridiction = mysql_fetch_assoc($select_juridiction);
$totalRows_select_juridiction = mysql_num_rows($select_juridiction);

mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Civile'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);

$datedebut=$_SESSION['datedebut'];
$datefin=$_SESSION['datefin'];

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
  </script></head>

<body class="imprime">
<table width="100%" align="center" >
  <tr>
    <td valign="top"><div align="center">
<span class="Style2">
<?php
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_SESSION['id_juridiction'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_SESSION['id_juridiction'] : addslashes($_SESSION['id_juridiction']);
	}

	mysql_select_db($database_jursta, $jursta);
	$query_selectionner_juridiction = sprintf("SELECT * FROM juridiction, type_juridiction WHERE ((id_juridiction = %s) AND  (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction))", GetSQLValueString($juridiction, "text"));
	$selectionner_juridiction = mysql_query($query_selectionner_juridiction, $jursta) or die(mysql_error());
	$row_selectionner_juridiction = mysql_fetch_assoc($selectionner_juridiction);
	$totalRows_selectionner_juridiction = mysql_num_rows($selectionner_juridiction);

	echo Change_formatDate($row_selectionner_juridiction['lib_typejuridiction']." DE ".$row_selectionner_juridiction['lib_juridiction']);
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
	echo Change_formatDate($row_select_juridiction['lib_typejuridiction']." DE ".$row_select_juridiction['lib_juridiction']);
}

?>
</span>
<p><span class="Style2">STATISTIQUES DES AFFAIRES SOCIALES</span> <span class="Style2">
  
</span><?php echo("P&eacute;riode du ".$_SESSION['datedebut']." au ".$_SESSION['datefin']); ?> </p>
    </div></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table cellpadding="2" cellspacing="1" >
      <tr>
        <td colspan="4" rowspan="2" bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="9" align="center" bgcolor="#FFFFFF" class="Style15"><table width="100%"  border="0" cellspacing="0" cellpadding="8">
          <tr>
            <td align="center" class="Style11">JUGEMENTS RENDUES </td>
          </tr>
        </table></td>
      </tr>
      <tr class="Style15">
        <td colspan="2" align="center" bgcolor="#FFFFFF" class="Style11">Statuant sur la demande </td>
        <td colspan="4" align="center" bgcolor="#FFFFFF" class="Style11">Autres Jugements rendus </td>
        <td colspan="3" align="center" bgcolor="#FFFFFF" class="Style11">&nbsp;</td>
      </tr>
      <tr bgcolor="#6186AF" class="Style11">
        <td align="center" bgcolor="#FFFFFF"><strong>#</strong></td>
        <td width="100%" align="center" bgcolor="#FFFFFF"><strong>Nature</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>Affaires pr&eacute;c&eacute;dentes </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>Nouvelle affaires enrol&eacute;es </strong></td>
        <td align="center" nowrap bgcolor="#FFFFFF"><strong>Accueillant<br>
          la demande </strong></td>
        <td align="center" nowrap bgcolor="#FFFFFF"><strong>Rejet de la<br>
          demande </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>Contradictoire</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>Incomp&eacute;tence</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>Radiation</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>D&eacute;faut</strong></td>
        <td align="center" nowrap bgcolor="#FFFFFF"><p align="center"><strong>Affaire en<br>
          cours en<br>
          fin du mois </strong></p></td>
        <td align="center" bgcolor="#FFFFFF"><strong>Dur&eacute;e moy<br>
          affaire trait&eacute;e </strong></td>
        <td align="center" bgcolor="#FFFFFF"><p align="center"><strong>Nombre actes greffe </strong></p></td>
      </tr>
  <?php $h=0; ?>
  <?php do { ?>
  <?php
$h++;
$categorie = $row_liste_nature['id_categorieaffaire'];

if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty  
	$juridiction="-1";
	if (isset($_POST['id_juridiction'])) {
	  $juridiction = (get_magic_quotes_gpc()) ? $_POST['id_juridiction'] : addslashes($_POST['id_juridiction']);
	}
}
else{
	$juridiction = $row_select_juridiction['id_juridiction'];
}

mysql_select_db($database_jursta, $jursta);

$query_affairesenrolees = "SELECT count(*) as affairesenrolees FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND 
(rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie."))";
$affairesenrolees = mysql_query($query_affairesenrolees, $jursta) or die(mysql_error());
$row_affairesenrolees = mysql_fetch_assoc($affairesenrolees);
$totalRows_affairesenrolees = mysql_num_rows($affairesenrolees);
echo $query_affairesenrolees;

mysql_select_db($database_jursta, $jursta);
$query_affairesprecedent = "SELECT count(*) as affairesprecedent FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (rg_social.date_creation< '".$datedebut."') AND (rg_social.id_categorieaffaire=".$categorie."))";
$affairesprecedent = mysql_query($query_affairesprecedent, $jursta) or die(mysql_error());
$row_affairesprecedent = mysql_fetch_assoc($affairesprecedent);
$totalRows_affairesprecedent = mysql_num_rows($affairesprecedent);


mysql_select_db($database_jursta, $jursta);
$query_liste_acte = "SELECT count(*) as nbacte FROM rep_actesnot, administrateurs WHERE ((administrateurs.Id_admin=rep_actesnot.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rep_actesnot.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_actesnot.id_categorieaffaire=".$categorie."))";
$liste_acte = mysql_query($query_liste_acte, $jursta) or die(mysql_error());
$row_liste_acte = mysql_fetch_assoc($liste_acte);
$totalRows_liste_acte = mysql_num_rows($liste_acte);


mysql_select_db($database_jursta, $jursta);
$query_liste_actecc = "SELECT count(*) as nbactecc FROM rep_actesacc, administrateurs WHERE ((administrateurs.Id_admin=rep_actesacc.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rep_actesacc.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_actesacc.id_categorieaffaire=".$categorie."))";
$liste_actecc = mysql_query($query_liste_actecc, $jursta) or die(mysql_error());
$row_liste_actecc = mysql_fetch_assoc($liste_actecc);
$totalRows_liste_actecc = mysql_num_rows($liste_actecc);


mysql_select_db($database_jursta, $jursta);
$query_demandeaccepte = "SELECT count(*) as demandeaccepte FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.statut_jugementsupp='Accept&eacute;e')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$demandeaccepte = mysql_query($query_demandeaccepte, $jursta) or die(mysql_error());
$row_demandeaccepte = mysql_fetch_assoc($demandeaccepte);
$totalRows_demandeaccepte = mysql_num_rows($demandeaccepte);


mysql_select_db($database_jursta, $jursta);
$query_demanderejete = "SELECT count(*) as demanderejete FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.statut_jugementsupp='Rejet&eacute;e')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$demanderejete = mysql_query($query_demanderejete, $jursta) or die(mysql_error());
$row_demanderejete = mysql_fetch_assoc($demanderejete);
$totalRows_demanderejete = mysql_num_rows($demanderejete);

mysql_select_db($database_jursta, $jursta);
$query_jug_contradictoires = "SELECT count(*) as jugcontradictoires FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Contradictoire')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$jug_contradictoires = mysql_query($query_jug_contradictoires, $jursta) or die(mysql_error());
$row_jug_contradictoires = mysql_fetch_assoc($jug_contradictoires);
$totalRows_jug_contradictoires = mysql_num_rows($jug_contradictoires);

mysql_select_db($database_jursta, $jursta);
$query_jugincompetence = "SELECT count(*) as jugincompetence FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Incompetence')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$jugincompetence = mysql_query($query_jugincompetence, $jursta) or die(mysql_error());
$row_jugincompetence = mysql_fetch_assoc($jugincompetence);
$totalRows_jugincompetence = mysql_num_rows($jugincompetence);

mysql_select_db($database_jursta, $jursta);
$query_jugradiatiation = "SELECT count(*) as jugradiatiation FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Radiation')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$jugradiatiation = mysql_query($query_jugradiatiation, $jursta) or die(mysql_error());
$row_jugradiatiation = mysql_fetch_assoc($jugradiatiation);
$totalRows_jugradiatiation = mysql_num_rows($jugradiatiation);

mysql_select_db($database_jursta, $jursta);
$query_jugdefaut = "SELECT count(*) as jugdefaut FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rg_social.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Defaut')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$jugdefaut = mysql_query($query_jugdefaut, $jursta) or die(mysql_error());
$row_jugdefaut = mysql_fetch_assoc($jugdefaut);
$totalRows_jugdefaut = mysql_num_rows($jugdefaut);

mysql_select_db($database_jursta, $jursta);
$query_total_affairesprecedent = "SELECT count(*) as affairesprecedent FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (rg_social.date_creation< '".$datedebut."'))";
$total_affairesprecedent = mysql_query($query_total_affairesprecedent, $jursta) or die(mysql_error());
$row_total_affairesprecedent = mysql_fetch_assoc($total_affairesprecedent);
$totalRows_total_affairesprecedent = mysql_num_rows($total_affairesprecedent);

mysql_select_db($database_jursta, $jursta);
$query_total_affairesenrolees = "SELECT count(*) as affairesenrolees FROM rg_social, administrateurs WHERE ((administrateurs.Id_admin=rg_social.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') )";
$total_affairesenrolees = mysql_query($query_total_affairesenrolees, $jursta) or die(mysql_error());
$row_total_affairesenrolees = mysql_fetch_assoc($total_affairesenrolees);
$totalRows_total_affairesenrolees = mysql_num_rows($total_affairesenrolees);

mysql_select_db($database_jursta, $jursta);
$query_total_demandeaccepte = "SELECT count(*) as demandeaccepte FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_jugementsupp.statut_jugementsupp='Accept&eacute;e')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$total_demandeaccepte = mysql_query($query_total_demandeaccepte, $jursta) or die(mysql_error());
$row_total_demandeaccepte = mysql_fetch_assoc($total_demandeaccepte);
$totalRows_total_demandeaccepte = mysql_num_rows($total_demandeaccepte);

mysql_select_db($database_jursta, $jursta);
$query_total_demanderejete = "SELECT count(*) as demanderejete FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_jugementsupp.statut_jugementsupp='Rejet&eacute;e')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$total_demanderejete = mysql_query($query_total_demanderejete, $jursta) or die(mysql_error());
$row_total_demanderejete = mysql_fetch_assoc($total_demanderejete);
$totalRows_total_demanderejete = mysql_num_rows($total_demanderejete);

mysql_select_db($database_jursta, $jursta);
$query_total_jugcontradictoires = "SELECT count(*) as jugcontradictoires FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_jugementsupp.dispositif_repjugementsupp='Contradictoire')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$total_jugcontradictoires = mysql_query($query_total_jugcontradictoires, $jursta) or die(mysql_error());
$row_total_jugcontradictoires = mysql_fetch_assoc($total_jugcontradictoires);
$totalRows_total_jugcontradictoires = mysql_num_rows($total_jugcontradictoires);

mysql_select_db($database_jursta, $jursta);
$query_total_jugincompetence = "SELECT count(*) as jugincompetence FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."') AND (rep_jugementsupp.dispositif_repjugementsupp='Incompetence')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$total_jugincompetence = mysql_query($query_total_jugincompetence, $jursta) or die(mysql_error());
$row_total_jugincompetence = mysql_fetch_assoc($total_jugincompetence);
$totalRows_total_jugincompetence = mysql_num_rows($total_jugincompetence);

mysql_select_db($database_jursta, $jursta);
$query_total_jugradiatiation = "SELECT count(*) as jugradiatiation FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."')  AND (rep_jugementsupp.dispositif_repjugementsupp='Radiation')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$total_jugradiatiation = mysql_query($query_total_jugradiatiation, $jursta) or die(mysql_error());
$row_total_jugradiatiation = mysql_fetch_assoc($total_jugradiatiation);
$totalRows_total_jugradiatiation = mysql_num_rows($total_jugradiatiation);

mysql_select_db($database_jursta, $jursta);
$query_total_jugdefaut = "SELECT count(*) as jugdefaut FROM administrateurs, rep_jugementsupp, rg_social WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rg_social.date_creation BETWEEN '".$datedebut."' AND '".$datefin."')  AND (rep_jugementsupp.dispositif_repjugementsupp='Defaut')  AND (rg_social.no_rgsocial=rep_jugementsupp.no_rgsocial))";
$total_jugdefaut = mysql_query($query_total_jugdefaut, $jursta) or die(mysql_error());
$row_total_jugdefaut = mysql_fetch_assoc($total_jugdefaut);
$totalRows_total_jugdefaut = mysql_num_rows($total_jugdefaut);

mysql_select_db($database_jursta, $jursta);
$query_total_nbactecc = "SELECT count(*) as nbactecc FROM rep_actesacc, administrateurs WHERE ((administrateurs.Id_admin=rep_actesacc.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (rep_actesacc.date_creation BETWEEN '".$datedebut."' AND '".$datefin."'))";
$total_nbactecc = mysql_query($query_total_nbactecc, $jursta) or die(mysql_error());
$row_total_nbactecc = mysql_fetch_assoc($total_nbactecc);
$totalRows_total_nbactecc = mysql_num_rows($total_nbactecc);

?>
      <tr bgcolor="#EDF0F3">
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $h; ?></td>
        <td bgcolor="#FFFFFF" class="Style22"><?php echo $row_liste_nature['lib_categorieaffaire']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22 Style22 Style22"><?php echo $row_affairesprecedent['affairesprecedent']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22 Style22 Style22"><?php echo $row_affairesenrolees['affairesenrolees']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_demandeaccepte['demandeaccepte']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_demanderejete['demanderejete']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_jug_contradictoires['jugcontradictoires']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_jugincompetence['jugincompetence']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_jugradiatiation['jugradiatiation']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo $row_jugdefaut['jugdefaut']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo Change_formatDate($row_affairesprecedent['affairesprecedent']+$row_affairesenrolees['affairesenrolees']-($row_jug_contradictoires['jugcontradictoires']+$row_jugdefaut['jugdefaut']+$row_jugincompetence['jugincompetence']+$row_jugradiatiation['jugradiatiation'])); //+$row_demandeaccepte['demandeaccepte']+$row_demanderejete['demanderejete']?></td>
        <td align="center" bgcolor="#FFFFFF" class="Style22">0</td>
        <td align="center" bgcolor="#FFFFFF" class="Style22"><?php echo Change_formatDate($row_liste_acte['nbacte']+$row_liste_actecc['nbactecc']); ?></td>
      </tr>
      <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
      <tr align="center" bgcolor="#677787" class="Style11">
        <td colspan="2" bgcolor="#FFFFFF" class="Style22"><strong>Total</strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_affairesprecedent['affairesprecedent']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_affairesenrolees['affairesenrolees']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_demandeaccepte['demandeaccepte']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_demanderejete['demanderejete']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_jugcontradictoires['jugcontradictoires']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_jugincompetence['jugincompetence']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_jugradiatiation['jugradiatiation']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_jugdefaut['jugdefaut']; ?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo Change_formatDate($row_total_affairesprecedent['affairesprecedent']+$row_total_affairesenrolees['affairesenrolees']-($row_total_jugcontradictoires['jugcontradictoires']+$row_total_jugdefaut['jugdefaut']+$row_total_jugincompetence['jugincompetence']+$row_total_jugradiatiation['jugradiatiation'])); //+$row_demandeaccepte['demandeaccepte']+$row_demanderejete['demanderejete']?></strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong>0</strong></td>
        <td bgcolor="#FFFFFF" class="Style22"><strong><?php echo $row_total_nbactecc['nbactecc']; ?></strong></td>
      </tr>
      <tr bgcolor="#677787">
        <td colspan="13" align="center" bgcolor="#FFFFFF" class="Style22"><img src="images/spacer.gif" width="1" height="1"></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($liste_nature);

mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);

mysql_free_result($affairesenrolees);

mysql_free_result($affairesprecedent);

mysql_free_result($liste_acte);

mysql_free_result($liste_actecc);

mysql_free_result($demandeaccepte);

mysql_free_result($demanderejete);

mysql_free_result($jug_contradictoires);

mysql_free_result($jugincompetence);

mysql_free_result($jugradiatiation);

mysql_free_result($jugdefaut);

mysql_free_result($total_affairprecedente);

mysql_free_result($totaldemanderejete);

mysql_free_result($totalaffairesenrolees);

mysql_free_result($totaldemandeaccepte);

mysql_free_result($Total_jugcontradictoires);

mysql_free_result($total_jugincompetence);

mysql_free_result($total_jugradiatiation);

mysql_free_result($total_jugdefaut);

mysql_free_result($total_nbacte);

mysql_free_result($select_juridiction);

mysql_free_result($crimes_constates);

mysql_free_result($crimes_poursuivis);

mysql_free_result($pvdedenonciation);

mysql_free_result($pvauteurinconnus);

mysql_free_result($pvcrimes);

mysql_free_result($pvdelit);

mysql_free_result($pvcontraventions);

mysql_free_result($affairepenals);

mysql_free_result($affaireautresparquet);
?>
