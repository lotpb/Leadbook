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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEdit")) {
  $updateSQL = sprintf("UPDATE Tasks SET `Date`=%s, `Time`=%s, Priority=%s, `Lead Name`=%s, `Customer Name`=%s, `Contact Name`=%s, `Vendor Name`=%s, Regarding=%s, Details=%s, Active=%s, Duration=%s WHERE TaskNo=%s",
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Time'], "date"),
                       GetSQLValueString($_POST['Priority'], "text"),
                       GetSQLValueString($_POST['Leads'], "text"),
                       GetSQLValueString($_POST['Customer'], "text"),
                       GetSQLValueString($_POST['Contact'], "text"),
                       GetSQLValueString($_POST['Vendor'], "text"),
                       GetSQLValueString($_POST['Regarding'], "text"),
                       GetSQLValueString($_POST['Details'], "text"),
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['Duration'], "text"),
                       GetSQLValueString($_POST['TaskNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "TaskTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_fmEditTasks = 25;
$pageNum_fmEditTasks = 0;
if (isset($_GET['pageNum_fmEditTasks'])) {
  $pageNum_fmEditTasks = $_GET['pageNum_fmEditTasks'];
}
$startRow_fmEditTasks = $pageNum_fmEditTasks * $maxRows_fmEditTasks;

$colname_fmEditTasks = "-1";
if (isset($_GET['TaskNo'])) {
  $colname_fmEditTasks = $_GET['TaskNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditTasks = sprintf("SELECT * FROM Tasks WHERE Tasks.TaskNo = %s", GetSQLValueString($colname_fmEditTasks, "int"));
$query_limit_fmEditTasks = sprintf("%s LIMIT %d, %d", $query_fmEditTasks, $startRow_fmEditTasks, $maxRows_fmEditTasks);
$fmEditTasks = mysql_query($query_limit_fmEditTasks, $Leadbook) or die(mysql_error());
$row_fmEditTasks = mysql_fetch_assoc($fmEditTasks);

if (isset($_GET['totalRows_fmEditTasks'])) {
  $totalRows_fmEditTasks = $_GET['totalRows_fmEditTasks'];
} else {
  $all_fmEditTasks = mysql_query($query_fmEditTasks);
  $totalRows_fmEditTasks = mysql_num_rows($all_fmEditTasks);
}
$totalPages_fmEditTasks = ceil($totalRows_fmEditTasks/$maxRows_fmEditTasks)-1;

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmVendorLookup = "SELECT VendorNo, `Vendor Name` FROM Vendors ORDER BY `Vendor Name` ASC";
$fmVendorLookup = mysql_query($query_fmVendorLookup, $Leadbook) or die(mysql_error());
$row_fmVendorLookup = mysql_fetch_assoc($fmVendorLookup);
$totalRows_fmVendorLookup = mysql_num_rows($fmVendorLookup);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmContactLookup = "SELECT ContactNo, `Last Name` FROM OtherNames ORDER BY `Last Name` ASC";
$fmContactLookup = mysql_query($query_fmContactLookup, $Leadbook) or die(mysql_error());
$row_fmContactLookup = mysql_fetch_assoc($fmContactLookup);
$totalRows_fmContactLookup = mysql_num_rows($fmContactLookup);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustLookup = "SELECT Leads.`Last Name` FROM Customer, Leads WHERE Customer.CustNo = Leads.LeadNo ORDER BY Leads.`Last Name`";
$fmCustLookup = mysql_query($query_fmCustLookup, $Leadbook) or die(mysql_error());
$row_fmCustLookup = mysql_fetch_assoc($fmCustLookup);
$totalRows_fmCustLookup = mysql_num_rows($fmCustLookup);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadLookup = "SELECT * FROM Leads ORDER BY Leads.`Last Name`";
$fmLeadLookup = mysql_query($query_fmLeadLookup, $Leadbook) or die(mysql_error());
$row_fmLeadLookup = mysql_fetch_assoc($fmLeadLookup);
$totalRows_fmLeadLookup = mysql_num_rows($fmLeadLookup);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Contact Details</title>

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
<h1>Task Edit</h1>
</hgroup>

<!-- end #header --></header>
<section id="sidebar1">
<div><button class="tableheader"type="submit">Print Vendors</button></div> 
<form id="form3" name="form3" method="post">
<input type="submit" name="button3" id="button3" value="Print" onclick="printpage()" />
</form>
<!-- end #sidebar1 --></section>
<header>
<div id="titlerepeat">Admin:Tasks Edit</div>
</header>
<aside id="mainContent">
<form action="<?php echo $editFormAction; ?>" method="POST" name="formEdit" id="formEdit">
<fieldset>
<legend>Task Info</legend>
<table id="maintable" >

<tr>
<td class="tddataright">Date:</td>
<td><input type="date" name="Date" value="<?php echo htmlentities($row_fmEditTasks['Date'], ENT_COMPAT, 'UTF-8'); ?>" size="15" /></td></tr>

<tr>
<td class="tddataright">Time:</td>
<td><input type="text" name="Time" value="<?php echo htmlentities($row_fmEditTasks['Time'], ENT_COMPAT, 'UTF-8'); ?>" size="15" /></td></tr>

<tr>
<td class="tddataright">Priority:</td>
<td>
<select name="Priority" id="Priority">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Priority']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<option value="High" <?php if (!(strcmp("High", $row_fmEditTasks['Priority']))) {echo "selected=\"selected\"";} ?>>High</option>
<option value="Medium" <?php if (!(strcmp("Medium", $row_fmEditTasks['Priority']))) {echo "selected=\"selected\"";} ?>>Medium</option>
<option value="Low" <?php if (!(strcmp("Low", $row_fmEditTasks['Priority']))) {echo "selected=\"selected\"";} ?>>Low</option>
</select>
</td></tr>

<tr>
<td class="tddataright">Lead Name:</td>
<td><select name="Leads" id="Leads">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Lead Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmLeadLookup['Last Name']?>"<?php if (!(strcmp($row_fmLeadLookup['Last Name'], $row_fmEditTasks['Lead Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmLeadLookup['Last Name']?></option>
<?php } while ($row_fmLeadLookup = mysql_fetch_assoc($fmLeadLookup));
$rows = mysql_num_rows($fmLeadLookup);
if($rows > 0) {
mysql_data_seek($fmLeadLookup, 0);
$row_fmLeadLookup = mysql_fetch_assoc($fmLeadLookup); } ?>
</select></td></tr>

<tr>
<td class="tddataright">Customer Name:</td>
<td><select name="Customer" id="Customer">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Customer Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCustLookup['Last Name']?>"<?php if (!(strcmp($row_fmCustLookup['Last Name'], $row_fmEditTasks['Customer Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCustLookup['Last Name']?></option>
<?php } while ($row_fmCustLookup = mysql_fetch_assoc($fmCustLookup));
$rows = mysql_num_rows($fmCustLookup);
if($rows > 0) {
mysql_data_seek($fmCustLookup, 0);
$row_fmCustLookup = mysql_fetch_assoc($fmCustLookup); } ?>
</select></td></tr>

<tr>
<td class="tddataright">Contact Name:</td>
<td><select name="Contact" id="Contact">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Contact Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmContactLookup['Last Name']?>"<?php if (!(strcmp($row_fmContactLookup['Last Name'], $row_fmEditTasks['Contact Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmContactLookup['Last Name']?></option>
<?php } while ($row_fmContactLookup = mysql_fetch_assoc($fmContactLookup));
$rows = mysql_num_rows($fmContactLookup);
if($rows > 0) {
mysql_data_seek($fmContactLookup, 0);
$row_fmContactLookup = mysql_fetch_assoc($fmContactLookup); } ?>
</select></td></tr>

<tr>
<td class="tddataright">Vendor Name:</td>
<td><select name="Vendor" id="Vendor">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Vendor Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmVendorLookup['Vendor Name']?>"<?php if (!(strcmp($row_fmVendorLookup['Vendor Name'], $row_fmEditTasks['Vendor Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmVendorLookup['Vendor Name']?></option>
<?php } while ($row_fmVendorLookup = mysql_fetch_assoc($fmVendorLookup));
$rows = mysql_num_rows($fmVendorLookup);
if($rows > 0) {
mysql_data_seek($fmVendorLookup, 0);
$row_fmVendorLookup = mysql_fetch_assoc($fmVendorLookup); } ?>
</select></td></tr>

