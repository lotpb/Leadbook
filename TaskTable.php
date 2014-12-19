<?php require_once('Connections/Leadbook.php'); ?>
<?php
//if (!isset($_SESSION)) {
//  session_start();
//}
//$MM_authorizedUsers = "";
//$MM_donotCheckaccess = "true";
//
//// *** Restrict Access To Page: Grant or deny access to this page
//function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
//  // For security, start by assuming the visitor is NOT authorized. 
//  $isValid = False; 
//
//  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
//  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
//  if (!empty($UserName)) { 
//    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
//    // Parse the strings into arrays. 
//    $arrUsers = Explode(",", $strUsers); 
//    $arrGroups = Explode(",", $strGroups); 
//    if (in_array($UserName, $arrUsers)) { 
//      $isValid = true; 
//    } 
//    // Or, you may restrict access to only certain users based on their username. 
//    if (in_array($UserGroup, $arrGroups)) { 
//      $isValid = true; 
//    } 
//    if (($strUsers == "") && true) { 
//      $isValid = true; 
//    } 
//  } 
//  return $isValid; 
//}
//
//$MM_restrictGoTo = "Login.php";
//if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
//  $MM_qsChar = "?";
//  $MM_referrer = $_SERVER['PHP_SELF'];
//  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
//  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
//  $MM_referrer .= "?" . $QUERY_STRING;
//  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
//  header("Location: ". $MM_restrictGoTo); 
//  exit;
//}
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO Tasks (TaskNo, `Date`, `Time`, Priority, `Lead Name`, `Customer Name`, `Contact Name`, `Vendor Name`, Regarding, Details, Active, Duration) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['TaskNo'], "int"),
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Time'], "date"),
                       GetSQLValueString($_POST['Priority'], "text"),
                       GetSQLValueString($_POST['Lead Name'], "text"),
                       GetSQLValueString($_POST['Customer'], "text"),
                       GetSQLValueString($_POST['Contact'], "text"),
                       GetSQLValueString($_POST['Vendor'], "text"),
                       GetSQLValueString($_POST['Regarding'], "text"),
                       GetSQLValueString($_POST['Details'], "text"),
                       GetSQLValueString($_POST['Active'], "int"),
                       GetSQLValueString($_POST['Duration'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "TaskTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//Chexbox
if ($_GET['ActiveTask'] == "1")  { 
$t1v="checked";
setcookie("Tasks1", "", time()+3600); 
} else {
$t1v=="";
setcookie("Tasks1", "Active Tasks", time()+3600);
}
//Vendor
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmVendorLookup = "SELECT VendorNo, `Vendor Name` FROM Vendors ORDER BY `Vendor Name` ASC";
$fmVendorLookup = mysql_query($query_fmVendorLookup, $Leadbook) or die(mysql_error());
$row_fmVendorLookup = mysql_fetch_assoc($fmVendorLookup);
$totalRows_fmVendorLookup = mysql_num_rows($fmVendorLookup);
//Contacts
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmContactLookup = "SELECT ContactNo, `Last Name` FROM OtherNames ORDER BY `Last Name` ASC";
$fmContactLookup = mysql_query($query_fmContactLookup, $Leadbook) or die(mysql_error());
$row_fmContactLookup = mysql_fetch_assoc($fmContactLookup);
$totalRows_fmContactLookup = mysql_num_rows($fmContactLookup);
//Lead
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadLookup = "SELECT * FROM Leads ORDER BY Leads.`Date` DESC";
$fmLeadLookup = mysql_query($query_fmLeadLookup, $Leadbook) or die(mysql_error());
$row_fmLeadLookup = mysql_fetch_assoc($fmLeadLookup);
$totalRows_fmLeadLookup = mysql_num_rows($fmLeadLookup);
//Customer
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustLookup = "SELECT Leads.`Last Name` FROM Customer, Leads WHERE Customer.LeadNo = Leads.LeadNo ORDER BY Leads.`Last Name`";
$fmCustLookup = mysql_query($query_fmCustLookup, $Leadbook) or die(mysql_error());
$row_fmCustLookup = mysql_fetch_assoc($fmCustLookup);
$totalRows_fmCustLookup = mysql_num_rows($fmCustLookup);

$maxRows_fmTasks = 25;
$pageNum_fmTasks = 0;
if (isset($_GET['pageNum_fmTasks'])) {
  $pageNum_fmTasks = $_GET['pageNum_fmTasks'];
}
$startRow_fmTasks = $pageNum_fmTasks * $maxRows_fmTasks;

$colname_fmTasks = "%";
if (isset($_GET['SelectRegarding'])) {
  $colname_fmTasks = $_GET['SelectRegarding'];
}
$var_fmTasks = "0";
if (isset($_GET['ActiveTask'])) {
  $var_fmTasks = $_GET['ActiveTask'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmTasks = sprintf("SELECT * FROM Tasks WHERE (Tasks.Regarding LIKE %s ) AND (Tasks.Active >= %s) ORDER BY Tasks.`Date` DESC", GetSQLValueString($colname_fmTasks, "text"),GetSQLValueString($var_fmTasks, "int"));
$query_limit_fmTasks = sprintf("%s LIMIT %d, %d", $query_fmTasks, $startRow_fmTasks, $maxRows_fmTasks);
$fmTasks = mysql_query($query_limit_fmTasks, $Leadbook) or die(mysql_error());
$row_fmTasks = mysql_fetch_assoc($fmTasks);

if (isset($_GET['totalRows_fmTasks'])) {
  $totalRows_fmTasks = $_GET['totalRows_fmTasks'];
} else {
  $all_fmTasks = mysql_query($query_fmTasks);
  $totalRows_fmTasks = mysql_num_rows($all_fmTasks);
}
$totalPages_fmTasks = ceil($totalRows_fmTasks/$maxRows_fmTasks)-1;

$queryString_fmTasks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmTasks") == false && 
        stristr($param, "totalRows_fmTasks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmTasks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmTasks = sprintf("&totalRows_fmTasks=%d%s", $totalRows_fmTasks, $queryString_fmTasks);

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Task Listing</title>

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/xpath.js" type="text/javascript"></script>
<script src="SpryAssets/SpryData.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
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
<![endif]--><!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColFixRtHdr #sidebar1 { padding-top: 30px; }
.twoColFixRtHdr #mainContent { zoom: 1; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->
<script type="text/javascript">
function reload(form)    //dont work
{var val=form.SelectRegard.options[form.SelectRegard.options.selectedIndex].value ;
self.location='TaskTable.php?SelectRegarding=' + val ; 
}
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
<h1>Tasks Online</h1>
</hgroup>

<!-- end #header --></header>
<section id="sidebar1">
<?php
if (isset($_COOKIE["Tasks1"]))
echo "Viewing  " . $_COOKIE["Tasks1"] . "!<br />" ;
else
echo "Viewing all Tasks!<br />";
?>  

<form id="form3" name="form3" method="get" action="TaskTable.php">
<input name="Search" type="text" id="Search" value="<?php echo $_REQUEST['Search']; ?>" size="18" />
<input type="submit" value="Search" />
</form>

<div><button class="tableheader"type="submit"> Records <?php echo ($startRow_fmTasks + 1) ?> to <?php echo min($startRow_fmTasks + $maxRows_fmTasks, $totalRows_fmTasks) ?> of <?php echo $totalRows_fmTasks ?> </button></div> 

<div><button class="tableheader"type="submit">Print Customers</button></div> 

<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<form id="form5" name="form5" method="get" action="TaskTable.php">
<p><button class="tableheader"type="submit">Search Tasks</button></p>
<p><input name="ActiveTask" type="checkbox" id="mycheckbox" value= "1" <?php echo $t1v ?> onclick="submit()"/> Active Tasks</p>
</form>
<p><button class="tableheader"type="submit">Regarding</button></p>
<form id="form4" name="form4" method="get">
<select name="SelectRegard" id="SelectRegard" onchange="reload(this.form)">
<option selected="selected">select from menu</option>
<option value="Meeting">Meeting</option>
<option value="Service Call">Service Call</option>
</select>
</form>
<!-- end #sidebar1 --></section>
<header>
<div id="titlerepeat">Admin:Task Listing</div>
</header>
<aside id="mainContent">

<div id="addnew">
<?php if ($totalRows_fmTasks == 0) { // Show if recordset empty ?>
There are no tasks defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmTasks > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Tasks</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Task Listing</li>
<li class="TabbedPanelsTab">New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table  id="nav">
  <tr>
    <td><?php if ($pageNum_fmTasks > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmTasks=%d%s", $currentPage, 0, $queryString_fmTasks); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmTasks > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmTasks=%d%s", $currentPage, max(0, $pageNum_fmTasks - 1), $queryString_fmTasks); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmTasks < $totalPages_fmTasks) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmTasks=%d%s", $currentPage, min($totalPages_fmTasks, $pageNum_fmTasks + 1), $queryString_fmTasks); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_fmTasks < $totalPages_fmTasks) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmTasks=%d%s", $currentPage, $totalPages_fmTasks, $queryString_fmTasks); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>

<table width="100%" id="delform">
<tr>
<th>Date</span></th>
<th>Name</span></th>
<th>Regarding</th>
<th>Details</th>
<th>Priority</th>
<th>Duration</th>
<th>Active</span></th>
<th>&nbsp;</th>
<th><input name="ContactNo" type="hidden" id="ContactNo" value="<?php echo $row_fmTasks['ContactNo']; ?>" /></th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td nowrap="nowrap"><?php echo $row_fmTasks['Date']; ?></td>
<td><?php echo $row_fmTasks['Lead Name']; ?><?php echo $row_fmTasks['Contact Name']; ?> <?php echo $row_fmTasks['Customer Name']; ?> <?php echo $row_fmTasks['Vendor Name']; ?></td>
<td><?php echo $row_fmTasks['Regarding']; ?></td>
<td><?php echo $row_fmTasks['Details']; ?></td>
<td><?php echo $row_fmTasks['Priority']; ?></td>
<td><?php echo $row_fmTasks['Duration']; ?></td>
<td><?php echo $row_fmTasks['Active']; ?></td>
<td><a href="TasksEdit.php?TaskNo=<?php echo $row_fmTasks['TaskNo']; ?>">edit</a></td>
<td><a href="DeleteAddress.php?TaskNo=<?php echo $row_fmTasks['TaskNo']; ?>">delete</a></td>
</tr>
<?php } while ($row_fmTasks = mysql_fetch_assoc($fmTasks)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<fieldset>
<legend id="legendcolor">Task Info</legend>
<table id="maintable">
<tr>
<td class="tddataright">Date:</td>
<td><input type="text" name="Date" value="<?php echo date("Y-m-d"); ?>" size="15" /></td></tr>

<tr>
<td class="tddataright">Time:</td>
<td><input type="text" name="Time" value="" size="15" /></td></tr>

<tr>
<td class="tddataright">Priority:</td>
<td><select name="Priority" id="Priority">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Priority']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<option value="High" <?php if (!(strcmp("High", $row_fmTasks['Priority']))) {echo "selected=\"selected\"";} ?>>High</option>
<option value="Medium" <?php if (!(strcmp("Medium", $row_fmTasks['Priority']))) {echo "selected=\"selected\"";} ?>>Medium</option>
<option value="Low" <?php if (!(strcmp("Low", $row_fmTasks['Priority']))) {echo "selected=\"selected\"";} ?>>Low</option>
</select></td></tr>

<tr>
<td class="tddataright">Lead Name:</td>
<td><select name="Lead Name" id="Lead Name">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Lead Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmLeadLookup['Last Name']?>"<?php if (!(strcmp($row_fmLeadLookup['Last Name'], $row_fmTasks['Lead Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmLeadLookup['Last Name']?></option>
<?php
} while ($row_fmLeadLookup = mysql_fetch_assoc($fmLeadLookup));
$rows = mysql_num_rows($fmLeadLookup);
if($rows > 0) {
mysql_data_seek($fmLeadLookup, 0);
$row_fmLeadLookup = mysql_fetch_assoc($fmLeadLookup);
} ?>
</select></td></tr>

<tr>
<td class="tddataright">Customer Name:</td>
<td><select name="Customer" id="Customer">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Customer Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCustLookup['Last Name']?>"<?php if (!(strcmp($row_fmCustLookup['Last Name'], $row_fmTasks['Customer Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCustLookup['Last Name']?></option>
<?php
} while ($row_fmCustLookup = mysql_fetch_assoc($fmCustLookup));
$rows = mysql_num_rows($fmCustLookup);
if($rows > 0) {
mysql_data_seek($fmCustLookup, 0);
$row_fmCustLookup = mysql_fetch_assoc($fmCustLookup);
} ?>
</select></td></tr>

<tr>
<td class="tddataright">Contact Name:</td>
<td><select name="Contact" id="Contact">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Contact Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmContactLookup['Last Name']?>"<?php if (!(strcmp($row_fmContactLookup['Last Name'], $row_fmTasks['Contact Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmContactLookup['Last Name']?></option>
<?php
} while ($row_fmContactLookup = mysql_fetch_assoc($fmContactLookup));
$rows = mysql_num_rows($fmContactLookup);
if($rows > 0) {
mysql_data_seek($fmContactLookup, 0);
$row_fmContactLookup = mysql_fetch_assoc($fmContactLookup);
} ?>
</select></td></tr>

<tr>
<td class="tddataright">Vendor Name:</td>
<td><select name="Vendor" id="Vendor">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Vendor Name']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmVendorLookup['Vendor Name']?>"<?php if (!(strcmp($row_fmVendorLookup['Vendor Name'], $row_fmTasks['Vendor Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmVendorLookup['Vendor Name']?></option>
<?php
} while ($row_fmVendorLookup = mysql_fetch_assoc($fmVendorLookup));
$rows = mysql_num_rows($fmVendorLookup);
if($rows > 0) {
mysql_data_seek($fmVendorLookup, 0);
$row_fmVendorLookup = mysql_fetch_assoc($fmVendorLookup);
} ?>
</select></td></tr>

