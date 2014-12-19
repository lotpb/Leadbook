<?php require_once('Connections/Leadbook.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$title = "Repeat";
//Repeat Cust
$maxRows_RepeatCust = 40;
$pageNum_RepeatCust = 0;
if (isset($_GET['pageNum_RepeatCust'])) {
  $pageNum_RepeatCust = $_GET['pageNum_RepeatCust'];
}
$startRow_RepeatCust = $pageNum_RepeatCust * $maxRows_RepeatCust;

$Search_RepeatCust = "%";
if (isset($_GET['Search'])) {
  $Search_RepeatCust = $_GET['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_RepeatCust = sprintf("SELECT Count(Customer.Address) as LeadNo, Customer.Date, Leads.`Last Name`, Customer.Address, Customer.City, Customer.Phone, Sum(Customer.Amount) as Amount, Customer.CustNo FROM Customer, Leads WHERE (Customer.LeadNo = Leads.LeadNo) AND (Leads.`Last Name` LIKE %s OR Customer.Address LIKE %s OR Customer.City LIKE %s OR Customer.Phone LIKE %s OR Customer.Amount LIKE %s) GROUP BY Customer.LeadNo HAVING Count(Customer.Address) > 1 ORDER BY Customer.`Amount` DESC", GetSQLValueString($Search_RepeatCust, "text"),GetSQLValueString($Search_RepeatCust, "text"),GetSQLValueString($Search_RepeatCust, "text"),GetSQLValueString($Search_RepeatCust, "text"),GetSQLValueString($Search_RepeatCust, "text"));
$query_limit_RepeatCust = sprintf("%s LIMIT %d, %d", $query_RepeatCust, $startRow_RepeatCust, $maxRows_RepeatCust);
$RepeatCust = mysql_query($query_limit_RepeatCust, $Leadbook) or die(mysql_error());
$row_RepeatCust = mysql_fetch_assoc($RepeatCust);

if (isset($_GET['totalRows_RepeatCust'])) {
  $totalRows_RepeatCust = $_GET['totalRows_RepeatCust'];
} else {
  $all_RepeatCust = mysql_query($query_RepeatCust);
  $totalRows_RepeatCust = mysql_num_rows($all_RepeatCust);
}
$totalPages_RepeatCust = ceil($totalRows_RepeatCust/$maxRows_RepeatCust)-1;

$queryString_RepeatCust = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RepeatCust") == false && 
        stristr($param, "totalRows_RepeatCust") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RepeatCust = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RepeatCust = sprintf("&totalRows_RepeatCust=%d%s", $totalRows_RepeatCust, $queryString_RepeatCust);

$currentPage = $_SERVER["PHP_SELF"];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Customer Listing</title>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharMenu.css" rel="stylesheet" />

<style type="text/css"> 
<!--

--> 
</style>

<!--[if IE 5]>
<style type="text/css"> 
/* place css box model fixes for IE 5* in this conditional comment */
.twoColFixRtHdr #sidebar1 { width: 220px; }
</style>
<![endif]-->
<!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColFixRtHdr #sidebar1 { padding-top: 30px; }
.twoColFixRtHdr #mainContent { zoom: 1; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->

<script type="text/javascript">

</script>
</head>
<body class="twoColFixRtHdr">
<div id="carbonForm">
<header id="header">
<hgroup>
<nav>
<ul id="menu">
<li><a href="index.php">Home</a> </li>
<li><a href="#">New</a>
    <ul>
      <li><a href="LeadInsert.php">New Lead</a></li>
      <li><a href="CustInsert.php">New Customer</a></li>
    </ul>
</li>
<li><a href="#">View</a>
    <ul>
      <li><a href="LeadTable.php">Lead Listing</a> </li>
      <li><a href="CustTable.php">Customer Listing</a></li>
      <li><a href="ContactsTable.php">Contact Listing</a></li>
      <li><a href="EmployeeTable.php">Employee Listing</a></li>
      <li><a href="VendorTable.php">Vendor Listing</a></li>
      <li><a href="TaskTable.php">Task Listing</a></li>
      <li><a href="#">Tools</a>
        <ul>
          <li><a href="ZipTable.php">Zip Code Listing</a></li>
          <li><a href="SalesmanTable.php">Salesman listing</a></li>
          <li><a href="ProductsTable.php">Product Listing</a></li>
          <li><a href="AdvertiseTable.php">Advertising Listing</a></li>
        </ul>
        </li>
    </ul>
</li>
<li><a href="Snapshot.php">Snapshot</a></li>
<li><a href="BlogTable.php">Blog</a></li>
</ul>
</nav>
<h1>Repeat Customers</h1>
</hgroup>
<!-- end #header --></header>
<section id="sidebar1">
<div>
 
<form id="form1" name="form1" method="get" action="CustRepeat.php">
<input name="Search" type="search" id="Search" autofocus value="Search <?php echo $_REQUEST['Search']; ?>" size="18" /> 
<button class="magglass"type="submit"><img src="images/magglass.png" alt="Search" /></button>
<br />
<select name="SelectState" id="SelectState" onchange="favState()">
<option>%</option>
<option>A%</option>
<option>B%</option>
<option>C%</option>
<option>D%</option>
<option>E%</option>
<option>F%</option>
<option>G%</option>
<option>H%</option>
<option>I%</option>
<option>J%</option>
<option>K%</option>
<option>L%</option>
<option>M%</option>
<option>N%</option>
<option>O%</option>
<option>P%</option>
<option>Q%</option>
<option>R%</option>
<option>S%</option>
<option>T%</option>
<option>U%</option>
<option>V%</option>
<option>W%</option>
<option>X%</option>
<option>Y%</option>
<option>Z%</option>
</select>
</form>
</div>
<!-- end #sidebar1 --></section>
<header>
<div id="titlerepeat">Admin: <?php echo $title ?> Customers</div>
</header>

<table  id="nav">
  <tr>
    <td><?php if ($pageNum_RepeatCust > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_RepeatCust=%d%s", $currentPage, 0, $queryString_RepeatCust); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_RepeatCust > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_RepeatCust=%d%s", $currentPage, max(0, $pageNum_RepeatCust - 1), $queryString_RepeatCust); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_RepeatCust < $totalPages_RepeatCust) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_RepeatCust=%d%s", $currentPage, min($totalPages_RepeatCust, $pageNum_RepeatCust + 1), $queryString_RepeatCust); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_RepeatCust < $totalPages_RepeatCust) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_RepeatCust=%d%s", $currentPage, $totalPages_RepeatCust, $queryString_RepeatCust); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>

<table width="77%" id="delform">
<tr>
<th><span>Num</span></th>
<th><span>Date</span></th>
<th><span>Last Name</span></th>
<th><span>Address</span></th>
<th><span>City</span></th>
<th><span>Phone</span></th>
<th><span>Amount</span></th>
<th><span>Cust</span></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td width="5"><a href="LeadEdit.php?LeadNo=<?php echo $row_RepeatCust['LeadNo']; ?>"><?php echo $row_RepeatCust['LeadNo']; ?></a></td>
<td nowrap="nowrap"><?php echo date("M y", strtotime($row_RepeatCust['Date'])); ?></td>
<td><?php echo $row_RepeatCust['Last Name']; ?></td>
<td nowrap="nowrap"><?php echo $row_RepeatCust['Address']; ?></td>
<td><?php echo $row_RepeatCust['City']; ?></td>
<td nowrap="nowrap"><?php echo $row_RepeatCust['Phone']; ?></td>
<td class="tdAmount" nowrap="nowrap"><input type="text" size="9" value="<?php echo $row_RepeatCust['Amount']; ?>"/></td>
<td nowrap="nowrap"><?php echo $row_RepeatCust['CustNo']; ?></td>
<td width="4"><a href="CustEdit.php?CustNo=<?php echo $row_RepeatCust['CustNo']; ?>">edit</a></td>
<td width="6"><a href="DeleteAddress.php?CustNo=<?php echo $row_RepeatCust['CustNo']; ?>">delete</a></td> 
</tr>
<?php } while ($row_RepeatCust = mysql_fetch_assoc($RepeatCust)); ?>
</table>
	<!-- end #mainContent --></div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
<footer id="footer">
<!--<p>&copy;copyright 2010 Leadbook Software.dev</p>-->
  <!-- end #footer --></footer>
<!-- end #container --></div>
<script type="text/javascript">
<!--

//-->
</script>
</body>
</html>
<?php
mysql_free_result($RepeatCust);
?>
