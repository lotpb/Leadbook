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
  $updateSQL = sprintf("UPDATE Employee SET `First Name`=%s, `Middle Name`=%s, `Last Name`=%s, `Company Name`=%s, `Social Security`=%s, Department=%s, Title=%s, Manager=%s, `Work Phone`=%s, `Cell Phone`=%s, Street=%s, City=%s, `State`=%s, Country=%s, Zip=%s, `Home Phone`=%s, Email=%s, Comments=%s, Active=%s WHERE EmployeeNo=%s",
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
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['EmployeeNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "EmployeeTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
//City
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Employee
$maxRows_fmEditEmployee = 40;
$pageNum_fmEditEmployee = 0;
if (isset($_GET['pageNum_fmEditEmployee'])) {
  $pageNum_fmEditEmployee = $_GET['pageNum_fmEditEmployee'];
}
$startRow_fmEditEmployee = $pageNum_fmEditEmployee * $maxRows_fmEditEmployee;

$colname_fmEditEmployee = "-1";
if (isset($_GET['EmployeeNo'])) {
  $colname_fmEditEmployee = $_GET['EmployeeNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditEmployee = sprintf("SELECT * FROM Employee WHERE Employee.EmployeeNo = %s", GetSQLValueString($colname_fmEditEmployee, "int"));
$query_limit_fmEditEmployee = sprintf("%s LIMIT %d, %d", $query_fmEditEmployee, $startRow_fmEditEmployee, $maxRows_fmEditEmployee);
$fmEditEmployee = mysql_query($query_limit_fmEditEmployee, $Leadbook) or die(mysql_error());
$row_fmEditEmployee = mysql_fetch_assoc($fmEditEmployee);

if (isset($_GET['totalRows_fmEditEmployee'])) {
  $totalRows_fmEditEmployee = $_GET['totalRows_fmEditEmployee'];
} else {
  $all_fmEditEmployee = mysql_query($query_fmEditEmployee);
  $totalRows_fmEditEmployee = mysql_num_rows($all_fmEditEmployee);
}
$totalPages_fmEditEmployee = ceil($totalRows_fmEditEmployee/$maxRows_fmEditEmployee)-1;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Employee Detail</title>

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
var address = '<?php echo $row_fmEditEmployee['Street'].', '.$row_fmEditEmployee['City'].', '.$row_fmEditEmployee['State'].', '.$row_fmEditEmployee['Zip']; ?>';
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
<h1>Employee Edit</h1>
</hgroup>
<!-- end #header --></header>

<section id="sidebar1">
<div><button class="tableheader"type="submit">Print Customers</button></div> 
<form id="form2" name="form2" method="post">
<input name="button2" type="submit" id="button2" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmEditEmployee['Street'] ?>, <?php echo $row_fmEditEmployee['City'] ?>, <?php echo $row_fmEditEmployee['State'] ?>, <?php echo $row_fmEditEmployee['Zip'] ?>'); return document.MM_returnValue;" value="Get Map" /> </form>

<form id="form3" name="form3" method="post">
<input type="submit" name="button3" id="button3" value="Print" onclick="printpage()" /> </form>

<form id="form4" name="form4" method="post">
<input type="button" name="button4" id="button4" value="Email" onclick="parent.location='mailto:<?php echo $row_fmEditEmployee['Email']; ?>?subject=Thank you for using United&amp;cc=eunitedws@verizon.net.com'" /> </form>
<!-- end #sidebar1 --></section>

<div id="titlerepeat">Admin:Employee Detail</div>
<aside id="mainContent">
<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab" tabindex="0">Employee Info</li>
<li class="TabbedPanelsTab" tabindex="1" onclick="initialize()">Map</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
     
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
<fieldset>
<legend>Employee Info</legend>
<table id="maintable">
<tr class="tablevalign">
<td class="tddataright">First Name:</td>
<td>
<input type="text" name="First_Name" placeholder="first name" value="<?php echo htmlentities($row_fmEditEmployee['First Name'], ENT_COMPAT, 'UTF-8'); ?>" size="15" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Last Name:</td>
<td>
<input type="text" name="Last_Name" placeholder="last name"value="<?php echo htmlentities($row_fmEditEmployee['Last Name'], ENT_COMPAT, 'UTF-8'); ?>" size="25" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Company Name:</td>
<td>
<input type="text" name="Company_Name" placeholder="company name"value="<?php echo htmlentities($row_fmEditEmployee['Company Name'], ENT_COMPAT, 'UTF-8'); ?>" size="25" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Home Phone:</td>
<td>
<input type="text" name="Home_Phone" placeholder="(###)###-####" value="<?php echo htmlentities($row_fmEditEmployee['Home Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Cell Phone:</td>
<td>
<input type="text" name="Cell_Phone" placeholder="(###)###-####" value="<?php echo htmlentities($row_fmEditEmployee['Cell Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Work Phone:</td>
<td>
<input type="text" name="Work_Phone" placeholder="(###)###-####" value="<?php echo htmlentities($row_fmEditEmployee['Work Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Email:</td>
<td>
<input name="Email" type="email" id="Email" value="<?php echo htmlentities($row_fmEditEmployee['Email'], ENT_COMPAT, 'UTF-8'); ?>" size="30" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Active:</td>
<td>
<input type="checkbox" name="Active" value="1" <?php if (!(strcmp($row_fmEditEmployee['Active'],1))) {echo "checked=\"checked\"";} ?> /></td>
</tr>
</table>
  <!---------------------------------table 3 start-->
<table width="33%"  class="tddataright">
<tr class="tablevalign">
<td>
<textarea name="Comments" id="Comments" placeholder="Comments" autofocus cols="25" rows="15"><?php echo $row_fmEditEmployee['Comments']; ?></textarea></td>
</tr>
</table>
<!------------------------------------table 3 end-->  
</fieldset>

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table id="infotable">
<tr class="tablevalign">
<td class="tddataright">Address:</td>
<td>
<input type="text" name="Street" value="<?php echo htmlentities($row_fmEditEmployee['Street'], ENT_COMPAT, 'UTF-8'); ?>" size="25" /></td>
<td class="tddataright">Social Security:</td>
<td>
<input type="text" name="Social_Security" value="<?php echo htmlentities($row_fmEditEmployee['Social Security'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">City:</td>
<td>
<select name="City" id="City" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $row_fmEditEmployee['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $row_fmEditEmployee['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php } while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity); } ?>
</select>
<a href="ZipLookup.php">select</a></td>
<td class="tddataright">Department:</td>
<td>
<input name="Department" type="text" id="Department" value="<?php echo htmlentities($row_fmEditEmployee['Department'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">State:</td>
<td>
<input type="text" name="State" id="State" value="<?php echo htmlentities($row_fmEditEmployee['State'], ENT_COMPAT, 'UTF-8'); ?>" size="10" /></td>
<td class="tddataright">Title:</td>
<td>
<input type="text" name="Title" value="<?php echo htmlentities($row_fmEditEmployee['Title'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Zip:</td>
<td>
<input type="text" name="Zip" id="Zip_Code" value="<?php echo htmlentities($row_fmEditEmployee['Zip'], ENT_COMPAT, 'UTF-8'); ?>" size="10" /></td>
<td class="tddataright">Manager:</td>
<td>
<input type="text" name="Manager" value="<?php echo htmlentities($row_fmEditEmployee['Manager'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Middle Name:</td>
<td>
<input type="text" name="Middle_Name" value="<?php echo htmlentities($row_fmEditEmployee['Middle Name'], ENT_COMPAT, 'UTF-8'); ?>" size="15" /></td>
<td class="tddataright">Country</td>
<td>
<input type="text" name="Country" value="<?php echo htmlentities($row_fmEditEmployee['Country'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
</table>
</fieldset> 
<div id="divsubmit">
<input type="submit" value="Update" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
<input type="hidden" name="MM_update" value="formEdit" />
<input type="hidden" name="EmployeeNo" value="<?php echo $row_fmEditEmployee['EmployeeNo']; ?>" />
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
  <option value="<?php echo $row_fmEditEmployee['Street']; ?>, <?php echo $row_fmEditEmployee['City'] ?>, <?php echo $row_fmEditEmployee['State'] ?>, <?php echo $row_fmEditEmployee['Zip'] ?>">Current Address</option>
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
<input type="text" name="TotalAddress" id="totalAddress" value="<?php echo $row_fmEditEmployee['Street']; ?>, <?php echo $row_fmEditEmployee['City'] ?>, <?php echo $row_fmEditEmployee['State'] ?>, <?php echo $row_fmEditEmployee['Zip'] ?>" size="45"/>
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
mysql_free_result($fmEditEmployee);

mysql_free_result($fmCity);
?>
