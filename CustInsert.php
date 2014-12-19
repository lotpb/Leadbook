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
  $insertSQL = sprintf("INSERT INTO Customer (CustNo, LeadNo, `Date`, Address, City, `State`, `Zip Code`, Phone, Quan, JobNo, Amount, `Start Date`, `Completion Date`, SalesNo, Comments, ProductNo, Active, Rate, `Contractor`, Email, `First`, Spouse) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CustNo'], "int"),
                       GetSQLValueString($_POST['LeadNo'], "int"),
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['LookupCity'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip_Code'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Quan'], "int"),
                       GetSQLValueString($_POST['LookupJobNo'], "int"),
                       GetSQLValueString($_POST['Amount'], "double"),
                       GetSQLValueString($_POST['Start_Date'], "date"),
                       GetSQLValueString($_POST['Completion_Date'], "date"),
                       GetSQLValueString($_POST['LookupSalesman'], "int"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['LookupProductNo'], "int"),
                       GetSQLValueString(isset($_POST['Active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Rate'], "text"),
                       GetSQLValueString($_POST['Contractor'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['First'], "text"),
                       GetSQLValueString($_POST['Spouse'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "CustTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmJobs = "SELECT * FROM Job ORDER BY Job.`Description`";
$fmJobs = mysql_query($query_fmJobs, $Leadbook) or die(mysql_error());
$row_fmJobs = mysql_fetch_assoc($fmJobs);
$totalRows_fmJobs = mysql_num_rows($fmJobs);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmProducts = "SELECT * FROM Product ORDER BY Product.Products";
$fmProducts = mysql_query($query_fmProducts, $Leadbook) or die(mysql_error());
$row_fmProducts = mysql_fetch_assoc($fmProducts);
$totalRows_fmProducts = mysql_num_rows($fmProducts);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeads = "SELECT Leads.LeadNo, Leads.`Last Name` FROM Leads  ORDER BY Leads.LeadNo DESC LIMIT 0, 30 ";
$fmLeads = mysql_query($query_fmLeads, $Leadbook) or die(mysql_error());
$row_fmLeads = mysql_fetch_assoc($fmLeads);
$totalRows_fmLeads = mysql_num_rows($fmLeads);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmSalesman = "SELECT * FROM Salesman ORDER BY Salesman.Salesman";
$fmSalesman = mysql_query($query_fmSalesman, $Leadbook) or die(mysql_error());
$row_fmSalesman = mysql_fetch_assoc($fmSalesman);
$totalRows_fmSalesman = mysql_num_rows($fmSalesman);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustomer = "SELECT Customer.CustNo, Customer.LeadNo, Customer.`Date`, Customer.Address, Customer.City, Customer.`State`, Customer.`Zip Code`, Customer.Phone, Customer.Quan, Customer.JobNo, Customer.Amount, Customer.`Start Date`, Customer.`Completion Date`, Customer.SalesNo, Customer.Comments, Customer.ProductNo, Customer.Active, Customer.Rate, Customer.`Contractor`, Customer.Photo, Customer.Photo1, Customer.Photo2, Customer.Email, Customer.`First`, Customer.Spouse FROM Customer";
$fmCustomer = mysql_query($query_fmCustomer, $Leadbook) or die(mysql_error());
$row_fmCustomer = mysql_fetch_assoc($fmCustomer);
$totalRows_fmCustomer = mysql_num_rows($fmCustomer);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>New Customer</title>
<meta charset="utf-8" />
<link rel="icon" href="favicon.ico">

<script src="assets/CalendarPopup.js" type="text/javascript" ></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="Stylesheets/Col2text.css" rel="stylesheet" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" />
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" />
<style type="text/css">
<!--
#carbonForm{/* The main form container */
width:850px;
}
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
var cal = new CalendarPopup()
</script>
</head>
<body class="twoColFixRtHdr">
<div id="carbonForm">
<header id="header">
<h1>New Customer</h1>
<!-- end #header --></header>
<aside id="mainContent" class="tddataleft">
<form action="<?php echo $editFormAction; ?>" method="POST" name="forminsert" id="forminsert">
<fieldset>
<legend>Customer Info</legend>
<table id="maintable">
<tr>
<td class="tddataright">Last Name:</td>
<td><!-----too slow below-->
<select name="LeadNo" id="LeadNo" autofocus tabindex="0">
<option value="" <?php if (!(strcmp("", $_REQUEST['LeadNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmLeads['LeadNo']?>"<?php if (!(strcmp($row_fmLeads['LeadNo'], $_REQUEST['LeadNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmLeads['Last Name']?></option>
<?php } while ($row_fmLeads = mysql_fetch_assoc($fmLeads));
$rows = mysql_num_rows($fmLeads);
if($rows > 0) {
mysql_data_seek($fmLeads, 0);
$row_fmLeads = mysql_fetch_assoc($fmLeads); } ?>
</select></td></tr> <!-----too slow above-->

<tr>
<td class="tddataright">Date:</td>
<td><input type="date" name="Date" id="Date" value="<?php echo date("Y-m-d"); ?>" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Date,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">select</a></td></tr>

<tr>
<td class="tddataright">&nbsp;</td>
</tr>

<tr>
<td class="tddataright">Address:</td>
<td><input type="text" name="Address" size="32" placeholder="address" value="<?php echo $_REQUEST['Address']; ?>"/></td></tr>

<tr>
<td class="tddataright">&nbsp;</td>
<td><select name="LookupCity" id="LookupCity" onchange="showZip(this.value)" tabindex="1">
<option value="" <?php if (!(strcmp("", $_GET['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $_REQUEST['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php } while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity); } ?>
</select> <input type="text" name="State" id="State" placeholder="state" value="<?php echo $_REQUEST['State']; ?>" size="3" />
<input type="text" name="Zip_Code" id="Zip_Code" placeholder="zip code" value="<?php echo $_REQUEST['Zip']; ?>" size="10" /></td></tr>

<tr>
<td class="tddataright">&nbsp;</td>
<td></td></tr>

<tr>
<td class="tddataright">Phone:</td>
<td><input type="text" placeholder="(555)555-5555" name="Phone" value="<?php echo $_REQUEST['Phone']; ?>" size="20" />
<br /></td></tr>

<tr>
<td class="tddataright">SalesNo:</td>
<td><select name="LookupSalesman" id="LookupSalesman" tabindex="1">
<option value="" <?php if (!(strcmp("", $_GET['SalesNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmSalesman['SalesNo']?>"<?php if (!(strcmp($row_fmSalesman['SalesNo'], $_REQUEST['SalesNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmSalesman['Salesman']?></option>
<?php } while ($row_fmSalesman = mysql_fetch_assoc($fmSalesman));
$rows = mysql_num_rows($fmSalesman);
if($rows > 0) {
mysql_data_seek($fmSalesman, 0);
$row_fmSalesman = mysql_fetch_assoc($fmSalesman); } ?>
</select></td></tr>
          
<tr>
<td class="tddataright">JobNo:</td>
<td><select name="LookupJobNo" id="LookupJobNo">
<option value="" <?php if (!(strcmp("", $_GET['Job']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmJobs['JobNo']?>"<?php if (!(strcmp($row_fmJobs['JobNo'], $_REQUEST['Job']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmJobs['Description']?></option>
<?php } while ($row_fmJobs = mysql_fetch_assoc($fmJobs));
$rows = mysql_num_rows($fmJobs);
if($rows > 0) {
mysql_data_seek($fmJobs, 0);
$row_fmJobs = mysql_fetch_assoc($fmJobs); } ?>
</select></td></tr>

<tr>
<td class="tddataright">Qty:</td>
<td><input type="number" min="0" max="10000000" step="1" name="Quan" placeholder="# windows" value="" size="10" /></td></tr>

<tr>
<td class="tddataright">ProductNo:</td>
<td><select name="LookupProductNo" id="LookupProductNo">
<option value="" <?php if (!(strcmp("", $row_fmCustomer['ProductNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmProducts['ProductNo']?>"<?php if (!(strcmp($row_fmProducts['ProductNo'], $_REQUEST['ProductNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmProducts['Products']?></option>
<?php } while ($row_fmProducts = mysql_fetch_assoc($fmProducts));
$rows = mysql_num_rows($fmProducts);
if($rows > 0) {
mysql_data_seek($fmProducts, 0);
$row_fmProducts = mysql_fetch_assoc($fmProducts);} ?>
</select></td></tr>

<tr>
<td class="tddataright">Amount:</td>
<td><input type="text" name="Amount" value="<?php echo $_REQUEST['Amount']; ?>" size="20" /></td></tr>
</table>

<!---------------------------------table 3 start-->
<table width="33%"  class="tddataright">

<tr>
<td><textarea name="Comments" id="Comments" placeholder="comment" value="<?php echo $_REQUEST['Comments']; ?>"cols="30" rows="20"></textarea></td></tr>

<tr>
<td>&nbsp;</td></tr>

<tr>
<td align="Center">Active: <input <?php if (!(strcmp($row_fmCustomer['Active'],1))) {echo "checked=\"checked\"";} ?> name="Active" type="checkbox" value="1" checked="checked" /></td>
<td>&nbsp;</td></tr>
</table>
<!------------------------------------table 3 end-->
</fieldset>

<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table width="100%" align="center">

<tr>
<td class="tddataright">First Name:</td>
<td><input type="text" name="First" placeholder="first name" onkeyup="showHint(this.value)" value="<?php echo $_REQUEST['First']; ?>" size="20" /><span id="txtHint"></span></td>
<td class="tddataright">Rate:</td>
<td><input type="text" name="Rate" id="Rate" value="None" size="10" />
<select name="selectrate" id="selectrate" onchange="favRate()">
<option selected="selected">Select Rate</option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>
</select></td></tr>

<tr>
<td class="tddataright">Spouse:</td>
<td><input type="text" name="Spouse" placeholder="spouse" value="<?php echo $_REQUEST['Spouse']; ?>" size="20" /></td>
<td class="tddataright">Contractor:</td>
<td><input type="text" name="Contractor" placeholder="contractor" value="<?php echo $_REQUEST['Contractor']; ?>" size="20" /></td></tr>

<tr>
<td class="tddataright">Email:</td>
<td><input type="email" name="Email" placeholder="valid email address" value"<?php echo $_REQUEST['Email']; ?>" size="32" /></td>
<td class="tddataright">Start:</td>
<td><input type="date" name="Start_Date" value="<?php echo date("Y-m-d"); ?>" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Start_Date,'anchor2','yyyy-MM-dd'); return false;" name="anchor1" id="anchor2">select</a></td></tr>

<tr>
<td class="tddataright"></td>
<td>&nbsp;</td>
<td class="tddataright">Completion:</td>
<td><input type="date" name="Completion_Date" value="<?php echo date("Y-m-d"); ?>" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Completion_Date,'anchor3','yyyy-MM-dd'); return false;" name="anchor1" id="anchor3" /> select</a></td></tr>
</table>
</fieldset>
<div id="divsubmit" align="center">
<input type="submit" value="Insert" />
<input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" />
<input type="hidden" name="CustNo" id="CustNo" />
<input type="hidden" name="MM_insert" value="forminsert" />
</div>
</form>
<!-- end #mainContent --></aside>
  <!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <div id="footer">
    <!-- end #footer --></div>
  <!-- end #container --></div>
<script type="text/javascript">
<!--

-->
</script>
</body>
</html>
<?php
mysql_free_result($fmCustomer);

mysql_free_result($fmCity);

mysql_free_result($fmJobs);

mysql_free_result($fmProducts);

mysql_free_result($fmLeads);

mysql_free_result($fmSalesman);
?>