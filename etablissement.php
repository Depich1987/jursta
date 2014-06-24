<?php require_once('Connections/jursta.php'); ?>
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
 /*

*/
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Document sans titre</title>
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

<body class="stat">

				  <table width="100%" cellpadding="0" cellspacing="0">
                      <?php
if ($row_select_juridiction['id_juridiction'] == 55) { // Show if recordset empty 
	mysql_select_db($database_jursta, $jursta);
$query_liste_typejuridiction = "SELECT * FROM type_juridiction WHERE (id_typejuridiction <> 5) ORDER BY lib_typejuridiction ASC";
$liste_typejuridiction = mysql_query($query_liste_typejuridiction, $jursta) or die(mysql_error());
$row_liste_typejuridiction = mysql_fetch_assoc($liste_typejuridiction);
$totalRows_liste_typejuridiction = mysql_num_rows($liste_typejuridiction);

	$colname_liste_juridiction = "-1";
if (isset($_POST['id_typejuridiction'])) {
  $colname_liste_juridiction = $_POST['id_typejuridiction'];
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_typejuridiction = %s", GetSQLValueString($colname_liste_juridiction, "int"));
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);
}


	mysql_select_db($database_jursta, $jursta);
	$idjuridiction=$_POST['id_juridiction'];
	if ($row_select_juridiction['id_juridiction']!=55) $idjuridiction=$row_select_juridiction['id_juridiction'];
	if ($idjuridiction==0) {	
		$query_liste_ville = "SELECT * FROM penitentier ORDER BY lib_penitentier ASC";
	}
	else {
		$query_liste_ville = "SELECT * FROM penitentier WHERE id_juridiction =".$idjuridiction.";";
	}
	$liste_ville = mysql_query($query_liste_ville, $jursta) or die(mysql_error());
	$row_liste_ville = mysql_fetch_assoc($liste_ville);
	$totalRows_liste_ville = mysql_num_rows($liste_ville);
?>
                      <?php do { ?>
                      <tr>
                          <td class="Style11"><a href="stat_penitentier1-3.php?vl=<?php echo $row_liste_ville['lib_penitentier']; ?>" class="Style10" target="_parent"><?php echo $row_liste_ville['lib_penitentier']; ?></a></td>
                      </tr>
                      <?php } while ($row_liste_ville = mysql_fetch_assoc($liste_ville)); ?>
                  </table>
</body>
</html>
<?php
mysql_free_result($liste_typejuridiction);

mysql_free_result($liste_juridiction);
?>
