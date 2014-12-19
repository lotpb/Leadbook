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

$sql="SELECT Customer.Date, Customer.LeadNo, Customer.CustNo, Customer.Address, Customer.City, Job.Description, Customer.Amount FROM Customer, Job WHERE (Customer.`Address` LIKE '%".$test."') AND (Customer.JobNo = Job.JobNo) ORDER BY Customer.`Date` DESC";

$result = mysql_query($sql);

echo "<table id='ajaxtable'>
<tr>
<th>Date</th>
<th>Lead</th>
<th>CustNo</th>
<th>Address</th>
<th>City</th>
<th>Description</th>
<th>Amount</th>
</tr>";

while($row = mysql_fetch_array($result))
{ echo "<tr>"; 
  echo "<td>" . date("M d y", strtotime($row['Date'])) . "</td>";
  echo "<td>" . $row['LeadNo'] . "</td>";
  echo "<td>" . $row['CustNo'] . "</td>";
  echo "<td>" . $row['Address'] . "</td>";
  echo "<td>" . $row['City'] . "</td>";
  echo "<td>" . $row['Description'] . "</td>";
  echo "<td>" . $row['Amount'] . "</td>";
  echo "</tr>";
}
echo "</table>";

mysql_close($con);
?>
