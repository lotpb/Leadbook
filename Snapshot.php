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
setcookie("user", "Peter Balsamo", time()+3600);

$Datefrom = date('Y-01-01');
$Dateto = date('Y-12-31');
$Datenow = date('Y-m-d');
$Day1= mktime(0,0,0,date("m"),date("d")+1,date("Y"));
$DateTommorrow = date("Y-m-d", $Day1);

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

if ($_GET['SelectDate'] == "1" OR $_POST['SelectDate'] == "1")  { 
$t1v="selected";
} else {
$t1v=="";
}
if ($_GET['SelectDate'] == "2" OR $_POST['SelectDate'] == "2")  { 
$t2v="selected";
} else {
$t2v=="";
}
if ($_GET['SelectDate'] == "3" OR $_POST['SelectDate'] == "3")  { 
$t3v="selected";
} else {
$t3v=="";
}
if ($_GET['SelectDate'] == "4" OR $_POST['SelectDate'] == "4")  { 
$t4v="selected";
} else {
$t4v=="";
}
if ($_GET['SelectDate'] == "5" OR $_POST['SelectDate'] == "5")  { 
$t5v="selected";
} else {
$t5v=="";
}
if ($_GET['SelectDate'] == "6" OR $_POST['SelectDate'] == "6")  { 
$t6v="selected";
} else {
$t6v=="";
}
if ($_GET['SelectDate'] == "7" OR $_POST['SelectDate'] == "7")  { 
$t7v="selected";
} else {
$t7v=="";
}
if ($_GET['SelectDate'] == "8" OR $_POST['SelectDate'] == "8")  { 
$t8v="selected";
} else {
$t8v=="";
}
if ($_GET['SelectDate'] == "9" OR $_POST['SelectDate'] == "9")  { 
$t9v="selected";
} else {
$t9v=="";
}
if ($_GET['SelectDate'] == "10" OR $_POST['SelectDate'] == "10")  { 
$t10v="selected";
} else {
$t10v=="";
}
if ($_GET['SelectDate'] == "11" OR $_POST['SelectDate'] == "11")  { 
$t11v="selected";
} else {
$t11v=="";
}
if ($_GET['SelectDate'] == "12" OR $_POST['SelectDate'] == "12")  { 
$t12v="selected";
} else {
$t12v=="";
}
if ($_GET['SelectDate'] == "13" OR $_POST['SelectDate'] == "13")  { 
$t13v="selected";
} else {
$t13v=="";
}
if ($_GET['SelectDate'] == "14" OR $_POST['SelectDate'] == "14")  { 
$t14v="selected";
} else {
$t14v=="";
}

/**/
$Search_fmLeadlookgood = "Looks Good%";
if (isset($_REQUEST['Search'])) {
  $Search_fmLeadlookgood = $_REQUEST['Search'];
}
$var_fmLeadlookgood = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmLeadlookgood = $_GET['Datefrom'];
}
$var1_fmLeadlookgood = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmLeadlookgood = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadlookgood = sprintf("SELECT Leads.`Apt date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.Amount FROM Leads WHERE (Leads.`Call Back` Like %s) AND Leads.`Date` >= %s AND Leads.`Date` <= %s ORDER BY Leads.`Date` DESC", GetSQLValueString($Search_fmLeadlookgood, "text"),GetSQLValueString($var_fmLeadlookgood, "date"),GetSQLValueString($var1_fmLeadlookgood, "date"));
$fmLeadlookgood = mysql_query($query_fmLeadlookgood, $Leadbook) or die(mysql_error());
$row_fmLeadlookgood = mysql_fetch_assoc($fmLeadlookgood);
$totalRows_fmLeadlookgood = mysql_num_rows($fmLeadlookgood);

/**/
$Search_fmLeadfuture = "Work in %";
if (isset($_GET['Search'])) {
  $Search_fmLeadfuture = $_GET['Search'];
}
$var_fmLeadfuture = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmLeadfuture = $_GET['Datefrom'];
}
$var1_fmLeadfuture = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmLeadfuture = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadfuture = sprintf("SELECT Leads.`Apt date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.Amount FROM Leads WHERE (Leads.`Call Back` LIKE %s) AND Leads.`Date` >= %s AND Leads.`Date` <= %s ORDER BY Leads.`Date` DESC", GetSQLValueString($Search_fmLeadfuture, "text"),GetSQLValueString($var_fmLeadfuture, "date"),GetSQLValueString($var1_fmLeadfuture, "date"));
$fmLeadfuture = mysql_query($query_fmLeadfuture, $Leadbook) or die(mysql_error());
$row_fmLeadfuture = mysql_fetch_assoc($fmLeadfuture);
$totalRows_fmLeadfuture = mysql_num_rows($fmLeadfuture);

/**/
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadtoday = "SELECT Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.`Apt date` FROM Leads WHERE Leads.`Date` = CURDATE()";
$fmLeadtoday = mysql_query($query_fmLeadtoday, $Leadbook) or die(mysql_error());
$row_fmLeadtoday = mysql_fetch_assoc($fmLeadtoday);
$totalRows_fmLeadtoday = mysql_num_rows($fmLeadtoday);

/**/
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAptToday = "SELECT Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.`Apt date` FROM Leads WHERE Leads.`Apt date` = CURDATE()";
$fmAptToday = mysql_query($query_fmAptToday, $Leadbook) or die(mysql_error());
$row_fmAptToday = mysql_fetch_assoc($fmAptToday);
$totalRows_fmAptToday = mysql_num_rows($fmAptToday);

/**/
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

/**/
$Var_fmLeadCity = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmLeadCity = $_GET['Datefrom'];
}
$Var1_fmLeadCity = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmLeadCity = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadCity = sprintf("SELECT COUNT(Leads.City) as Num, Leads.City FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s GROUP BY Leads.City ORDER BY 1 Desc", GetSQLValueString($Var_fmLeadCity, "date"),GetSQLValueString($Var1_fmLeadCity, "date"));
$fmLeadCity = mysql_query($query_fmLeadCity, $Leadbook) or die(mysql_error());
$row_fmLeadCity = mysql_fetch_assoc($fmLeadCity);
$totalRows_fmLeadCity = mysql_num_rows($fmLeadCity);

/**/
$var_fmLeadSalesman = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmLeadSalesman = $_GET['Datefrom'];
}
$var1_fmLeadSalesman = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmLeadSalesman = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadSalesman = sprintf("SELECT COUNT(Leads.SalesNo) as Num, Salesman.Salesman FROM Leads, Salesman WHERE (Salesman.SalesNo = Leads.SalesNo) AND Leads.`Date` >= %s AND Leads.`Date` <= %s GROUP BY Salesman ORDER BY 1 Desc", GetSQLValueString($var_fmLeadSalesman, "date"),GetSQLValueString($var1_fmLeadSalesman, "date"));
$fmLeadSalesman = mysql_query($query_fmLeadSalesman, $Leadbook) or die(mysql_error());
$row_fmLeadSalesman = mysql_fetch_assoc($fmLeadSalesman);
$totalRows_fmLeadSalesman = mysql_num_rows($fmLeadSalesman);

/**/
$var_fmLeadAdvert = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmLeadAdvert = $_GET['Datefrom'];
}
$var1_fmLeadAdvert = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmLeadAdvert = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadAdvert = sprintf("SELECT COUNT(Leads.AdNo) as Num, advertising.Advertiser FROM Leads, advertising WHERE (advertising.AdNo = Leads.AdNo) AND (Leads.`Date` >= %s AND Leads.`Date` <= %s) GROUP BY Advertiser ORDER BY 1 Desc", GetSQLValueString($var_fmLeadAdvert, "date"),GetSQLValueString($var1_fmLeadAdvert, "date"));
$fmLeadAdvert = mysql_query($query_fmLeadAdvert, $Leadbook) or die(mysql_error());
$row_fmLeadAdvert = mysql_fetch_assoc($fmLeadAdvert);
$totalRows_fmLeadAdvert = mysql_num_rows($fmLeadAdvert);

/**/
$Var_fmCustJobCount = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmCustJobCount = $_GET['Datefrom'];
}
$Var1_fmCustJobCount = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmCustJobCount = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustJobCount = sprintf("SELECT COUNT(Customer.Amount) as Amount, Job.`Description` FROM Customer, Job WHERE (Job.JobNo = Customer.JobNo) AND Customer.`Date` >= %s AND Customer.`Date`  <= %s GROUP BY Description ORDER BY 1 Desc", GetSQLValueString($Var_fmCustJobCount, "date"),GetSQLValueString($Var1_fmCustJobCount, "date"));
$fmCustJobCount = mysql_query($query_fmCustJobCount, $Leadbook) or die(mysql_error());
$row_fmCustJobCount = mysql_fetch_assoc($fmCustJobCount);
$totalRows_fmCustJobCount = mysql_num_rows($fmCustJobCount);

