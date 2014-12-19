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
  $updateSQL = sprintf("UPDATE Vendors SET `Vendor Name`=%s, Address=%s, City=%s, `State`=%s, Zip=%s, Phone=%s, Phone1=%s, Phone2=%s, Phone3=%s, PhoneCmbo=%s, PhoneCmbo1=%s, PhoneCmbo2=%s, PhoneCnbo3=%s, Email=%s, `Web Page`=%s, Department=%s, Office=%s, Manager=%s, Profession=%s, `Assistant`=%s, Comments=%s, Active=%s WHERE VendorNo=%s",
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
                       GetSQLValueString($_POST['Lookupphone1'], "text"),
                       GetSQLValueString($_POST['Lookupphone2'], "text"),
                       GetSQLValueString($_POST['Lookupphone3'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Web_Page'], "text"),
                       GetSQLValueString($_POST['Department'], "text"),
                       GetSQLValueString($_POST['Office'], "text"),
                       GetSQLValueString($_POST['Manager'], "text"),
                       GetSQLValueString($_POST['Profession'], "text"),
                       GetSQLValueString($_POST['Assistant'], "text"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Active'], "int"),
                       GetSQLValueString($_POST['VendorNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "VendorTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
//Zip
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Vendor
$maxRows_fmEditVendor = 40;
$pageNum_fmEditVendor = 0;
if (isset($_GET['pageNum_fmEditVendor'])) {
  $pageNum_fmEditVendor = $_GET['pageNum_fmEditVendor'];
}
$startRow_fmEditVendor = $pageNum_fmEditVendor * $maxRows_fmEditVendor;

$colname_fmEditVendor = "-1";
if (isset($_GET['VendorNo'])) {
  $colname_fmEditVendor = $_GET['VendorNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditVendor = sprintf("SELECT * FROM Vendors WHERE Vendors.VendorNo = %s", GetSQLValueString($colname_fmEditVendor, "int"));
$query_limit_fmEditVendor = sprintf("%s LIMIT %d, %d", $query_fmEditVendor, $startRow_fmEditVendor, $maxRows_fmEditVendor);
$fmEditVendor = mysql_query($query_limit_fmEditVendor, $Leadbook) or die(mysql_error());
$row_fmEditVendor = mysql_fetch_assoc($fmEditVendor);

if (isset($_GET['totalRows_fmEditVendor'])) {
  $totalRows_fmEditVendor = $_GET['totalRows_fmEditVendor'];
} else {
  $all_fmEditVendor = mysql_query($query_fmEditVendor);
  $totalRows_fmEditVendor = mysql_num_rows($all_fmEditVendor);
}
$totalPages_fmEditVendor = ceil($totalRows_fmEditVendor/$maxRows_fmEditVendor)-1;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Vendor Detail</title>

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<script src="//maps.googleapis.com/maps/api/js?libraries=weather&sensor=false" type="text/javascript"></script>
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
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
  
function initialize() {
directionsDisplay = new google.maps.DirectionsRenderer();
var geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(-34.397, 150.644);
var address = '<?php echo $row_fmEditVendor['Address'].', '.$row_fmEditVendor['City'].', '.$row_fmEditVendor['State'].', '.$row_fmEditVendor['Zip']; ?>';
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
<h1>Vendor Edit</h1>
</hgroup>
<!-- end #header --></header>
<section id="sidebar1">
<div><button class="tableheader"type="submit">Print Vendors</button></div> 
<form id="form2" name="form2" method="post">
<input name="button2" type="submit" id="button2" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmEditVendor['Address'] ?>, <?php echo $row_fmEditVendor['City'] ?>, <?php echo $row_fmEditVendor['State'] ?>, <?php echo $row_fmEditVendor['Zip'] ?>'); return document.MM_returnValue;" value="Get Map" /> 
</form>
<form id="form3" name="form3" method="post">
<input type="submit" name="button3" id="button3" value="Print" onclick="printpage()" />
</form>
<form id="form4" name="form4" method="post">
<input type="button" name="button4" id="button4" value="Email" onclick="parent.location='mailto:<?php echo $row_fmEditVendor['Email']; ?>?subject=Thank you for using United&cc=eunitedws@verizon.net.com'" />
</form>
<!-- end #sidebar1 --></section>
<aside id="mainContent">
<header id="divrepeat">
<div id="titlerepeat">Admin:Vendor Edit</div>
</header>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab" tabindex="0">Contact Details</li>
<li class="TabbedPanelsTab" tabindex="1" onclick="initialize()">Map</li>
</ul>
<div class="TabbedPanelsContentGroup">

<div class="TabbedPanelsContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
<fieldset>
<legend>Vendor Info</legend>
<div id="threecoldiv">
<ul id="threecolul">
<li id="onem"><textarea name="Photo" placeholder="photo" cols="18" rows="14"></textarea></li>

<li id="twom">
<table width="43%" class="tddataleft" cellpadding="3" id="delform">
<tr>
<td class="tddataright">Company:</td>
<td><input type="text" name="Vendor_Name" placeholder="company" value="<?php echo htmlentities($row_fmEditVendor['Vendor Name'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Phone:</td>
<td><input type="text" name="Phone" value="<?php echo htmlentities($row_fmEditVendor['Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone" id="Lookupphone">
<option value="" <?php if (!(strcmp("", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Other</option><option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditVendor['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr>
<td class="tddataright">Phone1:</td>
<td><input type="text" name="Phone1" value="<?php echo htmlentities($row_fmEditVendor['Phone1'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone1" id="Lookupphone1">
<option value="" <?php if (!(strcmp("", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Other</option><option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditVendor['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr>
<td class="tddataright">Phone2:</td>
<td><input type="text" name="Phone2" value="<?php echo htmlentities($row_fmEditVendor['Phone2'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone2" id="Lookupphone2">
<option value="" <?php if (!(strcmp("", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditVendor['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr>
<td class="tddataright">Phone3:</td>
<td><input type="text" name="Phone3" value="<?php echo htmlentities($row_fmEditVendor['Phone3'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone3" id="Lookupphone3">
<option value="" <?php if (!(strcmp("", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditVendor['PhoneCnbo3']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr>
<td class="tddataright">Email:</td>
<td><input type="email" name="Email" placeholder="email" value="<?php echo htmlentities($row_fmEditVendor['Email'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Web Page:</td>
<td><input type="text" name="Web_Page" placeholder="web page" value="<?php echo htmlentities($row_fmEditVendor['Web Page'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Active:</td>
<td><input type="checkbox" name="Active" value="1" <?php if (!(strcmp($row_fmEditVendor['Active'],1))) {echo "checked=\"checked\"";} ?> /></td>
</tr>
</table>
</li>

<li id="threem">
<textarea name="Comments" autofocus placeholder="comments" cols="23" rows="14" id="Comments"><?php echo $row_fmEditVendor['Comments']; ?></textarea></td>
</li>
</ul>
</div>
</fieldset> 

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table id="infotable">
<tr>
<td class="tddataright">Address:</td>
<td><input type="text" name="Address" value="<?php echo htmlentities($row_fmEditVendor['Address'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
<td>Department:</td>
<td><input name="Department" type="text" id="Department" value="<?php echo htmlentities($row_fmEditVendor['Department'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr><td class="tddataright">City:</td>
<td><select name="City" id="City" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $row_fmEditVendor['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $row_fmEditVendor['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
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
<td>Office:</td>
<td><input name="Office" type="text" id="Office" value="<?php echo htmlentities($row_fmEditVendor['Office'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr>
<td class="tddataright">State:</td>
<td><input name="State" type="text" id="State" value="<?php echo htmlentities($row_fmEditVendor['State'], ENT_COMPAT, 'UTF-8'); ?>" size="10" /></td>
<td>Manager:</td>
<td><input name="Manager" type="text" id="Manager" value="<?php echo htmlentities($row_fmEditVendor['Manager'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Zip:</td>
<td><input type="text" name="Zip" id="Zip_Code" value="<?php echo htmlentities($row_fmEditVendor['Zip'], ENT_COMPAT, 'UTF-8'); ?>" size="10" /></td>
<td>Assistant:</td>
<td><input type="text" name="Assistant" value="<?php echo htmlentities($row_fmEditVendor['Assistant'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr>
  <td class="tddataright">&nbsp;</td>
  <td>&nbsp;</td>
  <td>Profession:</td>
  <td><input type="text" name="Profession" id="Profession" value="<?php echo htmlentities($row_fmEditVendor['Profession'], ENT_COMPAT, 'UTF-8'); ?>" size="14" />
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
    </select>
    </td>
  </tr>
</table>
</fieldset>

<!-----------------------------------tab panel 2 end-->
<div id="divsubmit">
<input type="hidden" name="MM_update" value="formEdit" />
<input name="VendorNo" type="hidden" id="VendorNo" value="<?php echo $row_fmEditVendor['VendorNo']; ?>" />
<input type="submit" value="Update" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
</div>
</form>
</div>

<div class="TabbedPanelsContent">
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
  <option value="<?php echo $row_fmEditVendor['Address'] ?>, <?php echo $row_fmEditVendor['City'] ?>, <?php echo $row_fmEditVendor['State'] ?>, <?php echo $row_fmEditVendor['Zip'] ?>">Current Address</option>
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
<input type="text" name="TotalAddress" id="totalAddress" value="<?php echo $row_fmEditVendor['Address'] ?>, <?php echo $row_fmEditVendor['City'] ?>, <?php echo $row_fmEditVendor['State'] ?>, <?php echo $row_fmEditVendor['Zip'] ?>" size="45"/>
</div>
<div id="map_canvas" style="width:100%; height:450px;" ></div>
</div>
</div>
</div>
<!-- end #mainContent --></aside>
<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
<footer id="footer">
<!-- end #footer --></footer>
<!-- end #container --></div>

<p>&nbsp;</p>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmEditVendor);

mysql_free_result($fmCity);
?>
