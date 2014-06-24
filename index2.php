<?php require_once('Connections/jursta.php'); ?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['login_admin'])) {
  $loginUsername=$_POST['login_admin'];
  $password=$_POST['pwd_admin'];
  $MM_fldUserAuthorization = "type_admin";
  $MM_redirectLoginSuccess = "connect.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_jursta, $jursta);
  	
  $LoginRS__query=sprintf("SELECT login_admin, pwd_admin, type_admin FROM administrateurs WHERE login_admin='%s' AND pwd_admin='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $jursta) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'type_admin');
    
    //declare two session variables and assign them
    $GLOBALS['MM_Username'] = $loginUsername;
    $GLOBALS['MM_UserGroup'] = $loginStrGroup;	      

    //register the session variables
    session_register("MM_Username");
    session_register("MM_UserGroup");

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	if ((isset($_POST['checkbox'])) && ($_POST['checkbox']=="majstat")){
	  require_once('statistiquesmaj.php');
	}
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    $GLOBALS['errorconnect'] = -1;      
    session_register("errorconnect");
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/global.css" rel="stylesheet" type="text/css">
</head>

<body class="stat">
<table width="940"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td background="images/index_01.gif"><?php require_once('haut.php'); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="3" cellpadding="5">
        <tr>
          <td><form ACTION="<?php echo $loginFormAction; ?>" name="form1" method="post">
            <p>&nbsp;</p>
            <table border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#677787"><table border="0" cellpadding="0" cellspacing="1">
                    <tr>
                      <td bgcolor="#FFFFFF"><table border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><table width="100%" cellpadding="10" >
                                <tr>
                                  <td><table width="470" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td valign="top"><table width="468" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td width="100%" valign="middle" > <span class="Style27">Connection - Identification</span></td>
                                            </tr>
                                          </table>
                                            <table width="458" border="0" align="center" cellpadding="5" cellspacing="3">
                                              <tr>
                                                <td width="460"><p class="Style5">Pourquoi l'identification ?</p>
                                                    <p align="justify" class="Style11">L'identification permet de s&eacute;curiser les informations saisies et d'acc&eacute;der &agrave; votre espace personnel de saisie des donn&eacute;es.</p>
                                                    <p align="justify" class="Style11">Si vous avez oubli&eacute; vos param&egrave;tres de connection veuillez contacter l'administrateur.</p>
                                                    <p align="justify" class="Style11">ou appeler l'inspection g&eacute;n&eacute;ral des services judiciaires et penitentiaires. </p></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                              </tr>
                                          </table></td>
                                        <td valign="middle"><table border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td bgcolor="#677787"><table border="0" cellpadding="0" cellspacing="1">
                                                  <tr>
                                                    <td bgcolor="#FFFFFF"><table border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                          <td><table width="150" border="0" align="center" cellpadding="8" cellspacing="0">
                                                              <tr>
                                                                <td colspan="2" bgcolor="#677787" class="Style28">Identifiez-vous  </td>
                                                              </tr>
<?php  if ((isset($_SESSION['errorconnect'])) && ($_SESSION['errorconnect']==-1)) { ?>
                                                              <tr align="center">
                                                                <td colspan="2" nowrap class="Style29">Param&egrave;tres de connection incorrects</td>
                                                                </tr>
<?php } ?>															  
                                                              <tr>
                                                                <td align="right" nowrap><span class="Style26">Nom d'utilisateur : </span></td>
                                                                <td><input name="login_admin" type="text" id="login_admin" size="18" maxlength="14"></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="right" class="Style26">Mot de passe : </td>
                                                                <td><input name="pwd_admin" type="password" id="pwd_admin" size="18" maxlength="14"></td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="2"><table width="100%"  border="0" cellspacing="5" cellpadding="0">
                                                                  <tr>
                                                                    <td><input name="checkbox" type="checkbox" value="majstat" checked></td>
                                                                    <td class="Style11">Se connecter et mettre &agrave; jour les donn&eacute;es statistiques </td>
                                                                  </tr>
                                                                </table></td>
                                                                </tr>
                                                              <tr>
                                                                <td colspan="2"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
                                                                  <tr>
                                                                    <td bgcolor="#677787" class="Style11"><a href="#">Cliquez - i&ccedil;i</a> si vous avez oubli&eacute; vos parm&egrave;tres de connection</td>
                                                                    </tr>
                                                                </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="center"><input name="connexion_cmd" type="submit" id="connexion_cmd" value="Connexion"></td>
                                                              </tr>
                                                          </table></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                              </table></td>
                                            </tr>
                                        </table>                                          </td>
                                      </tr>
                                  </table></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table>
              <p>&nbsp;</p>
            </form></td>
        </tr>
        </table></td>
  </tr>
  <tr align="center">
    <td bgcolor="#FFFFFF"><?php require_once('menubas.php'); ?></td>
  </tr>
</table>
</body>
</html>
