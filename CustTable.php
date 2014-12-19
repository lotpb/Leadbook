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

include('FusionCharts/FusionCharts_Gen.php');
include('FusionCharts/DBConn.php');

$title = "Customer";
$Datefrom = date('Y-01-01');
$Dateto = date('Y-12-31');
$Datenow = date('Y-m-d');

$Year1 = mktime(0,0,0,date("m"),date("d"),date("Y")-1);
$Year2 = mktime(0,0,0,date("m"),date("d"),date("Y")-2);
$Year3 = mktime(0,0,0,date("m"),date("d"),date("Y")-3);
$Year4 = mktime(0,0,0,date("m"),date("d"),date("Y")-4);
$Year5 = mktime(0,0,0,date("m"),date("d"),date("Y")-5);
$Year6 = mktime(0,0,0,date("m"),date("d"),date("Y")-6);

$Datefrom1 = date("Y-01-01", $Year1);
$Dateto1 = date("Y-m-d", $Year1);
$Datefrom2 = date("Y-01-01", $Year2);
$Dateto2 = date("Y-m-d", $Year2);
$Datefrom3 = date("Y-01-01", $Year3);
$Dateto3 = date("Y-m-d", $Year3);
$Datefrom4 = date("Y-01-01", $Year4);
$Dateto4 = date("Y-m-d", $Year4);
$Datefrom5 = date("Y-01-01", $Year5);
$Dateto5 = date("Y-m-d", $Year5);
$Datefrom6 = date("Y-01-01", $Year6);
$Dateto6 = date("Y-m-d", $Year6);

//Checkbox and cookies
if ($_GET['ActiveCust'] == "1" && $_COOKIE['ActiveCust'] == "1") { 
$title="Active Customer";
$t1v="checked";
setcookie("ActiveCust", "", time()+(60*60*24*365)); 
} else {
$t1v=="";
setcookie("ActiveCust", "1", time()+(60*60*24*365));
}

if ($_GET['RepeatCust'] == "1") { 
$title="Repeat Customer";
$t1v2="checked";
header('Location: CustRepeat.php');
} else {
$t1v2=="";
}

//Selectbox
if ($_GET['SelectRate'] == "A" OR $_POST['SelectDate'] == "A")  { 
$t1A="selected";
} else {
$t1A=="";
}
if ($_GET['SelectRate'] == "B" OR $_POST['SelectDate'] == "B")  { 
$t1B="selected";
} else {
$tBv=="";
}
if ($_GET['SelectRate'] == "C" OR $_POST['SelectDate'] == "C")  { 
$t1C="selected";
} else {
$t1C=="";
}
if ($_GET['SelectRate'] == "D" OR $_POST['SelectDate'] == "D")  { 
$t1D="selected";
} else {
$t2D=="";
}

//CustCount
$Var_fmCustCount = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmCustCount = $_GET['Datefrom'];
}
$Var1_fmCustCount = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmCustCount = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustCount = sprintf("SELECT Count(Customer.CustNo) as Count FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($Var_fmCustCount, "date"),GetSQLValueString($Var1_fmCustCount, "date"));
$fmCustCount = mysql_query($query_fmCustCount, $Leadbook) or die(mysql_error());
$row_fmCustCount = mysql_fetch_assoc($fmCustCount);
$totalRows_fmCustCount = mysql_num_rows($fmCustCount);

//ActiveCust
$colname_fmActiveCust = "1";
if (isset($_GET['colname'])) {
  $colname_fmActiveCust = $_GET['colname'];
}
$var_fmActiveCust = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmActiveCust = $_GET['Datefrom'];
}
$var1_fmActiveCust = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmActiveCust = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmActiveCust = sprintf("SELECT * FROM Customer WHERE Customer.Active = %s AND Customer.`Date` >= %s  AND Customer.`Date` <= %s", GetSQLValueString($colname_fmActiveCust, "text"),GetSQLValueString($var_fmActiveCust, "date"),GetSQLValueString($var1_fmActiveCust, "date"));
$fmActiveCust = mysql_query($query_fmActiveCust, $Leadbook) or die(mysql_error());
$row_fmActiveCust = mysql_fetch_assoc($fmActiveCust);
$totalRows_fmActiveCust = mysql_num_rows($fmActiveCust);

