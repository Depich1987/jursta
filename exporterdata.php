<?php
    // � elle seule, la ligne suivante suffit � envoyer le r�sultat du script dans une feuille Excel
    //header("Content-type: application/vnd.ms-excel");
    // la ligne suivante est facultative, elle sert � donner un nom au fichier Excel
  	//header("Content-Disposition: attachment; filename=C:\Justice\statcivils.xls");  
	
	header('Content-type: text/plain');
	header('Content-Disposition: attachment; filename="test.txt"');
	echo $pagecontent;
?>