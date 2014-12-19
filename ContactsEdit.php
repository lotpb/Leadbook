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
  $updateSQL = sprintf("UPDATE OtherNames SET `First Name`=%s, `Last Name`=%s, Address=%s, City=%s, `State`=%s, Zip=%s, Phone=%s, Phone1=%s, Phone2=%s, Phone3=%s, PhoneCmbo=%s, PhoneCmbo1=%s, PhoneCmbo2=%s, PhoneCmbo3=%s, Nickname=%s, `Spouse Name`=%s, Birthday=%s, Anniversary=%s, Email=%s, `Web Page`=%s, Comments=%s, Active=%s WHERE ContactNo=%s",
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
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['ContactNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "ContactsTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
//zip
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
//Contacts
$maxRows_fmEditContacts = 40;
$pageNum_fmEditContacts = 0;
if (isset($_GET['pageNum_fmEditContacts'])) {
  $pageNum_fmEditContacts = $_GET['pageNum_fmEditContacts'];
}
$startRow_fmEditContacts = $pageNum_fmEditContacts * $maxRows_fmEditContacts;

$colname_fmEditContacts = "-1";
if (isset($_GET['ContactNo'])) {
  $colname_fmEditContacts = $_GET['ContactNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditContacts = sprintf("SELECT * FROM OtherNames WHERE OtherNames.ContactNo = %s", GetSQLValueString($colname_fmEditContacts, "int"));
$query_limit_fmEditContacts = sprintf("%s LIMIT %d, %d", $query_fmEditContacts, $startRow_fmEditContacts, $maxRows_fmEditContacts);
$fmEditContacts = mysql_query($query_limit_fmEditContacts, $Leadbook) or die(mysql_error());
$row_fmEditContacts = mysql_fetch_assoc($fmEditContacts);

if (isset($_GET['totalRows_fmEditContacts'])) {
  $totalRows_fmEditContacts = $_GET['totalRows_fmEditContacts'];
} else {
  $all_fmEditContacts = mysql_query($query_fmEditContacts);
  $totalRows_fmEditContacts = mysql_num_rows($all_fmEditContacts);
}
$totalPages_fmEditContacts = ceil($totalRows_fmEditContacts/$maxRows_fmEditContacts)-1;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Contact Details</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/jquery.js"></script>
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
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
  
function initialize() {
directionsDisplay = new google.maps.DirectionsRenderer();
var geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(-34.397, 150.644);
var address = '<?php echo $row_fmEditContacts['Address'].', '.$row_fmEditContacts['City'].', '.$row_fmEditContacts['State'].', '.$row_fmEditContacts['Zip']; ?>';
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
<h1>Contacts Edit</h1>
</hgroup>

<!-- end #header --></header>
<section id="sidebar1">

<div><button class="tableheader"type="submit">Print Contacts</button></div> 
<form id="form3" name="form3" method="post">
<input type="submit" name="button3" id="button3" value="Print" onclick="printpage()" />
</form>

<form id="form2" name="form2" method="post">
<input name="button2" type="submit" id="button2" onclick="MM_goToURL('parent','http://maps.google.com/?q=<?php echo $row_fmEditContacts['Address'] ?>, <?php echo $row_fmEditContacts['City'] ?>, <?php echo $row_fmEditContacts['State'] ?>, <?php echo $row_fmEditContacts['Zip'] ?>'); return document.MM_returnValue;" value="Get Map" /> 
</form>

<form id="forminsert" name="form4" method="post">
<input type="button" name="button4" id="button4" value="Email" onclick="parent.location='mailto:<?php echo $row_fmEditContacts['Email']; ?>?subject=Thank you for using United&amp;cc=eunitedws@verizon.net.com'" />
</form>
<select name="state" id="state">
<option value="AL" <?PHP if($state=="AL") echo "selected";?>>Alabama</option>
<option value="AK" <?PHP if($state=="AK") echo "selected";?>>Alaska</option>
<option value="AZ" <?PHP if($state=="AZ") echo "selected";?>>Arizona</option>
<option value="AR" <?PHP if($state=="AR") echo "selected";?>>Arkansas</option>
<option value="CA" <?PHP if($state=="CA") echo "selected";?>>California</option>
<option value="CO" <?PHP if($state=="CO") echo "selected";?>>Colorado</option>
<option value="CT" <?PHP if($state=="CT") echo "selected";?>>Connecticut</option>
<option value="DE" <?PHP if($state=="DE") echo "selected";?>>Delaware</option>
<option value="DC" <?PHP if($state=="DC") echo "selected";?>>District of Columbia</option>
<option value="FL" <?PHP if($state=="FL") echo "selected";?>>Florida</option>
<option value="GA" <?PHP if($state=="GA") echo "selected";?>>Georgia</option>
<option value="HI" <?PHP if($state=="HI") echo "selected";?>>Hawaii</option>
<option value="ID" <?PHP if($state=="ID") echo "selected";?>>Idaho</option>
<option value="IL" <?PHP if($state=="IL") echo "selected";?>>Illinois</option>
<option value="IN" <?PHP if($state=="IN") echo "selected";?>>Indiana</option>
<option value="IA" <?PHP if($state=="IA") echo "selected";?>>Iowa</option>
<option value="KS" <?PHP if($state=="KS") echo "selected";?>>Kansas</option>
<option value="KY" <?PHP if($state=="KY") echo "selected";?>>Kentucky</option>
<option value="LA" <?PHP if($state=="LA") echo "selected";?>>Louisiana</option>
<option value="ME" <?PHP if($state=="ME") echo "selected";?>>Maine</option>
<option value="MD" <?PHP if($state=="MD") echo "selected";?>>Maryland</option>
<option value="MA" <?PHP if($state=="MA") echo "selected";?>>Massachusetts</option>
<option value="MI" <?PHP if($state=="MI") echo "selected";?>>Michigan</option>
<option value="MN" <?PHP if($state=="MN") echo "selected";?>>Minnesota</option>
<option value="MS" <?PHP if($state=="MS") echo "selected";?>>Mississippi</option>
<option value="MO" <?PHP if($state=="MO") echo "selected";?>>Missouri</option>
<option value="MT" <?PHP if($state=="MT") echo "selected";?>>Montana</option>
<option value="NE" <?PHP if($state=="NE") echo "selected";?>>Nebraska</option>
<option value="NV" <?PHP if($state=="NV") echo "selected";?>>Nevada</option>
<option value="NH" <?PHP if($state=="NH") echo "selected";?>>New Hampshire</option>
<option value="NJ" <?PHP if($state=="NJ") echo "selected";?>>New Jersey</option>
<option value="NM" <?PHP if($state=="NM") echo "selected";?>>New Mexico</option>
<option value="NY" <?PHP if($state=="NY") echo "selected";?>>New York</option>
<option value="NC" <?PHP if($state=="NC") echo "selected";?>>North Carolina</option>
<option value="ND" <?PHP if($state=="ND") echo "selected";?>>North Dakota</option>
<option value="OH" <?PHP if($state=="OH") echo "selected";?>>Ohio</option>
<option value="OK" <?PHP if($state=="OK") echo "selected";?>>Oklahoma</option>
<option value="OR" <?PHP if($state=="OR") echo "selected";?>>Oregon</option>
<option value="PA" <?PHP if($state=="PA") echo "selected";?>>Pennsylvania</option>
<option value="RI" <?PHP if($state=="RI") echo "selected";?>>Rhode Island</option>
<option value="SC" <?PHP if($state=="SC") echo "selected";?>>South Carolina</option>
<option value="SD" <?PHP if($state=="SD") echo "selected";?>>South Dakota</option>
<option value="TN" <?PHP if($state=="TN") echo "selected";?>>Tennessee</option>
<option value="TX" <?PHP if($state=="TX") echo "selected";?>>Texas</option>
<option value="UT" <?PHP if($state=="UT") echo "selected";?>>Utah</option>
<option value="VT" <?PHP if($state=="VT") echo "selected";?>>Vermont</option>
<option value="VA" <?PHP if($state=="VA") echo "selected";?>>Virginia</option>
<option value="WA" <?PHP if($state=="WA") echo "selected";?>>Washington</option>
<option value="WV" <?PHP if($state=="WV") echo "selected";?>>West Virginia</option>
<option value="WI" <?PHP if($state=="WI") echo "selected";?>>Wisconsin</option>
<option value="WY" <?PHP if($state=="WY") echo "selected";?>>Wyoming</option>
</select>
<!-- end #sidebar1 --></section>
<header id="divrepeat">
<div id="titlerepeat">Admin:Contacts Edit</div>
</header>
<aside id="mainContent">
<!-----------------------------------tab panel 1-->

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab" tabindex="0">Contact Details</li>
<li class="TabbedPanelsTab" tabindex="1" onclick="initialize()">Map</li>
</ul>
<div class="TabbedPanelsContentGroup">

<div class="TabbedPanelsContent">
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
<fieldset>
<legend>Contact Info</legend>
<div id="threecoldiv">
<ul id="threecolul">
<li id="onem"><textarea name="Photo" placeholder="photo" cols="18" rows="14"></textarea></li>

<li id="twom">
<table class="tddataleft">
<tr>
<td class="tddataright">First:</td>
<td><input type="text" name="First_Name" placeholder="first" value="<?php echo htmlentities($row_fmEditContacts['First Name'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Last Name:</td>
<td><input type="text" name="Last_Name" placeholder="last name" value="<?php echo htmlentities($row_fmEditContacts['Last Name'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Phone:</td>
<td><input type="text" name="Phone" value="<?php echo htmlentities($row_fmEditContacts['Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone" id="Lookupphone">
<option value="" <?php if (!(strcmp("", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditContacts['PhoneCmbo']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Phone1:</td>
<td><input type="text" name="Phone1" value="<?php echo htmlentities($row_fmEditContacts['Phone1'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone1" id="Lookupphone1">
<option value="" <?php if (!(strcmp("", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditContacts['PhoneCmbo1']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Phone2:</td>
<td><input type="text" name="Phone2" value="<?php echo htmlentities($row_fmEditContacts['Phone2'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone2" id="Lookupphone2">
<option value="" <?php if (!(strcmp("", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditContacts['PhoneCmbo2']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Phone3:</td>
<td><input type="text" name="Phone3" value="<?php echo htmlentities($row_fmEditContacts['Phone3'], ENT_COMPAT, 'UTF-8'); ?>" size="15" />
<select name="Lookupphone3" id="Lookupphone3">
<option value="" <?php if (!(strcmp("", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Pick from menu</option>
<option value="Business" <?php if (!(strcmp("Business", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Business</option>
<option value="Business 2" <?php if (!(strcmp("Business 2", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Business 2</option>
<option value="Business Fax" <?php if (!(strcmp("Business Fax", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Business Fax</option>
<option value="Car" <?php if (!(strcmp("Car", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Car</option>
<option value="Company" <?php if (!(strcmp("Company", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Company</option>
<option value="Home" <?php if (!(strcmp("Home", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Home</option>
<option value="Home Fax" <?php if (!(strcmp("Home Fax", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Home Fax</option>
<option value="Mobile" <?php if (!(strcmp("Mobile", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Mobile</option>
<option value="Other" <?php if (!(strcmp("Other", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Other</option>
<option value="Pager" <?php if (!(strcmp("Pager", $row_fmEditContacts['PhoneCmbo3']))) {echo "selected=\"selected\"";} ?>>Pager</option>
</select></td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Email:</td>
<td><input type="email" name="Email" placeholder="email" value="<?php echo htmlentities($row_fmEditContacts['Email'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Web Page:</td>
<td><input type="text" name="Web_Page" placeholder="web page" value="<?php echo htmlentities($row_fmEditContacts['Web Page'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Active:</td>
<td><input name="Active" type="checkbox" id="Active" value="1" <?php if (!(strcmp($row_fmEditContacts['Active'],1))) {echo "checked=\"checked\"";} ?> />
</td>
</tr>
</table>
</li>

<li id="threem">
<textarea name="Comments" id="Comments" autofocus placeholder="comments" cols="25" rows="15" ><?php echo $row_fmEditContacts['Comments']; ?></textarea>
</li>
</ul>
</div>
</fieldset> 

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table class="tddataleft" width="100%">
<tr class="tablevalign">
<td class="tddataright">Street:</td>
<td><input type="text" name="Address" value="<?php echo htmlentities($row_fmEditContacts['Address'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>
<td class="tddataright">Nickname: </td>
<td><input type="text" name="Nickname" value="<?php echo htmlentities($row_fmEditContacts['Nickname'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>
<td>&nbsp;</td>
</tr>
<tr class="tablevalign">
<td class="tddataright">City:</td>
<td class="tddataleft"><select name="City" id="City" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $row_fmEditContacts['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php
do {  
?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $row_fmEditContacts['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php
} while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity);
}
?>
</select>
</td>
<td class="tddataright">Spouse Name:</td>
<td class="tddataleft"><input type="text" name="Spouse_Name" value="<?php echo htmlentities($row_fmEditContacts['Spouse Name'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>
</tr>
<tr>
<td class="tddataright">State:</td>
<td><input type="text" name="State" id="State" value="<?php echo htmlentities($row_fmEditContacts['State'], ENT_COMPAT, 'UTF-8'); ?>" size="10" />
</td>
<td class="tddataright">Birthday:</td>
<td><input type="text" name="Birthday" value="<?php echo htmlentities($row_fmEditContacts['Birthday'], ENT_COMPAT, 'UTF-8'); ?>" size="32" />
</td>
</tr>
<tr class="tablevalign">
<td class="tddataright">Zip:</td>
<td class="tddataleft"><input type="text" name="Zip" id="Zip_Code" value="<?php echo htmlentities($row_fmEditContacts['Zip'], ENT_COMPAT, 'UTF-8'); ?>" size="10" /></td>
<td class="tddataright">Anniversary:</td>
<td class="tddataleft"><input type="text" name="Anniversary" value="<?php echo htmlentities($row_fmEditContacts['Anniversary'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
</table>
</fieldset>
<div id="divsubmit">
<input type="submit" value="Update" />
<input type="button" name="button" id="button" value="Cancel" onclick="history.back()" />
<input type="hidden" name="MM_update" value="formEdit" />
<input type="hidden" name="ContactNo" value="<?php echo $row_fmEditContacts['ContactNo']; ?>" />
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
  <option value="<?php echo $row_fmEditContacts['Address']; ?>, <?php echo $row_fmEditContacts['City']; ?>, <?php echo $row_fmEditContacts['State']; ?>, <?php echo $row_fmEditContacts['Zip']; ?>">Current Address</option>
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
<input type="text" name="TotalAddress" id="totalAddress" value="<?php echo $row_fmEditContacts['Address']; ?>, <?php echo $row_fmEditContacts['City']; ?>, <?php echo $row_fmEditContacts['State']; ?>, <?php echo $row_fmEditContacts['Zip']; ?>" size="45"/>
</div>
<div id="map_canvas" style="width:100%; height:450px;" ></div>
</div>
</div>
</div>
<!---------------------tab panel 1 end-->
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
mysql_free_result($fmEditContacts);
mysql_free_result($fmCity);
?>
