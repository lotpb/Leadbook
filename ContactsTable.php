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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO OtherNames (ContactNo, `First Name`, `Last Name`, Address, City, `State`, Zip, Phone, Phone1, Phone2, Phone3, PhoneCmbo, PhoneCmbo1, PhoneCmbo2, PhoneCmbo3, Nickname, `Spouse Name`, Birthday, Anniversary, Email, `Web Page`, Comments, Active) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ContactNo'], "int"),
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Phone1'], "text"),
                       GetSQLValueString($_POST['Phone2'], "text"),
                       GetSQLValueString($_POST['Phone3'], "text"),
                       GetSQLValueString($_POST['Lookupphone'], "text"),
                       GetSQLValueString($_POST['Lookupphone1'], "text"),
                       GetSQLValueString($_POST['Lookupphone2'], "text"),
                       GetSQLValueString($_POST['Lookupphone3'], "text"),
                       GetSQLValueString($_POST['Nickname'], "text"),
                       GetSQLValueString($_POST['Spouse_Name'], "text"),
                       GetSQLValueString($_POST['Birthday'], "date"),
                       GetSQLValueString($_POST['Anniversary'], "date"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Web_Page'], "text"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Active'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "ContactsTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//checkbox
if ($_GET['Active'] == "1")  { 
$t1v="checked";
setcookie("Contacts1", "", time()+3600); 
} else {
$t1v=="";
setcookie("Contacts1", "Active Contacts", time()+3600);
}
//Zip
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Contact
$maxRows_fmContact = 24;
$pageNum_fmContact = 0;
if (isset($_GET['pageNum_fmContact'])) {
  $pageNum_fmContact = $_GET['pageNum_fmContact'];
}
$startRow_fmContact = $pageNum_fmContact * $maxRows_fmContact;

$Search_fmContact = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmContact = $_REQUEST['Search'];
}
$var_fmContact = "0";
if (isset($_GET['Active'])) {
  $var_fmContact = $_GET['Active'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmContact = sprintf("SELECT * FROM OtherNames WHERE (OtherNames.`Last Name` LIKE %s OR OtherNames.`First Name` LIKE %s OR OtherNames.Address LIKE %s OR OtherNames.City LIKE %s OR OtherNames.Phone LIKE %s OR OtherNames.Email LIKE %s) AND (OtherNames.Active >= %s) ORDER BY OtherNames.`Last Name`", GetSQLValueString($Search_fmContact, "text"),GetSQLValueString($Search_fmContact, "text"),GetSQLValueString($Search_fmContact, "text"),GetSQLValueString($Search_fmContact, "text"),GetSQLValueString($Search_fmContact, "text"),GetSQLValueString($Search_fmContact, "text"),GetSQLValueString($var_fmContact, "int"));
$query_limit_fmContact = sprintf("%s LIMIT %d, %d", $query_fmContact, $startRow_fmContact, $maxRows_fmContact);
$fmContact = mysql_query($query_limit_fmContact, $Leadbook) or die(mysql_error());
$row_fmContact = mysql_fetch_assoc($fmContact);

if (isset($_GET['totalRows_fmContact'])) {
  $totalRows_fmContact = $_GET['totalRows_fmContact'];
} else {
  $all_fmContact = mysql_query($query_fmContact);
  $totalRows_fmContact = mysql_num_rows($all_fmContact);
}
$totalPages_fmContact = ceil($totalRows_fmContact/$maxRows_fmContact)-1;

$queryString_fmContact = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmContact") == false && 
        stristr($param, "totalRows_fmContact") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmContact = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmContact = sprintf("&totalRows_fmContact=%d%s", $totalRows_fmContact, $queryString_fmContact);

$currentPage = $_SERVER["PHP_SELF"]; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Contact Listing</title>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/xpath.js" type="text/javascript"></script>
<script src="SpryAssets/SpryData.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/CalendarPopup.js"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
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
var cal = new CalendarPopup()
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
<h1>Contacts Online</h1>
</hgroup>

<!-- end #header --></header>
<section id="sidebar1">
<?php
if ($_GET['Active'] == "1")
echo "Viewing  " . $_COOKIE["Contacts1"] . "!<br />" ;
else
echo "Viewing all Contacts!<br />";
?>  
<form id="form6" name="form6" method="get" action="ContactsTable.php">
<input name="Search" type="text" id="Search" autofocus value="Search<?php echo $_REQUEST['Search']; ?>" size="18" />
<button class="magglass"type="submit"><img src="images/magglass.png" alt="Search" /></button>
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

<div><button class="tableheader"type="submit">Records <?php echo ($startRow_fmContact + 1) ?> to <?php echo min($startRow_fmContact + $maxRows_fmContact, $totalRows_fmContact) ?> of <?php echo $totalRows_fmContact ?></button></div> 

<form id="form5" name="form5" method="post">
  <input name="button2" type="submit" id="button2" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmEditContact['Address'] ?>, <?php echo $row_fmEditContact['City'] ?>, <?php echo $row_fmEditContact['State'] ?>, <?php echo $row_fmEditContact['Zip'] ?>'); return document.MM_returnValue;" value="Get Map" />
</form>

<form id="form2" name="form2" method="post">
  <input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<form id="form4" name="form4" method="get" action="ContactsTable.php">
<p><button class="tableheader"type="submit">Search Contacts</button></p>
<p><input name="Active" type="checkbox" id="mycheckbox" value= "1" <?php echo $t1v ?> onclick="submit()"/> Active Contacts</p><!--disabled="true" checked="checked"-->
</form>
<!-- end #sidebar1 --></section>
<header>
<div id="titlerepeat">Admin:Contacts Listing</div>
</header>
<aside id="mainContent" class="tddataleft">

<div id="addnew">
<?php if ($totalRows_fmContact == 0) { // Show if recordset empty ?>
There are no contacts defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmContact > 0) { // Show if recordset not empty ?>
<a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Contact Type</a>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Contact Listing</li>
<li class="TabbedPanelsTab"> New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table id="nav">
<tr>
<td><?php if ($pageNum_fmContact > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmContact=%d%s", $currentPage, 0, $queryString_fmContact); ?>">First</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmContact > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmContact=%d%s", $currentPage, max(0, $pageNum_fmContact - 1), $queryString_fmContact); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmContact < $totalPages_fmContact) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmContact=%d%s", $currentPage, min($totalPages_fmContact, $pageNum_fmContact + 1), $queryString_fmContact); ?>">Next</a>
<?php } // Show if not last page ?>
</td>
<td><?php if ($pageNum_fmContact < $totalPages_fmContact) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmContact=%d%s", $currentPage, $totalPages_fmContact, $queryString_fmContact); ?>">Last</a>
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
<th><span>Email</span></th>
<th>&nbsp;</th>
<th><input name="ContactNo" type="hidden" id="ContactNo" value="<?php echo $row_fmContact['ContactNo']; ?>" /></th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmContact['First Name']; ?> <?php echo $row_fmContact['Last Name']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmContact['Address']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmContact['City']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmContact['Phone']; ?></td>
<td><?php echo $row_fmContact['Email']; ?></td>
<td><a href="ContactsEdit.php?ContactNo=<?php echo $row_fmContact['ContactNo']; ?>">edit</a></td>
<td><a href="DeleteAddress.php?ContactNo=<?php echo $row_fmContact['ContactNo']; ?>">delete</a></td>
</tr>
<?php } while ($row_fmContact = mysql_fetch_assoc($fmContact)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<fieldset>
<legend>Contact Info</legend>

<div id="threecoldiv">
<ui id="threecolul">
<li>
<table class="tddataleft">
<tr>
<td class="tddataright">First Name:</td>
<td><input type="text" name="First_Name" placeholder="first name" value="" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Last Name:</td>
<td><input type="text" name="Last_Name" placeholder="last name" value="" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Phone:</td>
<td>
<input type="text" name="Phone" placeholder="(555)555-5555" value="" size="15" />
<select name="Lookupphone" id="Lookupphone">
<option value="" <?php if (!(strcmp("", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmContact['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select>
</td>
</tr>
<tr>
<td class="tddataright">Phone1:</td>
<td><input type="text" name="Phone1" placeholder="(555)555-5555" value="" size="15" />
<select name="Lookupphone1" id="Lookupphone1">
<option value="" <?php if (!(strcmp("", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmContact['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select>
</td>
</tr>
<tr>
<td class="tddataright">Phone2:</td>
<td><input type="text" name="Phone2" placeholder="(555)555-5555" value="" size="15" />
<select name="Lookupphone2" id="Lookupphone2">
<option value="" <?php if (!(strcmp("", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmContact['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select>
</td>
</tr>
<tr>
<td class="tddataright">Phone3:</td>
<td><input type="text" name="Phone3" placeholder="(555)555-5555" value="" size="15" />
<select name="Lookupphone3" id="Lookupphone3">
<option value="" <?php if (!(strcmp("", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmContact['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select>
</td>
</tr>
<tr>
  <td class="tddataright">Email:</td>
  <td><input type="email" name="Email" placeholder="email" value="" size="32" /></td>
</tr>
<tr>
  <td class="tddataright">Web Page:</td>
  <td><input type="url" name="Web_Page" value="http://" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Active:</td>
<td><input <?php if (!(strcmp($row_fmContact['Active'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="Active" value="1" checked="checked" /></td>
</tr>
</table>
</li>

<li id="onecoment">
<textarea name="Comments" id="Comments" placeholder="comments" cols="30" rows="20"><?php echo $row_fmContact['Comments']; ?></textarea>
</li>
</ui>
</div>
</fieldset>

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table width="100%">
<tr>
<td class="tddataright">Address:</td>
<td><input type="text" name="Address" value="" size="32" /></td>
<td>Nickname:</td>
<td><input type="text" name="Nickname" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">City:</td>
<td><select name="City" id="City" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $_GET['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do {  ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $_GET['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php
} while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity);
}
?>
</select><a href="ZipLookup.php">select</a></td>
<td>Spouse Name:</td>
<td><input type="text" name="Spouse_Name" value="" size="20" /></td>
</tr>
<tr>
<td class="tddataright">State:</td>
<td><input type="text" name="State" id="State" value="" size="10" /></td>
<td>Birthday:</td>
<td><input type="text" name="Birthday" value="" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Birthday,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor2">select</a></td>
</tr>
<tr>
<td class="tddataright">Zip:</td>
<td><input type="text" name="Zip" id="Zip_Code" value="" size="10" /></td>
<td>Anniversary:</td>
<td><input type="text" name="Anniversary" value="" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Anniversary,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">select</a></td>
</tr>
</table>
</fieldset>

<div id="divsubmit">
<input type="submit" value="Insert" />
<input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" />
<input type="hidden" name="MM_insert" value="forminsert" />
<input name="ContactNo" type="hidden" id="ContactNo" value="<?php echo $row_fmContact['ContactNo']; ?>" />
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
mysql_free_result($fmContact);

mysql_free_result($fmCity);
?>
