<?php require_once('Connections/jursta.php'); ?><?php
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
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<HTML>
<HEAD>
<TITLE>Jursta - Base de Donn&eacute;es statistiques des juridictions ivoiriennes</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Style2 {
	font-size: 24px;
	color: #6186AF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	color: #FFFFFF;
}
a:link {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	color: #6186AF;
	text-decoration: none;
}
a:hover {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	color: #999999;
	text-decoration: none;
}
.Style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-image: url(images/index_01.gif);
	background-repeat: repeat-x;
}
.Style10 {
	font-size: 12px;
	font-weight: bold;
}
input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #677787;
	background-color: #FFFFFF;
	border: 1px solid #677787;
}
.Style11 {font-size: x-small}
.Style14 {font-size: xx-small}
-->
</style>
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<form ACTION="<?php echo $loginFormAction; ?>" name="form1" method="POST">
  <div align="center"></div>
  <TABLE WIDTH=768 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
    <TR>
      <TD ROWSPAN=4> <IMG SRC="images/index_01.gif" WIDTH=18 HEIGHT=122 title=""></TD>
      <TD> <IMG SRC="images/index_02.jpg" WIDTH=178 HEIGHT=25 title=""></TD>
      <TD COLSPAN=2> <IMG SRC="images/index_03.gif" WIDTH=572 HEIGHT=25 title=""></TD>
    </TR>
    <TR>
      <TD> <IMG SRC="images/index_04.gif" WIDTH=178 HEIGHT=57 title=""></TD>
      <TD> <IMG SRC="images/index_05.gif" WIDTH=8 HEIGHT=57 title=""></TD>
      <TD> <IMG SRC="images/spacer.gif" WIDTH=564 HEIGHT=57 title=""></TD>
    </TR>
    <TR>
      <TD> <IMG SRC="images/index_07.gif" WIDTH=178 HEIGHT=7 title=""></TD>
      <TD> <IMG SRC="images/index_08.gif" WIDTH=8 HEIGHT=7 title=""></TD>
      <TD> <IMG SRC="images/spacer.gif" WIDTH=564 HEIGHT=7 title=""></TD>
    </TR>
    <TR>
      <TD COLSPAN=3> <IMG SRC="images/index_10.gif" WIDTH=750 HEIGHT=33 title=""></TD>
    </TR>
  </TABLE>
   
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
                                <td width="100%" valign="middle" > <span class="Style2">Connection - Identification</span></td>
                              </tr>
                            </table>
                              <table width="458" border="0" align="center" cellpadding="5" cellspacing="3">
                                <tr>
                                  <td width="460"><p class="Style5">Pourquoi l'identification ?</p>
                                      <p align="justify" class="Style11">L'identification permet de s&eacute;curiser les informations saisies et d'acc&eacute;der &agrave; votre espace personnel de saisie des donn&eacute;es.</p>
                                      <p align="justify" class="Style11">Si vous avez oubli&eacute; vos param&egrave;tres de connection veuillez contacter l'administrateur.</p>
                                      <p align="justify" class="Style11">ou appeler l'inspection g&eacute;n&eacute;ral des services judiciaires et penitentiaires. </p></td>
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
                                                  <td colspan="2" bgcolor="#677787" class="Style3">Identifiez-vous</td>
                                                </tr>
                                                <tr>
                                                  <td align="right" nowrap><span class="Style10">Nom d'utilisateur : </span></td>
                                                  <td><input name="login_admin" type="text" id="login_admin" size="18" maxlength="14"></td>
                                                </tr>
                                                <tr>
                                                  <td align="right" class="Style10">Mot de passe : </td>
                                                  <td><input name="pwd_admin" type="password" id="pwd_admin" size="18" maxlength="14"></td>
                                                </tr>
                                                <tr>
                                                  <td>&nbsp;</td>
                                                  <td align="center"><input type="submit" name="Submit" value="  Connexion  "></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                </table></td>
                              </tr>
                          </table></td>
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
   
<table width="100%" >
    <tr>
      <td align="center" bgcolor="#6186AF"><?php require_once('menubas.php'); ?></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>