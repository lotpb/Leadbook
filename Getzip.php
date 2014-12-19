<?php
$q=$_GET["q"];

//$con = mysql_connect('localhost', 'root', 'root');
$con = mysql_connect('mysql6.000webhost.com', 'a5658470_root', 'eunit7ed');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
//mysql_select_db("Leadbook", $con);
mysql_select_db("a5658470_Lead", $con);
$sql="SELECT * FROM Zip WHERE City = '".$q."'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{ $State = $row['State'];
  $Zip_Code = $row['Zip Code']; }
  
echo $State;
echo ",";
echo $Zip_Code;

mysql_close($con);
?>
