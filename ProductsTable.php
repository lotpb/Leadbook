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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE Product SET Products=%s, Active=%s WHERE ProductNo=%s",
                       GetSQLValueString($_POST['Products'], "text"),
                       GetSQLValueString($_POST['Active'], "text"),
                       GetSQLValueString($_POST['ProductNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "ProductsTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
  $insertSQL = sprintf("INSERT INTO Product (ProductNo, Products, Active) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['ProductNo'], "int"),
                       GetSQLValueString($_POST['Products'], "text"),
                       GetSQLValueString($_POST['Active'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "ProductsTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//Edit Product
$colname_fmEditproduct = "-1";
if (isset($_GET['ProductNo'])) {
  $colname_fmEditproduct = $_GET['ProductNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmEditproduct = sprintf("SELECT * FROM Product WHERE ProductNo = %s", GetSQLValueString($colname_fmEditproduct, "int"));
$fmEditproduct = mysql_query($query_fmEditproduct, $Leadbook) or die(mysql_error());
$row_fmEditproduct = mysql_fetch_assoc($fmEditproduct);
$totalRows_fmEditproduct = mysql_num_rows($fmEditproduct);
//Product
$maxRows_fmProduct = 25;
$pageNum_fmProduct = 0;
if (isset($_GET['pageNum_fmProduct'])) {
  $pageNum_fmProduct = $_GET['pageNum_fmProduct'];
}
$startRow_fmProduct = $pageNum_fmProduct * $maxRows_fmProduct;

$Search_fmProduct = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmProduct = $_REQUEST['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmProduct = sprintf("SELECT * FROM Product WHERE Product.Products LIKE %s ORDER BY Product.Products", GetSQLValueString($Search_fmProduct, "text"));
$query_limit_fmProduct = sprintf("%s LIMIT %d, %d", $query_fmProduct, $startRow_fmProduct, $maxRows_fmProduct);
$fmProduct = mysql_query($query_limit_fmProduct, $Leadbook) or die(mysql_error());
$row_fmProduct = mysql_fetch_assoc($fmProduct);

if (isset($_GET['totalRows_fmProduct'])) {
  $totalRows_fmProduct = $_GET['totalRows_fmProduct'];
} else {
  $all_fmProduct = mysql_query($query_fmProduct);
  $totalRows_fmProduct = mysql_num_rows($all_fmProduct);
}
$totalPages_fmProduct = ceil($totalRows_fmProduct/$maxRows_fmProduct)-1;

$queryString_fmProduct = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmProduct") == false && 
        stristr($param, "totalRows_fmProduct") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmProduct = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmProduct = sprintf("&totalRows_fmProduct=%d%s", $totalRows_fmProduct, $queryString_fmProduct);

$currentPage = $_SERVER["PHP_SELF"]; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Product Listing</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="Stylesheets/tableCasablanca.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Addresstext.css" rel="stylesheet" type="text/css" media="screen" />

<style type="text/css"> 
<!-- 
ul.MenuBarHorizontal a{ color:#FFFFFF; background-color: #333333; }
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
<form id="form1" name="form1" method="get" action="SalesmanTable.php">
<p>
<input name="Search" type="text" id="Search" autofocus value="<?php echo $_REQUEST['Search']; ?>" size="18" />
<input type="submit" value="Search" />
<br />
</p>
</form>
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>
<h3>&nbsp;
Records <?php echo ($startRow_fmProduct + 1) ?> to <?php echo min($startRow_fmProduct + $maxRows_fmProduct, $totalRows_fmProduct) ?> of <?php echo $totalRows_fmProduct ?> </h3>
<h3>&nbsp;</h3>
<!-- end #sidebar1 --></section>
<aside id="mainContent">
<header>
<h1 class="style1">&nbsp; </h1>
<h1 class="stylered">Admin:Products Listing</h1>
<h3>The following is a list of all products</h3>
</header>
<p>
<?php if ($totalRows_fmProduct == 0) { // Show if recordset empty ?>
There are no products defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?> 
</p>
<?php if ($totalRows_fmProduct > 0) { // Show if recordset not empty ?>
<p><a href="" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Product Type</a></p>
<?php } // Show if recordset not empty ?>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Product Listing</li>
<li class="TabbedPanelsTab">Details</li>
<li class="TabbedPanelsTab"> New</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
  <table  id="nav">
    <tr>
      <td><?php if ($pageNum_fmProduct > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_fmProduct=%d%s", $currentPage, 0, $queryString_fmProduct); ?>">First</a>
            <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_fmProduct > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_fmProduct=%d%s", $currentPage, max(0, $pageNum_fmProduct - 1), $queryString_fmProduct); ?>">Previous</a>
            <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_fmProduct < $totalPages_fmProduct) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_fmProduct=%d%s", $currentPage, min($totalPages_fmProduct, $pageNum_fmProduct + 1), $queryString_fmProduct); ?>">Next</a>
            <?php } // Show if not last page ?>
      </td>
      <td><?php if ($pageNum_fmProduct < $totalPages_fmProduct) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_fmProduct=%d%s", $currentPage, $totalPages_fmProduct, $queryString_fmProduct); ?>">Last</a>
            <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>
</p>
<table  id="cart">
<tr>
<th>ProductNo</th>
<th>Products</th>
<th>Active</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr>
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmProduct['ProductNo']; ?></td>
<td><?php echo $row_fmProduct['Products']; ?></td>
<td><?php echo $row_fmProduct['Active']; ?></td>
<td><a href="ProductsTable.php?ProductNo=<?php echo $row_fmProduct['ProductNo']; ?>" >edit</a></td>
</tr>
<?php } while ($row_fmProduct = mysql_fetch_assoc($fmProduct)); ?>
</table>
</div>
<div class="TabbedPanelsContent">Content 2
<form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
<table align="center">

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">ProductNo:</td>
<td><?php echo $row_fmEditproduct['ProductNo']; ?></td></tr>

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">Products:</td>
<td><input type="text" name="Products" value="<?php echo htmlentities($row_fmEditproduct['Products'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td></tr>

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">Active:</td>
<td><input type="checkbox" name="Active" value="Active" <?php if (!(strcmp(htmlentities($row_fmEditproduct['Active']),"Active"))) {echo "checked=\"checked\"";} ?> /></td></tr>

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">&nbsp;</td>
<td><input type="submit" value="Update record" /></td></tr>
</table>

<input type="hidden" name="MM_update" value="form3" />
<input type="hidden" name="ProductNo" value="<?php echo $row_fmEditproduct['ProductNo']; ?>" />
</form>
<p>&nbsp;</p>
</div>
<div class="TabbedPanelsContent">Content 3
<form action="<?php echo $editFormAction; ?>" method="post" name="form4" id="form4">
<table align="center">

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">ProductNo:</td>
<td><input type="text" name="ProductNo" value="" size="32" /></td></tr>

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">Products:</td>
<td><input type="text" name="Products" value="" size="32" /></td></tr>

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">Active:</td>
<td><input type="checkbox" name="Active" value="Active" checked="checked" /></td></tr>

<tr class="tablevalign">
<td nowrap="nowrap" class="tddataright">&nbsp;</td>
<td><input type="submit" value="Insert record" /></td></tr>
</table>
<input type="hidden" name="MM_insert" value="form4" />
</form>
  <p>&nbsp;</p>
</div>
</div>
</div>
  <!-- end #mainContent --></aside>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <footer id="footer">
    <p>&copy;copyright 2010 Leadbook Software.dev</p>
  <!-- end #footer --></footer>
<!-- end #container --></div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmProduct);
mysql_free_result($fmEditproduct);
?>
