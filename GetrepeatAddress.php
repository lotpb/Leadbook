<?php
$q=$_GET["q"];

//this removes number from address
$test = preg_replace("/[0-9]/", "", $q);

//$con = mysql_connect('localhost', 'root', 'root');
$con = mysql_connect('mysql6.000webhost.com', 'a5658470_root', 'eunit7ed');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
//mysql_select_db("Leadbook", $con);
mysql_select_db("a5658470_Lead", $con);

$sql="SELECT Leads.Date, Leads.LeadNo, Leads.`Last Name`, Leads.Address, Leads.City, Job.Description, Leads.`Call Back`, Leads.Amount FROM Leads, Job WHERE (Leads.`Address` LIKE '%".$test."') AND (Leads.JobNo = Job.JobNo) ORDER BY Leads.`Date` DESC";

$result = mysql_query($sql);

echo "<table id='ajaxtable'>
<tr>
<th>Date</th>
<th>Lead</th>
<th>Last Name</th>
<th>Address</th>
<th>City</th>
<th>Description</th>
<th>Call</th>
<th>Total Orders</th>
</tr>";

while($row = mysql_fetch_array($result))
{ echo "<tr>"; 
  echo "<td>" . date("M d y", strtotime($row['Date'])) . "</td>";
  echo "<td>" . $row['LeadNo'] . "</td>";
  echo "<td>" . $row['Last Name'] . "</td>";
  echo "<td>" . $row['Address'] . "</td>";
  echo "<td>" . $row['City'] . "</td>";
  echo "<td>" . $row['Description'] . "</td>";
  echo "<td>" . $row['Call Back'] . "</td>";
  echo "<td>" . $row['Amount'] . "</td>";
  echo "</tr>";
}
echo "</table>";

mysql_close($con);
?>
