<?php
function listerNoms($key)
{
	$hostname_jursta = "127.0.0.1";
	$database_jursta = "db_jursta";
	$username_jursta = "root";
	$password_jursta = "";
	
	$id = mysql_pconnect($hostname_jursta, $username_jursta, $password_jursta) or trigger_error(mysql_error(),E_USER_ERROR); 
	
	$requete = "select * from reg_plaintes_noms	where cles_pivot = '$key' ";
	mysql_select_db($database_jursta, $id);
	$result = mysql_query($requete,$id);
	
	$tableau = "";
	
	while($ligne = mysql_fetch_array($result))
	{
		$tableau[] = $ligne['NomPreDomInculpes_plaintes'];
	}
	
	return $tableau;
	
}


function listernature($key)
{
	$hostname_jursta = "127.0.0.1";
	$database_jursta = "db_jursta";
	$username_jursta = "root";
	$password_jursta = "";
	
	$id = mysql_pconnect($hostname_jursta, $username_jursta, $password_jursta) or trigger_error(mysql_error(),E_USER_ERROR); 
	
	$requete = "select * from reg_plaintes_noms	where cles_pivot = '$key' ";
	mysql_select_db($database_jursta, $id);
	$result = mysql_query($requete,$id);
	
	$tableau = "";
	
	while($ligne = mysql_fetch_array($result))
	{
		$tableau[] = $ligne['NatInfraction_plaintes'];
	}
	
	return $tableau;
	
}

function Change_formatDate($date, $format = 'fr')
{
    $r = '^([0-9]{1,4}).([0-9]{1,2}).([0-9]{1,4})$';
	
    if($format === 'en')
    return @ereg_replace($r, '\\3-\\2-\\1', $date);
	
    return @ereg_replace($r, '\\3/\\2/\\1', $date);
}

function changedatefrus($datefr)
{
$dateus=$datefr{6}.$datefr{7}.$datefr{8}.$datefr{9}."-".$datefr{3}.$datefr{4}."-".$datefr{0}.$datefr{1};

return $dateus;
}

?>
