<?php
 
  	/***************************************************************
		Description: 	City data in JSON.
		Developer:	Vishal Kurup
	***************************************************************/
	
	$host = "mysql6.000webhost.com"; //Your database host server
	$db = "a5658470_Lead"; //Your database name
	$user = "a5658470_root"; //Your database user
	$pass = "eunit7ed"; //Your password
	
	$connection = mysql_connect($host, $user, $pass);
	
	//Check to see if we can connect to the server
	if(!$connection)
	{
		die("Database server connection failed.");	
	}
	else
	{
		//Attempt to select the database
		$dbconnect = mysql_select_db($db, $connection);
		
		//Check to see if we could select the database
		if(!$dbconnect)
		{
			die("Unable to connect to the specified database!");
		}
		else
		{
			$query = "SELECT * FROM Locations";
			$resultset = mysql_query($query, $connection);
			
			$resultArray = array();
			
			//Loop through all our records and add them to our array
			while($r = mysql_fetch_assoc($resultset))
			{
				$resultArray[] = $r;		
			}
			
			//Output the data as JSON
			echo json_encode($resultArray);
		}
		
		
	}
	
 
?>