<?php require_once('Connections/Leadbook.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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
//RegLoginEdit
$colname_fmRegLoginEdit = "-1";
if (isset($_GET['AdminNo'])) {
  $colname_fmRegLoginEdit = $_GET['AdminNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmRegLoginEdit = sprintf("SELECT * FROM Addressadmin WHERE Addressadmin.AdmindNo = %s", GetSQLValueString($colname_fmRegLoginEdit, "int"));
$fmRegLoginEdit = mysql_query($query_fmRegLoginEdit, $Leadbook) or die(mysql_error());
$row_fmRegLoginEdit = mysql_fetch_assoc($fmRegLoginEdit);
$totalRows_fmRegLoginEdit = mysql_num_rows($fmRegLoginEdit);
//AdressAdmin
$maxRows_fmRegLogin = 10;
$pageNum_fmRegLogin = 0;
if (isset($_GET['pageNum_fmRegLogin'])) {
  $pageNum_fmRegLogin = $_GET['pageNum_fmRegLogin'];
}
$startRow_fmRegLogin = $pageNum_fmRegLogin * $maxRows_fmRegLogin;

$Search_fmRegLogin = "%";
if (isset($_GET['Search'])) {
  $Search_fmRegLogin = $_GET['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmRegLogin = sprintf("SELECT Addressadmin.AdmindNo, Addressadmin.`First Name`, Addressadmin.`Last Name`, Addressadmin.Email, Addressadmin.Adminpassword, Addressadmin.Active FROM Addressadmin WHERE Addressadmin.`Last Name` LIKE %s", GetSQLValueString($Search_fmRegLogin, "text"));
$query_limit_fmRegLogin = sprintf("%s LIMIT %d, %d", $query_fmRegLogin, $startRow_fmRegLogin, $maxRows_fmRegLogin);
$fmRegLogin = mysql_query($query_limit_fmRegLogin, $Leadbook) or die(mysql_error());
$row_fmRegLogin = mysql_fetch_assoc($fmRegLogin);

if (isset($_GET['totalRows_fmRegLogin'])) {
  $totalRows_fmRegLogin = $_GET['totalRows_fmRegLogin'];
} else {
  $all_fmRegLogin = mysql_query($query_fmRegLogin);
  $totalRows_fmRegLogin = mysql_num_rows($all_fmRegLogin);
}
$totalPages_fmRegLogin = ceil($totalRows_fmRegLogin/$maxRows_fmRegLogin)-1;

$queryString_fmRegLogin = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmRegLogin") == false && 
        stristr($param, "totalRows_fmRegLogin") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmRegLogin = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmRegLogin = sprintf("&totalRows_fmRegLogin=%d%s", $totalRows_fmRegLogin, $queryString_fmRegLogin);


$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "forminsert")) {
  $updateSQL = sprintf("UPDATE Addressadmin SET `First Name`=%s, `Last Name`=%s, Email=%s, Adminpassword=%s, Active=%s WHERE AdmindNo=%s",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Adminpassword'], "text"),
                       GetSQLValueString($_POST['Active'], "int"),
                       GetSQLValueString($_POST['AdmindNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "RegLoginTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Registration Listing</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" type="text/css">

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
<div id="header">
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
<h1>Login Online</h1>

<!-- end #header --></div>
<div id="sidebar1">
<form id="form1" name="form1" method="get" action="RegLoginTable.php">
<p>
<input name="Search" type="text" id="Search" value="Search<?php echo $_REQUEST['Search']; ?>" size="18" />
<button class="magglass"type="submit"><img src="images/magglass.png" alt="Search"></button>
<br />
<select name="SelectState" id="SelectState" onchange="favState()">
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


<div><button class="tableheader"type="submit">Print Customers</button></div> 
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>
<!-- end #sidebar1 --></div>

<header>
<div id="titlerepeat">Admin:Registration Login</div>
</header>
<div id="mainContent" class="tddataleft">

<div id="addnew">
<?php if ($totalRows_fmRegLogin == 0) { // Show if recordset empty ?>
There are no registration login defined. <a href="RegLogin.php">Add one...</a>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_fmRegLogin > 0) { // Show if recordset not empty ?>
<p><a href="RegLogin.php" onclick="onclick=TabbedPanels1.showPanel(2); return false;">Add New Login Type</a></p>
<?php } // Show if recordset not empty ?>
</div>

<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Registrants</li>
<li class="TabbedPanelsTab">Details</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<fieldset id="fieldcolor">
<table  id="nav">
  <tr>
    <td><?php if ($pageNum_fmRegLogin > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmRegLogin=%d%s", $currentPage, 0, $queryString_fmRegLogin); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmRegLogin > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_fmRegLogin=%d%s", $currentPage, max(0, $pageNum_fmRegLogin - 1), $queryString_fmRegLogin); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_fmRegLogin < $totalPages_fmRegLogin) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmRegLogin=%d%s", $currentPage, min($totalPages_fmRegLogin, $pageNum_fmRegLogin + 1), $queryString_fmRegLogin); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_fmRegLogin < $totalPages_fmRegLogin) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_fmRegLogin=%d%s", $currentPage, $totalPages_fmRegLogin, $queryString_fmRegLogin); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>

<table  id="delform">
<tr>
<th>AdminNo</th>
<th>Full Name</th>
<th>Email</th>
<th>Password</th>
<th>Active</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmRegLogin['AdmindNo']; ?></td>
<td><?php echo $row_fmRegLogin['First Name']; ?> <?php echo $row_fmRegLogin['Last Name']; ?></td>
<td><?php echo $row_fmRegLogin['Email']; ?></td>
<td><?php echo $row_fmRegLogin['Adminpassword']; ?></td>
<td><?php echo $row_fmRegLogin['Active']; ?></td>
<td><a href="RegLoginTable.php?AdminNo=<?php echo $row_fmRegLogin['AdmindNo']; ?>">edit</a></td>
</tr>
<?php } while ($row_fmRegLogin = mysql_fetch_assoc($fmRegLogin)); ?>
</table>
</fieldset>
</div>

<div class="TabbedPanelsContent">
  <form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
    <table align="center">
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">AdmindNo:</td>
        <td><?php echo $row_fmRegLoginEdit['AdmindNo']; ?></td>
      </tr>
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">First Name:</td>
        <td><input type="text" name="First_Name" value="<?php echo $row_fmRegLoginEdit['First Name']; ?>" size="32" /></td>
      </tr>
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">Last Name:</td>
        <td><input type="text" name="Last_Name" value="<?php echo $row_fmRegLoginEdit['Last Name']; ?>" size="32" /></td>
      </tr>
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">Email:</td>
        <td><input type="email" name="Email" value="<?php echo $row_fmRegLoginEdit['Email']; ?>" size="32" /></td>
      </tr>
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">Adminpassword:</td>
        <td><input type="password" name="Adminpassword" value="<?php echo $row_fmRegLoginEdit['Adminpassword']; ?>" size="32" /></td>
      </tr>
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">Active:</td>
        <td><input type="checkbox" name="Active" value="1" <?php if (!(strcmp($row_fmRegLoginEdit['Active'],1))) {echo "checked=\"checked\"";} ?> /></td>
      </tr>
      <tr class="tablevalign">
        <td nowrap="nowrap" class="tddataright">&nbsp;</td>
        <td><input type="submit" value="Update record" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="forminsert" />
    <input type="hidden" name="AdmindNo" value="<?php echo $row_fmRegLoginEdit['AdmindNo']; ?>" />
  </form>
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
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmRegLogin);

mysql_free_result($fmRegLoginEdit);
?>