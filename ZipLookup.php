<?php require_once('Connections/Leadbook.php'); ?>
<?php
//die($_GET['Last_Name']);
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Leads (LeadNo, `Date`, `Last Name`, Address, City, `State`, `Zip Code`, Phone, `Apt date`, SalesNo, JobNo, C, Amount, AdNo, Coments, `Call Back`, Active, Email, `Time`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['LeadNo'], "int"),
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['LookupCity'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip_Code'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Apt_date'], "date"),
                       GetSQLValueString($_POST['LookupSalesman'], "int"),
                       GetSQLValueString($_POST['LookupJobNo'], "int"),
                       GetSQLValueString($_POST['C'], "text"),
                       GetSQLValueString($_POST['Amount'], "int"),
                       GetSQLValueString($_POST['LookupAdNo'], "int"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Call_Back'], "text"),
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Time'], "date"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "LeadTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//Zip
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = sprintf("SELECT * FROM Zip WHERE Zip.City LIKE %s ORDER BY Zip.City", GetSQLValueString($Search_fmCity, "text"));
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Search
$Search_fmCity = "%";
if (isset($_GET['Search'])) {
  $Search_fmCity = $_GET['Search'];
}

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>New Lead</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/CalendarPopup.js"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="assets/TableLead.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Addresstext.css" rel="stylesheet" type="text/css" />
<style type="text/css"> 
<!-- 
.style2 { font-size: 11px; }
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
var cal = new CalendarPopup();
</script>
</head>

<body class="twoColFixRtHdr" onload="setFocus()">

<div id="container">
<header id="header">
<hgroup>
<h1>&nbsp;</h1>
</hgroup>
<nav>
<ul id="MenuBar1" class="MenuBarHorizontal">
<li><a href="index.php">Home</a> </li>
<li><a href="#" class="MenuBarItemSubmenu">New</a>
    <ul>
      <li><a href="LeadInsert.php">New Lead</a></li>
      <li><a href="CustInsert.php">New Customer</a></li>
    </ul>
</li>
<li><a class="MenuBarItemSubmenu" href="#">View</a>
    <ul>
      <li><a href="LeadTable.php">Lead Listing</a> </li>
      <li><a href="CustTable.php">Customer Listing</a></li>
      <li><a href="ContactsTable.php">Contact Listing</a></li>
      <li><a href="EmployeeTable.php">Employee Listing</a></li>
      <li><a href="VendorTable.php">Vendor Listing</a></li>
      <li><a href="TaskTable.php">Task Listing</a></li>
      <li><a href="#" class="MenuBarItemSubmenu">Tools</a>
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
<!-- end #header --></header>
<section id="sidebar1">
<form id="form1" name="form1" method="get" action="ZipLookup.php">
<p>
<input name="Search" type="text" id="Search" value="<?php echo $_REQUEST['Search']; ?>" size="18" />
<input type="submit" value="Search" />
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

<!-- end #sidebar1 --></section>
<aside id="mainContent">
<header>
<h1 class="style1">&nbsp; </h1>
<h1 class="stylered">Admin:Zip Code Lookup</h1>
<h3>Complete the form below to add a new zip code type</h3> 
</header>
<p>&nbsp;</p>
    
<table  id="cart">
  <tr>
    <th><span class="style2">ZipNo</span></th>
    <th><span class="style2">City</span></th>
    <th><span class="style2">State</span></th>
    <th><span class="style2">Zip Code</span></th>
  </tr>
  <?php do { ?>
    <tr>
    <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
      <td><a href="LeadInsert.php?City=<?php echo $row_fmCity['City']; ?>&amp;State=<?php echo $row_fmCity['State']; ?>&amp;Zip=<?php echo $row_fmCity['Zip Code']; ?>" class="style2"><?php echo $row_fmCity['ZipNo']; ?></a></td>
      <td><span class="style2"><?php echo $row_fmCity['City']; ?></span></td>
      <td><span class="style2"><?php echo $row_fmCity['State']; ?></span></td>
      <td><span class="style2"><?php echo $row_fmCity['Zip Code']; ?></span></td>
    </tr>
    <?php } while ($row_fmCity = mysql_fetch_assoc($fmCity)); ?>
</table>
	<!-- end #mainContent --></aside>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <footer id="footer">
    <p>&copy;copyright 2010 Leadbook Software.dev</p>
  <!-- end #footer --></footer>
<!-- end #container --></div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmCity);
?>