/**/
$maxRows_fmWindowSold = 1;
$pageNum_fmWindowSold = 0;
if (isset($_GET['pageNum_fmWindowSold'])) {
  $pageNum_fmWindowSold = $_GET['pageNum_fmWindowSold'];
}
$startRow_fmWindowSold = $pageNum_fmWindowSold * $maxRows_fmWindowSold;

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

/**/
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

/**/
$Var_fmCustCity = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmCustCity = $_GET['Datefrom'];
}
$Var1_fmCustCity = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmCustCity = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustCity = sprintf("SELECT Count(Customer.City) as Num, Customer.City FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s GROUP BY Customer.City ORDER BY 1 Desc", GetSQLValueString($Var_fmCustCity, "date"),GetSQLValueString($Var1_fmCustCity, "date"));
$fmCustCity = mysql_query($query_fmCustCity, $Leadbook) or die(mysql_error());
$row_fmCustCity = mysql_fetch_assoc($fmCustCity);
$totalRows_fmCustCity = mysql_num_rows($fmCustCity);

/**/
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadProcess = "SELECT Leads.LeadNo, Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.Amount, Leads.`Call Back` FROM Leads WHERE (Leads.Amount = 0) AND (Leads.`Call Back` = 'None') ORDER BY Leads.`Apt date`";
$fmLeadProcess = mysql_query($query_fmLeadProcess, $Leadbook) or die(mysql_error());
$row_fmLeadProcess = mysql_fetch_assoc($fmLeadProcess);
$totalRows_fmLeadProcess = mysql_num_rows($fmLeadProcess);

/**/
$var_fmLeadJobCount = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmLeadJobCount = $_GET['Datefrom'];
}
$var1_fmLeadJobCount = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmLeadJobCount = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadJobCount = sprintf("SELECT COUNT(Leads.Amount) as Amount, Job.`Description` FROM Leads, Job WHERE (Job.JobNo = Leads.JobNo) AND Leads.`Date` >= %s AND Leads.`Date` <= %s GROUP BY Description ORDER BY 1 Desc", GetSQLValueString($var_fmLeadJobCount, "date"),GetSQLValueString($var1_fmLeadJobCount, "date"));
$fmLeadJobCount = mysql_query($query_fmLeadJobCount, $Leadbook) or die(mysql_error());
$row_fmLeadJobCount = mysql_fetch_assoc($fmLeadJobCount);
$totalRows_fmLeadJobCount = mysql_num_rows($fmLeadJobCount);

/**/
$var_fmCustSalesman = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmCustSalesman = $_GET['Datefrom'];
}
$var1_fmCustSalesman = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmCustSalesman = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustSalesman = sprintf("SELECT COUNT(Customer.SalesNo) as Num, Salesman.Salesman FROM Customer, Salesman WHERE (Salesman.SalesNo = Customer.SalesNo) AND Customer.`Date` >= %s AND Customer.`Date` <= %s GROUP BY Salesman ORDER BY 1 Desc", GetSQLValueString($var_fmCustSalesman, "date"),GetSQLValueString($var1_fmCustSalesman, "date"));
$fmCustSalesman = mysql_query($query_fmCustSalesman, $Leadbook) or die(mysql_error());
$row_fmCustSalesman = mysql_fetch_assoc($fmCustSalesman);
$totalRows_fmCustSalesman = mysql_num_rows($fmCustSalesman);

