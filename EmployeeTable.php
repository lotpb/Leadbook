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
$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO Employee (EmployeeNo, `First Name`, `Middle Name`, `Last Name`, `Company Name`, `Social Security`, Department, Title, Manager, `Work Phone`, `Cell Phone`, Street, City, `State`, Country, Zip, `Home Phone`, Email, Comments, Active) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['EmployeeNo'], "int"),
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Middle_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Company_Name'], "text"),
                       GetSQLValueString($_POST['Social_Security'], "text"),
                       GetSQLValueString($_POST['Department'], "text"),
                       GetSQLValueString($_POST['Title'], "text"),
                       GetSQLValueString($_POST['Manager'], "text"),
                       GetSQLValueString($_POST['Work_Phone'], "text"),
                       GetSQLValueString($_POST['Cell_Phone'], "text"),
                       GetSQLValueString($_POST['Street'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Country'], "text"),
                       GetSQLValueString($_POST['Zip'], "text"),
                       GetSQLValueString($_POST['Home_Phone'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Active'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "EmployeeTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//checkbox
if ($_GET['Active'] == "1")  { 
$t1v="checked";
setcookie("Employee1", "", time()+3600); 
} else {
$t1v=="";
setcookie("Employee1", "Active Employee", time()+3600);
}
//city
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Employee
$maxRows_fmEmployee = 25;
$pageNum_fmEmployee = 0;
if (isset($_GET['pageNum_fmEmployee'])) {
  $pageNum_fmEmployee = $_GET['pageNum_fmEmployee'];
}
$startRow_fmEmployee = $pageNum_fmEmployee * $maxRows_fmEmployee;

$Search_fmEmployee = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmEmployee = $_REQUEST['Search'];
}
$var_fmEmployee = "0";
if (isset($_GET['Active'])) {
  $var_fmEmployee = $_GET['Active'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEmployee = sprintf("SELECT * FROM Employee WHERE (Employee.EmployeeNo LIKE %s OR Employee.`First Name` LIKE %s OR Employee.`Last Name` LIKE %s OR Employee.Street LIKE %s OR Employee.City LIKE %s OR Employee.`Home Phone` LIKE %s) AND Employee.Active >= %s ORDER BY Employee.`Last Name`", GetSQLValueString($Search_fmEmployee, "text"),GetSQLValueString($Search_fmEmployee, "text"),GetSQLValueString($Search_fmEmployee, "text"),GetSQLValueString($Search_fmEmployee, "text"),GetSQLValueString($Search_fmEmployee, "text"),GetSQLValueString($Search_fmEmployee, "text"),GetSQLValueString($var_fmEmployee, "int"));
$query_limit_fmEmployee = sprintf("%s LIMIT %d, %d", $query_fmEmployee, $startRow_fmEmployee, $maxRows_fmEmployee);
$fmEmployee = mysql_query($query_limit_fmEmployee, $Leadbook) or die(mysql_error());
$row_fmEmployee = mysql_fetch_assoc($fmEmployee);

if (isset($_GET['totalRows_fmEmployee'])) {
  $totalRows_fmEmployee = $_GET['totalRows_fmEmployee'];
} else {
  $all_fmEmployee = mysql_query($query_fmEmployee);
  $totalRows_fmEmployee = mysql_num_rows($all_fmEmployee);
}
$totalPages_fmEmployee = ceil($totalRows_fmEmployee/$maxRows_fmEmployee)-1;

$queryString_fmEmployee = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmEmployee") == false && 
        stristr($param, "totalRows_fmEmployee") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmEmployee = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmEmployee = sprintf("&totalRows_fmEmployee=%d%s", $totalRows_fmEmployee, $queryString_fmEmployee);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Employee Listing</title>

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
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
<h1>Employee Online</h1>
</hgroup>
<!-- end #header --></header>

<section id="sidebar1">
<?php
if ($_GET['Active'] == "1") 
echo "Viewing  " . $_COOKIE["Employee1"] . "!<br />" ;
else
echo "Viewing all Employees!<br />";
?> 

<form id="form6" name="form6" method="get" action="EmployeeTable.php">
<p>
<input name="Search" type="text" id="Search" autofocus value="Search<?php echo $_REQUEST['Search']; ?>" size="18" />
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
</p>
</form>
<div><button class="tableheader"type="submit">Records <?php echo ($startRow_fmEmployee + 1) ?> to <?php echo min($startRow_fmEmployee + $maxRows_fmEmployee, $totalRows_fmEmployee) ?> of <?php echo $totalRows_fmEmployee ?></button></div> 

<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<form id="form4" name="form4" method="get" action="EmployeeTable.php">
<p><button class="tableheader"type="submit">Search Employees</button></p>
<p><input name="Active" type="checkbox" id="mycheckbox" value="1" <?php echo $t1v ?> onclick="submit()"/> Active Employees</p>
</form>
<!-- end #sidebar1 --></section>

<header>
<div id="titlerepeat">Admin:Employee Listing</div>
</header>
<aside id="mainContent" class="tddataleft">

<div id="addnew">
<?php if ($totalRows_fmEmployee == 0) { // Show if recordset empty ?>
There are no employees defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmEmployee > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Employee</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Employee Listing</li>
<li class="TabbedPanelsTab">New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table  id="nav">
<tr>
<td><?php if ($pageNum_fmEmployee > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmEmployee=%d%s", $currentPage, 0, $queryString_fmEmployee); ?>">First</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmEmployee > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmEmployee=%d%s", $currentPage, max(0, $pageNum_fmEmployee - 1), $queryString_fmEmployee); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmEmployee < $totalPages_fmEmployee) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmEmployee=%d%s", $currentPage, min($totalPages_fmEmployee, $pageNum_fmEmployee + 1), $queryString_fmEmployee); ?>">Next</a>
<?php } // Show if not last page ?>
</td>
<td><?php if ($pageNum_fmEmployee < $totalPages_fmEmployee) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmEmployee=%d%s", $currentPage, $totalPages_fmEmployee, $queryString_fmEmployee); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
</table>

<table width="100%" id="delform">
<tr>
<th>Name</th>
<th>Street</th>
<th>City</th>
<th>Phone</th>
<th>Active</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmEmployee['First Name']; ?> <?php echo $row_fmEmployee['Last Name']; ?> <?php echo $row_fmEmployee['Company Name']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmEmployee['Street']; ?></td>
<td><?php echo $row_fmEmployee['City']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmEmployee['Home Phone']; ?></td>
<td><?php echo $row_fmEmployee['Active']; ?></td>
<td><a href="EmployeeEdit.php?EmployeeNo=<?php echo $row_fmEmployee['EmployeeNo']; ?>" >edit</a></td>
<td><a href="DeleteAddress.php?EmployeeNo=<?php echo $row_fmEmployee['EmployeeNo']; ?>">delete</a></td>
</tr>
<?php } while ($row_fmEmployee = mysql_fetch_assoc($fmEmployee)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<fieldset>
<legend>Employee Info</legend>
<div id="threecoldiv">
<ui id="threecolul">
<li>
<table>
<tr>
<td class="tddataright">First Name:</td>
<td><input type="text" name="First_Name" placeholder="first name" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Middle Name:</td>
<td><input type="text" name="Middle_Name" placeholder="middle name" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Last Name:</td>
<td><input type="text" name="Last_Name" placeholder="last name" value="" size="25" /></td>
</tr>
<tr>
<td class="tddataright">Company Name:</td>
<td><input type="text" name="Company_Name" placeholder="company name" value="" size="25" /></td>
</tr>
<tr>
<td class="tddataright">Street:</td>
<td><input type="text" name="Street" placeholder="street" value="" size="25" /></td>
</tr>
<tr>
<td class="tddataright">City:</td>
<td><select name="City" id="City" onchange="showZip(this.value)">
  <option value="" <?php if (!(strcmp("", $_GET['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
  <?php
do {  
?>
  <option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $_GET['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
  <?php
} while ($row_fmCity = mysql_fetch_assoc($fmCity));
  $rows = mysql_num_rows($fmCity);
  if($rows > 0) {
      mysql_data_seek($fmCity, 0);
	  $row_fmCity = mysql_fetch_assoc($fmCity);
  }
?>
</select>
<a href="ZipLookup.php">select</a></td>
</tr>
<tr>
<td class="tddataright">State:</td>
<td><input type="text" name="State" id="State" placeholder="state" value="" size="10" /> <input type="text" name="Zip" id="Zip_Code" placeholder="zip" value="" size="10" /></td>
</tr>
<tr>
<td class="tddataright">Home Phone:</td>
<td><input type="text" name="Home_Phone" placeholder="phone" value="" size="20" /><br />
<label>(###)###-####</label></td>
</tr>
<tr>
<td class="tddataright">Email:</td>
<td><input type="email" name="Email" placeholder="email" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Active:</td>
<td><input <?php if (!(strcmp($row_fmEmployee['Active'],1))) {echo "checked=\"checked\"";} ?> name="Active" type="checkbox" value="1" checked="checked" /></td>
</tr>
</table>
</li>

<li id="onecoment">
<textarea name="Comments" id="Comments" placeholder="comments" cols="30" rows="17"><?php echo $row_fmEditEmployee['Comments']; ?></textarea></td>
</li>
</ui>
</div>
</fieldset>

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table width="100%" class="tddataleft">
<tr>
<td class="tddataright">Social Security:</td>
<td><input type="text" name="Social_Security" placeholder="###-##-####" value="" size="20" /></td>
<td class="tddataright">Work Phone:</td>
<td><input type="text" name="Work_Phone" placeholder="phone" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Department:</td>
<td><input type="text" name="Department" value="" size="20" /></td>
<td class="tddataright">Cell Phone:</td>
<td><input type="text" name="Cell_Phone" placeholder="phone" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Title:</td>
<td><input type="text" name="Title" value="" size="20" /></td>
<td class="tddataright">Manager:</td>
<td><input type="text" name="Manager" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
<td>&nbsp;</td>
<td class="tddataright">Country:</td>
<td><input type="text" name="Country" value="" size="20" /></td>
</tr>
</table>
<p>&nbsp;</p>
</fieldset>

<div id="divsubmit">
<input type="submit" value="Insert record" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
<input type="hidden" name="MM_insert" value="forminsert" />
<input type="hidden" name="EmployeeNo" id="EmployeeNo" value="<?php echo $row_fmEmployee['EmployeeNo']; ?>" />
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
mysql_free_result($fmEmployee);
mysql_free_result($fmCity);
?>