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
  $insertSQL = sprintf("INSERT INTO Vendors (VendorNo, `Vendor Name`, Address, City, `State`, Zip, Phone, Phone1, Phone2, Phone3, PhoneCmbo, PhoneCmbo1, PhoneCmbo2, PhoneCnbo3, Email, `Web Page`, Department, Office, Manager, Profession, `Assistant`, Comments, Active) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['VendorNo'], "int"),
                       GetSQLValueString($_POST['Vendor_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Phone1'], "text"),
                       GetSQLValueString($_POST['Phone2'], "text"),
                       GetSQLValueString($_POST['Phone3'], "text"),
                       GetSQLValueString($_POST['Lookupphone'], "text"),
                       GetSQLValueString($_POST['Lookupphone2'], "text"),
                       GetSQLValueString($_POST['Lookupphone3'], "text"),
                       GetSQLValueString($_POST['Lookupphone4'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Web_Page'], "text"),
                       GetSQLValueString($_POST['Department'], "text"),
                       GetSQLValueString($_POST['Office'], "text"),
                       GetSQLValueString($_POST['Manager'], "text"),
                       GetSQLValueString($_POST['Profession'], "text"),
                       GetSQLValueString($_POST['Assistant'], "text"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Active'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "VendorTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//Checkbox
if ($_GET['Active'] == "1")  { 
$t1v="checked";
setcookie("Vendor1", "", time()+3600); 
} else {
$t1v=="";
setcookie("Vendor1", "Active Vendors", time()+3600);
}
//City
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Vendor
$maxRows_fmVendor = 25;
$pageNum_fmVendor = 0;
if (isset($_GET['pageNum_fmVendor'])) {
  $pageNum_fmVendor = $_GET['pageNum_fmVendor'];
}
$startRow_fmVendor = $pageNum_fmVendor * $maxRows_fmVendor;

$Search_fmVendor = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmVendor = $_REQUEST['Search'];
}
$colname1_fmVendor = "%";
if (isset($_GET['SelectProf'])) {
  $colname1_fmVendor = $_GET['SelectProf'];
}
$colname_fmVendor = "0";
if (isset($_GET['Active'])) {
  $colname_fmVendor = $_GET['Active'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmVendor = sprintf("SELECT * FROM Vendors WHERE (Vendors.VendorNo LIKE %s OR Vendors.`Vendor Name` LIKE %s OR Vendors.Address LIKE %s OR Vendors.City LIKE %s OR Vendors.Phone LIKE %s OR Vendors.Email LIKE %s) AND Vendors.Profession LIKE %s AND Vendors.Active >= %s ORDER BY Vendors.`Vendor Name`", GetSQLValueString($Search_fmVendor, "text"),GetSQLValueString($Search_fmVendor, "text"),GetSQLValueString($Search_fmVendor, "text"),GetSQLValueString($Search_fmVendor, "text"),GetSQLValueString($Search_fmVendor, "text"),GetSQLValueString($Search_fmVendor, "text"),GetSQLValueString($colname1_fmVendor, "text"),GetSQLValueString($colname_fmVendor, "int"));
$query_limit_fmVendor = sprintf("%s LIMIT %d, %d", $query_fmVendor, $startRow_fmVendor, $maxRows_fmVendor);
$fmVendor = mysql_query($query_limit_fmVendor, $Leadbook) or die(mysql_error());
$row_fmVendor = mysql_fetch_assoc($fmVendor);

if (isset($_GET['totalRows_fmVendor'])) {
  $totalRows_fmVendor = $_GET['totalRows_fmVendor'];
} else {
  $all_fmVendor = mysql_query($query_fmVendor);
  $totalRows_fmVendor = mysql_num_rows($all_fmVendor);
}
$totalPages_fmVendor = ceil($totalRows_fmVendor/$maxRows_fmVendor)-1;

$queryString_fmVendor = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmVendor") == false && 
        stristr($param, "totalRows_fmVendor") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmVendor = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmVendor = sprintf("&totalRows_fmVendor=%d%s", $totalRows_fmVendor, $queryString_fmVendor);

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
<title>Vendor Listing</title>

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
</style><!--[if IE 5]>
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
function reload(form)  
{var val=form.SelectProf.options[form.SelectProf.options.selectedIndex].value ;
self.location='VendorTable.php?SelectProf=' + val ; 
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
<h1>Vendors Online</h1>
</hgroup>
<!-- end #header --></header>

<section id="sidebar1">
<?php
if ($_GET['Active'] == "1") 
echo "Viewing  " . $_COOKIE["Vendor1"] . "!<br />" ;
else
echo "Viewing all Vendors!<br />";
?> 

<form id="form6" name="form6" method="get" action="VendorTable.php">
<input name="Search" type="text" id="Search" autofocus value="Search<?php echo $_REQUEST['Search']; ?>" size="18" />
<button class="magglass"type="submit"><img src="images/magglass.png" alt="Search"></button>
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

<div><button class="tableheader"type="submit">Records <?php echo ($startRow_fmVendor + 1) ?> to <?php echo min($startRow_fmVendor + $maxRows_fmVendor, $totalRows_fmVendor) ?> of <?php echo $totalRows_fmVendor ?></button></div> 

<div><button class="tableheader"type="submit">Print Customers</button></div> 
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<form id="form5" name="form5" method="post">
<input name="button2" type="submit" id="button2" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmEditVendor['Address'] ?>, <?php echo $row_fmEditVendor['City'] ?>, <?php echo $row_fmEditVendor['State'] ?>, <?php echo $row_fmEditVendor['Zip'] ?>'); return document.MM_returnValue;" value="Get Map" />
</form>

<form id="form8" name="form8" method="get" action="VendorTable.php">
<p><button class="tableheader"type="submit">Search Vendors</button></p>
<p><input name="Active" type="checkbox" id="mycheckbox" value= "1" <?php echo $t1v ?> onclick="submit()"/> Active Vendor</p>
</form>
<p><button class="tableheader"type="submit">Active Profession</button></p>
<form id="form4" name="form4" method="get">
<select name="SelectProf" id="SelectProf" onchange="reload(this.form)">
<option selected="selected">select from menu</option>
<option>Windows</option>
<option>Siding</option>
<option>Gutters</option>
<option>Roofing</option>
<option>Doors</option>
<option>Garage Doors</option>
<option>Subcontractor</option>
<option>Building Supply</option>
<option>Rubbish Removal</option>
<option>Auto</option>
<option>Lawyer</option>
<option>Insurance</option>
<option>Banking</option>
<option>Advertising</option>
<option>Printing</option>
</select>
</form>
<!-- end #sidebar1 --></section>

<header>
<div id="titlerepeat">Admin:Vendor Listings</div>
</header>
<aside id="mainContent" class="tddataleft">

<div id="addnew">
<?php if ($totalRows_fmVendor == 0) { // Show if recordset empty ?>
There are no vendors defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmVendor > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Vendor Type</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Vendor Listing</li>
<li class="TabbedPanelsTab"> New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table id="nav">
<tr>
<td><?php if ($pageNum_fmVendor > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmVendor=%d%s", $currentPage, 0, $queryString_fmVendor); ?>">First</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmVendor > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmVendor=%d%s", $currentPage, max(0, $pageNum_fmVendor - 1), $queryString_fmVendor); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmVendor < $totalPages_fmVendor) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmVendor=%d%s", $currentPage, min($totalPages_fmVendor, $pageNum_fmVendor + 1), $queryString_fmVendor); ?>">Next</a>
<?php } // Show if not last page ?>
</td>
<td><?php if ($pageNum_fmVendor < $totalPages_fmVendor) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmVendor=%d%s", $currentPage, $totalPages_fmVendor, $queryString_fmVendor); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
</table>

<table width="100%" id="delform">
<tr>
<th><span>Name</span></th>
<th><span>Address</span></th>
<th><span>City</span></th>
<th><span>Phone</span></th>
<th><span>Active</span></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th><input name="ContactNo" type="hidden" id="ContactNo" /></th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td nowrap="nowrap"><?php echo $row_fmVendor['Vendor Name']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmVendor['Address']; ?></td>
<td><?php echo $row_fmVendor['City']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmVendor['Phone']; ?></td>
<td><?php echo $row_fmVendor['Active']; ?></td>
<td><a href="VendorEdit.php?VendorNo=<?php echo $row_fmVendor['VendorNo']; ?>">edit</a></td>
<td><a href="DeleteAddress.php?VendorNo=<?php echo $row_fmVendor['VendorNo']; ?>">delete</a></td>
</tr>
<?php } while ($row_fmVendor = mysql_fetch_assoc($fmVendor)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<fieldset>
<legend>Vendor Info</legend>
<div id="threecoldiv">
<ui id="threecolul">
<li>
<table>
<tr>
<td class="tddataright">Vendor Name:</td>
<td><input type="text" name="Vendor_Name" placeholder="vendor name" value="" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Phone:</td>
<td><input type="text" name="Phone" placeholder="phone" value="" size="15" /> 
<select name="Lookupphone" id="Lookupphone">
<option value="" <?php if (!(strcmp("", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select><br />
<label>(###)###-####</label></td>
</tr>
<tr>
<td class="tddataright">Phone1:</td>
<td><input type="text" name="Phone1" placeholder="phone 1" value="" size="15" />
<select name="Lookupphone2" id="Lookupphone2">
<option value="" <?php if (!(strcmp("", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select><br />
<label>(###)###-####</label></td>
</tr>
<tr>
<td class="tddataright">Phone2:</td>
<td><input type="text" name="Phone2" placeholder="phone 2" value="" size="15" />
<select name="Lookupphone3" id="Lookupphone3">
<option value="" <?php if (!(strcmp("", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select><br />
<label>(###)###-####</label></td>
</tr>
<tr>
<td class="tddataright">Phone3:</td>
<td><input type="text" name="Phone3" placeholder="phone 3" value="" size="15" />
<select name="Lookupphone4" id="Lookupphone4">
<option value="" <?php if (!(strcmp("", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select><br />
<label>(###)###-####</label></td>
</tr>
<tr>
  <td class="tddataright">Email:</td>
  <td><input type="email" name="Email" placeholder="email" value="" size="25" /></td>
</tr>
<tr>
  <td class="tddataright">Web Page:</td>
  <td><input type="text" name="Web_Page" placeholder="web page" value="http://" size="25" /></td>
</tr>
<tr>
<td class="tddataright">Active:</td>
<td><input <?php if (!(strcmp($row_fmVendor['Active'],"Active"))) {echo "checked=\"checked\"";} ?> name="Active" type="checkbox" id="Active" value="1" checked="checked" /></td>
</tr>
</table>
</li>
<li id="onecoment">
<textarea name="Comments" id="Comments" placeholder="comment" cols="30" rows="20"><?php echo $row_fmVendor['Comments']; ?></textarea></td>
</li>
</ui>
</div>
</fieldset>

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table width="100%" class="tddataleft">
<tr>
<td align="right">Address:</td>
<td><input type="text" name="Address" value="" size="32" /></td>
<td class="tddataright">Profession:</td>
<td><input type="text" name="Profession" id="Profession" size="14" />
  <select name="SelectProfession" id="SelectProfession" onchange="favProfession()">
    <option selected="selected">Not assigned</option>
    <option>Windows</option>
    <option>Siding</option>
    <option>Gutters</option>
    <option>Roofing</option>
    <option>Doors</option>
    <option>Garage Doors</option>
    <option>Subcontractor</option>
    <option>Building Supply</option>
    <option>Rubbish Removal</option>
    <option>Auto</option>
    <option>Lawyer</option>
    <option>Insurance</option>
    <option>Banking</option>
    <option>Advertising</option>
    <option>Printing</option>
  </select></td>
</tr>
<tr>
<td class="tddataright">City:</td>
<td><select name="City" id="City" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $_GET['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
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
<td class="tddataright">Department:</td>
<td><input type="text" name="Department" value="" size="20" /></td>
</tr>
<tr>
  <td class="tddataright">State:</td>
  <td><input type="text" name="State" id="State" value="" size="10" /> <input type="text" name="Zip" id="Zip_Code" value="" size="10" /></td>
  <td class="tddataright">Office:</td>
  <td><input type="text" name="Office" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Assistant:</td>
<td><input type="text" name="Assistant" value="" size="20" /></td>
<td class="tddataright">Manager:</td>
<td><input type="text" name="Manager" value="" size="20" /></td>
</tr>
</table>
</fieldset>
<div id="divsubmit">
<input type="submit" value="Insert" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
<input type="hidden" name="MM_insert" value="forminsert" />
<input name="VendorNo" type="hidden" id="VendorNo" value="<?php echo $row_fmVendor['VendorNo']; ?>" />
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
mysql_free_result($fmVendor);

mysql_free_result($fmCity);
/*mysql_free_result($SearchLeads);*/
?>