/**/
$var1_fmCustMonthGraph = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmCustMonthGraph = $_GET['Datefrom'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustMonthGraph = sprintf("SELECT 'a' as Num, Sum(Customer.Amount) as Amount, 'Jan' as SeqMonth FROM Customer WHERE EXTRACT(Month FROM Customer.Date) = 1 AND EXTRACT(Year FROM Customer.Date) = %s UNION SELECT 'b' as Num, SUM(Customer.Amount) as Amount, 'Feb' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 2 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'c' as Num, SUM(Customer.Amount) as Amount, 'Mar' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 3 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'd' as Num, SUM(Customer.Amount) as Amount, 'Apr' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 4 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'e' as Num, SUM(Customer.Amount) as Amount, 'May' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 5 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'f' as Num, SUM(Customer.Amount) as Amount, 'Jun' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 6 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'g' as Num, SUM(Customer.Amount) as Amount, 'Jul' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 7 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'h' as Num, SUM(Customer.Amount) as Amount, 'Aug' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 8 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'i' as Num, SUM(Customer.Amount) as Amount, 'Sep' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 9 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'j' as Num, SUM(Customer.Amount) as Amount, 'Oct' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 10 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'k' as Num, SUM(Customer.Amount) as Amount, 'Nov' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 11 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'l' as Num, SUM(Customer.Amount) as Amount, 'Dec' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 12 AND EXTRACT(Year from Customer.Date) = %s", GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"),GetSQLValueString($var1_fmCustMonthGraph, "date"));
$fmCustMonthGraph = mysql_query($query_fmCustMonthGraph, $Leadbook) or die(mysql_error());
$row_fmCustMonthGraph = mysql_fetch_assoc($fmCustMonthGraph);
$totalRows_fmCustMonthGraph = mysql_num_rows($fmCustMonthGraph);

/**/
$var1_fmLeadMonthGraph = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmLeadMonthGraph = $_GET['Datefrom'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadMonthGraph = sprintf("SELECT 'a' as Num, Count(Leads.City) as Amount, 'Jan' as SeqMonth FROM Leads WHERE EXTRACT(Month FROM Leads.Date) = 1 AND EXTRACT(Year FROM Leads.Date) = %s UNION SELECT 'b' as Num, Count(Leads.City) as Amount, 'Feb' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 2 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'c' as Num, Count(Leads.City) as Amount, 'Mar' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 3 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'd' as Num, Count(Leads.City) as Amount, 'Apr' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 4 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'e' as Num, Count(Leads.City) as Amount, 'May' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 5 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'f' as Num, Count(Leads.City) as Amount, 'Jun' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 6 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'g' as Num, Count(Leads.City) as Amount, 'Jul' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 7 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'h' as Num, Count(Leads.City) as Amount, 'Aug' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 8 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'i' as Num, Count(Leads.City) as Amount, 'Sep' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 9 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'j' as Num, Count(Leads.City) as Amount, 'Oct' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 10 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'k' as Num, Count(Leads.City) as Amount, 'Nov' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 11 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'l' as Num, Count(Leads.City) as Amount, 'Dec' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 12 AND EXTRACT(Year from Leads.Date) = %s", GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"));
$fmLeadMonthGraph = mysql_query($query_fmLeadMonthGraph, $Leadbook) or die(mysql_error());
$row_fmLeadMonthGraph = mysql_fetch_assoc($fmLeadMonthGraph);
$totalRows_fmLeadMonthGraph = mysql_num_rows($fmLeadMonthGraph);

/**/
$var_fmLeadYear = "$Datefrom";
if (isset($_GET['var'])) {
  $var_fmLeadYear = $_GET['var'];
}
$var1_fmLeadYear = "$Datenow";
if (isset($_GET['var1'])) {
  $var1_fmLeadYear = $_GET['var1'];
}
$var2_fmLeadYear = "$Datefrom1";
if (isset($_GET['var2'])) {
  $var2_fmLeadYear = $_GET['var2'];
}
$var3_fmLeadYear = "$Dateto1";
if (isset($_GET['var3'])) {
  $var3_fmLeadYear = $_GET['var3'];
}
$var4_fmLeadYear = "$Datefrom2";
if (isset($_GET['var4'])) {
  $var4_fmLeadYear = $_GET['var4'];
}
$var5_fmLeadYear = "$Dateto2";
if (isset($_GET['var5'])) {
  $var5_fmLeadYear = $_GET['var5'];
}
$var6_fmLeadYear = "$Datefrom3";
if (isset($_GET['var6'])) {
  $var6_fmLeadYear = $_GET['var6'];
}
$var7_fmLeadYear = "$Dateto3";
if (isset($_GET['var7'])) {
  $var7_fmLeadYear = $_GET['var7'];
}
$var8_fmLeadYear = "$Datefrom4";
if (isset($_GET['var8'])) {
  $var8_fmLeadYear = $_GET['var8'];
}
$var9_fmLeadYear = "$Dateto4";
if (isset($_GET['var9'])) {
  $var9_fmLeadYear = $_GET['var9'];
}
$var10_fmLeadYear = "$Datefrom5";
if (isset($_GET['var10'])) {
  $var10_fmLeadYear = $_GET['var10'];
}
$var11_fmLeadYear = "$Dateto5";
if (isset($_GET['var11'])) {
  $var11_fmLeadYear = $_GET['var11'];
}
$var12_fmLeadYear = "$Datefrom6";
if (isset($_GET['var12'])) {
  $var12_fmLeadYear = $_GET['var12'];
}
$var13_fmLeadYear = "$Dateto6";
if (isset($_GET['var13'])) {
  $var13_fmLeadYear = $_GET['var13'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadYear = sprintf("SELECT YEAR(CURRENT_TIMESTAMP), Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -1, Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) - 1 as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -2, Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) - 2 as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -3, Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) - 3 as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -4, Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) - 4 as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -5, Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) - 5 as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -6, Count(Leads.JobNo) as Amount, YEAR(CURRENT_TIMESTAMP) - 6 as Year FROM Leads WHERE Leads.`Date`>= %s AND Leads.`Date` <= %s", GetSQLValueString($var_fmLeadYear, "date"),GetSQLValueString($var1_fmLeadYear, "date"),GetSQLValueString($var2_fmLeadYear, "date"),GetSQLValueString($var3_fmLeadYear, "date"),GetSQLValueString($var4_fmLeadYear, "date"),GetSQLValueString($var5_fmLeadYear, "date"),GetSQLValueString($var6_fmLeadYear, "date"),GetSQLValueString($var7_fmLeadYear, "date"),GetSQLValueString($var8_fmLeadYear, "date"),GetSQLValueString($var9_fmLeadYear, "date"),GetSQLValueString($var10_fmLeadYear, "date"),GetSQLValueString($var11_fmLeadYear, "date"),GetSQLValueString($var12_fmLeadYear, "date"),GetSQLValueString($var13_fmLeadYear, "date"));
$fmLeadYear = mysql_query($query_fmLeadYear, $Leadbook) or die(mysql_error());
$row_fmLeadYear = mysql_fetch_assoc($fmLeadYear);
$totalRows_fmLeadYear = mysql_num_rows($fmLeadYear);

/**/
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

/**/
$var1_fmWindowSoldGraph = "$Datefrom";
if (isset($_GET['var1'])) {
  $var1_fmWindowSoldGraph = $_GET['var1'];
}
$var2_fmWindowSoldGraph = "$Dateto";
if (isset($_GET['var2'])) {
  $var2_fmWindowSoldGraph = $_GET['var2'];
}
$var3_fmWindowSoldGraph = "$Datefrom1";
if (isset($_GET['var3'])) {
  $var3_fmWindowSoldGraph = $_GET['var3'];
}
$var4_fmWindowSoldGraph = "$Dateto1";
if (isset($_GET['var4'])) {
  $var4_fmWindowSoldGraph = $_GET['var4'];
}
$var5_fmWindowSoldGraph = "$Datefrom2";
if (isset($_GET['var5'])) {
  $var5_fmWindowSoldGraph = $_GET['var5'];
}
$var6_fmWindowSoldGraph = "$Dateto2";
if (isset($_GET['var6'])) {
  $var6_fmWindowSoldGraph = $_GET['var6'];
}
$var7_fmWindowSoldGraph = "$Datefrom3";
if (isset($_GET['var7'])) {
  $var7_fmWindowSoldGraph = $_GET['var7'];
}
$var8_fmWindowSoldGraph = "$Dateto3";
if (isset($_GET['var8'])) {
  $var8_fmWindowSoldGraph = $_GET['var8'];
}
$var9_fmWindowSoldGraph = "$Datefrom4";
if (isset($_GET['var9'])) {
  $var9_fmWindowSoldGraph = $_GET['var9'];
}
$var10_fmWindowSoldGraph = "$Dateto4";
if (isset($_GET['var10'])) {
  $var10_fmWindowSoldGraph = $_GET['var10'];
}
$var11_fmWindowSoldGraph = "$Datefrom5";
if (isset($_GET['var11'])) {
  $var11_fmWindowSoldGraph = $_GET['var11'];
}
$var12_fmWindowSoldGraph = "$Dateto5";
if (isset($_GET['var12'])) {
  $var12_fmWindowSoldGraph = $_GET['var12'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmWindowSoldGraph = sprintf("SELECT YEAR(CURRENT_TIMESTAMP), Sum(Customer.Quan) as Amount,YEAR(CURRENT_TIMESTAMP) as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 1, Sum(Customer.Quan) as Amount,YEAR(CURRENT_TIMESTAMP) - 1 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 2, Sum(Customer.Quan) as Amount,YEAR(CURRENT_TIMESTAMP) - 2 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 3, Sum(Customer.Quan) as Amount,YEAR(CURRENT_TIMESTAMP) - 3 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 4, Sum(Customer.Quan) as Amount,YEAR(CURRENT_TIMESTAMP) - 4 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION 
SELECT YEAR(CURRENT_TIMESTAMP) - 5, Sum(Customer.Quan) as Amount,YEAR(CURRENT_TIMESTAMP) - 5 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($var1_fmWindowSoldGraph, "date"),GetSQLValueString($var2_fmWindowSoldGraph, "date"),GetSQLValueString($var3_fmWindowSoldGraph, "date"),GetSQLValueString($var4_fmWindowSoldGraph, "date"),GetSQLValueString($var5_fmWindowSoldGraph, "date"),GetSQLValueString($var6_fmWindowSoldGraph, "date"),GetSQLValueString($var7_fmWindowSoldGraph, "date"),GetSQLValueString($var8_fmWindowSoldGraph, "date"),GetSQLValueString($var9_fmWindowSoldGraph, "date"),GetSQLValueString($var10_fmWindowSoldGraph, "date"),GetSQLValueString($var11_fmWindowSoldGraph, "date"),GetSQLValueString($var12_fmWindowSoldGraph, "date"));
$fmWindowSoldGraph = mysql_query($query_fmWindowSoldGraph, $Leadbook) or die(mysql_error());
$row_fmWindowSoldGraph = mysql_fetch_assoc($fmWindowSoldGraph);
$totalRows_fmWindowSoldGraph = mysql_num_rows($fmWindowSoldGraph);

/**/
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
$query_fmAvgCustGraph = sprintf("
SELECT YEAR(CURRENT_TIMESTAMP), AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -1, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 1 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 2, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 2 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 3, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 3 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 4, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 4 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 5, AVG(Customer.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 5 as Windows FROM Customer WHERE Customer.`Date` >= %s AND Customer.`Date` <= %s", GetSQLValueString($var1_fmAvgCustGraph, "date"),GetSQLValueString($var2_fmAvgCustGraph, "date"),GetSQLValueString($var3_fmAvgCustGraph, "date"),GetSQLValueString($var4_fmAvgCustGraph, "date"),GetSQLValueString($var5_fmAvgCustGraph, "date"),GetSQLValueString($var6_fmAvgCustGraph, "date"),GetSQLValueString($var7_fmAvgCustGraph, "date"),GetSQLValueString($var8_fmAvgCustGraph, "date"),GetSQLValueString($var9_fmAvgCustGraph, "date"),GetSQLValueString($var10_fmAvgCustGraph, "date"),GetSQLValueString($var11_fmAvgCustGraph, "date"),GetSQLValueString($var12_fmAvgCustGraph, "date"));
$fmAvgCustGraph = mysql_query($query_fmAvgCustGraph, $Leadbook) or die(mysql_error());
$row_fmAvgCustGraph = mysql_fetch_assoc($fmAvgCustGraph);
$totalRows_fmAvgCustGraph = mysql_num_rows($fmAvgCustGraph);

/**/
$var_fmCustAdvert = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var_fmCustAdvert = $_GET['Datefrom'];
}
$var1_fmCustAdvert = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var1_fmCustAdvert = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustAdvert = sprintf("SELECT COUNT(Leads.AdNo) as Num, advertising.Advertiser FROM Leads, advertising, Customer WHERE (advertising.AdNo = Leads.AdNo) AND (Customer.`Date` >= %s AND Customer.`Date` <= %s) AND Customer.LeadNo = Leads.LeadNo GROUP BY Advertiser ORDER BY 1 Desc", GetSQLValueString($var_fmCustAdvert, "date"),GetSQLValueString($var1_fmCustAdvert, "date"));
$fmCustAdvert = mysql_query($query_fmCustAdvert, $Leadbook) or die(mysql_error());
$row_fmCustAdvert = mysql_fetch_assoc($fmCustAdvert);
$totalRows_fmCustAdvert = mysql_num_rows($fmCustAdvert);

/**/
$var1_fmCustJobSum = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmCustJobSum = $_GET['Datefrom'];
}
$var2_fmCustJobSum = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var2_fmCustJobSum = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustJobSum = sprintf("SELECT SUM(Customer.Amount) as Amount, Job.`Description` FROM Customer, Job WHERE (Job.JobNo = Customer.JobNo) AND Customer.`Date`  >= %s AND Customer.`Date`  <= %s GROUP BY Description ORDER BY 1 Desc", GetSQLValueString($var1_fmCustJobSum, "date"),GetSQLValueString($var2_fmCustJobSum, "date"));
$fmCustJobSum = mysql_query($query_fmCustJobSum, $Leadbook) or die(mysql_error());
$row_fmCustJobSum = mysql_fetch_assoc($fmCustJobSum);
$totalRows_fmCustJobSum = mysql_num_rows($fmCustJobSum);

/**/
$var1_fmCustAdvertSum = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmCustAdvertSum = $_GET['Datefrom'];
}
$var2_fmCustAdvertSum = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var2_fmCustAdvertSum = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustAdvertSum = sprintf("SELECT SUM(Customer.Amount) as Amount, advertising.Advertiser FROM Customer, advertising, Leads WHERE advertising.AdNo = Leads.AdNo AND Customer.LeadNo = Leads.LeadNo AND Customer.`Date` >= %s AND Customer.`Date` <= %s GROUP BY Advertiser ORDER BY 1 Desc", GetSQLValueString($var1_fmCustAdvertSum, "date"),GetSQLValueString($var2_fmCustAdvertSum, "date"));
$fmCustAdvertSum = mysql_query($query_fmCustAdvertSum, $Leadbook) or die(mysql_error());
$row_fmCustAdvertSum = mysql_fetch_assoc($fmCustAdvertSum);
$totalRows_fmCustAdvertSum = mysql_num_rows($fmCustAdvertSum);

/**/
$var1_fmCustCitySum = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmCustCitySum = $_GET['Datefrom'];
}
$var2_fmCustCitySum = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var2_fmCustCitySum = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustCitySum = sprintf("SELECT SUM(Customer.Amount) as Amount, Customer.City FROM Customer WHERE Customer.`Date`  >= %s AND Customer.`Date`  <= %s GROUP BY City ORDER BY 1 Desc", GetSQLValueString($var1_fmCustCitySum, "date"),GetSQLValueString($var2_fmCustCitySum, "date"));
$fmCustCitySum = mysql_query($query_fmCustCitySum, $Leadbook) or die(mysql_error());
$row_fmCustCitySum = mysql_fetch_assoc($fmCustCitySum);
$totalRows_fmCustCitySum = mysql_num_rows($fmCustCitySum);

/**/
$var1_fmCustSalesmanSum = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmCustSalesmanSum = $_GET['Datefrom'];
}
$var2_fmCustSalesmanSum = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var2_fmCustSalesmanSum = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustSalesmanSum = sprintf("SELECT SUM(Customer.Amount) as Amount, Salesman.Salesman FROM Customer, Salesman WHERE (Salesman.SalesNo = Customer.SalesNo) AND Customer.`Date`  >= %s AND Customer.`Date`  <= %s GROUP BY Salesman ORDER BY 1 Desc", GetSQLValueString($var1_fmCustSalesmanSum, "date"),GetSQLValueString($var2_fmCustSalesmanSum, "date"));
$fmCustSalesmanSum = mysql_query($query_fmCustSalesmanSum, $Leadbook) or die(mysql_error());
$row_fmCustSalesmanSum = mysql_fetch_assoc($fmCustSalesmanSum);
$totalRows_fmCustSalesmanSum = mysql_num_rows($fmCustSalesmanSum);

/**/
$var_fmCustMonthPrev = "$Datefrom1";
if (isset($_GET['var'])) {
  $var_fmCustMonthPrev = $_GET['var'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustMonthPrev = sprintf("SELECT 'a' as Num, Sum(Customer.Amount) as Amount, 'Jan' as SeqMonth FROM Customer WHERE EXTRACT(Month FROM Customer.Date) = 1 AND EXTRACT(Year FROM Customer.Date) = %s UNION SELECT 'b' as Num, SUM(Customer.Amount) as Amount, 'Feb' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 2 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'c' as Num, SUM(Customer.Amount) as Amount, 'Mar' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 3 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'd' as Num, SUM(Customer.Amount) as Amount, 'Apr' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 4 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'e' as Num, SUM(Customer.Amount) as Amount, 'May' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 5 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'f' as Num, SUM(Customer.Amount) as Amount, 'Jun' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 6 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'g' as Num, SUM(Customer.Amount) as Amount, 'Jul' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 7 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'h' as Num, SUM(Customer.Amount) as Amount, 'Aug' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 8 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'i' as Num, SUM(Customer.Amount) as Amount, 'Sep' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 9 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'j' as Num, SUM(Customer.Amount) as Amount, 'Oct' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 10 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'k' as Num, SUM(Customer.Amount) as Amount, 'Nov' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 11 AND EXTRACT(Year from Customer.Date) = %s UNION SELECT 'l' as Num, SUM(Customer.Amount) as Amount, 'Dec' as SeqMonth FROM Customer WHERE EXTRACT(Month From Customer.Date) = 12 AND EXTRACT(Year from Customer.Date) = %s", GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"),GetSQLValueString($var_fmCustMonthPrev, "date"));
$fmCustMonthPrev = mysql_query($query_fmCustMonthPrev, $Leadbook) or die(mysql_error());
$row_fmCustMonthPrev = mysql_fetch_assoc($fmCustMonthPrev);
$totalRows_fmCustMonthPrev = mysql_num_rows($fmCustMonthPrev);

/**/
$var_fmLeadMonthPrev = "$Datefrom1";
if (isset($_GET['var'])) {
  $var_fmLeadMonthPrev = $_GET['var'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadMonthPrev = sprintf("SELECT 'a' as Num, Count(Leads.City) as Amount, 'Jan' as SeqMonth FROM Leads WHERE EXTRACT(Month FROM Leads.Date) = 1 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'b' as Num, Count(Leads.City) as Amount, 'Feb' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 2 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'c' as Num, Count(Leads.City) as Amount, 'Mar' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 3 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'd' as Num, Count(Leads.City) as Amount, 'Apr' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 4 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'e' as Num, Count(Leads.City) as Amount, 'May' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 5 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'f' as Num, Count(Leads.City) as Amount, 'Jun' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 6 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'g' as Num, Count(Leads.City) as Amount, 'Jul' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 7 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'h' as Num, Count(Leads.City) as Amount, 'Aug' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 8 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'i' as Num, Count(Leads.City) as Amount, 'Sep' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 9 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'j' as Num, Count(Leads.City) as Amount, 'Oct' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 10 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'k' as Num, Count(Leads.City) as Amount, 'Nov' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 11 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'l' as Num, Count(Leads.City) as Amount, 'Dec' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 12 AND EXTRACT(Year from Leads.Date) = %s", GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"),GetSQLValueString($var_fmLeadMonthPrev, "date"));
$fmLeadMonthPrev = mysql_query($query_fmLeadMonthPrev, $Leadbook) or die(mysql_error());
$row_fmLeadMonthPrev = mysql_fetch_assoc($fmLeadMonthPrev);
$totalRows_fmLeadMonthPrev = mysql_num_rows($fmLeadMonthPrev);

/**/
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadQuarter = "SELECT year(Leads.Date) as Year, quarter(Leads.Date) as Quarter, count(0) as Leads FROM Leads WHERE Date(Leads.Date) > '2000' GROUP BY year(date), quarter(date) ORDER BY 1 Desc";
$fmLeadQuarter = mysql_query($query_fmLeadQuarter, $Leadbook) or die(mysql_error());
$row_fmLeadQuarter = mysql_fetch_assoc($fmLeadQuarter);
$totalRows_fmLeadQuarter = mysql_num_rows($fmLeadQuarter);

/**/
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmCustQuarter = "SELECT year(Customer.Date) as Year, quarter(Customer.Date) as Quarter, count(0) as Customers FROM Customer WHERE Date(Customer.Date) > '2000' GROUP BY year(date), quarter(date) ORDER BY 1 Desc";
$fmCustQuarter = mysql_query($query_fmCustQuarter, $Leadbook) or die(mysql_error());
$row_fmCustQuarter = mysql_fetch_assoc($fmCustQuarter);
$totalRows_fmCustQuarter = mysql_num_rows($fmCustQuarter);

/**/
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

/**/
$Var_fmLeadCount = "$Datefrom";
if (isset($_GET['Var'])) {
  $Var_fmLeadCount = $_GET['Var'];
}
$Var1_fmLeadCount = "$Dateto";
if (isset($_GET['Var1'])) {
  $Var1_fmLeadCount = $_GET['Var1'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadCount = sprintf("SELECT Count(Leads.LeadNo) as Count FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s", GetSQLValueString($Var_fmLeadCount, "date"),GetSQLValueString($Var1_fmLeadCount, "date"));
$fmLeadCount = mysql_query($query_fmLeadCount, $Leadbook) or die(mysql_error());
$row_fmLeadCount = mysql_fetch_assoc($fmLeadCount);
$totalRows_fmLeadCount = mysql_num_rows($fmLeadCount);

/**/
$var_fmAptTommorrow = "$DateTommorrow";
if (isset($_GET['var'])) {
  $var_fmAptTommorrow = $_GET['var'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAptTommorrow = sprintf("SELECT Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.`Apt date` FROM Leads WHERE Leads.`Apt date` = %s", GetSQLValueString($var_fmAptTommorrow, "date"));
$fmAptTommorrow = mysql_query($query_fmAptTommorrow, $Leadbook) or die(mysql_error());
$row_fmAptTommorrow = mysql_fetch_assoc($fmAptTommorrow);
$totalRows_fmAptTommorrow = mysql_num_rows($fmAptTommorrow);

/**/
$maxRows_fmRepeatCust = 23;
$pageNum_fmRepeatCust = 0;
if (isset($_GET['pageNum_fmRepeatCust'])) {
  $pageNum_fmRepeatCust = $_GET['pageNum_fmRepeatCust'];
}
$startRow_fmRepeatCust = $pageNum_fmRepeatCust * $maxRows_fmRepeatCust;

/*SELECT Count(Customer.LeadNo) as Count, Leads.`Last Name`, Customer.Address, Customer.City, Customer.Phone, Sum(Customer.Amount) as Amount, Customer.CustNo FROM Customer, Leads WHERE (Customer.LeadNo = Leads.LeadNo) GROUP BY Customer.Address HAVING Count(Customer.LeadNo) > 1 ORDER BY Customer.`CustNo` DESC*/

mysql_select_db($database_Leadbook, $Leadbook);
$query_fmRepeatCust = "SELECT Count(Customer.LeadNo) as Count, Customer.CustNo, Customer.Date, Leads.`Last Name`, Customer.Address, Customer.City, Customer.Phone, Sum(Customer.Amount) as Amount  FROM Customer, Leads WHERE (Customer.LeadNo = Leads.LeadNo) GROUP BY Customer.Date HAVING Count(Customer.LeadNo) > 1 ORDER BY Customer.`Date` DESC";
$query_limit_fmRepeatCust = sprintf("%s LIMIT %d, %d", $query_fmRepeatCust, $startRow_fmRepeatCust, $maxRows_fmRepeatCust);
$fmRepeatCust = mysql_query($query_limit_fmRepeatCust, $Leadbook) or die(mysql_error());
$row_fmRepeatCust = mysql_fetch_assoc($fmRepeatCust);

if (isset($_GET['totalRows_fmRepeatCust'])) {
  $totalRows_fmRepeatCust = $_GET['totalRows_fmRepeatCust'];
} else {
  $all_fmRepeatCust = mysql_query($query_fmRepeatCust);
  $totalRows_fmRepeatCust = mysql_num_rows($all_fmRepeatCust);
}
$totalPages_fmRepeatCust = ceil($totalRows_fmRepeatCust/$maxRows_fmRepeatCust)-1;

$queryString_fmRepeatCust = "";
if (!empty($_SERVER['QUERY_STRING'])) {
$params = explode("&", $_SERVER['QUERY_STRING']);
$newParams = array();
foreach ($params as $param) {
if (stristr($param, "pageNum_fmRepeatCust") == false && 
stristr($param, "totalRows_fmRepeatCust") == false) {
array_push($newParams, $param);
}
}
if (count($newParams) != 0) {
$queryString_fmRepeatCust = "&" . htmlentities(implode("&", $newParams));
}
}
$queryString_fmRepeatCust = sprintf("&totalRows_fmRepeatCust=%d%s", $totalRows_fmRepeatCust, $queryString_fmRepeatCust);

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Snapshot</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script src="FusionCharts/FusionCharts.js" type="text/javascript"></script>
<script src="assets/functions.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css" />
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/CharcoalUpdate.css" rel="stylesheet" type="text/css">

<style type="text/css"> 
<!-- 
ul.MenuBarHorizontal a {color:#FFF; background-color:#333;}
#delform th {color: #0196e3; font-weight: bold; }
<!--a:link {text-decoration:none; color:#E63C1E;}-->
.AccordionPanelContent {height:425px;}
.Accordion {border-left:solid 0 gray; border-right:solid 0 #000;}
<!--.twoColFixRtHdr #header h1,.twoColFixRtHdr #footer p {margin:0; padding:10px 0;}-->
<!--.TabbedPanelsTab,.TabbedPanelsTab1 {font-size:11px; height:16px; width:120px;}-->
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
if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)) {
		document.location = "Snapshotipad.php";
	} // ]]>
</script>
</head>
<body class="twoColFixRtHdr">
<div id="carbonForm">
  <header id="header">
  <hgroup>
      <nav>
    <ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="index.php">Home</a> </li>
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
    <h1>Snapshot Online</h1>
    </hgroup>
    <!-- end #header --></header>
    
<section id="sidebar1">
<?php
if (isset($_COOKIE["user"]))
echo "Welcome " . $_COOKIE["user"] . "!<br />" ;
else
echo "Welcome guest!<br />";
?>       

<form id="form1" name="form1" method="get">
<p>
<input name="Search" type="text" id="Search" value="<?php echo $_REQUEST['Search']; ?>" size="18" />
<input type="submit" value="Search" />
<br />
</p>
</form>
<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>
<p><button class="tableheader"type="submit">Lead Statistics</button></p>
<p>Lead Count...<strong><?php echo $row_fmLeadCount['Count'] ?></strong></p>
<p>Leads Today...<strong><?php echo $totalRows_fmLeadtoday ?></strong></p>
<p>Appointments Today...<strong><?php echo $totalRows_fmAptToday ?></strong></p>
<p>Appointments Tommorrow...<strong><?php echo $totalRows_fmAptTommorrow ?></strong></p>
<p>Leads to Process...<strong><?php echo $totalRows_fmLeadProcess ?></strong></p>
<p>&nbsp;</p>
<p><button class="tableheader"type="submit">Customer Statistics</button></p>
<p>Customer Count...<strong><?php echo $row_fmCustCount['Count'] ?></strong></p>
<p>Active Customers...<strong><?php echo $totalRows_fmActiveCust ?></strong></p>
<p>Windows Sold...<strong>
<?php do { ?>
<?php echo $row_fmWindowSold['Windows']; ?>
<?php } while ($row_fmWindowSold = mysql_fetch_assoc($fmWindowSold)); ?></strong></p>
<p>Avg Customer...<strong>
<?php do { ?>
<?php echo number_format($row_fmAvgCust['AVG(Customer.Amount)'],0); ?>
<?php } while ($row_fmAvgCust = mysql_fetch_assoc($fmAvgCust)); ?></strong></p>

<?php
$months = array();
for($i = 0; $i < 12; $i++){
  $timestamp = strtotime("-$i month");
  $value =  date('n', strtotime("-$i month"));
  $text  =  date('F', strtotime("-$i month"));  
  $months[$value] =  $text;
}
print '<select>';
foreach($months as $value => $text){
    print '<option value="'.$value.'">'.$text.'</option>'; 
}
print '</select>';
?>
<!-- end #sidebar1 --></section>

<aside id="mainContent">
<div id="titlerepeat">Admin:Snapshot</div>

<?php			
$SelectDate=$_GET['SelectDate'];
switch($SelectDate)
{
        case "1" :
                $Datefrom = date('Y-01-01');
				$Dateto = date('Y-12-31');
                break;
        case "2" :
                $Datefrom = date('Y-01-01');
				$Dateto = date('Y-m-d');
                break;
        case "3" :
                $Datefrom = date("Y-m-d",strtotime("-1 days"));
				$Dateto = date("Y-m-d",strtotime("-1 days"));
                break;
		case "4" :
                $Datefrom = date('Y-m-d',strtotime(date('Y')."W".date('W')."0"));
				$Dateto = date('Y-m-d',strtotime(date('Y')."W".date('W')."7"));
                break;
        case "5" :
                $Datefrom = date('Y-m-d',strtotime(date('Y')."W".date('W')."0"));
				$Dateto = date('Y-m-d');
                break;
        case "6" :
                $Datefrom = date("Y-m-01",strtotime("-1 month"));
				$Dateto = date("Y-m-t",strtotime("-1 month"));
                break;
	    case "7" :
                $Datefrom = date("Y-m-01",strtotime("-1 month"));
				$Dateto = date("Y-m-d",strtotime("-1 month"));
                break;
        case "8" :
                $Datefrom = date("Y-01-01",strtotime("-1 year"));
				$Dateto = date("Y-12-31",strtotime("-1 year"));
                break;
        case "9" :
                $Datefrom = date("Y-01-01",strtotime("-1 year"));
				$Dateto = date("Y-m-d",strtotime("-1 year"));
                break;
		case "10" :
                $Datefrom = date('Y-m-d');
				$Dateto = date('Y-m-d');
                break;
        case "11" :
                $Datefrom = date("Y-m-01");
				$Dateto = date("Y-m-t");
                break;
        case "12" :
                
                break;		
        case "13" :
               
                break;
        case "14" :
                $Datefrom = date('1980-01-01');
				$Dateto = date('Y-12-31');
                break;						
}
?>
<form action="Snapshot.php" method="get" name="formEdit" id="formEdit">
<select name='SelectDate' id="SelectDate" onchange="submit()">
<option value="1" <?php echo $t1v ?>>Current Year</option>
<option value="2" <?php echo $t2v ?>>Current Year-to-date</option>
<option value="3" <?php echo $t3v ?>>Yesterday</option>
<option value="4" <?php echo $t4v ?>>This Week</option>
<option value="5" <?php echo $t5v ?>>This Week-to-date</option>
<option value="6" <?php echo $t6v ?>>Last Month</option>
<option value="7" <?php echo $t7v ?>>Last Month-to-date</option>
<option value="8" <?php echo $t8v ?>>Last Year</option>
<option value="9" <?php echo $t9v ?>>Last Year-to-date</option>
<option value="10" <?php echo $t10v ?>>Today</option>
<option value="11" <?php echo $t11v ?>>Current Month</option>
<option value="12" <?php echo $t12v ?>>Current Quarter</option>
<option value="13" <?php echo $t13v ?>>Current Quarter-to-date</option>
<option value="14" <?php echo $t14v ?>>All Dates</option>
</select>
from<input name="Datefrom" type="text" id="Datefrom" value="<?php echo $Datefrom ?>" size="12" />
to<input name="Dateto" type="text" id="Dateto" value="<?php echo $Dateto ?>" size="12" />
<input type="submit" name="button2" id="button2" value="New date" />
</form>

<div id="Accordion1" class="Accordion">
<div class="AccordionPanel">
<div class="AccordionPanelTab">Sales Graph</div>
<div class="AccordionPanelContent">
<table width="100%"  id="delform">
<tr>
<td><?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$FC->setChartMessage("ChartNoDataText=Chart Data not provided;PBarLoadingText=Please Wait.The chart is loading...");
$strParam="caption=Sales by Month;subCaption=;xAxisName=;showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=$;decimalPrecision=0;formatNumberScale=1;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustMonthGraph) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "SeqMonth");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Sales by Year;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;formatNumberScale=1;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustYear) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "Year");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
</tr>
<tr>
<td>
<?php  $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Leads by Month;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmLeadMonthGraph) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "SeqMonth");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Leads by Year;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmLeadYear) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "Year");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
</tr>
<tr>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Window Sales by Year;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmWindowSoldGraph) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "Windows");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Average Sales by Year;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmAvgCustGraph) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "Windows");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
</tr>
</table>
<table width="100%"  id="delform">
<tr>
<td width="16%" class= "stylered">Sales by Month</td>
<td width="16%" class= "stylered">Leads by Month</td>
<td width="16%" class= "stylered">Leads by Year</td>
<td width="16%" class= "stylered">Sales by Year</td>
<td width="16%" class= "stylered">Window Sales by Year</td>
<td width="16%" class= "stylered">Avg Sales by Year</td>
</tr>
<tr>
<td><table  id="delform">
<tr>
<th>Amount</th>
<th>Month</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmCustMonthGraph['Amount']; ?></td>
<td><?php echo $row_fmCustMonthGraph['SeqMonth']; ?></td></tr>
<?php } while ($row_fmCustMonthGraph = mysql_fetch_assoc($fmCustMonthGraph)); ?>
</table></td>

<td><table  id="delform">
<tr>
<th>Amount</th>
<th>Month</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadMonthGraph['Amount']; ?></td>
<td><?php echo $row_fmLeadMonthGraph['SeqMonth']; ?></td>
</tr>
<?php } while ($row_fmLeadMonthGraph = mysql_fetch_assoc($fmLeadMonthGraph)); ?>
</table></td>
<td class="tddataleft" valign="top"><table  id="delform">
<tr>
<th>Amount</th>
<th>Year</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadYear['Amount']; ?></td>
<td><?php echo $row_fmLeadYear['Year']; ?></td>
</tr>
<?php } while ($row_fmLeadYear = mysql_fetch_assoc($fmLeadYear)); ?>
</table></td>
<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Year</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmCustYear['Amount']; ?></td>
<td><?php echo $row_fmCustYear['Year']; ?></td>
</tr>
<?php } while ($row_fmCustYear = mysql_fetch_assoc($fmCustYear)); ?>
</table></td>
<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Year</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmWindowSoldGraph['Amount']; ?></td>
<td><?php echo $row_fmWindowSoldGraph['Windows']; ?></td>
</tr>
<?php } while ($row_fmWindowSoldGraph = mysql_fetch_assoc($fmWindowSoldGraph)); ?>
</table></td>
<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Windows</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo number_format($row_fmAvgCustGraph['Amount'],0); ?></td>
<td><?php echo $row_fmAvgCustGraph['Windows']; ?></td>
</tr>
<?php } while ($row_fmAvgCustGraph = mysql_fetch_assoc($fmAvgCustGraph)); ?>
</table></td>
</tr>
</table>
</div>
</div>
<div class="AccordionPanel">
<div class="AccordionPanelTab">Previous Year Graph</div>
<div class="AccordionPanelContent">
<div class="AccordionPanelContent">
<table width="100%"  id="delform">
<tr>
<td><?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Pevious Year Sales by Month;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustMonthPrev) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "SeqMonth");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
<td><?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Previous Year Leads by Month;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmLeadMonthPrev) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "SeqMonth");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
</tr>
</table>

