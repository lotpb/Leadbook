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
  $insertSQL = sprintf("INSERT INTO Leads (LeadNo, `Date`, `Last Name`, Address, City, `State`, `Zip Code`, Phone, `Apt date`, SalesNo, JobNo, `First`, Spouse, Amount, AdNo, Coments, `Call Back`, Active, Email, `Time`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['First'], "text"),
                       GetSQLValueString($_POST['Spouse'], "text"),
                       GetSQLValueString($_POST['Amount'], "double"),
                       GetSQLValueString($_POST['LookupAdNo'], "int"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['CallBack'], "text"),
                       GetSQLValueString(isset($_POST['Active']) ? "true" : "", "defined","1","0"),
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

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmSalesman = "SELECT * FROM Salesman ORDER BY Salesman.Salesman";
$fmSalesman = mysql_query($query_fmSalesman, $Leadbook) or die(mysql_error());
$row_fmSalesman = mysql_fetch_assoc($fmSalesman);
$totalRows_fmSalesman = mysql_num_rows($fmSalesman);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAdveriser = "SELECT * FROM advertising ORDER BY Advertiser ASC";
$fmAdveriser = mysql_query($query_fmAdveriser, $Leadbook) or die(mysql_error());
$row_fmAdveriser = mysql_fetch_assoc($fmAdveriser);
$totalRows_fmAdveriser = mysql_num_rows($fmAdveriser);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmJob = "SELECT * FROM Job ORDER BY Job.`Description`";
$fmJob = mysql_query($query_fmJob, $Leadbook) or die(mysql_error());
$row_fmJob = mysql_fetch_assoc($fmJob);
$totalRows_fmJob = mysql_num_rows($fmJob);

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCity = "SELECT * FROM Zip ORDER BY Zip.City";
$fmCity = mysql_query($query_fmCity, $Leadbook) or die(mysql_error());
$row_fmCity = mysql_fetch_assoc($fmCity);
$totalRows_fmCity = mysql_num_rows($fmCity);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>New Lead</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="favicon.ico">

<script src="assets/CalendarPopup.js" type="text/javascript" ></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
#teltext{font-size: 10px; }
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
<h1>New Lead</h1>
<!-- end #header --></header>

<aside id="mainContent" class="tddataleft">
<form action="<?php echo $editFormAction; ?>" method="POST" name="forminsert" id="forminsert">

<fieldset>
<legend>Leadinfo</legend>
<table id="maintable">
<tr>
<td class="tddataright">Date:</td>
<td><input type="date" name="Date" id="Date" value="<?php echo date("Y-m-d"); ?>" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Date,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">select</a></td></tr>

<tr>
<td class="tddataright">Last Name:</td><td>
<input type="text" name="Last_Name" id="Last_Name"autofocus placeholder="last name" value="" size="30" /></td></tr>

<tr>
<td align="right">Address:</td><td>
<input type="text" name="Address" placeholder="address" value="" size="41" /></td></tr>

<tr>
<td class="tddataright">City:</td><td>
<select name="LookupCity" id="LookupCity" onchange="showZip(this.value)">
<option value="" <?php if (!(strcmp("", $_GET['City']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmCity['City']?>"<?php if (!(strcmp($row_fmCity['City'], $_GET['City']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmCity['City']?></option>
<?php } while ($row_fmCity = mysql_fetch_assoc($fmCity));
$rows = mysql_num_rows($fmCity);
if($rows > 0) {
mysql_data_seek($fmCity, 0);
$row_fmCity = mysql_fetch_assoc($fmCity); } ?> </select>
<a href="ZipLookup.php">select</a></td> 
  
</tr><tr>
<td align="right">State:</td><td>
<input type="text" name="State" id="State" placeholder="NY" value="<?php echo $_GET['State']; ?>" size="5"/>
<input type="text" name="Zip_Code" id="Zip_Code" placeholder="zip code" value="<?php echo $_GET['Zip']; ?>" size="10" /></td></tr>

<tr>
<td class="tddataright">Phone:</td><td>
<input name="Phone" type="tel" placeholder="(555)555-5555" id="Phone" value="<?php echo '(516)'; ?>" size="15" /><br />
<input name="RadioGroup1" type="radio" onclick="check(this.value)"  value="(516)" checked="checked"  />
<label id="teltext">(516)</label>
<input name="RadioGroup1" type="radio" onclick="check(this.value)" value="(631)"  />
<label id="teltext">(631)</label>
<input name="RadioGroup1" type="radio" onclick="check(this.value)"  value="(718)"  />
<label id="teltext">(718)</label>
<input name="RadioGroup1" type="radio" onclick="check(this.value)"  value="(212)"  />
<label id="teltext">(212)</label>
<input name="RadioGroup1" type="radio" onclick="check(this.value)"  value="(917)"  />
<label id="teltext">(917)</label></td></tr>

<tr>
<td class="tddataright">Apt date:</td><td>
<input type="date" name="Apt_date" value="<?php echo date("Y-m-d"); ?>" size="20" />
<a href="#" onclick="cal.select(document.forms[0].Apt_date,'anchor2','yyyy-MM-dd'); return false;" name="anchor2" id="anchor2">select</a></td></tr>

<tr>
<td class="tddataright">SalesNo:</td><td>
<select name="LookupSalesman" id="LookupSalesman">
<option value="" <?php if (!(strcmp("", $row_fmLeads['SalesNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmSalesman['SalesNo']?>"<?php if (!(strcmp($row_fmSalesman['SalesNo'], $_GET['SalesNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmSalesman['Salesman']?></option>
<?php } while ($row_fmSalesman = mysql_fetch_assoc($fmSalesman));
$rows = mysql_num_rows($fmSalesman);
if($rows > 0) {
mysql_data_seek($fmSalesman, 0);
$row_fmSalesman = mysql_fetch_assoc($fmSalesman); } ?>
</select></td></tr>

<tr>
<td class="tddataright">JobNo:</td><td>
<select name="LookupJobNo" id="LookupJobNo">
<option value="" <?php if (!(strcmp("", $row_fmLeads['JobNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmJob['JobNo']?>"<?php if (!(strcmp($row_fmJob['JobNo'], $_GET['JobNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmJob['Description']?></option>
<?php } while ($row_fmJob = mysql_fetch_assoc($fmJob));
$rows = mysql_num_rows($fmJob);
if($rows > 0) {
mysql_data_seek($fmJob, 0);
$row_fmJob = mysql_fetch_assoc($fmJob); } ?>
</select></td></tr>

<tr>
<td class="tddataright">Amount:</td><td>
<input type="text" name="Amount" value="0.00" size="20" /></td></tr>

<tr>
<td class="tddataright">AdNo:</td><td>
<select name="LookupAdNo" id="LookupAdNo">
<option value="" <?php if (!(strcmp("", $row_fmLeads['AdNo']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<?php do { ?>
<option value="<?php echo $row_fmAdveriser['AdNo']?>"<?php if (!(strcmp($row_fmAdveriser['AdNo'], $_GET['AdNo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmAdveriser['Advertiser']?></option>
<?php
} while ($row_fmAdveriser = mysql_fetch_assoc($fmAdveriser));
$rows = mysql_num_rows($fmAdveriser);
if($rows > 0) {
mysql_data_seek($fmAdveriser, 0);
$row_fmAdveriser = mysql_fetch_assoc($fmAdveriser); } ?>
</select></td></tr>
</table>
        <!---------------------------------table 3 start-->
<table width="33%"  class="tddataright">

<tr>
<td height="278"><textarea name="Comments" id="Comments" placeholder="comment" cols="30" rows="20"></textarea></td><td>&nbsp;</td></tr>

<tr>
<td>&nbsp;</td></tr>
<td width="11%" align="center">Active: <input <?php if (!(strcmp($row_fmLeads['Active'],1))) {echo "checked=\"checked\"";} ?> name="Active" type="checkbox" id="Active" value="1" checked="checked" /></td>
</table>
<!------------------------------------table 3 end-->
</fieldset>
<fieldset id="fieldcolor">
<legend id="legendcolor">Additional Info</legend>
<table width="100%" class="tddataleft">

<tr>
<td width="13%" class="tddataright">Call Back:</td>
<td width="36%"><select name="CallBack" id="CallBack">
<option value="None" <?php if (!(strcmp("None", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Select from menu</option>
<option value="Sold" <?php if (!(strcmp("Sold", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Sold</option>
<option value="Canceled" <?php if (!(strcmp("Canceled", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Canceled </option>
<option value="Dead" <?php if (!(strcmp("Dead", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Dead</option>
<option value="Bought Already" <?php if (!(strcmp("Bought Already", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Bought Already</option>
<option value="Future Work" <?php if (!(strcmp("Future Work", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Future Work</option>
<option value="Looks Good" <?php if (!(strcmp("Looks Good", $row_fmLeads['Call Back']))) {echo "selected=\"selected\"";} ?>>Looks Good</option>
</select></td>
<td class="tddataright">First:</td><td>
<input type="text" name="First" placeholder="first name" onkeyup="showHint(this.value)" value="" size="20" />
<span id="txtHint"></span></td></tr>

<tr>
<td class="tddataright">Email:</td>
<td><input type="email" name="Email" placeholder="valid email address" value="" size="32" /></td>
<td class="tddataright">Spouse:</td><td>
<input type="text" name="Spouse" placeholder="spouse name" value="" size="20" /></td></tr>

<tr>
<td class="tddataright">Time:</td>

<td><input type="datetime" name="Time" value="<?php date_default_timezone_set('America/New_York'); echo date('Y-m-d H:i:s'); ?>" size="25" /></td>
<td class="tddataright">:</td>
<td></td>
</tr>
</tr>
</table>
</fieldset>
<div id="divsubmit" align="center">
<input type="submit" value="Insert" />
<input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" />
<input type="hidden" name="LeadNo" />
<input type="hidden" name="MM_insert" value="forminsert" />
</div>
</form>
    <!-- end #mainContent --></aside>
  <!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <footer id="footer">
    <!-- end #footer --></footer>
  <!-- end #container --></div>
<script type="text/javascript">
<!--

//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmSalesman);

mysql_free_result($fmAdveriser);

mysql_free_result($fmJob);

mysql_free_result($fmCity);
?>
