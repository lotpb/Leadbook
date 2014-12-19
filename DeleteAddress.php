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
//delete Leads
if ((isset($_POST['LeadNo'])) && ($_POST['LeadNo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Leads WHERE LeadNo=%s",
                       GetSQLValueString($_POST['LeadNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($deleteSQL, $Leadbook) or die(mysql_error());

  $deleteGoTo = "LeadTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
//delete Cust
if ((isset($_POST['CustNo'])) && ($_POST['CustNo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Customer WHERE CustNo=%s",
                       GetSQLValueString($_POST['CustNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($deleteSQL, $Leadbook) or die(mysql_error());

  $deleteGoTo = "CustTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
//delete Contacts
if ((isset($_POST['ContactNo'])) && ($_POST['ContactNo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM OtherNames WHERE ContactNo=%s",
                       GetSQLValueString($_POST['ContactNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($deleteSQL, $Leadbook) or die(mysql_error());

  $deleteGoTo = "ContactsTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
//delete Vendor
if ((isset($_POST['VendorNo'])) && ($_POST['VendorNo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Vendors WHERE VendorNo=%s",
                       GetSQLValueString($_POST['VendorNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($deleteSQL, $Leadbook) or die(mysql_error());

  $deleteGoTo = "VendorTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
//delete Tasks
if ((isset($_POST['TaskNo'])) && ($_POST['TaskNo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Tasks WHERE TaskNo=%s",
                       GetSQLValueString($_POST['TaskNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($deleteSQL, $Leadbook) or die(mysql_error());

  $deleteGoTo = "TaskTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
//delete Employee
if ((isset($_POST['EmployeeNo'])) && ($_POST['EmployeeNo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Employee WHERE EmployeeNo=%s",
                       GetSQLValueString($_POST['EmployeeNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($deleteSQL, $Leadbook) or die(mysql_error());

  $deleteGoTo = "EmployeeTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
//tables
$colname_frLeads = "0";
if (isset($_GET['LeadNo'])) {
  $colname_frLeads = $_GET['LeadNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frLeads = sprintf("SELECT * FROM Leads WHERE LeadNo = %s", GetSQLValueString($colname_frLeads, "int"));
$frLeads = mysql_query($query_frLeads, $Leadbook) or die(mysql_error());
$row_frLeads = mysql_fetch_assoc($frLeads);
$totalRows_frLeads = mysql_num_rows($frLeads);

$colname_frCustomer = "0";
if (isset($_GET['CustNo'])) {
  $colname_frCustomer = $_GET['CustNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frCustomer = sprintf("SELECT Leads.`Last Name`, Customer.CustNo FROM Customer, Leads WHERE Customer.CustNo = %s  AND Customer.LeadNo = Leads.LeadNo", GetSQLValueString($colname_frCustomer, "int"));
$frCustomer = mysql_query($query_frCustomer, $Leadbook) or die(mysql_error());
$row_frCustomer = mysql_fetch_assoc($frCustomer);
$totalRows_frCustomer = mysql_num_rows($frCustomer);

$colname_frContact = "0";
if (isset($_GET['ContactNo'])) {
  $colname_frContact = $_GET['ContactNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frContact = sprintf("SELECT * FROM OtherNames WHERE OtherNames.ContactNo = %s", GetSQLValueString($colname_frContact, "int"));
$frContact = mysql_query($query_frContact, $Leadbook) or die(mysql_error());
$row_frContact = mysql_fetch_assoc($frContact);
$totalRows_frContact = mysql_num_rows($frContact);

$colname_frVendor = "0";
if (isset($_GET['VendorNo'])) {
  $colname_frVendor = $_GET['VendorNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frVendor = sprintf("SELECT * FROM Vendors WHERE Vendors.VendorNo = %s", GetSQLValueString($colname_frVendor, "int"));
$frVendor = mysql_query($query_frVendor, $Leadbook) or die(mysql_error());
$row_frVendor = mysql_fetch_assoc($frVendor);
$totalRows_frVendor = mysql_num_rows($frVendor);

$colname_frTask = "0";
if (isset($_GET['TaskNo'])) {
  $colname_frTask = $_GET['TaskNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frTask = sprintf("SELECT * FROM Tasks WHERE Tasks.TaskNo = %s", GetSQLValueString($colname_frTask, "int"));
$frTask = mysql_query($query_frTask, $Leadbook) or die(mysql_error());
$row_frTask = mysql_fetch_assoc($frTask);
$totalRows_frTask = mysql_num_rows($frTask);

$colname_frEmployee = "0";
if (isset($_GET['EmployeeNo'])) {
  $colname_frEmployee = $_GET['EmployeeNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frEmployee = sprintf("SELECT * FROM Employee WHERE Employee.EmployeeNo = %s", GetSQLValueString($colname_frEmployee, "int"));
$frEmployee = mysql_query($query_frEmployee, $Leadbook) or die(mysql_error());
$row_frEmployee = mysql_fetch_assoc($frEmployee);
$totalRows_frEmployee = mysql_num_rows($frEmployee);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Delete Form</title>
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--

-->
</style>
</head>

<body class="oneColFixCtrHdr">
<div id="carbonForm" align="center">
<div id="header">
<h1>Leads Online</h1>
<p>&nbsp;</p>
<!-- end #header --></div>
<div class="fieldContainer">

<h2>Admin:Delete File</h2>
<form id="delform" name="delform" method="post">
<h3>Are you sure you want to delete <?php echo $row_frLeads['Last Name']; ?><?php echo $row_frCustomer['Last Name']; ?><?php echo $row_frContact['Last Name']; ?><?php echo $row_frVendor['Vendor Name']; ?><?php echo $row_frEmployee['Last Name']; ?><?php echo $row_frTask['Type']; ?> ?</h3>
<p>
<input name="LeadNo" type="hidden" id="LeadNo" value="<?php echo $row_frLeads['LeadNo']; ?>" />
<input name="CustNo" type="hidden" id="CustNo" value="<?php echo $row_frCustomer['CustNo']; ?>" />
<input name="ContactNo" type="hidden" id="ContactNo" value="<?php echo $row_frContact['ContactNo']; ?>" />
<input name="VendorNo" type="hidden" id="VendorNo" value="<?php echo $row_frVendor['VendorNo']; ?>" />
<input name="TaskNo" type="hidden" id="TaskNo" value="<?php echo $row_frTask['TaskNo']; ?>" />
<input name="EmployeeNo" type="hidden" id="EmployeeNo" value="<?php echo $row_frEmployee['EmployeeNo']; ?>" />
<div class="signupButton">
<input type="submit" name="Submit" id="submit" value="Delete" />
<input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" />
</div>
</p>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<!-- end #mainContent --></div>
<!-- end #container --></div>
</body>
</html>
<?php
mysql_free_result($frLeads);

mysql_free_result($frCustomer);

mysql_free_result($frContact);

mysql_free_result($frVendor);

mysql_free_result($frTask);

mysql_free_result($frEmployee);
?>