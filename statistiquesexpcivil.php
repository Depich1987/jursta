<?php require_once('Connections/jursta.php'); ?>
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

$deleteSQL = "TRUNCATE TABLE T36_DFSCC;";
mysql_select_db($database_jursta, $jursta);
$Result1 = mysql_query($deleteSQL, $jursta) or die(mysql_error());

mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = "SELECT * FROM juridiction, type_juridiction WHERE (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction)";
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);

$sql_insert_t30="";
$sql_insert_t36="";
?>
<?php do { ?>
<?php 
mysql_select_db($database_jursta, $jursta);
$query_liste_nature = "SELECT * FROM categorie_affaire WHERE justice_categorieaffaire = 'Civile'";
$liste_nature = mysql_query($query_liste_nature, $jursta) or die(mysql_error());
$row_liste_nature = mysql_fetch_assoc($liste_nature);
$totalRows_liste_nature = mysql_num_rows($liste_nature);
?>
    <?php do { ?>
    <?php
$categorie = $row_liste_nature['id_categorieaffaire'];
$juridiction = $row_liste_juridiction['id_juridiction'];
for ($annee=2010;$annee<=substr(date('Y-m-d'),0,4);$annee++){
	for ($ms=1;$ms<=12;$ms++){
	if ($ms<10) {$ms="0".$ms;}
	$mois=$ms;
	if (($annee==substr(date('Y-m-d'),0,4)) && ($mois>substr(date('Y-m-d'),5,2))){ break; }
$mois=intval($mois);
switch($mois)
{
	case 1 : 
		$trimestre=1;
		$semestre=1;
		break;
	case 2 : 
		$trimestre=1;
		$semestre=1;
		break;
	case 3 : 
		$trimestre=1;
		$semestre=1;
		break;
	case 4 : 
		$trimestre=2;
		$semestre=1;
		break;
	case 5 : 
		$trimestre=2;
		$semestre=1;
		break;
	case 6 : 
		$trimestre=2;
		$semestre=1;
		break;
	case 7 : 
		$trimestre=3;
		$semestre=2;
		break;
	case 8 : 
		$trimestre=3;
		$semestre=2;
		break;
	case 9 : 
		$trimestre=3;
		$semestre=2;
		break;
	case 10 : 
		$trimestre=4;
		$semestre=2;
		break;
	case 11 : 
		$trimestre=4;
		$semestre=2;
		break;
	case 12 : 
		$trimestre=4;
		$semestre=2;
		break;
}

mysql_select_db($database_jursta, $jursta);
$query_select_liaison = "SELECT * FROM t30_fs WHERE ((t30_fs.T06_ANNEE=".$annee.")"." AND (t30_fs.T30_MOIS=".$mois."));";
$select_liaison = mysql_query($query_select_liaison, $jursta) or die(mysql_error());
$row_select_liaison = mysql_fetch_assoc($select_liaison);
$totalRows_select_liaison = mysql_num_rows($select_liaison);

if ($totalRows_select_liaison==0){
	$insertSQL = "INSERT INTO t30_fs (T06_ANNEE, T30_MOIS, id_juridiction,T30_TRIM,T30_SEM) VALUES (".$annee.",".$mois.",".$juridiction.",".$trimestre.",".$semestre.");";
  	mysql_select_db($database_jursta, $jursta);
  	$Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
	$numero_liaison=mysql_insert_id();
	$sql_insert_t30=$sql_insert_t30.$insertSQL;
}
else{
	$numero_liaison=$row_select_liaison['T30_NUMERO'];
}
			
mysql_select_db($database_jursta, $jursta);
$query_affairesenrolees = "SELECT count(*) as affairesenrolees FROM role_general, administrateurs WHERE ((administrateurs.Id_admin=role_general.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(role_general.date_creation,0,4)='".$annee."') AND (substr(role_general.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie."))";
$affairesenrolees = mysql_query($query_affairesenrolees, $jursta) or die(mysql_error());
$row_affairesenrolees = mysql_fetch_assoc($affairesenrolees);
$totalRows_affairesenrolees = mysql_num_rows($affairesenrolees); 

mysql_select_db($database_jursta, $jursta);
$query_affairesprecedent = "SELECT count(*) as affairesprecedent FROM rep_actesnot, administrateurs WHERE ((administrateurs.Id_admin=rep_actesnot.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.")  AND (substr(rep_actesnot.date_creation,0,4)<='".$annee."') AND (substr(rep_actesnot.date_creation,5,2)<='".$mois."') AND (rep_actesnot.id_categorieaffaire=".$categorie."))";
$affairesprecedent = mysql_query($query_affairesprecedent, $jursta) or die(mysql_error());
$row_affairesprecedent = mysql_fetch_assoc($affairesprecedent);
$totalRows_affairesprecedent = mysql_num_rows($affairesprecedent);

mysql_select_db($database_jursta, $jursta);
$query_liste_acte = "SELECT count(*) as nbacte FROM rep_actesnot, administrateurs WHERE ((administrateurs.Id_admin=rep_actesnot.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_actesnot.date_creation,0,4)='".$annee."') AND (substr(rep_actesnot.date_creation,5,2)='".$mois."') AND (rep_actesnot.id_categorieaffaire=".$categorie."))";
$liste_acte = mysql_query($query_liste_acte, $jursta) or die(mysql_error());
$row_liste_acte = mysql_fetch_assoc($liste_acte);
$totalRows_liste_acte = mysql_num_rows($liste_acte);