<table width="100%"  id="delform">
<tr>
<td width="16%" class= "stylered">Pevious Year Sales by Month</td>
<td width="16%" class= "stylered">Previous Year Leads by Month</td>
<td width="16%" class= "stylered">Advertising Sales</td>
<td width="16%" class= "stylered">Advertising Leads</td>
<td width="16%" class= "stylered">Salesman Leads</td>
<td width="16%" class= "stylered">Salesman Sales</td>
</tr>

<tr>
<td><table  id="delform">
<tr>
<th>Amount</th>
<th>Month</th>
</tr>
<?php do { ?>
<tr><?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmCustMonthPrev['Amount']; ?></td>
<td><?php echo $row_fmCustMonthPrev['SeqMonth']; ?></td>
</tr>
<?php } while ($row_fmCustMonthPrev = mysql_fetch_assoc($fmCustMonthPrev)); ?>
</table></td>

<td><table  id="delform">
<tr>
<th>Amount</th>
<th>Month</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadMonthPrev['Amount']; ?></td>
<td><?php echo $row_fmLeadMonthPrev['SeqMonth']; ?></td>
</tr>
<?php } while ($row_fmLeadMonthPrev = mysql_fetch_assoc($fmLeadMonthPrev)); ?>
</table></td>

<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Year</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadYear['Amount']; ?></td>
<td><?php echo $row_fmLeadYear['Year']; ?></td>
</tr>
<?php } while ($row_fmLeadYear = mysql_fetch_assoc($fmLeadYear)); ?>
</table></td>

