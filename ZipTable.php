<?php require_once('Connections/Leadbook.php'); ?>
<?php
//if (!isset($_SESSION)) {
//  session_start();
//}
//$MM_authorizedUsers = "";
//$MM_donotCheckaccess = "true";
//
//// *** Restrict Access To Page: Grant or deny access to this page
//function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
//  // For security, start by assuming the visitor is NOT authorized. 
//  $isValid = False; 
//
//  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
//  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
//  if (!empty($UserName)) { 
//    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
//    // Parse the strings into arrays. 
//    $arrUsers = Explode(",", $strUsers); 
//    $arrGroups = Explode(",", $strGroups); 
//    if (in_array($UserName, $arrUsers)) { 
//      $isValid = true; 
//    } 
//    // Or, you may restrict access to only certain users based on their username. 
//    if (in_array($UserGroup, $arrGroups)) { 
//      $isValid = true; 
//    } 
//    if (($strUsers == "") && true) { 
//      $isValid = true; 
//    } 
//  } 
//  return $isValid; 
//}
//
//$MM_restrictGoTo = "Login.php";
//if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
//  $MM_qsChar = "?";
//  $MM_referrer = $_SERVER['PHP_SELF'];
//  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
//  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
//  $MM_referrer .= "?" . $QUERY_STRING;
//  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
//  header("Location: ". $MM_restrictGoTo); 
//  exit;
//}
?>
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
  $updateSQL = sprintf("UPDATE Zip SET City=%s, `State`=%s, `Zip Code`=%s WHERE ZipNo=%s",
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip_Code'], "text"),
                       GetSQLValueString($_POST['ZipNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "ZipTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO Zip (ZipNo, City, `State`, `Zip Code`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['ZipNo'], "int"),
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip_Code'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "ZipTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//Edit Zip
$colname_fmEditZip = "-1";
if (isset($_GET['ZipNo'])) {
  $colname_fmEditZip = $_GET['ZipNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditZip = sprintf("SELECT * FROM Zip WHERE Zip.ZipNo = %s", GetSQLValueString($colname_fmEditZip, "int"));
$fmEditZip = mysql_query($query_fmEditZip, $Leadbook) or die(mysql_error());
$row_fmEditZip = mysql_fetch_assoc($fmEditZip);
$totalRows_fmEditZip = mysql_num_rows($fmEditZip);
//Zip
$maxRows_fmZip = 25;
$pageNum_fmZip = 0;
if (isset($_GET['pageNum_fmZip'])) {
  $pageNum_fmZip = $_GET['pageNum_fmZip'];
}
$startRow_fmZip = $pageNum_fmZip * $maxRows_fmZip;

$Search_fmZip = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmZip = $_REQUEST['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmZip = sprintf("SELECT * FROM Zip WHERE Zip.City LIKE %s ORDER BY Zip.City", GetSQLValueString($Search_fmZip, "text"));
$query_limit_fmZip = sprintf("%s LIMIT %d, %d", $query_fmZip, $startRow_fmZip, $maxRows_fmZip);
$fmZip = mysql_query($query_limit_fmZip, $Leadbook) or die(mysql_error());
$row_fmZip = mysql_fetch_assoc($fmZip);

if (isset($_GET['totalRows_fmZip'])) {
  $totalRows_fmZip = $_GET['totalRows_fmZip'];
} else {
  $all_fmZip = mysql_query($query_fmZip);
  $totalRows_fmZip = mysql_num_rows($all_fmZip);
}
$totalPages_fmZip = ceil($totalRows_fmZip/$maxRows_fmZip)-1;

$queryString_fmZip = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmZip") == false && 
        stristr($param, "totalRows_fmZip") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmZip = "&" . htmlentities(implode("&", $newParams));
  }
}

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Address Listing</title>

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharMenu.css" rel="stylesheet" />

<style type="text/css"> 
<!-- 

--> 
</style><!--[if IE 5]>
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

<body class="twoColFixRtHdr" onload="setFocus()">

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
<h1>Zip Code Online</h1>
</hgroup>
<!-- end #header --></header>

<section id="sidebar1">
<form id="form1" name="form1" method="get" action="ZipTable.php">
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
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>

<div><button class="tableheader"type="submit"> Records <?php echo ($startRow_fmZip + 1) ?> to <?php echo min($startRow_fmZip + $maxRows_fmZip, $totalRows_fmZip) ?> of <?php echo $totalRows_fmZip ?> </button></div> 
<!-- end #sidebar1 --></section>

<aside id="mainContent">
<header>
<div id="titlerepeat">Admin:Zip Code Listing</div>
</header>

<div id="addnew">
<?php if ($totalRows_fmZip == 0) { // Show if recordset empty ?>
There are no zip codes defined. <a href="#">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmZip > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Zip Code</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Zip Code  Listing</li>
<li class="TabbedPanelsTab">Details</li>
<li class="TabbedPanelsTab">New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table  id="nav">
  <tr>
    <td><?php if ($pageNum_fmZip > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmZip=%d%s", $currentPage, 0, $queryString_fmZip); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmZip > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmZip=%d%s", $currentPage, max(0, $pageNum_fmZip - 1), $queryString_fmZip); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmZip < $totalPages_fmZip) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmZip=%d%s", $currentPage, min($totalPages_fmZip, $pageNum_fmZip + 1), $queryString_fmZip); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_fmZip < $totalPages_fmZip) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmZip=%d%s", $currentPage, $totalPages_fmZip, $queryString_fmZip); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<table   width="100%" id="delform">
<tr>
<th>City</th>
<th>State</th>
<th>Zip Code</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmZip['City']; ?></td>
<td><?php echo $row_fmZip['State']; ?></td>
<td><?php echo $row_fmZip['Zip Code']; ?></td>
<td><a href="ZipTable.php?ZipNo=<?php echo $row_fmZip['ZipNo']; ?>" >edit</a></td>
</tr>
<?php } while ($row_fmZip = mysql_fetch_assoc($fmZip)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
  <form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
    <table>
      <tr>
        <td class="tddataright">ZipNo:</td>
        <td><?php echo $row_fmEditZip['ZipNo']; ?></td>
      </tr>
      <tr>
        <td class="tddataright">City:</td>
        <td><input type="text" name="City" value="<?php echo htmlentities($row_fmEditZip['City'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">State:</td>
        <td><input type="text" name="State" value="<?php echo htmlentities($row_fmEditZip['State'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">Zip Code:</td>
        <td><input type="text" name="Zip_Code" value="<?php echo htmlentities($row_fmEditZip['Zip Code'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">&nbsp;</td>
        <td><input type="submit" value="Update record" />
         <input type="button" name="button" id="button" value="Cancel" onclick="history.back()" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="formEdit" />
    <input type="hidden" name="ZipNo" value="<?php echo $row_fmEditZip['ZipNo']; ?>" />
  </form>
</fieldset>
</div>
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
  <form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
    <table>
      <tr>
        <td class="tddataright">ZipNo:</td>
        <td><input type="text" name="ZipNo" value="" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">City:</td>
        <td><input type="text" name="City" value="" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">State:</td>
        <td><input type="text" name="State" value="" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">Zip Code:</td>
        <td><input type="text" name="Zip_Code" value="" size="32" /></td>
      </tr>
      <tr>
        <td class="tddataright">&nbsp;</td>
        <td><input type="submit" value="Insert record" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="forminsert" />
  </form>
</fieldset>
</div>
</div>
</div>
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
mysql_free_result($fmZip);

mysql_free_result($fmEditZip);
?>
