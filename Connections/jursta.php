<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_jursta = "127.0.0.1";
$database_jursta = "db_jursta";
$username_jursta = "root";
$password_jursta = "";
$jursta = mysql_pconnect($hostname_jursta, $username_jursta, $password_jursta) or trigger_error(mysql_error(),E_USER_ERROR); 
?>