mysql_select_db($database_jursta, $jursta);
$query_jug_contradictoires = "SELECT count(*) as jugcontradictoires FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_jugementsupp.date_creation,0,4)='".$annee."') AND (substr(rep_jugementsupp.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Contradictoire')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jug_contradictoires = mysql_query($query_jug_contradictoires, $jursta) or die(mysql_error());
$row_jug_contradictoires = mysql_fetch_assoc($jug_contradictoires);
$totalRows_jug_contradictoires = mysql_num_rows($jug_contradictoires);

mysql_select_db($database_jursta, $jursta);
$query_jugincompetence = "SELECT count(*) as jugincompetence FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_jugementsupp.date_creation,0,4)='".$annee."') AND (substr(rep_jugementsupp.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Incompetence')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jugincompetence = mysql_query($query_jugincompetence, $jursta) or die(mysql_error());
$row_jugincompetence = mysql_fetch_assoc($jugincompetence);
$totalRows_jugincompetence = mysql_num_rows($jugincompetence);

mysql_select_db($database_jursta, $jursta);
$query_jugradiatiation = "SELECT count(*) as jugradiatiation FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_jugementsupp.date_creation,0,4)='".$annee."') AND (substr(rep_jugementsupp.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Radiation')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jugradiatiation = mysql_query($query_jugradiatiation, $jursta) or die(mysql_error());
$row_jugradiatiation = mysql_fetch_assoc($jugradiatiation);
$totalRows_jugradiatiation = mysql_num_rows($jugradiatiation);

mysql_select_db($database_jursta, $jursta);
$query_jugdefaut = "SELECT count(*) as jugdefaut FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_jugementsupp.date_creation,0,4)='".$annee."') AND (substr(rep_jugementsupp.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.dispositif_repjugementsupp='Defaut')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$jugdefaut = mysql_query($query_jugdefaut, $jursta) or die(mysql_error());
$row_jugdefaut = mysql_fetch_assoc($jugdefaut);
$totalRows_jugdefaut = mysql_num_rows($jugdefaut);
mysql_select_db($database_jursta, $jursta);
$query_demandeaccepte = "SELECT count(*) as demandeaccepte FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_jugementsupp.date_creation,0,4)='".$annee."') AND (substr(rep_jugementsupp.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.statut_jugementsupp='Acceptée')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$demandeaccepte = mysql_query($query_demandeaccepte, $jursta) or die(mysql_error());
$row_demandeaccepte = mysql_fetch_assoc($demandeaccepte);
$totalRows_demandeaccepte = mysql_num_rows($demandeaccepte);

mysql_select_db($database_jursta, $jursta);
$query_demanderejete = "SELECT count(*) as demanderejete FROM administrateurs, rep_jugementsupp, role_general WHERE ((administrateurs.Id_admin=rep_jugementsupp.Id_admin) AND (administrateurs.id_juridiction=".$juridiction.") AND (substr(rep_jugementsupp.date_creation,0,4)='".$annee."') AND (substr(rep_jugementsupp.date_creation,5,2)='".$mois."') AND (role_general.id_categorieaffaire=".$categorie.") AND (rep_jugementsupp.statut_jugementsupp='Rejetée')  AND (role_general.no_rolegeneral=rep_jugementsupp.no_rolegeneral))";
$demanderejete = mysql_query($query_demanderejete, $jursta) or die(mysql_error());
$row_demanderejete = mysql_fetch_assoc($demanderejete);
$totalRows_demanderejete = mysql_num_rows($demanderejete);

?>
<?php

  $insertSQL = sprintf("INSERT INTO T36_DFSCC (T36_NBENROLES, T36_JR_CONTRA, T36_JR_DEF, T36_JR_ACCDEM, T36_JR_REJET, T36_JR_INCOMP, T36_JR_RADIATION, T36_DUREEMOY, T36_RAJ, T34_CODE, T36_NBACT, T36_NBAFFPREC,T30_NUMERO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_affairesenrolees['affairesenrolees'], "int"),
                       GetSQLValueString($row_jug_contradictoires['jugcontradictoires'], "int"),
                       GetSQLValueString($row_jugdefaut['jugdefaut'], "int"),
                       GetSQLValueString($row_demandeaccepte['demandeaccepte'], "int"),
                       GetSQLValueString($row_demanderejete['demanderejete'], "int"),
                       GetSQLValueString($row_jugincompetence['jugincompetence'], "int"),
                       GetSQLValueString($row_jugradiatiation['jugradiatiation'], "int"),
                       GetSQLValueString($_POST['moyenne'], "double"),
                       GetSQLValueString($_POST['encours'], "int"),
                       GetSQLValueString($categorie, "int"),
                       GetSQLValueString($row_liste_acte['nbacte'], "int"),				   
                       GetSQLValueString($row_affairesprecedent['affairesprecedent'], "int"),
					   GetSQLValueString($numero_liaison, "int"));

  mysql_select_db($database_jursta, $jursta);
  $Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());
  $sql_insert_t36=$sql_insert_t36.$insertSQL
?> 
	<?php 	}
	}
	?>
    <?php } while ($row_liste_nature = mysql_fetch_assoc($liste_nature)); ?>
    <?php } while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction)); ?>	