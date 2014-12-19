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
  $insertSQL = sprintf("INSERT INTO advertising (AdNo, Advertiser, Active) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['AdNo'], "int"),
                       GetSQLValueString($_POST['Advertiser'], "text"),
                       GetSQLValueString($_POST['Active'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEdit")) {
  $updateSQL = sprintf("UPDATE advertising SET Advertiser=%s, Active=%s WHERE AdNo=%s",
                       GetSQLValueString($_POST['Advertiser'], "text"),
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['AdNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());
}
//Edit Advertise
$colname_fmEditadvertise = "-1";
if (isset($_GET['AdNo'])) {
  $colname_fmEditadvertise = $_GET['AdNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditadvertise = sprintf("SELECT * FROM advertising WHERE advertising.AdNo = %s", GetSQLValueString($colname_fmEditadvertise, "int"));
$fmEditadvertise = mysql_query($query_fmEditadvertise, $Leadbook) or die(mysql_error());
$row_fmEditadvertise = mysql_fetch_assoc($fmEditadvertise);
$totalRows_fmEditadvertise = mysql_num_rows($fmEditadvertise);
//Advertise
$maxRows_fmAdvertise = 25;
$pageNum_fmAdvertise = 0;
if (isset($_GET['pageNum_fmAdvertise'])) {
  $pageNum_fmAdvertise = $_GET['pageNum_fmAdvertise'];
}
$startRow_fmAdvertise = $pageNum_fmAdvertise * $maxRows_fmAdvertise;

$Search_fmAdvertise = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmAdvertise = $_REQUEST['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAdvertise = sprintf("SELECT * FROM advertising WHERE advertising.Advertiser LIKE %s ORDER BY advertising.Advertiser", GetSQLValueString($Search_fmAdvertise, "text"));
$query_limit_fmAdvertise = sprintf("%s LIMIT %d, %d", $query_fmAdvertise, $startRow_fmAdvertise, $maxRows_fmAdvertise);
$fmAdvertise = mysql_query($query_limit_fmAdvertise, $Leadbook) or die(mysql_error());
$row_fmAdvertise = mysql_fetch_assoc($fmAdvertise);

if (isset($_GET['totalRows_fmAdvertise'])) {
  $totalRows_fmAdvertise = $_GET['totalRows_fmAdvertise'];
} else {
  $all_fmAdvertise = mysql_query($query_fmAdvertise);
  $totalRows_fmAdvertise = mysql_num_rows($all_fmAdvertise);
}
$totalPages_fmAdvertise = ceil($totalRows_fmAdvertise/$maxRows_fmAdvertise)-1;

$queryString_fmAdvertise = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmAdvertise") == false && 
        stristr($param, "totalRows_fmAdvertise") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmAdvertise = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmAdvertise = sprintf("&totalRows_fmAdvertise=%d%s", $totalRows_fmAdvertise, $queryString_fmAdvertise);

$currentPage = $_SERVER["PHP_SELF"]; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Advertise Listing</title>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
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
<![endif]--><!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColFixRtHdr #sidebar1 { padding-top: 30px; }
.twoColFixRtHdr #mainContent { zoom: 1; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->

<script type="text/javascript">
</script>
</head>
<body class="twoColFixRtHdr">

<div id="carbonForm">
<div id="header">
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
<h1>Advertising Online</h1>
</hgroup>
<!-- end #header --></div>

<div id="sidebar1">
<form id="form1" name="form1" method="get" action="AdvertiseTable.php">

<p>
<input name="Search" type="text" id="Search" value="<?php echo $_REQUEST['Search']; ?>" size="18" />
<input type="submit" value="Search" />
<br />
</p>

</form>
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<div><button class="tableheader"type="submit"> Records <?php echo ($startRow_fmAdvertise + 1) ?> to <?php echo min($startRow_fmAdvertise + $maxRows_fmAdvertise, $totalRows_fmAdvertise) ?> of <?php echo $totalRows_fmAdvertise ?> </button></div> 
<!-- end #sidebar1 -->
</div>
<div id="mainContent">
<header>
<div id="titlerepeat">Admin:Advertise Listing</div>
</header>

<div id="addnew">
<?php if ($totalRows_fmAdvertise == 0) { // Show if recordset empty ?>
There are no advertising defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmAdvertise > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Advertising</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Advertising</li>
<li class="TabbedPanelsTab">Details</li>
<li class="TabbedPanelsTab">New</li>
</ul>
<div class="TabbedPanelsContentGroup">

<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table id="nav">
<tr>
<td><?php if ($pageNum_fmAdvertise > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmAdvertise=%d%s", $currentPage, 0, $queryString_fmAdvertise); ?>">First</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmAdvertise > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmAdvertise=%d%s", $currentPage, max(0, $pageNum_fmAdvertise - 1), $queryString_fmAdvertise); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmAdvertise < $totalPages_fmAdvertise) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmAdvertise=%d%s", $currentPage, min($totalPages_fmAdvertise, $pageNum_fmAdvertise + 1), $queryString_fmAdvertise); ?>">Next</a>
<?php } // Show if not last page ?>
</td>
<td><?php if ($pageNum_fmAdvertise < $totalPages_fmAdvertise) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmAdvertise=%d%s", $currentPage, $totalPages_fmAdvertise, $queryString_fmAdvertise); ?>">Last</a>
<?php } // Show if not last page ?>
</td></tr>
</table>

<table width="100%" id="delform">
<tr>
<th>AdNo</th>
<th>Advertiser</th>
<th>Active</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmAdvertise['AdNo']; ?></td>
<td><?php echo $row_fmAdvertise['Advertiser']; ?></td>
<td><?php echo $row_fmAdvertise['Active']; ?></td>
<td><a onclick="onclick=TabbedPanels1.showPanel(1); return false;" href="AdvertiseTable.php?AdNo=<?php echo $row_fmAdvertise['AdNo']; ?>">edit</a></td>
</tr>
<?php } while ($row_fmAdvertise = mysql_fetch_assoc($fmAdvertise)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
<table>
<tr>
<td class="tddataright">AdNo:</td>
<td><?php echo $row_fmEditadvertise['AdNo']; ?></td></tr>

<tr>
<td class="tddataright">Advertiser:</td>
<td><input type="text" name="Advertiser2" value="<?php echo htmlentities($row_fmEditadvertise['Advertiser'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td></tr>

<tr>
<td class="tddataright">Active:</td>
<td><input type="checkbox" name="Active2" value="Active" <?php if (!(strcmp(htmlentities($row_fmEditadvertise['Active'],ENT_COMPAT, 'UTF-8'),"Active"))) {echo "checked=\"checked\"";} ?> /></td></tr>

<tr>
<td class="tddataright">&nbsp;</td>
<td><input type="submit" value="Update record" /></td></tr>
</table>

<input type="hidden" name="MM_update" value="formEdit" />
<input type="hidden" name="AdNo2" value="<?php echo $row_fmEditadvertise['AdNo']; ?>" />
</form>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<fieldset id="fieldcolor"> 
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<table>
<tr>
<td class="tddataright">AdNo:</td>
<td><input type="text" name="AdNo" value="" size="32" /></td></tr>

<tr>
<td class="tddataright">Advertiser:</td>
<td><input type="text" name="Advertiser" value="" size="32" /></td></tr>

<tr>
<td class="tddataright">Active:</td>
<td><input type="checkbox" name="Active" value="Active" checked="checked" /></td></tr>

<tr>
<td class="tddataright">&nbsp;</td>
<td><input type="submit" value="Insert record" /></td></tr>
</table>

<input type="hidden" name="MM_insert" value="forminsert" />
</form>
</fieldset>
</div>
</div>
</div>
  <!-- end #mainContent --></div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <div id="footer">
  <!-- end #footer --></div>
<!-- end #container --></div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmAdvertise);
mysql_free_result($fmEditadvertise);
?>