<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Year</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmCustYear['Amount']; ?></td>
<td><?php echo $row_fmCustYear['Year']; ?></td>
</tr>
<?php } while ($row_fmCustYear = mysql_fetch_assoc($fmCustYear)); ?>
</table></td>

<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Year</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmWindowSoldGraph['Amount']; ?></td>
<td><?php echo $row_fmWindowSoldGraph['Windows']; ?></td>
</tr>
<?php } while ($row_fmWindowSoldGraph = mysql_fetch_assoc($fmWindowSoldGraph)); ?>
</table></td>

<td class="tddataleft" valign="top">
<table  id="delform">
<tr>
<th>Amount</th>
<th>Windows</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmAvgCustGraph['Amount']; ?></td>
<td><?php echo $row_fmAvgCustGraph['Windows']; ?></td>
</tr>
<?php } while ($row_fmAvgCustGraph = mysql_fetch_assoc($fmAvgCustGraph)); ?>
</table></td>
</tr>
</table>
</div>
</div>
</div>
<div class="AccordionPanel">
<div class="AccordionPanelTab">Statistics</div>
<div class="AccordionPanelContent">
<h3>Click tab to view statistics</h3>
<div id="TabbedPanels2" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">By Advertising</li>
<li class="TabbedPanelsTab">By City</li>
<li class="TabbedPanelsTab">By Job</li>
<li class="TabbedPanelsTab">By Salesman</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<table width="100%"  id="delform">
<tr>
<td><?php $link = connectToDB();
$FC = new FusionCharts("Pie3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Leads by Advertisers;subCaption=;decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=70; pieSliceDepth=15; pieRadius=100;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmLeadAdvert) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Num", "Advertiser");
}
mysql_close($link);
$FC->renderChart(); ?>
                    </td>
                    <td><?php $link = connectToDB();
