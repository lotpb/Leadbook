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
  $updateSQL = sprintf("UPDATE Leads SET `Date`=%s, `Last Name`=%s, Address=%s, City=%s, `State`=%s, `Zip Code`=%s, Phone=%s, `Apt date`=%s, SalesNo=%s, JobNo=%s, `First`=%s, Spouse=%s, Amount=%s, AdNo=%s, Coments=%s, `Call Back`=%s, Photo=%s, Active=%s, Email=%s, `Time`=%s WHERE LeadNo=%s",
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['LookupCity'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip_Code'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Apt_date'], "date"),
                       GetSQLValueString($_POST['LookSalesNo'], "int"),
                       GetSQLValueString($_POST['LookupJobNo'], "int"),
                       GetSQLValueString($_POST['First'], "text"),
                       GetSQLValueString($_POST['Spouse'], "text"),
                       GetSQLValueString($_POST['Amount'], "double"),
                       GetSQLValueString($_POST['LookupAdNo'], "int"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['LookupCallBack'], "text"),
                       GetSQLValueString($_POST['Photo'], "text"),
                       GetSQLValueString(isset($_POST['Active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Time'], "date"),
                       GetSQLValueString($_POST['LeadNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "LeadTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
//Salesman
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmSalesman = "SELECT * FROM Salesman ORDER BY Salesman.Salesman";
$fmSalesman = mysql_query($query_fmSalesman, $Leadbook) or die(mysql_error());
$row_fmSalesman = mysql_fetch_assoc($fmSalesman);
$totalRows_fmSalesman = mysql_num_rows($fmSalesman);
//City
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
//Advertiser
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAdvertiser = "SELECT * FROM advertising ORDER BY advertising.Advertiser";
$fmAdvertiser = mysql_query($query_fmAdvertiser, $Leadbook) or die(mysql_error());
$row_fmAdvertiser = mysql_fetch_assoc($fmAdvertiser);
$totalRows_fmAdvertiser = mysql_num_rows($fmAdvertiser);
//Leads
$maxRows_fmLeads = 1;
$pageNum_fmLeads = 0;
if (isset($_GET['pageNum_fmLeads'])) {
  $pageNum_fmLeads = $_GET['pageNum_fmLeads'];
}
$startRow_fmLeads = $pageNum_fmLeads * $maxRows_fmLeads;

$colname_fmLeads = "-1";
if (isset($_GET['LeadNo'])) {
  $colname_fmLeads = $_GET['LeadNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeads = sprintf("SELECT * FROM Leads WHERE LeadNo = %s ", GetSQLValueString($colname_fmLeads, "int"));
$query_limit_fmLeads = sprintf("%s LIMIT %d, %d", $query_fmLeads, $startRow_fmLeads, $maxRows_fmLeads);
$fmLeads = mysql_query($query_limit_fmLeads, $Leadbook) or die(mysql_error());
$row_fmLeads = mysql_fetch_assoc($fmLeads);

if (isset($_GET['totalRows_fmLeads'])) {
  $totalRows_fmLeads = $_GET['totalRows_fmLeads'];
} else {
  $all_fmLeads = mysql_query($query_fmLeads);
  $totalRows_fmLeads = mysql_num_rows($all_fmLeads);
}
$totalPages_fmLeads = ceil($totalRows_fmLeads/$maxRows_fmLeads)-1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Edit Name: <?php echo $row_fmLeads['Last Name']; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="favicon.ico">

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="assets/CalendarPopup.js" type="text/javascript" ></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script> 
<script src="assets/functions.js" type="text/javascript"></script>
<script src="//maps.googleapis.com/maps/api/js?libraries=weather&sensor=false" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
var cal = new CalendarPopup();

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;  

function initialize() {
directionsDisplay = new google.maps.DirectionsRenderer();	
var geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(34.052234,-118.243685);
var address = '<?php echo $row_fmLeads['Address'].', '.$row_fmLeads['City'].', '.$row_fmLeads['State']; ?>';

var myOptions = {
zoom: 15,
center: latlng,
mapTypeId: google.maps.MapTypeId.ROADMAP
}
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
myOptions.center = results[0].geometry.location;

map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
directionsDisplay.setMap(map);
var marker = new google.maps.Marker({
    map: map,
    position: results[0].geometry.location
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
 map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);  
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
<h1>Lead Edit</h1>
</hgroup>
<!-- end #header --></header>
<section id="sidebar1">

<div><button class="tableheader"type="submit">Print Leads</button></div> 
<form id="form3" name="form3" method="post">
<input type="submit" name="button3" id="button3" value="Print" onclick="printpage()" />
</form>

<form id="form4" name="form4" method="post">
<input type="button" name="button4" id="button4" value="Email" onclick="parent.location='mailto:<?php echo $row_fmLeads['Email']; ?>?subject=Thank you for using United&amp;cc=eunitedws@verizon.net.com'" />
</form>

<form id="form2" name="form2" method="post">
<input name="button2" type="submit" id="button2" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmLeads['Address'] ?>, <?php echo $row_fmLeads['City'] ?>, <?php echo $row_fmLeads['State'] ?>, <?php echo $row_fmLeads['Zip Code'] ?>'); 
return document.MM_returnValue;" value="Get Map" />  
</form>

<!--Uploadfile-->

 <form enctype="multipart/form-data" action="upload.php" method="post"> 
 <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
 <input type="hidden" value="<?php echo $row_fmLeads['LeadNo']; ?>" name="name" /> 
 <input type="hidden" value="Leads" name="tablepic" />
 <input type="hidden" value="LeadNo" name="fieldpic" /><br /> 
 Photo: <input type="file" name="Photo" /><br /> 
 <input type="submit" value="Upload" /> 
 </form>

<!--Uploadfile-->

<div><button class="tableheader" type="submit">Repeat Leads</button></div> 
<select id="RepeatLead" onchange="showRepeatLead(this.value)">
<option value="">Select Repeat Leads:</option>
<option value="<?php echo $row_fmLeads['Last Name']; ?>">Repeat Lead Name</option>
<option value="<?php echo $row_fmLeads['Address']; ?>">Same Lead Addresse</option>
</select>
<!-- end #sidebar1 --></section>

<aside id="mainContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
<header id="divrepeat">
<div id="txtrepeat"><b>Lead info will be listed here.</b></div>
</header>

<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Lead Info</li>
    <li class="TabbedPanelsTab" tabindex="1" onclick="initialize()">Map</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    
<fieldset>
<legend>Lead Info</legend>
<table id="maintable">
<tr>
<td class="tddataright">Date:</td>
<td>
<input type="date" name="Date" value="<?php echo htmlentities($row_fmLeads['Date'], ENT_COMPAT, 'UTF-8'); ?>" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Date,'anchor4','yyyy-MM-dd'); return false;" name="anchor4" id="anchor4">select</a></td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
</tr>
<tr>
<td class="tddataright">Last Name:</td>
<td>
<input type="text" name="Last_Name" id="Last_Name" value="<?php echo htmlentities($row_fmLeads['Last Name'], ENT_COMPAT, 'UTF-8'); ?>" size="25" /></td>
</tr>
<tr>
<td class="tddataright">Address:</td>
<td>
<input type="text" name="Address" value="<?php echo htmlentities($row_fmLeads['Address'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
<td><select name="LookupCity" id="LookupCity" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $row_fmLeads['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $row_fmLeads['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php } while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity); } ?>
</select> <input type="text" name="State" id="State" value="<?php echo htmlentities($row_fmLeads['State'], ENT_COMPAT, 'UTF-8'); ?>" size="05" /> <input type="text" name="Zip_Code" id="Zip_Code" value="<?php echo htmlentities($row_fmLeads['Zip Code'], ENT_COMPAT, 'UTF-8'); ?>" size="13" />
</td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
</tr>
<tr>
<td class="tddataright">Phone:</td>
<td>
<input type="text" name="Phone" placeholder="(555)555-5555" value="<?php echo htmlentities($row_fmLeads['Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr>
<td class="tddataright">Apt date:</td>
<td>
<input type="date" name="Apt_date" value="<?php echo htmlentities($row_fmLeads['Apt date'], ENT_COMPAT, 'UTF-8'); ?>" size="20" /></td>
</tr>
<tr>
<td class="tddataright">SalesNo:</td>
<td>
<select name="LookSalesNo" size="1" id="LookSalesNo">
<option value="" <?php if (!(strcmp("", $row_fmLeads['SalesNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmSalesman['SalesNo']?>"<?php if (!(strcmp($row_fmSalesman['SalesNo'], $row_fmLeads['SalesNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmSalesman['Salesman']?></option>
<?php
} while ($row_fmSalesman = mysql_fetch_assoc($fmSalesman));
$rows = mysql_num_rows($fmSalesman);
if($rows > 0) {
mysql_data_seek($fmSalesman, 0);
$row_fmSalesman = mysql_fetch_assoc($fmSalesman); } ?>
</select>
</td>
</tr>
<tr>
<td class="tddataright">JobNo:</td>
<td>
<select name="LookupJobNo" id="LookupJobNo">
<option value="" <?php if (!(strcmp("", $row_fmLeads['JobNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmJob['JobNo']?>"<?php if (!(strcmp($row_fmJob['JobNo'], $row_fmLeads['JobNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmJob['Description']?></option>
<?php } while ($row_fmJob = mysql_fetch_assoc($fmJob));
$rows = mysql_num_rows($fmJob);
if($rows > 0) {
mysql_data_seek($fmJob, 0);
$row_fmJob = mysql_fetch_assoc($fmJob); } ?>
</select>
</td>
</tr>
<tr>
<td class="tddataright">Amount:</td>
<td>
<input type="text" name="Amount" value="<?php echo htmlentities($row_fmLeads['Amount'], ENT_COMPAT, 'UTF-8'); ?>" size="15" /></td>
</tr>
<tr>
<td class="tddataright">AdNo:</td>
<td>
<select name="LookupAdNo" id="LookupAdNo">
<option value="" <?php if (!(strcmp("", $row_fmLeads['AdNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmAdvertiser['AdNo']?>"<?php if (!(strcmp($row_fmAdvertiser['AdNo'], $row_fmLeads['AdNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmAdvertiser['Advertiser']?></option>
<?php
} while ($row_fmAdvertiser = mysql_fetch_assoc($fmAdvertiser));
$rows = mysql_num_rows($fmAdvertiser);
if($rows > 0) {
mysql_data_seek($fmAdvertiser, 0);
$row_fmAdvertiser = mysql_fetch_assoc($fmAdvertiser); } ?>
</select>
</td>
</tr>

<tr>
<td class="tddataright" valign="top">Comment:</td>
<td><textarea name="Comments" id="Comments" autofocus placeholder="Comments" cols="40" rows="5"><?php echo htmlentities($row_fmLeads['Coments'], ENT_COMPAT, 'UTF-8'); ?></textarea></td>
</tr> 
<tr>
<td></tr></td></tr>
</table>
<!--table 3 start-->
<table width="33%">
<tr>
<td>
<section class="picdiv">
<?php if (!empty($row_fmLeads["Photo"])) {?>
<img src="/upload/<?php echo $row_fmLeads['Photo']; ?>" alt="Image" width="250" height="350" />
<?php } else { ?>
<img  src="/images/NopicNew.jpg" alt="Image" width="250" height="350" />
<?php } ?>
</section>
</td>
</tr>

<td>
<input type="text" name="Photo" placeholder="photo" value="<?php echo htmlentities($row_fmLeads['Photo'], ENT_COMPAT, 'UTF-8'); ?>" size="26" />
</td>
<tr>
<td align="Center">Active:
<input name="Active" type="checkbox" id="Active" value="1" <?php if (!(strcmp($row_fmLeads['Active'],1))) {echo "checked=\"checked\"";} ?> /></td>
</tr>
</table>
<!--table 3 end-->
</fieldset>

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table id="infotable" width="100%">
<tr>
<td class="tddataright">Email:</td>
<td>
<input type="email" name="Email" placeholder="valid email address" value="<?php echo htmlentities($row_fmLeads['Email'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>

<td class="tddataright">First: </td>
<td><input type="text" name="First" id="First" placeholder="first name" value="<?php echo htmlentities($row_fmLeads['First'], ENT_COMPAT, 'UTF-8'); ?>" size="25" />
</td>
</tr>

<tr>
<td class="tddataright">Call Back:</td>
<td>
<select name="LookupCallBack" id="LookupCallBack">
<option value="None" <?php if (!(strcmp("None", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<option value="Sold" <?php if (!(strcmp("Sold", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Sold</option>
<option value="Cancel" <?php if (!(strcmp("Cancel", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Cancel</option>
<option value="Dead" <?php if (!(strcmp("Dead", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Dead</option>
<option value="Bought" <?php if (!(strcmp("Bought", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Bought</option>
<option value="Future Work" <?php if (!(strcmp("Future Work", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Future Work</option>
<option value="Looks Good" <?php if (!(strcmp("Looks Good", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Looks Good</option>
<option value="Follow Up" <?php if (!(strcmp("Follow Up", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Follow Up</option>
<option value="Called" <?php if (!(strcmp("Called", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Called</option>
</select>
</td>

<td class="tddataright">Spouse:</td>
<td>
<input type="text" name="Spouse" placeholder="spouse name" value="<?php echo htmlentities($row_fmLeads['Spouse'], ENT_COMPAT, 'UTF-8'); ?>" size="25" />
</td>
</tr>

<tr>
<td class="tddataright">LeadNo:</td>
<td>
<input name="LeadNo" type="text" id="LeadNo" value="<?php echo $row_fmLeads['LeadNo']; ?>" /></td>

<td class="tddataright">Time:</td>
<td>
<input type="datetime" name="Time" value="<?php echo htmlentities($row_fmLeads['Time'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr>
</table>
</fieldset>

<div id="divsubmit">
<input type="hidden" name="MM_update" value="formEdit" />
<input type="submit" value="Update" />
<input type="submit" name="button" id="button" value="Cancel" onclick="history.back()" />
</div>
</div>

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
  <option value="<?php echo $row_fmLeads['Address'].', '.$row_fmLeads['City'].', '.$row_fmLeads['State']; ?>">Current Address</option>
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
<input type="text" name="TotalAddress" id="totalAddress" value="<?php echo $row_fmLeads['Address'].', '.$row_fmLeads['City'].', '.$row_fmLeads['State']; ?>" size="50"/>
</div>
<div id="map_canvas" style="width:100%;height:600px;background-color:#ffffff"></div>
</section>
</div>
</div>
</form>  
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
mysql_free_result($fmLeads);

mysql_free_result($fmSalesman);

mysql_free_result($fmCity);

mysql_free_result($fmJob);

mysql_free_result($fmAdvertiser);
?>
