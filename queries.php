<?php 

$getLeads = "SELECT * FROM Leads";
$getCustomer = "SELECT * FROM Customer";

function getAuthorsById($id) {
$query = “SELECT id, name, ……. FROM authors a WHERE a.id == $id”;
$result = mysql_query($query);
if (! $result) {
throw new Exception(mysql_error());
}
}

?>