//WindowSold
$Var_fmWindowSold = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmWindowSold = $_GET['Datefrom'];
}
$Var1_fmWindowSold = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmWindowSold = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmWindowSold = sprintf("SELECT Sum(Customer.Quan) as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($Var_fmWindowSold, "date"),GetSQLValueString($Var1_fmWindowSold, "date"));
$fmWindowSold = mysql_query($query_fmWindowSold, $Leadbook) or die(mysql_error());
$row_fmWindowSold = mysql_fetch_assoc($fmWindowSold);
$totalRows_fmWindowSold = mysql_num_rows($fmWindowSold);

//AvgCust
$maxRows_fmAvgCust = 1;
$pageNum_fmAvgCust = 0;
if (isset($_GET['pageNum_fmAvgCust'])) {
  $pageNum_fmAvgCust = $_GET['pageNum_fmAvgCust'];
}
$startRow_fmAvgCust = $pageNum_fmAvgCust * $maxRows_fmAvgCust;

$Var_fmAvgCust = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmAvgCust = $_GET['Datefrom'];
}
$Var1_fmAvgCust = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmAvgCust = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAvgCust = sprintf("SELECT AVG(Customer.Amount) FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($Var_fmAvgCust, "date"),GetSQLValueString($Var1_fmAvgCust, "date"));
$query_limit_fmAvgCust = sprintf("%s LIMIT %d, %d", $query_fmAvgCust, $startRow_fmAvgCust, $maxRows_fmAvgCust);
$fmAvgCust = mysql_query($query_limit_fmAvgCust, $Leadbook) or die(mysql_error());
$row_fmAvgCust = mysql_fetch_assoc($fmAvgCust);

if (isset($_GET['totalRows_fmAvgCust'])) {
  $totalRows_fmAvgCust = $_GET['totalRows_fmAvgCust'];
} else {
  $all_fmAvgCust = mysql_query($query_fmAvgCust);
  $totalRows_fmAvgCust = mysql_num_rows($all_fmAvgCust);
}
$totalPages_fmAvgCust = ceil($totalRows_fmAvgCust/$maxRows_fmAvgCust)-1;

//Repeat Cust
$var_RepeatCust = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_RepeatCust = $_GET['Datefrom'];
}
$var1_RepeatCust = "$Datenow";
if (isset($_GET['Datenow'])) {
  $var1_RepeatCust = $_GET['Datenow'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_RepeatCust = sprintf("SELECT Count(Customer.Address) as LeadNo, Customer.Date, Leads.`Last Name`, Customer.Address, Customer.City, Customer.Phone, Sum(Customer.Amount) as Amount, Customer.CustNo FROM Customer, Leads WHERE (Customer.LeadNo = Leads.LeadNo) GROUP BY Customer.LeadNo HAVING Count(Customer.Address) > 1 ", GetSQLValueString($var_RepeatCust, "date"),GetSQLValueString($var1_RepeatCust, "date"));
$RepeatCust = mysql_query($query_RepeatCust, $Leadbook) or die(mysql_error());
$row_RepeatCust = mysql_fetch_assoc($RepeatCust);
$totalRows_RepeatCust = mysql_num_rows($RepeatCust);

//Salesman
$colname_fmSalesman = "Active";
if (isset($_GET['Active'])) {
  $colname_fmSalesman = $_GET['Active'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmSalesman = sprintf("SELECT * FROM Salesman WHERE Salesman.Active = %s", GetSQLValueString($colname_fmSalesman, "text"));
$fmSalesman = mysql_query($query_fmSalesman, $Leadbook) or die(mysql_error());
$row_fmSalesman = mysql_fetch_assoc($fmSalesman);
$totalRows_fmSalesman = mysql_num_rows($fmSalesman);

//Products
$colname_fmProducts = "Active";
if (isset($_GET['colname'])) {
  $colname_fmProducts = $_GET['colname'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmProducts = sprintf("SELECT * FROM Product WHERE Product.Active = %s ORDER BY Product.Products", GetSQLValueString($colname_fmProducts, "text"));
$fmProducts = mysql_query($query_fmProducts, $Leadbook) or die(mysql_error());
$row_fmProducts = mysql_fetch_assoc($fmProducts);
$totalRows_fmProducts = mysql_num_rows($fmProducts);

//Cust by Month
$var1_fmCustMonthGraph = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmCustMonthGraph = $_GET['Datefrom'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustMonthGraph = sprintf("SELECT 'a' as Num, Sum(Customer.Amount) as Amount, 'Jan' as SeqMonth FROM Customer WHERE EXTRACT(Month FROM Customer.Date) = 1 AND EXTRACT(Year FROM Customer.Date) = %s UNION SELECT 'b' as Num, SUM(Customer.Amount) as Amount, 'Feb' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 2 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'c' as Num, SUM(Customer.Amount) as Amount, 'Mar' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 3 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'd' as Num, SUM(Customer.Amount) as Amount, 'Apr' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 4 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'e' as Num, SUM(Customer.Amount) as Amount, 'May' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 5 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'f' as Num, SUM(Customer.Amount) as Amount, 'Jun' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 6 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'g' as Num, SUM(Customer.Amount) as Amount, 'Jul' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 7 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'h' as Num, SUM(Customer.Amount) as Amount, 'Aug' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 8 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'i' as Num, SUM(Customer.Amount) as Amount, 'Sep' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 9 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'j' as Num, SUM(Customer.Amount) as Amount, 'Oct' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 10 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'k' as Num, SUM(Customer.Amount) as Amount, 'Nov' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 11 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'l' as Num, SUM(Customer.Amount) as Amount, 'Dec' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 12 AND EXTRACT(Year from Customer.Date) = %s", GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"));
$fmCustMonthGraph = mysql_query($query_fmCustMonthGraph, $Leadbook) or die(mysql_error());
$row_fmCustMonthGraph = mysql_fetch_assoc($fmCustMonthGraph);
$totalRows_fmCustMonthGraph = mysql_num_rows($fmCustMonthGraph);

//CustByYear
$var1_fmCustYear = "$Datefrom";
if (isset($_GET['var1'])) {
  $var1_fmCustYear = $_GET['var1'];
}
$var2_fmCustYear = "$Datenow";
if (isset($_GET['var2'])) {
  $var2_fmCustYear = $_GET['var2'];
}
$var3_fmCustYear = "$Datefrom1";
if (isset($_GET['var3'])) {
  $var3_fmCustYear = $_GET['var3'];
}
$var4_fmCustYear = "$Dateto1";
if (isset($_GET['var4'])) {
  $var4_fmCustYear = $_GET['var4'];
}
$var5_fmCustYear = "$Datefrom2";
if (isset($_GET['var5'])) {
  $var5_fmCustYear = $_GET['var5'];
}
$var6_fmCustYear = "$Dateto2";
if (isset($_GET['var6'])) {
  $var6_fmCustYear = $_GET['var6'];
}
$var7_fmCustYear = "$Datefrom3";
if (isset($_GET['var7'])) {
  $var7_fmCustYear = $_GET['var7'];
}
$var8_fmCustYear = "$Dateto3";
if (isset($_GET['var8'])) {
  $var8_fmCustYear = $_GET['var8'];
}
$var9_fmCustYear = "$Datefrom4";
if (isset($_GET['var9'])) {
  $var9_fmCustYear = $_GET['var9'];
}
$var10_fmCustYear = "$Dateto4";
if (isset($_GET['var10'])) {
  $var10_fmCustYear = $_GET['var10'];
}
$var11_fmCustYear = "$Datefrom5";
if (isset($_GET['var11'])) {
  $var11_fmCustYear = $_GET['var11'];
}
$var12_fmCustYear = "$Dateto5";
if (isset($_GET['var12'])) {
  $var12_fmCustYear = $_GET['var12'];
}
$var13_fmCustYear = "$Datefrom6";
if (isset($_GET['var13'])) {
  $var13_fmCustYear = $_GET['var13'];
}
$var14_fmCustYear = "$Dateto6";
if (isset($_GET['var14'])) {
  $var14_fmCustYear = $_GET['var14'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustYear = sprintf("SELECT YEAR(CURRENT_TIMESTAMP), Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 1, Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) - 1 as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 2, Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) - 2 as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 3, Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) - 3 as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 4, Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) - 4 as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 5, Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) - 5 as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 6, Sum(Customer.Amount) as Amount, YEAR(CURRENT_TIMESTAMP) - 6 as Year FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($var1_fmCustYear, "date"),GetSQLValueString($var2_fmCustYear, "date"),GetSQLValueString($var3_fmCustYear, "date"),GetSQLValueString($var4_fmCustYear, "date"),GetSQLValueString($var5_fmCustYear, "date"),GetSQLValueString($var6_fmCustYear, "date"),GetSQLValueString($var7_fmCustYear, "date"),GetSQLValueString($var8_fmCustYear, "date"),GetSQLValueString($var9_fmCustYear, "date"),GetSQLValueString($var10_fmCustYear, "date"),GetSQLValueString($var11_fmCustYear, "date"),GetSQLValueString($var12_fmCustYear, "date"),GetSQLValueString($var13_fmCustYear, "date"),GetSQLValueString($var14_fmCustYear, "date"));
$fmCustYear = mysql_query($query_fmCustYear, $Leadbook) or die(mysql_error());
$row_fmCustYear = mysql_fetch_assoc($fmCustYear);
$totalRows_fmCustYear = mysql_num_rows($fmCustYear);

//AvgCust
$var1_fmAvgCustGraph = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmAvgCustGraph = $_GET['Datefrom'];
}
$var2_fmAvgCustGraph = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var2_fmAvgCustGraph = $_GET['Dateto'];
}
$var3_fmAvgCustGraph = "$Datefrom1";
if (isset($_GET['var3'])) {
  $var3_fmAvgCustGraph = $_GET['var3'];
}
$var4_fmAvgCustGraph = "$Dateto1";
if (isset($_GET['var4'])) {
  $var4_fmAvgCustGraph = $_GET['var4'];
}
$var5_fmAvgCustGraph = "$Datefrom2";
if (isset($_GET['var5'])) {
  $var5_fmAvgCustGraph = $_GET['var5'];
}
$var6_fmAvgCustGraph = "$Dateto2";
if (isset($_GET['var6'])) {
  $var6_fmAvgCustGraph = $_GET['var6'];
}
$var7_fmAvgCustGraph = "$Datefrom3";
if (isset($_GET['var7'])) {
  $var7_fmAvgCustGraph = $_GET['var7'];
}
$var8_fmAvgCustGraph = "$Dateto3";
if (isset($_GET['var8'])) {
  $var8_fmAvgCustGraph = $_GET['var8'];
}
$var9_fmAvgCustGraph = "$Datefrom4";
if (isset($_GET['var9'])) {
  $var9_fmAvgCustGraph = $_GET['var9'];
}
$var10_fmAvgCustGraph = "$Dateto4";
if (isset($_GET['var10'])) {
  $var10_fmAvgCustGraph = $_GET['var10'];
}
$var11_fmAvgCustGraph = "$Datefrom5";
if (isset($_GET['var11'])) {
  $var11_fmAvgCustGraph = $_GET['var11'];
}
$var12_fmAvgCustGraph = "$Dateto5";
if (isset($_GET['var12'])) {
  $var12_fmAvgCustGraph = $_GET['var12'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAvgCustGraph = sprintf("SELECT YEAR(CURRENT_TIMESTAMP), AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -1, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 1 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 2, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 2 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 3, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 3 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 4, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 4 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 5, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 5 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($var1_fmAvgCustGraph, "date"),GetSQLValueString($var2_fmAvgCustGraph, "date"),GetSQLValueString($var3_fmAvgCustGraph, "date"),GetSQLValueString($var4_fmAvgCustGraph, "date"),GetSQLValueString($var5_fmAvgCustGraph, "date"),GetSQLValueString($var6_fmAvgCustGraph, "date"),GetSQLValueString($var7_fmAvgCustGraph, "date"),GetSQLValueString($var8_fmAvgCustGraph, "date"),GetSQLValueString($var9_fmAvgCustGraph, "date"),GetSQLValueString($var10_fmAvgCustGraph, "date"),GetSQLValueString($var11_fmAvgCustGraph, "date"),GetSQLValueString($var12_fmAvgCustGraph, "date"));
$fmAvgCustGraph = mysql_query($query_fmAvgCustGraph, $Leadbook) or die(mysql_error());
$row_fmAvgCustGraph = mysql_fetch_assoc($fmAvgCustGraph);
$totalRows_fmAvgCustGraph = mysql_num_rows($fmAvgCustGraph);

//Customer
$maxRows_fmCustomer = 40;
$pageNum_fmCustomer = 0;
if (isset($_GET['pageNum_fmCustomer'])) {
  $pageNum_fmCustomer = $_GET['pageNum_fmCustomer'];
}
$startRow_fmCustomer = $pageNum_fmCustomer * $maxRows_fmCustomer;

$var1_fmCustomer = "0";
if (isset($_GET['SaleNo'])) {
  $var1_fmCustomer = $_GET['SaleNo'];
}
$var2_fmCustomer = "10000";
if (isset($_GET['SaleNo'])) {
  $var2_fmCustomer = $_GET['SaleNo'];
}
$var3_fmCustomer = "0";
if (isset($_GET['ProdNo'])) {
  $var3_fmCustomer = $_GET['ProdNo'];
}
$var4_fmCustomer = "10000";
if (isset($_GET['ProdNo'])) {
  $var4_fmCustomer = $_GET['ProdNo'];
}
$RateSearch_fmCustomer = "%";
if (isset($_GET['SelectRate'])) {
  $RateSearch_fmCustomer = $_GET['SelectRate'];
}
$ActiveCust_fmCustomer = "-1";
if (isset($_GET['ActiveCust'])) {
  $ActiveCust_fmCustomer = $_GET['ActiveCust'];
}
$Search_fmCustomer = "%";
if (isset($_REQUEST['Search'])) {
  $Search_fmCustomer = $_REQUEST['Search'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustomer = sprintf("SELECT Customer.CustNo, Customer.`Date`, Customer.Address, Customer.City, Customer.Phone, Customer.Amount, Leads.`Last Name`, Customer.LeadNo FROM Customer, Leads WHERE (Customer.LeadNo = Leads.LeadNo) AND (Customer.SalesNo BETWEEN %s AND %s) AND (Customer.ProductNo BETWEEN %s AND %s) AND (Customer.Rate LIKE %s) AND (Customer.Active >= %s) AND (Customer.CustNo = %s OR Customer.LeadNo = %s OR Leads.`Last Name` LIKE %s OR Customer.City LIKE %s OR Customer.Address LIKE %s OR Customer.Phone LIKE %s OR Customer.Amount LIKE %s) ORDER BY Customer.`Date` DESC", GetSQLValueString($var1_fmCustomer, "int"),GetSQLValueString($var2_fmCustomer, "int"),GetSQLValueString($var3_fmCustomer, "int"),GetSQLValueString($var4_fmCustomer, "int"),GetSQLValueString($RateSearch_fmCustomer, "text"),GetSQLValueString($ActiveCust_fmCustomer, "int"),GetSQLValueString($Search_fmCustomer, "text"),GetSQLValueString($Search_fmCustomer, "text"),GetSQLValueString($Search_fmCustomer, "text"),GetSQLValueString($Search_fmCustomer, "text"),GetSQLValueString($Search_fmCustomer, "text"),GetSQLValueString($Search_fmCustomer, "text"),GetSQLValueString($Search_fmCustomer, "text"));
$query_limit_fmCustomer = sprintf("%s LIMIT %d, %d", $query_fmCustomer, $startRow_fmCustomer, $maxRows_fmCustomer);
$fmCustomer = mysql_query($query_limit_fmCustomer, $Leadbook) or die(mysql_error());
$row_fmCustomer = mysql_fetch_assoc($fmCustomer);

if (isset($_GET['totalRows_fmCustomer'])) {
  $totalRows_fmCustomer = $_GET['totalRows_fmCustomer'];
} else {
  $all_fmCustomer = mysql_query($query_fmCustomer);
  $totalRows_fmCustomer = mysql_num_rows($all_fmCustomer);
}
$totalPages_fmCustomer = ceil($totalRows_fmCustomer/$maxRows_fmCustomer)-1;

$queryString_fmCustomer = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fmCustomer") == false && 
        stristr($param, "totalRows_fmCustomer") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fmCustomer = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fmCustomer = sprintf("&totalRows_fmCustomer=%d%s", $totalRows_fmCustomer, $queryString_fmCustomer);

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Customer Form</title>
<meta charset="utf-8" />
<link rel="icon" href="favicon.ico">

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="FusionCharts/FusionCharts.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" />
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" />
<link href="Stylesheets/ChartTabs.css" rel="stylesheet" />
<link href="Stylesheets/CharMenu.css" rel="stylesheet" />
<style type="text/css">
<!--
.twoColFixRtHdr #sidebar1 {
height:950px;
padding:1em .5em;
}
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

if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)) {
		document.location = "CustTableipad.php";
	} // ]]>
	
$(document).ready(function(){
  $("button").click(function(){
    $("#chart").fadeToggle();
/*    $("#div2").fadeToggle("slow");
    $("#div3").fadeToggle(3000);*/
  });
});
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
          <li><a href="#">Tools</a>
        <ul>
          <li><a href="ZipTable.php">Zip Code Listing</a></li>
          <li><a href="SalesmanTable.php">Salesman listing</a></li>
          <li><a href="ProductsTable.php">Product Listing</a></li>
          <li><a href="AdvertiseTable.php">Advertising Listing</a></li>
        </ul>
        </li>
      <li><a href="LeadTable.php">Lead Listing</a> </li>
      <li><a href="CustTable.php">Customer Listing</a></li>
      <li><a href="ContactsTable.php">Contact Listing</a></li>
      <li><a href="EmployeeTable.php">Employee Listing</a></li>
      <li><a href="VendorTable.php">Vendor Listing</a></li>
      <li><a href="TaskTable.php">Task Listing</a></li>

    </ul>
</li>
<li><a href="Snapshot.php">Snapshot</a></li>
<li><a href="BlogTable.php">Blog</a></li>
</ul>
</nav>
<h1>Customers Online</h1>
</hgroup>
<!-- end #header --></header>
<section id="sidebar1">
<div>
<?php
if ($_GET['ActiveCust'] == "1")  
echo "Viewing Active Customers!<br />" ;
else
echo "Viewing all Customers!<br />";
?>  
<form id="form1" name="form1" method="get" action="CustTable.php">
<input name="Search" type="search" id="Search" autofocus value="Search <?php echo $_REQUEST['Search']; ?>" size="18" /> 
<button class="magglass"type="submit"><img src="images/magglass.png" alt="Search" /></button>
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
</select> <input type="button" name="b1" id="b1" value="New Customer" onclick="location.href='CustInsert.php'">
</form>
<!-- end #search --></div>

<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form> 

<div><button class="tableheader"type="submit">Records <?php echo ($startRow_fmCustomer + 1) ?> to <?php echo min($startRow_fmCustomer + $maxRows_fmCustomer, $totalRows_fmCustomer) ?> of <?php echo $totalRows_fmCustomer ?></button></div> 

<p>Customer Count...<strong><?php echo $row_fmCustCount['Count'] ?></strong></p>
<p>Active Customers...<strong><?php echo $totalRows_fmActiveCust ?></strong></p>
<p>Repeat Customers...<strong><?php echo $totalRows_RepeatCust ?></strong></p>

<p>Windows Sold...<strong>
<?php do { ?>
<?php echo $row_fmWindowSold['Windows']; ?>
<?php } while ($row_fmWindowSold = mysql_fetch_assoc($fmWindowSold)); ?>
</strong></p>

<p>Avg Customer...<strong>
<?php do { ?>
<?php echo number_format($row_fmAvgCust['AVG(Customer.Amount)'],0); ?>
<?php } while ($row_fmAvgCust = mysql_fetch_assoc($fmAvgCust)); ?>
</strong></p>

<button>Hide chart</button>

<div id="chart"> 
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Month</li>
    <li class="TabbedPanelsTab" tabindex="0">Year</li>
    <li class="TabbedPanelsTab" tabindex="0">Avg</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<?php $link = connectToDB();
$FC = new FusionCharts("Pie2D","190","230");
$FC->setSwfPath("FusionCharts/");
$FC->setChartMessage("ChartNoDataText=Chart Data not provided; PBarLoadingText=Please Wait.The chart is loading...");
$strParam="caption=Sales by Month; subCaption=; decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=$; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=100; pieSliceDepth=15; pieRadius=100; chartTopMargin=0; chartBottomMargin=0; chartRightMargin=0; chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustMonthGraph) or die(mysql_error());
if ($result) 
{ $FC->addDataFromDatabase($result, "Amount", "SeqMonth"); }
mysql_close($link);
$FC->renderChart(); ?> 
</div>

<div class="TabbedPanelsContent">
<?php $link = connectToDB();
$FC = new FusionCharts("Column2D","190","230");
$FC->setSwfPath("FusionCharts/");
$FC->setChartMessage("ChartNoDataText=Chart Data not provided; PBarLoadingText=Please Wait.The chart is loading...");
$strParam="caption=Sales by Year; subCaption=; xAxisName=; showBorder='0'; showNames=1; formatNumberScale=1; numberSuffix=; decimalPrecision=0; chartBottomMargin=0; chartRightMargin=0; chartLeftMargin=0; chartTopMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustYear) or die(mysql_error());
if ($result) 
{ $FC->addDataFromDatabase($result, "Amount", "Year"); }
mysql_close($link);
$FC->renderChart(); ?>    
</div>

<div class="TabbedPanelsContent">
<?php $link = connectToDB();
$FC = new FusionCharts("Column2D","190","230");
$FC->setSwfPath("FusionCharts/");
$FC->setChartMessage("ChartNoDataText=Chart Data not provided; PBarLoadingText=Please Wait.The chart is loading...");
$strParam="caption=Avg Sales by Year; subCaption=; xAxisName=; showBorder='0'; showNames=1; formatNumberScale=1; numberSuffix=; decimalPrecision=0; chartBottomMargin=0; chartRightMargin=0; chartLeftMargin=0; chartTopMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmAvgCustGraph) or die(mysql_error());
if ($result) 
{ $FC->addDataFromDatabase($result, "Amount", "Windows"); }
mysql_close($link);
$FC->renderChart(); ?>  
</div>
    
  </div>
</div>
</div>

<div><button class="tableheader"type="submit">Search Customers</button></div>  
<form id="form4" name="form4" method="get" action="CustTable.php"> 
<p><input name="ActiveCust" type="checkbox" id="ActiveCust" value="1" <?php echo $t1v ?> onclick="submit()" /> Active Customer<br /></p>
<p><input name="RepeatCust" type="checkbox" id="RepeatCust" value="1" <?php echo $t1v2 ?> onclick="submit()" /> Repeat Customer</p>
</form>

<div><button class="tableheader"type="submit">Active Salesman</button></div> 
<form id="form6" name="form6" method="get">
<select name="SelectSaleman" id="SelectSaleman" tabindex="1" onchange="reloadSale(this.form)">
<option value="" <?php if (!(strcmp("", $row_fmSalesman['Salesman']))) {echo "selected=\"selected\"";} ?>>Select Salesman</option>
<?php do { ?>
<option value="<?php echo $row_fmSalesman['SalesNo']?>"<?php if (!(strcmp($row_fmSalesman['SalesNo'], $row_fmSalesman['Salesman']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmSalesman['Salesman']?></option>
<?php } while ($row_fmSalesman = mysql_fetch_assoc($fmSalesman));
$rows = mysql_num_rows($fmSalesman);
if($rows > 0) {
mysql_data_seek($fmSalesman, 0);
$row_fmSalesman = mysql_fetch_assoc($fmSalesman); } ?>
</select></form>
 
<div><button class="tableheader"type="submit">Active Products</button></div> 
<form id="form3" name="form3" method="get">
<select name="SelectProd" id="SelectProd" tabindex="1" onchange="reloadProd(this.form)">
<option value="" <?php if (!(strcmp("", $_GET['ProductNo']))) {echo "selected=\"selected\"";} ?>>Select Products</option>
<?php do { ?>
<option value="<?php echo $row_fmProducts['ProductNo']?>"<?php if (!(strcmp($row_fmProducts['ProductNo'], $row_fmProducts['Products']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fmProducts['Products']?></option>
<?php } while ($row_fmProducts = mysql_fetch_assoc($fmProducts));
$rows = mysql_num_rows($fmProducts);
if($rows > 0) {
mysql_data_seek($fmProducts, 0);
$row_fmProducts = mysql_fetch_assoc($fmProducts); } ?>
</select></form> 

<div><button class="tableheader"type="submit">Active Rate</button></div> 
<form id="form5" name="form5" method="get">
<select name="SelectRate" id="SelectRate" onchange="submit()">
<option selected="selected">Select Rate</option>
<option value="A" <?php echo $t1A ?>>A</option>
<option value="B" <?php echo $t1B ?>>B</option>
<option value="C" <?php echo $t1C ?>>C</option>
<option value="D" <?php echo $t1D ?>>D</option>
</select>
</form>
<!-- end #sidebar1 --></section>

<div id="titlerepeat">Admin: <?php echo $title ?> Listings</div>

<div id="addnew">
<?php if ($totalRows_fmCustomer == 0) { // Show if recordset empty ?>
There are no customers defined. <a href="CustInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>
</div>

<table  id="nav">
<tr>
<td><?php if ($pageNum_fmCustomer > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmCustomer=%d%s", $currentPage, 0, $queryString_fmCustomer); ?>">First</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmCustomer > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmCustomer=%d%s", $currentPage, max(0, $pageNum_fmCustomer - 1), $queryString_fmCustomer); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>
<td><?php if ($pageNum_fmCustomer < $totalPages_fmCustomer) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmCustomer=%d%s", $currentPage, min($totalPages_fmCustomer, $pageNum_fmCustomer + 1), $queryString_fmCustomer); ?>">Next</a>
<?php } // Show if not last page ?>
</td>
<td><?php if ($pageNum_fmCustomer < $totalPages_fmCustomer) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmCustomer=%d%s", $currentPage, $totalPages_fmCustomer, $queryString_fmCustomer); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
</table>

<table width="80%" id="delform">
<tr>
<th><span>Lead</span></th>
<th><span>Date</span></th>
<th><span>Last Name</span></th>
<th><span>Address</span></th>
<th><span>City</span></th>
<th><span>Phone</span></th>
<th><span>Amount</span></th>
<th><span>Num</span></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php do { ?>
<tr class="formRow">
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><a href="LeadEdit.php?LeadNo=<?php echo $row_fmCustomer['LeadNo']; ?>"><?php echo $row_fmCustomer['LeadNo']; ?></a></td>
<td nowrap="nowrap"><?php echo date("M y", strtotime($row_fmCustomer['Date'])); ?></td>
<td><?php echo $row_fmCustomer['Last Name']; ?></td>
<td><?php echo $row_fmCustomer['Address']; ?></td>
<td><?php echo $row_fmCustomer['City']; ?></td>
<td nowrap="nowrap"><?php echo $row_fmCustomer['Phone']; ?></td>
<td class="tdAmount" nowrap="nowrap"><input type="text" size="9" value="<?php echo $row_fmCustomer['Amount']; ?>"/></td>
<td><?php echo $row_fmCustomer['CustNo']; ?></td>
<td width="4"><a href="CustEdit.php?CustNo=<?php echo $row_fmCustomer['CustNo']; ?>">edit</a></td>
<td width="6"><a href="DeleteAddress.php?CustNo=<?php echo $row_fmCustomer['CustNo']; ?>">delete</a></td> 
</tr>
<?php } while ($row_fmCustomer = mysql_fetch_assoc($fmCustomer)); ?>
</table>
<!-- end #mainContent --></div>
<!-- end #container --></div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmCustCount);

mysql_free_result($fmActiveCust);

mysql_free_result($fmWindowSold);

mysql_free_result($fmAvgCust);

mysql_free_result($RepeatCust);

mysql_free_result($fmSalesman);

mysql_free_result($fmProducts);

mysql_free_result($fmCustMonthGraph);

mysql_free_result($fmCustYear);

mysql_free_result($fmAvgCustGraph);

mysql_free_result($fmCustomer);
?>