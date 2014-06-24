<?php require_once('Connections/jursta.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Document sans titre</title>

<style type="text/css">
<!--
.Style2 {
	font-size: 12px;
	color: #6186AF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Style4 {font-size: 12}
-->
</style>
</head>

<body>
  <table cellpadding="1" cellspacing="1" >
    <?php
        mysql_select_db($database_jursta, $jursta);
$query_Liste_juridiction1 = "SELECT * FROM juridiction WHERE (id_typejuridiction = 1)";
$Liste_juridiction1 = mysql_query($query_Liste_juridiction1, $jursta) or die(mysql_error());
$row_Liste_juridiction1 = mysql_fetch_assoc($Liste_juridiction1);
$totalRows_Liste_juridiction1 = mysql_num_rows($Liste_juridiction1);
        ?>
    <?php do { ?>
	<?php if ($totalRows_Liste_juridiction1 > 0) { // Show if recordset not empty ?>
        <tr>
          <td><img src="images/rssicon.png" /></td>
          <td ><input name="action_opt" type="radio" id="action_opt" value="<?php echo $row_Liste_juridiction1['id_juridiction']; ?>" /></td>
          <td width="100%" class="Style2" ><?php echo $row_Liste_juridiction1['lib_juridiction']; ?></td>
        </tr>
        <tr>
          <td height="100%"><table align="center" cellpadding="0" cellspacing="0" height="100%">
              <tr>
                <td background="images/continue.jpg"><img src="images/spacer.gif" width="1" height="1" /></td>
              </tr>
          </table></td>
          <td class="Style2">&nbsp;</td>
          <td class="Style2"><table cellpadding="1" cellspacing="1">
              <?php
            mysql_select_db($database_jursta, $jursta);
$query_Liste_juridiction2 = "SELECT * FROM juridiction WHERE ((id_typejuridiction = 2) AND (id_juridictiontutelle=".$row_Liste_juridiction1['id_juridiction']."))";
$Liste_juridiction2 = mysql_query($query_Liste_juridiction2, $jursta) or die(mysql_error());
$row_Liste_juridiction2 = mysql_fetch_assoc($Liste_juridiction2);
$totalRows_Liste_juridiction2 = mysql_num_rows($Liste_juridiction2);
            ?>
              <?php do { ?>
               <?php if ($totalRows_Liste_juridiction2 > 0) { // Show if recordset not empty ?>
                <tr>
                  <td align="center" valign="middle"><img src="images/contentheading.png" /></td>
                  <td ><input type="radio" name="action_opt" id="action_opt" value="<?php echo $row_Liste_juridiction1['id_juridiction']; ?>" /></td>
                  <td ><?php echo $row_Liste_juridiction2['lib_juridiction']; ?></td>
                </tr>
                <tr>
                  <td height="100%" align="center" valign="middle"><table align="center" cellpadding="0" cellspacing="0" height="100%">
                      <tr>
                        <td background="images/continue.jpg"><img src="images/spacer.gif" width="1" height="1" /></td>
                      </tr>
                  </table></td>
                  <td >&nbsp;</td>
                  <td ><table cellpadding="1" cellspacing="1">
                      <?php
            mysql_select_db($database_jursta, $jursta);
$query_Liste_juridiction3 = "SELECT * FROM juridiction WHERE ((id_typejuridiction = 3) AND (id_juridictiontutelle=".$row_Liste_juridiction2['id_juridiction']."))";
$Liste_juridiction3 = mysql_query($query_Liste_juridiction3, $jursta) or die(mysql_error());
$row_Liste_juridiction3 = mysql_fetch_assoc($Liste_juridiction3);
$totalRows_Liste_juridiction3 = mysql_num_rows($Liste_juridiction3);
            ?>
                      <?php do { ?>
                      <?php if ($totalRows_Liste_juridiction3 > 0) { // Show if recordset not empty ?>
                        <tr>
                          <td><img src="images/printButton.png" /></td>
                          <td nowrap="nowrap" ><input type="radio" name="action_opt" id="action_opt" value="<?php echo $row_Liste_juridiction1['id_juridiction']; ?>" /></td>
                          <td nowrap="nowrap" ><?php echo $row_Liste_juridiction3['lib_juridiction']; ?></td>
                        </tr>
                        <tr>
                          <td height="100%"><table align="center" cellpadding="0" cellspacing="0" height="100%">
                              <tr>
                                <td background="images/continue.jpg"><img src="images/spacer.gif" width="1" height="1" /></td>
                              </tr>
                          </table></td>
                          <td nowrap="nowrap" >&nbsp;</td>
                          <td nowrap="nowrap" ><table cellpadding="1" cellspacing="1">
                              <?php
            mysql_select_db($database_jursta, $jursta);
$query_Liste_juridiction4 = "SELECT * FROM juridiction WHERE ((id_typejuridiction = 4) AND (id_juridictiontutelle=".$row_Liste_juridiction3['id_juridiction']."))";
$Liste_juridiction4 = mysql_query($query_Liste_juridiction4, $jursta) or die(mysql_error());
$row_Liste_juridiction4 = mysql_fetch_assoc($Liste_juridiction4);
$totalRows_Liste_juridiction4 = mysql_num_rows($Liste_juridiction4);
            ?>
                              <?php do { ?>
                              <?php if ($totalRows_Liste_juridiction4 > 0) { // Show if recordset not empty ?>
                                <tr>
                                  <td></td>
                                  <td><input type="radio" name="action_opt" id="action_opt" value="<?php echo $row_Liste_juridiction1['id_juridiction']; ?>" /></td>
                                  <td><?php echo $row_Liste_juridiction4['lib_juridiction']; ?></td>
                                </tr>
                                <?php } // Show if recordset not empty ?>
                                <?php } while ($row_Liste_juridiction4 = mysql_fetch_assoc($Liste_juridiction4)); ?>
                          </table></td>
                        </tr>
                        <?php } // Show if recordset not empty ?>
                        <?php } while ($row_Liste_juridiction3 = mysql_fetch_assoc($Liste_juridiction3)); ?>
                  </table></td>
                </tr>
                <?php } // Show if recordset not empty ?>
                <?php } while ($row_Liste_juridiction2 = mysql_fetch_assoc($Liste_juridiction2)); ?>
          </table></td>
        </tr>
		<?php } // Show if recordset not empty ?>        
        <?php } while ($row_Liste_juridiction1 = mysql_fetch_assoc($Liste_juridiction1)); ?>
  </table>

</body>
</html>
<?php
mysql_free_result($Liste_juridiction1);

mysql_free_result($Liste_juridiction2);

mysql_free_result($Liste_juridiction3);

mysql_free_result($Liste_juridiction4);
?>
