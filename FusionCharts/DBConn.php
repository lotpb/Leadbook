<?php
// In this page, we open the connection to the Database
// In this page, we open the connection to the Database
// Our MySQL database (blueprintdb) for the Blueprint Application
// Function to connect to the DB
function connectToDB() {
    // These four parameters must be changed dependent on your MySQL settings
    $hostdb = 'mysql6.000webhost.com'; // MySQl host
	$namedb = 'a5658470_Lead'; // MySQL database name
    $userdb = 'a5658470_root';  // MySQL username
    $passdb = 'eunit7ed';  // MySQL password

	
	//$hostdb = 'localhost'; // MySQl host
//    $namedb = 'Leadbook'; // MySQL database name
//    $userdb = 'root';  // MySQL username
//    $passdb = 'root';  // MySQL password

    //$link = mysql_connect ("localhost:3306", "username", "password");
    //$link = mysql_connect ($hostdb, $userdb, $passdb);
    $link = mysql_connect ($hostdb, $userdb, $passdb);

    if (!$link) {
        // we should have connected, but if any of the above parameters
        // are incorrect or we can't access the DB for some reason,
        // then we will stop execution here
        die('Could not connect: ' . mysql_error());
    }

    $db_selected = mysql_select_db($namedb);
    if (!$db_selected) {
        die ('Can\'t use database : ' . mysql_error());
    }
    return $link;
}
?>