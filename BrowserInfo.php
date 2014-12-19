<?php require_once('Connections/Leadbook.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Browser Info</title>
<meta charset="utf-8" />
<link rel="icon" href="favicon.ico">

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<script src="//maps.googleapis.com/maps/api/js?libraries=weather&sensor=false" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Addresstext.css" rel="stylesheet" type="text/css" media="screen" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
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
function initialize() {
var geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(-34.397, 150.644);
var address = 'Massapeq,NY';
/*Options*/
var myOptions = {
center: latlng,
zoom: 10,
mapTypeId: google.maps.MapTypeId.ROADMAP
}
/*Geocoder*/
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
/*map.setCenter(results[0].geometry.location);*/
myOptions.center = results[0].geometry.location;

var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
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
window.onload = initialize;
</script>
</head>
<body class="twoColFixRtHdr">

<div id="container">
<header id="header">
<hgroup>
<h1>&nbsp;</h1>
</hgroup>
<nav>
<ul id="MenuBar1" class="MenuBarHorizontal">
<li><a href="index.php">Home</a>      </li>
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
<form id="form1" name="form1" method="get" action="ZipTable.php">
<p>
<input name="Search" type="text" id="Search" size="18" />
<input type="submit" value="Search" />
<br />
</p>
</form>
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<h3>&nbsp;</h3>
<!-- end #sidebar1 --></section>
<aside id="mainContent">
<div id="map_canvas" style="width:100%; height:550px;" ></div>
<header>
<h1 class="style1">&nbsp; </h1>
<h1 class="stylered">Admin:Browser Info</h1>
<h3>The following is a list of all browser Info</h3>
<p class="stylered">Details of browser</p>
</header>
<script type="text/javascript">
document.write("<p>Browser: ");
document.write(navigator.appName + "</p>");

document.write("<p>Browserversion: ");
document.write(navigator.appVersion + "</p>");

document.write("<p>Code: ");
document.write(navigator.appCodeName + "</p>");

document.write("<p>Platform: ");
document.write(navigator.platform + "</p>");

document.write("<p>Cookies enabled: ");
document.write(navigator.cookieEnabled + "</p>");

document.write("<p>Browser's user agent header: ");
document.write(navigator.userAgent + "</p>");
</script>
<p class="stylered">All details of browser</p>
<script type="text/javascript">
var x = navigator;
document.write("CodeName=" + x.appCodeName);
document.write("<br />");
document.write("MinorVersion=" + x.appMinorVersion);
document.write("<br />");
document.write("Name=" + x.appName);
document.write("<br />");
document.write("Version=" + x.appVersion);
document.write("<br />");
document.write("CookieEnabled=" + x.cookieEnabled);
document.write("<br />");
document.write("CPUClass=" + x.cpuClass);
document.write("<br />");
document.write("OnLine=" + x.onLine);
document.write("<br />");
document.write("Platform=" + x.platform);
document.write("<br />");
document.write("UA=" + x.userAgent);
document.write("<br />");
document.write("BrowserLanguage=" + x.browserLanguage);
document.write("<br />");
document.write("SystemLanguage=" + x.systemLanguage);
document.write("<br />");
document.write("UserLanguage=" + x.userLanguage);
</script>
<p class="stylered">Details of screen</p>
<script type="text/javascript">
document.write("Screen resolution: ");
document.write(screen.width + "*" + screen.height);
document.write("<br />");
document.write("Available view area: ");
document.write(screen.availWidth + "*" + screen.availHeight);
document.write("<br />");
document.write("Color depth: ");
document.write(screen.colorDepth);
document.write("<br />");
document.write("Buffer depth: ");
document.write(screen.bufferDepth);
document.write("<br />");
document.write("DeviceXDPI: ");
document.write(screen.deviceXDPI);
document.write("<br />");
document.write("DeviceYDPI: ");
document.write(screen.deviceYDPI);
document.write("<br />");
document.write("LogicalXDPI: ");
document.write(screen.logicalXDPI);
document.write("<br />");
document.write("LogicalYDPI: ");
document.write(screen.logicalYDPI);
document.write("<br />");
document.write("FontSmoothingEnabled: ");
document.write(screen.fontSmoothingEnabled);
document.write("<br />");
document.write("PixelDepth: ");
document.write(screen.pixelDepth);
document.write("<br />");
document.write("UpdateInterval: ");
document.write(screen.updateInterval);
document.write("<br />");
</script>

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

