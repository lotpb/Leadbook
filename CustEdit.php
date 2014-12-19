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
  $updateSQL = sprintf("UPDATE Customer SET LeadNo=%s, `Date`=%s, Address=%s, City=%s, `State`=%s, `Zip Code`=%s, Phone=%s, Quan=%s, JobNo=%s, Amount=%s, `Start Date`=%s, `Completion Date`=%s, SalesNo=%s, Comments=%s, ProductNo=%s, Active=%s, Rate=%s, `Contractor`=%s, Photo=%s, Photo1=%s, Photo2=%s, Email=%s, `First`=%s, Spouse=%s WHERE CustNo=%s",
                       GetSQLValueString($_POST['LeadNo'], "int"),
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip_Code'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Quan'], "int"),
                       GetSQLValueString($_POST['JobNo'], "int"),
                       GetSQLValueString($_POST['Amount'], "int"),
                       GetSQLValueString($_POST['Start_Date'], "date"),
                       GetSQLValueString($_POST['Completion_Date'], "date"),
                       GetSQLValueString($_POST['SaleNo'], "int"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['ProductNo'], "int"),
                       GetSQLValueString($_POST['Active'], "int"),
                       GetSQLValueString($_POST['Rate'], "text"),
                       GetSQLValueString($_POST['Contractor'], "text"),
                       GetSQLValueString($_POST['Photo'], "text"),
                       GetSQLValueString($_POST['Photo1'], "text"),
                       GetSQLValueString($_POST['Photo2'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['First'], "text"),
                       GetSQLValueString($_POST['Spouse'], "text"),
                       GetSQLValueString($_POST['CustNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "CustTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//Zip
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Job
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmJob = "SELECT * FROM Job ORDER BY Job.`Description`";
$fmJob = mysql_query($query_fmJob, $Leadbook) or die(mysql_error());
$row_fmJob = mysql_fetch_assoc($fmJob);
$totalRows_fmJob = mysql_num_rows($fmJob);
//Saleman
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmSalesman = "SELECT * FROM Salesman ORDER BY Salesman.Salesman";
$fmSalesman = mysql_query($query_fmSalesman, $Leadbook) or die(mysql_error());
$row_fmSalesman = mysql_fetch_assoc($fmSalesman);
$totalRows_fmSalesman = mysql_num_rows($fmSalesman);
//Products
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmProducts = "SELECT * FROM Product ORDER BY Product.Products";
$fmProducts = mysql_query($query_fmProducts, $Leadbook) or die(mysql_error());
$row_fmProducts = mysql_fetch_assoc($fmProducts);
$totalRows_fmProducts = mysql_num_rows($fmProducts);
//Leads
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeads = "SELECT * FROM Leads ORDER BY Leads.`Last Name`";
$fmLeads = mysql_query($query_fmLeads, $Leadbook) or die(mysql_error());
$row_fmLeads = mysql_fetch_assoc($fmLeads);
$totalRows_fmLeads = mysql_num_rows($fmLeads);
//Customer
if (isset($_GET['CustNo'])) {
  $colname_fmCustomer = $_GET['CustNo'];
}
$colname_fmCustomer = "-1";
if (isset($_GET['CustNo'])) {
  $colname_fmCustomer = $_GET['CustNo'];
}
$colname1_fmCustomer = "-1";
if (isset($_GET['LeadNo'])) {
  $colname1_fmCustomer = $_GET['LeadNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustomer = sprintf("SELECT * FROM Customer WHERE Customer.CustNo = %s or Customer.LeadNo = %s", GetSQLValueString($colname_fmCustomer, "int"),GetSQLValueString($colname1_fmCustomer, "int"));
$fmCustomer = mysql_query($query_fmCustomer, $Leadbook) or die(mysql_error());
$row_fmCustomer = mysql_fetch_assoc($fmCustomer);
$totalRows_fmCustomer = mysql_num_rows($fmCustomer);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Customer Edit</title>
<meta charset="utf-8" />
<link rel="icon" href="favicon.ico">

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="assets/CalendarPopup.js" type="text/javascript" ></script>
<script src="assets/functions.js" type="text/javascript"></script>
<script src="//maps.googleapis.com/maps/api/js?libraries=weather&sensor=false" type="text/javascript"></script>
<link href="Stylesheets/CharMenu.css" rel="stylesheet" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" type="text/css">

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
var cal = new CalendarPopup();

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
  
function initializeCust() {
directionsDisplay = new google.maps.DirectionsRenderer();
var geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(-34.397, 150.644);
var address = '<?php echo $row_fmCustomer['Address'].', '.$row_fmCustomer['City'].', '.$row_fmCustomer['State'].', '.$row_fmCustomer['Zip Code']; ?>';
/*Options*/
var myOptions = {
center: latlng,
zoom: 15,
mapTypeId: google.maps.MapTypeId.ROADMAP
}
/*Geocoder*/
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
/*map.setCenter(results[0].geometry.location);*/
myOptions.center = results[0].geometry.location;

map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
directionsDisplay.setMap(map);
var marker = new google.maps.Marker({
	position: results[0].geometry.location,
    map: map,
});
/*Info*/
var infowindow =  new google.maps.InfoWindow({
content: 'Hello World!',
map: map
});

var weatherLayer = new google.maps.weather.WeatherLayer({
  temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT
});
weatherLayer.setMap(map);

var cloudLayer = new google.maps.weather.CloudLayer();
cloudLayer.setMap(map);

/*Listener*/
google.maps.event.addListener(marker, 'click', function() {
infowindow.open(map, this);
});

google.maps.event.addListener(weatherLayer, 'click', function(e) {
  alert('The current temperature at ' + e.featureDetails.location + ' is '
        + e.featureDetails.current.temperature + ' degrees.');
});

} else {
  alert("Geocode was not successful for the following reason: " + status);
  }
});
}

function calcRoute() {
  var start = document.getElementById("start").value;
  var end = document.getElementById("end").value;
  var request = {
  origin:start,
  destination:end,
    travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
}
-->
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
<h1>Customer Edit</h1>
</hgroup>
<!-- end #header --></header>

<section id="sidebar1">
<div><button class="tableheader"type="submit">Print Customers</button></div> 
<form id="form3" name="form3" method="post">
<input type="submit" name="button3" id="button3" value="Print" onclick="printpage()" />
</form>

<form id="form4" name="form4" method="post">
<input type="button" name="emailbutton" id="emailbutton" value="Email" onclick="parent.location='mailto:<?php echo $row_fmCustomer['Email']; ?>?subject=Thank you for using United&amp;cc=eunitedws@verizon.net.com'" />
</form>

<form id="form2" name="form2" method="post" >
<input name="map" type="submit" id="map" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmCustomer['Address'] ?>, <?php echo $row_fmCustomer['City'] ?>, <?php echo $row_fmCustomer['State'] ?>, <?php echo $row_fmCustomer['Zip Code'] ?>'); return document.MM_returnValue;" value="Get Map" />     
</form><br />

<!--Uploadfile Sample below dont work-->
 <form enctype="multipart/form-data" action="upload.php" method="post"> 
 <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
 <input type="hidden" value="<?php echo $row_fmCustomer['CustNo']; ?>" name="name" />
 <input type="hidden" value="Customer" name="tablepic" />
 <input type="hidden" value="CustNo" name="fieldpic" />
<!-- <input type="hidden" value="Photo" name="photopic" />-->
 Photo:
 <input type="file" name="Photo" /><br /> 
 <input type="submit" value="Upload" /> 
 </form>
 
<div><button class="tableheader" type="submit">View Orders</button></div>
<select name="Repeat" id="Repeat" onchange="showRepeat(this.value)">
<option value="">Select Orders:</option>
<option value="<?php echo $row_fmCustomer['LeadNo']; ?>">Customer Orders</option>
<option value="<?php echo $row_fmCustomer['LeadNo']; ?>">Total Customer Orders</option>
<option value="<?php echo $row_fmCustomer['Address']; ?>">Same Customer Address</option>
</select>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="3YNEZFSSJNVR4">
<input type="hidden" name="on0" value="service price">
service price<input type="text" name="os0" maxlength="200">

<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt=""  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></form>

<!--Uploadfile Sample above dont work-->   
<!-- end #sidebar1 --></section>

<aside id="mainContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">

<header id="divrepeat">
<div id="txtrepeat"><b>Order info will be listed here.</b></div>
</header>

<section id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Customer Info</li>
    <li class="TabbedPanelsTab" tabindex="1" onclick="initializeCust()">Photo/Map</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
<section class="TabbedPanelsContent">
<fieldset>
<legend>Customer Info</legend>
<table id="maintable">
<tr>
<td class="tddataright">Date:</td>
<td>
<input type="date" name="Date" id="Date" value="<?php echo $row_fmCustomer['Date']; ?>" size="15"/>
<a href="#" onclick="cal.select(document.forms[0].Date,'anchor4','yyyy-MM-dd'); return false;" name="anchor4" id="anchor4">select</a></td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
</tr>
<tr>
<td class="tddataright">Last Name:</td>
<td><select name="LeadNo" class="tableheader" id="LeadNo">
  <option value="" <?php if (!(strcmp("", $row_fmCustomer['LeadNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
  <?php do { ?>
  <option value="<?php echo $row_fmLeads['LeadNo']?>" <?php if (!(strcmp($row_fmLeads['LeadNo'], $row_fmCustomer['LeadNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmLeads['Last Name']?></option>
  <?php
} while ($row_fmLeads = mysql_fetch_assoc($fmLeads));
$rows = mysql_num_rows($fmLeads);
if($rows > 0) {
mysql_data_seek($fmLeads, 0);
$row_fmLeads = mysql_fetch_assoc($fmLeads); } ?>
</select> </td></tr>

<tr>
<td class="tddataright">Address:</td>
<td>
<input type="text" name="Address" id="Address" value="<?php echo htmlentities($row_fmCustomer['Address'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>

<tr>
<td class="tddataright">&nbsp;</td>
<td><select name="City" id="City" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $row_fmCustomer['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $row_fmCustomer['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php
} while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity); } ?>
</select> <input type="text" name="State" id="State" value="<?php echo htmlentities($row_fmCustomer['State'], ENT_COMPAT, 'UTF-8'); ?>" size="05" /> <input type="text" name="Zip_Code" id="Zip_Code" value="<?php echo htmlentities($row_fmCustomer['Zip Code'], ENT_COMPAT, 'UTF-8'); ?>" size="13" /></td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
</tr>

<tr>
<td class="tddataright">Phone:</td>
<td>
<input type="text" name="Phone" placeholder="(555)555-5555" value="<?php echo htmlentities($row_fmCustomer['Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="15" /></td>
</tr>

<tr>
<td class="tddataright">SalesNo:</td>
<td>
<select name="SaleNo" id="SaleNo">
<option value="" <?php if (!(strcmp("", $row_fmCustomer['SalesNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do {  ?>
<option value="<?php echo $row_fmSalesman['SalesNo']?>"<?php if (!(strcmp($row_fmSalesman['SalesNo'], $row_fmCustomer['SalesNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmSalesman['Salesman']?></option>
<?php } while ($row_fmSalesman = mysql_fetch_assoc($fmSalesman));
$rows = mysql_num_rows($fmSalesman);
if($rows > 0) {
mysql_data_seek($fmSalesman, 0);
$row_fmSalesman = mysql_fetch_assoc($fmSalesman); } ?>
</select>
</td></tr>

<tr>
<td class="tddataright">JobNo:</td>
<td>
<select name="JobNo" id="JobNo">
<option value="" <?php if (!(strcmp("", $row_fmCustomer['JobNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmJob['JobNo']?>"<?php if (!(strcmp($row_fmJob['JobNo'], $row_fmCustomer['JobNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmJob['Description']?></option>
<?php } while ($row_fmJob = mysql_fetch_assoc($fmJob));
$rows = mysql_num_rows($fmJob);
if($rows > 0) {
mysql_data_seek($fmJob, 0);
$row_fmJob = mysql_fetch_assoc($fmJob); } ?>
</select>
</td></tr>

<tr>
<td class="tddataright">Qty:</td>
<td>
<input type="number" min="0" max="10000000" step="1" name="Quan" placeholder="# windows" value="<?php echo htmlentities($row_fmCustomer['Quan'], ENT_COMPAT, 'UTF-8'); ?>" size="10" /></td>
</tr>

<tr>
<td class="tddataright">ProductNo:</td>
<td>
<select name="ProductNo" id="ProductNo">
<option value=""<?php if (!(strcmp("", $row_fmCustomer['ProductNo']))) {echo "selected=\"selected\"";} ?>> Select from menu</option>
<?php do {  ?>
<option value="<?php echo $row_fmProducts['ProductNo']?>"<?php if (!(strcmp($row_fmProducts['ProductNo'], $row_fmCustomer['ProductNo']))) {echo "selected=\"selected\"";} ?> > <?php echo $row_fmProducts['Products']?></option>
<?php } 
while ($row_fmProducts = mysql_fetch_assoc($fmProducts));
$rows = mysql_num_rows($fmProducts);
if($rows > 0) {
mysql_data_seek($fmProducts, 0); $row_fmProducts = mysql_fetch_assoc($fmProducts); } ?>
</select>
</td></tr>

<tr>
<td class="tddataright">Amount:</td>
<td><input type="text" name="Amount" value="<?php echo htmlentities($row_fmCustomer['Amount'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
</td>
</tr>

<tr>
<td class="tddataright" valign="top">Comment:</td>
<td><textarea name="Comments" id="Comments" autofocus placeholder="comments" cols="40" rows="5"><?php echo htmlentities($row_fmCustomer['Comments'], ENT_COMPAT, 'UTF-8'); ?></textarea></td> 
</tr>
</table>
     
<!--table 3 start-->
<table width="33%">
<tr><td>
<div class="picdiv">
<?php if (!empty($row_fmCustomer["Photo"])) { ?>
<img src="/upload/<?php echo $row_fmCustomer['Photo']; ?>" alt="Image" width="250" height="350" />
<?php } else { ?>
<img  src="/images/NopicNew.jpg" alt="Image" width="250" height="350" />
<?php } ?> </div>
</td></tr>

<td>
<input type="text" name="Photo" placeholder="photo" value="<?php echo htmlentities($row_fmCustomer['Photo'], ENT_COMPAT, 'UTF-8'); ?>" size="26" />
</td>
<tr><td align="Center">Active:
<input type="checkbox" name="Active" value="1" <?php if (!(strcmp($row_fmCustomer['Active'],1))) {echo "checked=\"checked\"";} ?> />
</td></tr>
</table>
<!--table 3 end-->   
</fieldset> 

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table id="infotable" width="100%">

<tr>
<td class="tddataright">First Name:</td>
<td><input type="text" name="First" placeholder="first Name" value="<?php echo htmlentities($row_fmCustomer['First'], ENT_COMPAT, 'UTF-8'); ?>" size="20" />
</td>
<td class="tddataright"></td>
<td>
<input type="date" name="Start_Date" id="Start_Date" placeholder="start date" value="<?php echo htmlentities($row_fmCustomer['Start Date'], ENT_COMPAT, 'UTF-8'); ?>" size="17" />
<a href="#" onclick="cal.select(document.forms[0].Start_Date,'anchor2','yyyy-MM-dd'); return false;" name="anchor2" id="anchor2">select</a>

<input type="date" name="Completion_Date" id="Completion_Date" placeholder="complete date" value="<?php echo htmlentities($row_fmCustomer['Completion Date'], ENT_COMPAT, 'UTF-8'); ?>" size="17" />
<a href="#" onclick="cal.select(document.forms[0].Completion_Date,'anchor3','yyyy-MM-dd'); return false;" name="anchor3" id="anchor3">select</a></td>
</tr>

<tr>
<td class="tddataright">Spouse:</td>
<td>
<input type="text" name="Spouse" placeholder="spouse" value="<?php echo htmlentities($row_fmCustomer['Spouse'], ENT_COMPAT, 'UTF-8'); ?>" size="20" />
</td>
<td></td>
<td><span class="tddataright"><select name="selectcontractor" id="selectcontractor" onchange="favContractor()">
<option selected="selected">Contractor:</option>
<option value="Jose Rosa">Jose Rosa</option>
<option value="John Kat Windows">John Kat Windows</option>
<option value="Ashland Home Improvement">Ashland Home</option>
<option value="Islandwide Gutters">Islandwide</option>
</select></span> <input type="text" name="Contractor" id="Contractor" value="<?php echo htmlentities($row_fmCustomer['Contractor'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td></tr>

<tr>
<td class="tddataright">Email:</td>
<td><input type="email" name="Email" placeholder="valid email address" value="<?php echo htmlentities($row_fmCustomer['Email'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>

<td class="tddataright"> </td>
<td>

<span class="tddataright"><select name="selectrate" id="selectrate" onchange="favRate()">
<option selected="selected">Rate:</option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>
</select></span> <input type="text" name="Rate" id="Rate" placeholder="rate" value="<?php echo htmlentities($row_fmCustomer['Rate'], ENT_COMPAT, 'UTF-8'); ?>" size="5" /></td></tr>

</table>
</fieldset>
<div id="divsubmit">
<input type="hidden" name="CustNo" value="<?php echo $row_fmCustomer['CustNo']; ?>" />
<input type="hidden" name="MM_update" value="formEdit" />
<input type="submit" value="Update" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
</div>
</section>

<section class="TabbedPanelsContent">
<div>
<strong>Start: </strong>
<select id="start" onchange="calcRoute();">
  <option value="1142 Hicksville Road, Massapequa, NY">Home</option>
  <option value="chicago, il">Chicago</option>
  <option value="st louis, mo">St Louis</option>
  <option value="joplin, mo">Joplin, MO</option>
  <option value="oklahoma city, ok">Oklahoma City</option>
  <option value="amarillo, tx">Amarillo</option>
  <option value="gallup, nm">Gallup, NM</option>
  <option value="flagstaff, az">Flagstaff, AZ</option>
  <option value="winona, az">Winona</option>
  <option value="kingman, az">Kingman</option>
  <option value="barstow, ca">Barstow</option>
  <option value="san bernardino, ca">San Bernardino</option>
  <option value="los angeles, ca">Los Angeles</option>
</select>
<strong>End: </strong>
<select id="end" onchange="calcRoute();">
  <option value="">Pick Destination</option>
  <option value="<?php echo $row_fmCustomer['Address'].', '.$row_fmCustomer['City'].', '.$row_fmCustomer['State']; ?>">Current Address</option>
  <option value="chicago, il">Chicago</option>
  <option value="st louis, mo">St Louis</option>
  <option value="joplin, mo">Joplin, MO</option>
  <option value="oklahoma city, ok">Oklahoma City</option>
  <option value="amarillo, tx">Amarillo</option>
  <option value="gallup, nm">Gallup, NM</option>
  <option value="flagstaff, az">Flagstaff, AZ</option>
  <option value="winona, az">Winona</option>
  <option value="kingman, az">Kingman</option>
  <option value="barstow, ca">Barstow</option>
  <option value="san bernardino, ca">San Bernardino</option>
  <option value="los angeles, ca">Los Angeles</option>
</select>
<input type="text" name="TotalAddress" id="totalAddress" value="<?php echo $row_fmCustomer['Address'].', '.$row_fmCustomer['City'].', '.$row_fmCustomer['State']; ?>" size="50"/>
</div>
<div id="map_canvas" style="width:100%; height:350px;"></div>

<div id="photodiv">
<ul id="ulphoto">
<li>Photo1:
<input type="text" name="Photo1" placeholder="photo" value="<?php echo htmlentities($row_fmCustomer['Photo1'], ENT_COMPAT, 'UTF-8'); ?>" size="27" />
<!--<div class="picdiv">-->
<?php if (!empty($row_fmCustomer["Photo1"])) { ?>
<img src="/upload/<?php echo $row_fmCustomer['Photo1']; ?>" alt="Image" width="250" height="360" />
<?php } else { ?>
<img src="/images/Nopic.jpg" alt="Image" width="250" height="360" />
<?php } ?> 
</li>

<li>Photo2:
<input type="text" name="Photo2" placeholder="photo" value="<?php echo htmlentities($row_fmCustomer['Photo2'], ENT_COMPAT, 'UTF-8'); ?>" size="27" />
<?php if (!empty($row_fmCustomer["Photo2"])) { ?>
<img src="/upload/<?php echo $row_fmCustomer['Photo2']; ?>" alt="Image" width="250" height="360" />
<?php } else { ?>
<img src="/images/Nopic.jpg" alt="Image" width="250" height="360" />
<?php } ?>
</li>
</ul>
</div>
</section>
</div>
</section>
</form> 
<!-- end #mainContent --></aside>
<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
<footer id="footer">
<!-- end #footer --></footer>
<!-- end #container --></div>

<!--<p>&nbsp;</p>-->
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("Date", "date", {format:"yyyy-mm-dd", validateOn:["blur"], hint:"yyyy-mm-dd", isRequired:false});
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmCustomer);

mysql_free_result($fmCity);

mysql_free_result($fmJob);

mysql_free_result($fmSalesman);

mysql_free_result($fmProducts);

mysql_free_result($fmLeads);
?>