<tr>
<td class="tddataright">Regarding:</td>
<td>
<select name="Regarding" size="1" id="Regarding">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Regarding']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<option value="Meeting" <?php if (!(strcmp("Meeting", $row_fmEditTasks['Regarding']))) {echo "selected=\"selected\"";} ?>>Meeting</option>
<option value="Service Call" <?php if (!(strcmp("Service Call", $row_fmEditTasks['Regarding']))) {echo "selected=\"selected\"";} ?>>Service Call</option>
</select>
</td></tr>

<tr>
<td class="tddataright">Duration:</td>
<td><select name="Duration" id="Duration">
<option value="" <?php if (!(strcmp("", $row_fmEditTasks['Duration']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<option value="1 Hour" <?php if (!(strcmp("1 Hour", $row_fmEditTasks['Duration']))) {echo "selected=\"selected\"";} ?>>1 Hour</option>
<option value="All Day" <?php if (!(strcmp("All Day", $row_fmEditTasks['Duration']))) {echo "selected=\"selected\"";} ?>>All Day</option>
</select></td></tr>

<tr>
<td class="tddataright">Active:</td>
<td><input type="checkbox" name="Active" value="1" <?php if (!(strcmp($row_fmEditTasks['Active'],1))) {echo "checked=\"checked\"";} ?> />
</td></tr>
</table>

<!---------------------------------table 3 start-->
<table class="tddataright" width="33%">
<tr>
<td><textarea name="Details" id="details" autofocus placeholder="comments" cols="25" rows="15"><?php echo htmlentities($row_fmEditTasks['Details'], ENT_COMPAT, 'UTF-8'); ?></textarea></td>
</tr>
</table>
<!------------------------------------table 3 end-->  
</fieldset>
<div id="divsubmit">
<input type="submit" value="Update record" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
<input type="hidden" name="TaskNo" value="<?php echo $row_fmEditTasks['TaskNo']; ?>" />
<input type="hidden" name="MM_update" value="formEdit" />
</div>
</form>
<!-- end #mainContent --></aside>
<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
<footer id="footer">
<!-- end #footer --></footer>
<!-- end #container --></div>

<p>&nbsp;</p>
<script type="text/javascript">
<!--

//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmEditTasks);

mysql_free_result($fmVendorLookup);

mysql_free_result($fmContactLookup);

mysql_free_result($fmCustLookup);

mysql_free_result($fmLeadLookup);
?>