$FC = new FusionCharts("Pie3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Customers by Advertisers;subCaption=;decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=70; pieSliceDepth=15; pieRadius=100;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustAdvert) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Num", "Advertiser");
}
mysql_close($link);
$FC->renderChart(); ?>
</td></tr>
<tr><td><?php $link = connectToDB();
$FC = new FusionCharts("Pie3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Sales by Advertisers;subCaption=;decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=70; pieSliceDepth=15; pieRadius=100;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustAdvertSum) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Amount", "Advertiser");
}
mysql_close($link);
$FC->renderChart(); ?>
</td></tr>
</table>

<table width="100%"  id="delform">
<tr>
<td valign="top" class="stylered">Leads by Adverisers</td>
<td valign="top" class="stylered">Customers by Advertisers</td>
<td valign="top" class="stylered">Sales by Advertisers</td></tr>

<tr>
<td valign="top"><table  id="delform">
<tr>
<th>Num</th>
<th>Advertiser</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmLeadAdvert['Num']; ?></td>
<td>
<?php echo $row_fmLeadAdvert['Advertiser']; ?></td>
</tr>
<?php } while ($row_fmLeadAdvert = mysql_fetch_assoc($fmLeadAdvert)); ?>
</table></td>

<td valign="top">
<table  id="delform">
<tr>
<th>Num</th>
<th>Advertiser</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustAdvert['Num']; ?></td>
<td>
<?php echo $row_fmCustAdvert['Advertiser']; ?></td>
</tr>
<?php } while ($row_fmCustAdvert = mysql_fetch_assoc($fmCustAdvert)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Amount</th>
<th>Advertiser</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustAdvertSum['Amount']; ?></td>
<td>
<?php echo $row_fmCustAdvertSum['Advertiser']; ?></td>
</tr>
<?php } while ($row_fmCustAdvertSum = mysql_fetch_assoc($fmCustAdvertSum)); ?>
</table></td>
</tr>
</table>
</div>
<div class="TabbedPanelsContent">
<table width="100%"  id="delform">
<tr>
<td valign="top" class= "stylered">Leads by City</td>
<td valign="top" class= "stylered">Customers by City</td>
<td valign="top" class= "stylered">Sales by City</td></tr>