<tr>
<td class="tddataright">Regarding:</td>
<td><select name="Regarding" size="1" id="Regarding">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Regarding']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<option value="Meeting" <?php if (!(strcmp("Meeting", $row_fmTasks['Regarding']))) {echo "selected=\"selected\"";} ?>>Meeting</option>
<option value="Service Call" <?php if (!(strcmp("Service Call", $row_fmTasks['Regarding']))) {echo "selected=\"selected\"";} ?>>Service Call</option>
</select></td></tr>

<tr>
<td class="tddataright">Duration:</td>
<td><select name="Duration" id="Duration">
<option value="" <?php if (!(strcmp("", $row_fmTasks['Duration']))) {echo "selected=\"selected\"";} ?>>select from menu</option>
<option value="1 Hour" <?php if (!(strcmp("1 Hour", $row_fmTasks['Duration']))) {echo "selected=\"selected\"";} ?>>1 Hour</option>
<option value="All Day" <?php if (!(strcmp("All Day", $row_fmTasks['Duration']))) {echo "selected=\"selected\"";} ?>>All Day</option>
</select></td></tr>

<tr>
<td class="tddataright">Active:</td>
<td><input <?php if (!(strcmp($row_fmTasks['Active'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="Active" value="1" checked="checked" /></td>
</tr>
</table>
<!---------------------------------table 3 start-->
<table width="33%"  class="tddataright">
<tr>
<td>
<textarea name="Details" id="Details" placeholder="comments" cols="27" rows="15"><?php echo $row_fmTasks['Details']; ?></textarea></td>
</tr>
</table>
<!------------------------------------table 3 end-->
</fieldset>

<div id="divsubmit">
<input type="submit" value="Insert" />
<input type="button" name="button3" id="button3" value="Cancel" onclick="history.back()"  />
<input type="hidden" name="MM_insert" value="forminsert" />
<input name="TaskNo" type="hidden" id="TaskNo" value="<?php echo $row_fmTasks['TaskNo']; ?>" />
</div>
</form>
</div>
</div>
</div>
  <!-- end #mainContent --></aside>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <footer id="footer">
  <!-- end #footer --></footer>
<!-- end #container --></div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmVendorLookup);

mysql_free_result($fmContactLookup);

mysql_free_result($fmLeadLookup);

mysql_free_result($fmCustLookup);

mysql_free_result($fmTasks);
?>
