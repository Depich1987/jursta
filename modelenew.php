<?php require_once('Connections/jursta.php'); ?>
<?php
$colname_liste_juridiction = "1";
if (isset($_POST['type_admin'])) {
  $colname_liste_juridiction = (get_magic_quotes_gpc()) ? $_POST['type_admin'] : addslashes($_POST['type_admin']);
}
mysql_select_db($database_jursta, $jursta);
$query_liste_juridiction = sprintf("SELECT * FROM juridiction WHERE id_juridiction = %s ORDER BY lib_juridiction ASC", $colname_liste_juridiction);
$liste_juridiction = mysql_query($query_liste_juridiction, $jursta) or die(mysql_error());
$row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
$totalRows_liste_juridiction = mysql_num_rows($liste_juridiction);

mysql_select_db($database_jursta, $jursta);
$query_typejuridiction = "SELECT * FROM type_juridiction ORDER BY lib_typejuridiction ASC";
$typejuridiction = mysql_query($query_typejuridiction, $jursta) or die(mysql_error());
$row_typejuridiction = mysql_fetch_assoc($typejuridiction);
$totalRows_typejuridiction = mysql_num_rows($typejuridiction);
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
  </script><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/index_01.gif);
	background-repeat: repeat-x;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style></head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr align="center">
    <td><?php require_once('haut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuhaut.php'); ?></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menuidentity.php'); ?></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td width="250"><?php require_once('menudroit.php'); ?><img src="images/spacer.gif" width="250" height="1"></td>
          <td align="center" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td width="100%" colspan="2" valign="middle" >
                <table width="100%" >
                  <tr>
                    <td><span class="Style2"><img src="images/forms48.png" width="32" border="0"></span></td>
                    <td width="100%"><span class="Style2">Cr&eacute;ation d'un compte </span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" valign="middle"><table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="Style15">
                  <tr>
                    <td valign="top">Nom :</td>
                    <td><input name="nom_admin" type="text" id="nom_admin" size="25"></td>
                  </tr>
                  <tr>
                    <td valign="top">Pr&eacute;noms : </td>
                    <td><input name="prenoms_admin" type="text" id="prenoms_admin" size="30"></td>
                  </tr>
                  <tr>
                    <td valign="top">Sexe : </td>
                    <td><input type="radio" name="sexe_admin" value="M">
            Masculin
              <input type="radio" name="sexe_admin" value="F">
            F&eacute;minin</td>
                  </tr>
                  <tr>
                    <td valign="top">Date de naissance : </td>
                    <td><input name="datenais_admin" type="text" id="datenais_admin" size="15"></td>
                  </tr>
                  <tr>
                    <td valign="top">E-mail : </td>
                    <td><input name="email_admin" type="text" id="email_admin" size="30"></td>
                  </tr>
                  <tr>
                    <td valign="top">Login : </td>
                    <td><input name="login_admin" type="text" id="login_admin" size="20"></td>
                  </tr>
                  <tr>
                    <td valign="top">Mot de passe : </td>
                    <td><input name="pwd_admin" type="password" id="pwd_admin" size="20"></td>
                  </tr>
                  <tr>
                    <td valign="top">Section Administrateur : </td>
                    <td><select name="type_admin" id="type_admin">
                      <option value="Civile" <?php if (!(strcmp("Civile", ($_POST['type_admin'])))) {echo "SELECTED";} ?>>Civile</option>
                      <option value="Sociale" <?php if (!(strcmp("Sociale", ($_POST['type_admin'])))) {echo "SELECTED";} ?>>Sociale</option>
                      <option value="Administrateur" <?php if (!(strcmp("Administrateur", ($_POST['type_admin'])))) {echo "SELECTED";} ?>>Administrateur</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td valign="top"> Type de juridiction: </td>
                    <td><select name="select2">
                      <?php
do {  
?>
                      <option value="<?php echo $row_typejuridiction['id_typejuridiction']?>"><?php echo $row_typejuridiction['lib_typejuridiction']?></option>
                      <?php
} while ($row_typejuridiction = mysql_fetch_assoc($typejuridiction));
  $rows = mysql_num_rows($typejuridiction);
  if($rows > 0) {
      mysql_data_seek($typejuridiction, 0);
	  $row_typejuridiction = mysql_fetch_assoc($typejuridiction);
  }
?>
                    </select></td>
                  </tr>
                  <tr>
                    <td valign="top">Juridiction d'exploitation :</td>
                    <td><select name="select">
                      <?php
do {  
?>
                      <option value="<?php echo $row_liste_juridiction['id_juridiction']?>"><?php echo $row_liste_juridiction['lib_juridiction']?></option>
                      <?php
} while ($row_liste_juridiction = mysql_fetch_assoc($liste_juridiction));
  $rows = mysql_num_rows($liste_juridiction);
  if($rows > 0) {
      mysql_data_seek($liste_juridiction, 0);
	  $row_liste_juridiction = mysql_fetch_assoc($liste_juridiction);
  }
?>
                    </select></td>
                  </tr>
                  <tr>
                    <td valign="top">Droits : </td>
                    <td><table width="100%" border="0" class="Style10">
                      <tr bgcolor="#6186AF">
                        <td colspan="4"><div align="center">Droits sur les R&eacute;gistres </div></td>
                      </tr>
                      <tr align="center">
                        <td>Ajouter</td>
                        <td>Modifier</td>
                        <td>Visualiser</td>
                        <td>Supprimer</td>
                      </tr>
                      <tr align="center">
                        <td><input name="ajouter_admin" type="checkbox" id="ajouter_admin" value="1"></td>
                        <td><input name="modifier_admin" type="checkbox" id="modifier_admin" value="1"></td>
                        <td><input name="visualiser_admin" type="checkbox" id="visualiser_admin2" value="1"></td>
                        <td>                          <input name="supprimer_admin" type="checkbox" id="supprimer_admin" value="1"></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td valign="top">&nbsp;</td>
                    <td><input type="submit" name="Submit" value="Envoyer"></td>
                  </tr>
                  <tr>
                    <td valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        </table></td>
  </tr>
  <tr align="center">
    <td><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($liste_juridiction);

mysql_free_result($typejuridiction);
?>