<tr>
<td valign="top"><table  id="delform" >
<tr>
<th>Num</th>
<th>City</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmLeadCity['Num']; ?></td>
<td>
<?php echo $row_fmLeadCity['City']; ?></td>
</tr>
<?php } while ($row_fmLeadCity = mysql_fetch_assoc($fmLeadCity)); ?>
</table></td>

<td valign="top"><table  id="delform" >
<tr>
<th>Num</th>
<th>City</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustCity['Num']; ?></td>
<td>
<?php echo $row_fmCustCity['City']; ?></td>
</tr>
<?php } while ($row_fmCustCity = mysql_fetch_assoc($fmCustCity)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Amount</th>
<th>City</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustCitySum['Amount']; ?></td>
<td>
<?php echo $row_fmCustCitySum['City']; ?></td>
</tr>
<?php } while ($row_fmCustCitySum = mysql_fetch_assoc($fmCustCitySum)); ?>
</table></td>
</tr>
</table>
<p>&nbsp;</p>
</div>

<div class="TabbedPanelsContent">
<table width="100%"  id="delform">
<tr>
<td class= "stylered">Leads by Jobs</td>
<td class= "stylered">Customers by Jobs</td>
<td class= "stylered">Sales by Jobs</td>
</tr>
<tr>
<td valign="top"><table  id="delform" >
<tr>
<th>Amount</th>
<th>Description</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmLeadJobCount['Amount']; ?></td>
<td>
<?php echo $row_fmLeadJobCount['Description']; ?></td>
</tr>
<?php } while ($row_fmLeadJobCount = mysql_fetch_assoc($fmLeadJobCount)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Amount</th>
<th>Description</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustJobCount['Amount']; ?></td>
<td>
<?php echo $row_fmCustJobCount['Description']; ?></td>
</tr>
<?php } while ($row_fmCustJobCount = mysql_fetch_assoc($fmCustJobCount)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Amount</th>
<th>Description</hd>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustJobSum['Amount']; ?></td>
<td>
<?php echo $row_fmCustJobSum['Description']; ?></td>
</tr>
<?php } while ($row_fmCustJobSum = mysql_fetch_assoc($fmCustJobSum)); ?>
</table></td>
</tr>
</table>
<p>&nbsp;</p>
</div>
<div class="TabbedPanelsContent">
<table width="100%"  id="delform">
<tr>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Pie3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Leads by Salesman;subCaption=;decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=70; pieSliceDepth=15; pieRadius=100;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmLeadSalesman) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Num", "Salesman");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Pie3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Customers by Salesman;subCaption=;decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=70; pieSliceDepth=15; pieRadius=100;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustSalesman) or die(mysql_error());
if ($result) 
{
$FC->addDataFromDatabase($result, "Num", "Salesman");
}
mysql_close($link);
$FC->renderChart(); ?>
</td>
</tr>
<tr>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Pie3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Sales by Salesman;subCaption=;decimalPrecision=0; showPercentageValues=0; showNames=1; numberPrefix=; showValues=1; showPercentageInLabel=0; pieYScale=45; pieBorderAlpha=40; pieFillAlpha=70; pieSliceDepth=15; pieRadius=100;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustSalesmanSum) or die(mysql_error());
if ($result) 
{ $FC->addDataFromDatabase($result, "Amount", "Salesman"); }
mysql_close($link);
$FC->renderChart(); ?></td>
</tr>
</table>

<table width="100%"  id="delform">
<tr>
<td class= "stylered">Leads by Salesman</td>
<td class= "stylered">Customers by Salesman</td>
<td class= "stylered">Sales by Salesman</td></tr>

<tr>
<td valign="top"><table  id="delform">
<tr>
<th>Num</th>
<th>Salesman</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmLeadSalesman['Num']; ?></td>
<td>
<?php echo $row_fmLeadSalesman['Salesman']; ?></td>
</tr>
<?php } while ($row_fmLeadSalesman = mysql_fetch_assoc($fmLeadSalesman)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Num</th>
<th>Salesman</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustSalesman['Num']; ?></td>
<td>
<?php echo $row_fmCustSalesman['Salesman']; ?></td>
</tr>
<?php } while ($row_fmCustSalesman = mysql_fetch_assoc($fmCustSalesman)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Amount</th>
<th>Salesman</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustSalesmanSum['Amount']; ?></td>
<td>
<?php echo $row_fmCustSalesmanSum['Salesman']; ?></td>
</tr>
<?php } while ($row_fmCustSalesmanSum = mysql_fetch_assoc($fmCustSalesmanSum)); ?>
</table></td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="AccordionPanel">
<div class="AccordionPanelTab">Quarter Statistics</div>
<div class="AccordionPanelContent">
<table width="100%"  id="delform">
<tr>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Leads by Quarter;subCaption=;xAxisName=;showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=$;decimalPrecision=0;formatNumberScale=1;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmLeadQuarter) or die(mysql_error());
if ($result) 
{ $FC->addDataFromDatabase($result, "Leads", "Quarter"); }
mysql_close($link);
$FC->renderChart(); ?>
</td>
<td>
<?php $link = connectToDB();
$FC = new FusionCharts("Column3D","340","200");
$FC->setSwfPath("FusionCharts/");
$strParam="caption=Customers by Quarter;subCaption=;xAxisName=; showBorder=1;showNames=1;formatNumberScale=0;numberSuffix=;decimalPrecision=0;chartTopMargin=0;chartBottomMargin=0;chartRightMargin=0;chartLeftMargin=0";
$FC->setChartParams($strParam); 
$result = mysql_query($query_fmCustQuarter) or die(mysql_error());
if ($result) 
{ $FC->addDataFromDatabase($result, "Customers", "Quarter");
} mysql_close($link); 
$FC->renderChart(); ?></td>
</tr>
</table>

<table width="100%"  id="delform">
<tr>
<td valign="top" class= "stylered">Leads by Quarter</td>
<td valign="top" class= "stylered">Customers by Quarter</td>
</tr>

<tr>
<td valign="top"><table  id="cart">
<tr>
<th>Year</th>
<th>Quarter</th>
<th>Leads</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmLeadQuarter['Year']; ?></td>
<td>
<?php echo $row_fmLeadQuarter['Quarter']; ?></td>
<td>
<?php echo $row_fmLeadQuarter['Leads']; ?></td>
</tr>
<?php } while ($row_fmLeadQuarter = mysql_fetch_assoc($fmLeadQuarter)); ?>
</table></td>

