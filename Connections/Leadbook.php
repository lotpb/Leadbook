<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

//$hostname_Leadbook = "localhost";
//$database_Leadbook = "Leadbook";
//$username_Leadbook = "root";
//$password_Leadbook = "root";

$hostname_Leadbook = "mysql6.000webhost.com";
$database_Leadbook = "a5658470_Lead";
$username_Leadbook = "a5658470_root";
$password_Leadbook = "eunit7ed";
$Leadbook = mysql_pconnect($hostname_Leadbook, $username_Leadbook, $password_Leadbook) or trigger_error(mysql_error(),E_USER_ERROR); 
?>