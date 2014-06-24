<?php
function listerNoms()
{
	$hostname_jursta = "127.0.0.1";
	$database_jursta = "db_jursta";
	$username_jursta = "root";
	$password_jursta = "";
	
	$id = mysql_pconnect($hostname_jursta, $username_jursta, $password_jursta) or trigger_error(mysql_error(),E_USER_ERROR); 
	
	$requete = "select * from reg_plaintes_noms	where cles_pivot = '1245/13-2013-02-26 00:09:46' ";
	mysql_select_db($database_jursta, $id);
	$result = mysql_query($requete,$id);
	
	
	
	while($ligne = mysql_fetch_array($result))
	{
		echo $ligne['NomPreDomInculpes_plaintes'];
	}
	

	
}

listerNoms();

?>