<td valign="top"><table  id="delform">
<tr>
<th>Year</th>
<th>Quarter</th>
<th>Customers</th>
</tr>
<?php do { ?>
<tr> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php echo $row_fmCustQuarter['Year']; ?></td>
<td>
<?php echo $row_fmCustQuarter['Quarter']; ?></td>
<td>
<?php echo $row_fmCustQuarter['Customers']; ?></td>
</tr>
<?php } while ($row_fmCustQuarter = mysql_fetch_assoc($fmCustQuarter)); ?>
</table></td>
</tr>
<tr>&nbsp;</tr>
</table>
</div>
</div>
</div>
<p>&nbsp;</p>
<div id="TabbedPanels1" class="TabbedPanels">
<ul class="TabbedPanelsTabGroup">
<li class="TabbedPanelsTab">Leads Look Good</li>
<li class="TabbedPanelsTab">Leads Future Work</li>
<li class="TabbedPanelsTab">Repeat Customers</li>
<li class="TabbedPanelsTab">Leads Today</li>
<li class="TabbedPanelsTab">Apt Today</li>
</ul>
<div class="TabbedPanelsContentGroup">
<div class="TabbedPanelsContent">
<h5>A list of leads that look good for following year</h5>

<?php if ($totalRows_fmLeadlookgood > 0) { // Show if recordset not empty ?>
<table  id="delform">
<tr>
<th>Apt date</th>
<th>Last Name</th>
<th>Address</th>
<th>City</th>
<th>Phone</th>
<th>Amount</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadlookgood['Apt date']; ?></td>
<td><?php echo $row_fmLeadlookgood['Last Name']; ?></td>
<td><?php echo $row_fmLeadlookgood['Address']; ?></td>
<td><?php echo $row_fmLeadlookgood['City']; ?></td>
<td><?php echo $row_fmLeadlookgood['Phone']; ?></td>
<td><?php echo $row_fmLeadlookgood['Amount']; ?></td>
</tr>
<?php } while ($row_fmLeadlookgood = mysql_fetch_assoc($fmLeadlookgood)); ?>
</table>
<?php } // Show if recordset not empty ?>
</div>
<div class="TabbedPanelsContent">
<h5>A list of future work leads for following year</h5>
<table  id="delform">
<tr>
<th>Apt date</th>
<th>Last Name</th>
<th>Address</th>
<th>City</th>
<th>Phone</th>
<th>Amount</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadfuture['Apt date']; ?></td>
<td><?php echo $row_fmLeadfuture['Last Name']; ?></td>
<td><?php echo $row_fmLeadfuture['Address']; ?></td>
<td><?php echo $row_fmLeadfuture['City']; ?></td>
<td><?php echo $row_fmLeadfuture['Phone']; ?></td>
<td><?php echo $row_fmLeadfuture['Amount']; ?></td>
</tr>
<?php } while ($row_fmLeadfuture = mysql_fetch_assoc($fmLeadfuture)); ?>
</table>
<p>&nbsp;</p>
</div>

<div class="TabbedPanelsContent">
<h5>A list of Repeat Customers for following year&nbsp;</h5>
<table  id="nav">
<tr>
<td>
<?php if ($pageNum_fmRepeatCust > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmRepeatCust=%d%s", $currentPage, 0, $queryString_fmRepeatCust); ?>">First</a>
<?php } // Show if not first page ?>
</td>
<td>
<?php if ($pageNum_fmRepeatCust > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_fmRepeatCust=%d%s", $currentPage, max(0, $pageNum_fmRepeatCust - 1), $queryString_fmRepeatCust); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>
<td>
<?php if ($pageNum_fmRepeatCust < $totalPages_fmRepeatCust) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmRepeatCust=%d%s", $currentPage, min($totalPages_fmRepeatCust, $pageNum_fmRepeatCust + 1), $queryString_fmRepeatCust); ?>">Next</a>
<?php } // Show if not last page ?>
</td>
<td>
<?php if ($pageNum_fmRepeatCust < $totalPages_fmRepeatCust) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_fmRepeatCust=%d%s", $currentPage, $totalPages_fmRepeatCust, $queryString_fmRepeatCust); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
</table>
<p></p>
<table  id="delform">
<tr>
<th>Count</th>
<th>Last Name</th>
<th>Address</th>
<th>City</th>
<th>Phone</th>
<th>Amount</th>
<th>CustNo</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmRepeatCust['Count']; ?></td>
<td><?php echo $row_fmRepeatCust['Last Name']; ?></td>
<td><?php echo $row_fmRepeatCust['Address']; ?></td>
<td><?php echo $row_fmRepeatCust['City']; ?></td>
<td><?php echo $row_fmRepeatCust['Phone']; ?></td>
<td><?php echo $row_fmRepeatCust['Amount']; ?></td>
<td><?php echo $row_fmRepeatCust['CustNo']; ?></td>
</tr>
<?php } while ($row_fmRepeatCust = mysql_fetch_assoc($fmRepeatCust)); ?>
</table>
</div>
<div class="TabbedPanelsContent">
<h5>A list of leads for today</h5>
<?php if ($totalRows_fmLeadtoday > 0) { // Show if recordset not empty ?>
<table  id="delform">
<tr>
<th>Date</th>
<th>Last Name</th>
<th>Address</th>
<th>City</th>
<th>Phone</th>
<th>Apt date</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmLeadtoday['Date']; ?></td>
<td><?php echo $row_fmLeadtoday['Last Name']; ?></td>
<td><?php echo $row_fmLeadtoday['Address']; ?></td>
<td><?php echo $row_fmLeadtoday['City']; ?></td>
<td><?php echo $row_fmLeadtoday['Phone']; ?></td>
<td><?php echo $row_fmLeadtoday['Apt date']; ?></td>
</tr>
<?php } while ($row_fmLeadtoday = mysql_fetch_assoc($fmLeadtoday)); ?>
</table>
<?php } // Show if recordset not empty ?>
</div>
<div class="TabbedPanelsContent">
<h5>A list of lead appointments for today</h5>
<?php if ($totalRows_fmAptToday > 0) { // Show if recordset not empty ?>
<table  id="delform">
<tr>
<th>Date</th>
<th>Last Name</th>
<th>Address</th>
<th>City</th>
<th>Phone</th>
<th>Apt date</th>
</tr>
<?php do { ?>
<tr> <?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td><?php echo $row_fmAptToday['Date']; ?></td>
<td><?php echo $row_fmAptToday['Last Name']; ?></td>
<td><?php echo $row_fmAptToday['Address']; ?></td>
<td><?php echo $row_fmAptToday['City']; ?></td>
<td><?php echo $row_fmAptToday['Phone']; ?></td>
<td><?php echo $row_fmAptToday['Apt date']; ?></td>
</tr>
<?php } while ($row_fmAptToday = mysql_fetch_assoc($fmAptToday)); ?>
</table>
<?php } // Show if recordset not empty ?>
</div>
</div>
</div>

<!-- end #mainContent --></aside>

<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats -->
<br class="clearfloat" />
<footer id="footer">
<!-- end #footer --></footer>
<!-- end #container --></div>

<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($fmLeadlookgood);

mysql_free_result($fmLeadfuture);

mysql_free_result($fmLeadtoday);

mysql_free_result($fmAptToday);

mysql_free_result($fmActiveCust);

mysql_free_result($fmLeadCity);

mysql_free_result($fmLeadSalesman);

mysql_free_result($fmLeadAdvert);

mysql_free_result($fmCustJobCount);

mysql_free_result($fmWindowSold);

mysql_free_result($fmAvgCust);

mysql_free_result($fmCustCity);

mysql_free_result($fmLeadProcess);

mysql_free_result($fmLeadJobCount);

mysql_free_result($fmCustSalesman);

mysql_free_result($fmCustMonthGraph);

mysql_free_result($fmLeadMonthGraph);

mysql_free_result($fmLeadYear);

mysql_free_result($fmCustYear);

mysql_free_result($fmWindowSoldGraph);

mysql_free_result($fmAvgCustGraph);

mysql_free_result($fmCustAdvert);

mysql_free_result($fmCustJobSum);

mysql_free_result($fmCustAdvertSum);

mysql_free_result($fmCustCitySum);

mysql_free_result($fmCustSalesmanSum);

mysql_free_result($fmCustMonthPrev);

mysql_free_result($fmLeadMonthPrev);

mysql_free_result($fmLeadQuarter);

mysql_free_result($fmCustQuarter);

mysql_free_result($fmCustCount);

mysql_free_result($fmLeadCount);

mysql_free_result($fmRepeatCust);

mysql_free_result($fmAptTommorrow);
?>
