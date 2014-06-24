<?php require_once('Connections/jursta.php'); ?>

<?php
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = "SELECT * FROM juridiction, type_juridiction WHERE (type_juridiction.id_typejuridiction=juridiction.id_typejuridiction)";
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);
?>
<?php do { ?>
<?php
$juridiction = $row_liste_juridiction['id_juridiction'];
for ($annee=2010;$annee<=2010;$annee++){
	for ($ms=1;$ms<=12;$ms++){
		if ($ms<10) {$ms="0".$ms;}
	$mois=$ms;
			$insertSQL = "INSERT INTO t30_fs (T06_ANNEE, T30_MOIS, id_juridiction,T30_TRIM,T30_SEM) VALUES (".$annee.",".$mois.",".$juridiction.",".$trimestre.",".$semestre.");";
  			mysql_select_db($database_jursta, $jursta);
  			$Result1 = mysql_query($insertSQL, $jursta) or die(mysql_error());

	}
}
?>
<?php } while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction)); 
mysql_free_result($liste_juridiction);
?>
