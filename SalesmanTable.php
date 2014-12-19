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
  $updateSQL = sprintf("UPDATE Salesman SET Salesman=%s, Active=%s WHERE SalesNo=%s",
                       GetSQLValueString($_POST['Salesman'], "text"),
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['SalesNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO Salesman (SalesNo, Salesman, Active) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['SalesNo'], "int"),
                       GetSQLValueString($_POST['Salesman'], "text"),
                       GetSQLValueString($_POST['Active'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());
}
//Edit Salesman
$colname_fmEditsalesman = "-1";
if (isset($_GET['SalesNo'])) {
  $colname_fmEditsalesman = $_GET['SalesNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditsalesman = sprintf("SELECT * FROM Salesman WHERE SalesNo = %s", GetSQLValueString($colname_fmEditsalesman, "int"));
$fmEditsalesman = mysql_query($query_fmEditsalesman, $Leadbook) or die(mysql_error());
$row_fmEditsalesman = mysql_fetch_assoc($fmEditsalesman);
$totalRows_fmEditsalesman = mysql_num_rows($fmEditsalesman);
//Salesman
$maxRows_fmSalesman = 25;
$pageNum_fmSalesman = 0;
if (isset($_GET['pageNum_fmSalesman'])) {
  $pageNum_fmSalesman = $_GET['pageNum_fmSalesman'];
}
$startRow_fmSalesman = $pageNum_fmSalesman * $maxRows_fmSalesman;

$Search_fmSalesman = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmSalesman = $_REQUEST['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmSalesman = sprintf("SELECT * FROM Salesman WHERE Salesman.Salesman LIKE %s ORDER BY Salesman.Salesman", GetSQLValueString($Search_fmSalesman, "text"));
$query_limit_fmSalesman = sprintf("%s LIMIT %d, %d", $query_fmSalesman, $startRow_fmSalesman, $maxRows_fmSalesman);
$fmSalesman = mysql_query($query_limit_fmSalesman, $Leadbook) or die(mysql_error());
$row_fmSalesman = mysql_fetch_assoc($fmSalesman);

if (isset($_GET['totalRows_fmSalesman'])) {
  $totalRows_fmSalesman = $_GET['totalRows_fmSalesman'];
} else {
  $all_fmSalesman = mysql_query($query_fmSalesman);
  $totalRows_fmSalesman = mysql_num_rows($all_fmSalesman);
}
$totalPages_fmSalesman = ceil($totalRows_fmSalesman/$maxRows_fmSalesman)-1;

$queryString_fmSalesman = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmSalesman") == false && 
        stristr($param, "totalRows_fmSalesman") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmSalesman = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmSalesman = sprintf("&totalRows_fmSalesman=%d%s", $totalRows_fmSalesman, $queryString_fmSalesman);

$currentPage = $_SERVER["PHP_SELF"]; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Salesman Listing</title>
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
<h1>Salesman Online</h1>
</hgroup>
<!-- end #header --></header>
<section id="sidebar1">
<form id="form1" name="form1" method="get" action="SalesmanTable.php">
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

<div><button class="tableheader"type="submit"> Records <?php echo ($startRow_fmSalesman + 1) ?> to <?php echo min($startRow_fmSalesman + $maxRows_fmSalesman, $totalRows_fmSalesman) ?> of <?php echo $totalRows_fmSalesman ?> </button></div>

<!-- end #sidebar1 --></section>
<aside id="mainContent">
<header>

<div id="titlerepeat">Admin:Salesman Listing</div>
</header>

<div id="addnew">
<?php if ($totalRows_fmSalesman == 0) { // Show if recordset empty ?>
There are no salesman defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmSalesman > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Salesman</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Salesman Listing</li>
<li class="TabbedPanelsTab">Details</li>
<li class="TabbedPanelsTab"> New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table  id="nav">
  <tr>
    <td><?php if ($pageNum_fmSalesman > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmSalesman=%d%s", $currentPage, 0, $queryString_fmSalesman); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmSalesman > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmSalesman=%d%s", $currentPage, max(0, $pageNum_fmSalesman - 1), $queryString_fmSalesman); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmSalesman < $totalPages_fmSalesman) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmSalesman=%d%s", $currentPage, min($totalPages_fmSalesman, $pageNum_fmSalesman + 1), $queryString_fmSalesman); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_fmSalesman < $totalPages_fmSalesman) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmSalesman=%d%s", $currentPage, $totalPages_fmSalesman, $queryString_fmSalesman); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<table width="100%" id="delform">
<tr>
<th>SalesNo</th>
<th>Salesman</th>
<th>Active</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmSalesman['SalesNo']; ?></td>
<td><?php echo $row_fmSalesman['Salesman']; ?></td>
<td><?php echo $row_fmSalesman['Active']; ?></td>
<td><a href="SalesmanTable.php?SalesNo=<?php echo $row_fmSalesman['SalesNo']; ?>" >edit</a></td>
</tr>
<?php } while ($row_fmSalesman = mysql_fetch_assoc($fmSalesman)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<form action="<?php echo $editFormAction; ?>" method="post" name="formEdit" id="formEdit">
<table>
<tr>
<td class="tddataright">SalesNo:</td>
<td>&nbsp;</td>
</tr>
<tr>
<td class="tddataright">Salesman:</td>
<td><input type="text" name="Salesman" value="<?php echo htmlentities($row_fmEditsalesman['Salesman'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Active:</td>
<td><input type="checkbox" name="Active" value="Active" <?php if (!(strcmp(htmlentities($row_fmEditsalesman['Active'],ENT_COMPAT, 'UTF-8'),"Active"))) {echo "checked=\"checked\"";} ?> /></td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
<td><input type="submit" value="Update record" /></td>
</tr>
</table>
<input type="hidden" name="MM_update" value="formEdit" />
<input type="hidden" name="SalesNo" value="<?php echo $row_fmEditsalesman['SalesNo']; ?>" />
</form>
</fieldset>
</div>

<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<table>
<tr>
<td class="tddataright">SalesNo:</td>
<td>
<input type="text" name="SalesNo" value="" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Salesman:</td>
<td>
<input type="text" name="Salesman" value="" size="32" /></td>
</tr>
<tr>
<td class="tddataright">Active:</td>
<td>
<select name="Active">
<option value="Active" <?php if (!(strcmp("Active", $row_fmSalesman['Active']))) {echo "selected=\"selected\"";} ?>>Active</option>
<option value=""  <?php if (!(strcmp("", $row_fmSalesman['Active']))) {echo "selected=\"selected\"";} ?>>Not Active</option>
</select>
</td>
</tr>
<tr>
<td class="tddataright">&nbsp;</td>
<td>
<input type="submit" value="Insert record" /></td>
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
mysql_free_result($fmSalesman);
mysql_free_result($fmEditsalesman);
?>
