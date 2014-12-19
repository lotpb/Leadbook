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

//include('FusionCharts/FusionCharts_Gen.php');
//include('FusionCharts/DBConn.php');
$title = "Leads"; 
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

//cookies
if (!isset($_COOKIE['visits'])) $_COOKIE['visits'] = 0;
$visits = $_COOKIE['visits'] + 1;
setcookie('visits',$visits,time()+60*60*24*30);

//checkboxes
if ($_GET['ActiveLead'] == 1) {
$t1v="checked"; 
} else { $t1v=""; }	

if ($_GET['EnableNewCustomer'] == "checked")  { 
$t1Newenable="checked";
} else { $t1Newenable==""; }

if ($_GET['EnableSearchCustomer'] == "checked")  { 
$t1Searchenable="checked";
} else { $t1Searchenable==""; }

if ($_GET['NewCustomer'] == "1")  { 
$title="New Customer";
$t1new="checked";
$t1search="";
} else { $t1new=""; }

if ($_GET['SearchCustomer'] == "1")  { 
$title="Search Customer";
$t1search="checked";
$t1new="";
} else { $t1search=""; }

//LeadsCount
//$Var_fmLeadCount = "$Datefrom";
//if (isset($_GET['Datefrom'])) {
//  $Var_fmLeadCount = $_GET['Datefrom'];
//}
//$Var1_fmLeadCount = "$Dateto";
//if (isset($_GET['Dateto'])) {
//  $Var1_fmLeadCount = $_GET['Dateto'];
//}
//mysql_select_db($database_Leadbook, $Leadbook);
//$query_fmLeadCount = sprintf("SELECT Count(Leads.LeadNo) as Count FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s", GetSQLValueString($Var_fmLeadCount, "date"),GetSQLValueString($Var1_fmLeadCount, "date"));
//$fmLeadCount = mysql_query($query_fmLeadCount, $Leadbook) or die(mysql_error());
//$row_fmLeadCount = mysql_fetch_assoc($fmLeadCount);
//$totalRows_fmLeadCount = mysql_num_rows($fmLeadCount);

//LeadsProcess
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadProcess = "SELECT Leads.LeadNo, Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.Amount, Leads.`Call Back` FROM Leads WHERE (Leads.Amount = 0) AND (Leads.`Call Back` = 'None') ORDER BY Leads.`Apt date`";
$fmLeadProcess = mysql_query($query_fmLeadProcess, $Leadbook) or die(mysql_error());
$row_fmLeadProcess = mysql_fetch_assoc($fmLeadProcess);
$totalRows_fmLeadProcess = mysql_num_rows($fmLeadProcess);

//LeadsToday
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadtoday = "SELECT Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.`Apt date` FROM Leads WHERE Leads.`Date` = CURDATE()";
$fmLeadtoday = mysql_query($query_fmLeadtoday, $Leadbook) or die(mysql_error());
$row_fmLeadtoday = mysql_fetch_assoc($fmLeadtoday);
$totalRows_fmLeadtoday = mysql_num_rows($fmLeadtoday);

//AptToday
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAptToday = "SELECT Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.`Apt date` FROM Leads WHERE (Leads.`Apt date` = CURDATE())";
$fmAptToday = mysql_query($query_fmAptToday, $Leadbook) or die(mysql_error());
$row_fmAptToday = mysql_fetch_assoc($fmAptToday);
$totalRows_fmAptToday = mysql_num_rows($fmAptToday);

//AptTommorrow
$Day1= mktime(0,0,0,date("m"),date("d")+1,date("Y"));
$DateTommorrow = date("Y-m-d", $Day1);
$var_fmAptTommorrow = "$DateTommorrow";
if (isset($_GET['var'])) {
  $var_fmAptTommorrow = $_GET['var'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAptTommorrow = sprintf("SELECT Leads.`Date`, Leads.`Last Name`, Leads.Address, Leads.City, Leads.Phone, Leads.`Apt date` FROM Leads WHERE Leads.`Apt date` = %s", GetSQLValueString($var_fmAptTommorrow, "date"));
$fmAptTommorrow = mysql_query($query_fmAptTommorrow, $Leadbook) or die(mysql_error());
$row_fmAptTommorrow = mysql_fetch_assoc($fmAptTommorrow);
$totalRows_fmAptTommorrow = mysql_num_rows($fmAptTommorrow);

//AvgLead
$maxRows_fmAvgLead = 1;
$pageNum_fmAvgLead = 0;
if (isset($_GET['pageNum_fmAvgLead'])) {
  $pageNum_fmAvgLead = $_GET['pageNum_fmAvgLead'];
}
$startRow_fmAvgLead = $pageNum_fmAvgLead * $maxRows_fmAvgLead;

$Var_fmAvgLead = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $Var_fmAvgLead = $_GET['Datefrom'];
}
$Var1_fmAvgLead = "$Dateto";
if (isset($_GET['Dateto'])) {
  $Var1_fmAvgLead = $_GET['Dateto'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAvgLead = sprintf("SELECT AVG(Leads.Amount) FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s", GetSQLValueString($Var_fmAvgLead, "date"),GetSQLValueString($Var1_fmAvgLead, "date"));
$query_limit_fmAvgLead = sprintf("%s LIMIT %d, %d", $query_fmAvgLead, $startRow_fmAvgLead, $maxRows_fmAvgLead);
$fmAvgLead = mysql_query($query_limit_fmAvgLead, $Leadbook) or die(mysql_error());
$row_fmAvgLead = mysql_fetch_assoc($fmAvgLead);

if (isset($_GET['totalRows_fmAvgLead'])) {
  $totalRows_fmAvgLead = $_GET['totalRows_fmAvgLead'];
} else {
  $all_fmAvgLead = mysql_query($query_fmAvgLead);
  $totalRows_fmAvgLead = mysql_num_rows($all_fmAvgLead);
}
$totalPages_fmAvgLead = ceil($totalRows_fmAvgLead/$maxRows_fmAvgLead)-1;

//Salesmam
$maxRows_frsalesman = 10;
$pageNum_frsalesman = 0;
if (isset($_GET['pageNum_frsalesman'])) {
  $pageNum_frsalesman = $_GET['pageNum_frsalesman'];
}
$startRow_frsalesman = $pageNum_frsalesman * $maxRows_frsalesman;

$colname_frsalesman = "Active";
if (isset($_GET['Active'])) {
  $colname_frsalesman = $_GET['Active'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frsalesman = sprintf("SELECT Salesman.SalesNo, Salesman.Salesman, Salesman.Active FROM Salesman WHERE Salesman.Active = %s", GetSQLValueString($colname_frsalesman, "text"));
$query_limit_frsalesman = sprintf("%s LIMIT %d, %d", $query_frsalesman, $startRow_frsalesman, $maxRows_frsalesman);
$frsalesman = mysql_query($query_limit_frsalesman, $Leadbook) or die(mysql_error());
$row_frsalesman = mysql_fetch_assoc($frsalesman);

//if (isset($_GET['totalRows_frsalesman'])) {
//  $totalRows_frsalesman = $_GET['totalRows_frsalesman'];
//} else {
//  $all_frsalesman = mysql_query($query_frsalesman);
//  $totalRows_frsalesman = mysql_num_rows($all_frsalesman);
//}
//$totalPages_frsalesman = ceil($totalRows_frsalesman/$maxRows_frsalesman)-1;

//Advertising
$maxRows_fradvert = 10;
$pageNum_fradvert = 0;
if (isset($_GET['pageNum_fradvert'])) {
  $pageNum_fradvert = $_GET['pageNum_fradvert'];
}
$startRow_fradvert = $pageNum_fradvert * $maxRows_fradvert;

$colname_fradvert = "Active";
if (isset($_GET['Active'])) {
  $colname_fradvert = $_GET['Active'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fradvert = sprintf("SELECT advertising.AdNo, advertising.Advertiser, advertising.Active FROM advertising WHERE advertising.Active = %s ORDER BY advertising.Advertiser", GetSQLValueString($colname_fradvert, "text"));
$query_limit_fradvert = sprintf("%s LIMIT %d, %d", $query_fradvert, $startRow_fradvert, $maxRows_fradvert);
$fradvert = mysql_query($query_limit_fradvert, $Leadbook) or die(mysql_error());
$row_fradvert = mysql_fetch_assoc($fradvert);

//if (isset($_GET['totalRows_fradvert'])) {
//  $totalRows_fradvert = $_GET['totalRows_fradvert'];
//} else {
//  $all_fradvert = mysql_query($query_fradvert);
//  $totalRows_fradvert = mysql_num_rows($all_fradvert);
//}
//$totalPages_fradvert = ceil($totalRows_fradvert/$maxRows_fradvert)-1;
//$totalRows_fradvert = ceil($totalRows_fradvert/$maxRows_frsadvert)-1;

//LeadsByMonth
$var1_fmLeadMonthGraph = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmLeadMonthGraph = $_GET['Datefrom'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmLeadMonthGraph = sprintf("SELECT 'a' as Num, Count(Leads.City) as Amount, 'Jan' as SeqMonth FROM Leads WHERE EXTRACT(Month FROM Leads.Date) = 1 AND EXTRACT(Year FROM Leads.Date) = %s UNION SELECT 'b' as Num, Count(Leads.City) as Amount, 'Feb' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 2 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'c' as Num, Count(Leads.City) as Amount, 'Mar' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 3 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'd' as Num, Count(Leads.City) as Amount, 'Apr' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 4 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'e' as Num, Count(Leads.City) as Amount, 'May' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 5 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'f' as Num, Count(Leads.City) as Amount, 'Jun' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 6 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'g' as Num, Count(Leads.City) as Amount, 'Jul' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 7 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'h' as Num, Count(Leads.City) as Amount, 'Aug' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 8 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'i' as Num, Count(Leads.City) as Amount, 'Sep' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 9 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'j' as Num, Count(Leads.City) as Amount, 'Oct' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 10 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'k' as Num, Count(Leads.City) as Amount, 'Nov' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 11 AND EXTRACT(Year from Leads.Date) = %s UNION SELECT 'l' as Num, Count(Leads.City) as Amount, 'Dec' as SeqMonth FROM Leads WHERE EXTRACT(Month From Leads.Date) = 12 AND EXTRACT(Year from Leads.Date) = %s", GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"),GetSQLValueString($var1_fmLeadMonthGraph, "date"));
$fmLeadMonthGraph = mysql_query($query_fmLeadMonthGraph, $Leadbook) or die(mysql_error());
$row_fmLeadMonthGraph = mysql_fetch_assoc($fmLeadMonthGraph);
$totalRows_fmLeadMonthGraph = mysql_num_rows($fmLeadMonthGraph);

//Leads Year
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

//AvgLeadYear
$var1_fmAvgLeadGraph = "$Datefrom";
if (isset($_GET['Datefrom'])) {
  $var1_fmAvgLeadGraph = $_GET['Datefrom'];
}
$var2_fmAvgLeadGraph = "$Dateto";
if (isset($_GET['Dateto'])) {
  $var2_fmAvgLeadGraph = $_GET['Dateto'];
}
$var3_fmAvgLeadGraph = "$Datefrom1";
if (isset($_GET['var3'])) {
  $var3_fmAvgLeadGraph = $_GET['var3'];
}
$var4_fmAvgLeadGraph = "$Dateto1";
if (isset($_GET['var4'])) {
  $var4_fmAvgLeadGraph = $_GET['var4'];
}
$var5_fmAvgLeadGraph = "$Datefrom2";
if (isset($_GET['var5'])) {
  $var5_fmAvgLeadGraph = $_GET['var5'];
}
$var6_fmAvgLeadGraph = "$Dateto2";
if (isset($_GET['var6'])) {
  $var6_fmAvgLeadGraph = $_GET['var6'];
}
$var7_fmAvgLeadGraph = "$Datefrom3";
if (isset($_GET['var7'])) {
  $var7_fmAvgLeadGraph = $_GET['var7'];
}
$var8_fmAvgLeadGraph = "$Dateto3";
if (isset($_GET['var8'])) {
  $var8_fmAvgLeadGraph = $_GET['var8'];
}
$var9_fmAvgLeadGraph = "$Datefrom4";
if (isset($_GET['var9'])) {
  $var9_fmAvgLeadGraph = $_GET['var9'];
}
$var10_fmAvgLeadGraph = "$Dateto4";
if (isset($_GET['var10'])) {
  $var10_fmAvgLeadGraph = $_GET['var10'];
}
$var11_fmAvgLeadGraph = "$Datefrom5";
if (isset($_GET['var11'])) {
  $var11_fmAvgLeadGraph = $_GET['var11'];
}
$var12_fmAvgLeadGraph = "$Dateto5";
if (isset($_GET['var12'])) {
  $var12_fmAvgLeadGraph = $_GET['var12'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_fmAvgLeadGraph = sprintf("SELECT YEAR(CURRENT_TIMESTAMP), AVG(Leads.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) as Windows FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) -1, AVG(Leads.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 1 as Windows FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 2, AVG(Leads.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 2 as Windows FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 3, AVG(Leads.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 3 as Windows FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 4, AVG(Leads.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 4 as Windows FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s UNION SELECT YEAR(CURRENT_TIMESTAMP) - 5, AVG(Leads.Amount) as Amount,YEAR(CURRENT_TIMESTAMP) - 5 as Windows FROM Leads WHERE Leads.`Date` >= %s AND Leads.`Date` <= %s", GetSQLValueString($var1_fmAvgLeadGraph, "date"),GetSQLValueString($var2_fmAvgLeadGraph, "date"),GetSQLValueString($var3_fmAvgLeadGraph, "date"),GetSQLValueString($var4_fmAvgLeadGraph, "date"),GetSQLValueString($var5_fmAvgLeadGraph, "date"),GetSQLValueString($var6_fmAvgLeadGraph, "date"),GetSQLValueString($var7_fmAvgLeadGraph, "date"),GetSQLValueString($var8_fmAvgLeadGraph, "date"),GetSQLValueString($var9_fmAvgLeadGraph, "date"),GetSQLValueString($var10_fmAvgLeadGraph, "date"),GetSQLValueString($var11_fmAvgLeadGraph, "date"),GetSQLValueString($var12_fmAvgLeadGraph, "date"));
$fmAvgLeadGraph = mysql_query($query_fmAvgLeadGraph, $Leadbook) or die(mysql_error());
$row_fmAvgLeadGraph = mysql_fetch_assoc($fmAvgLeadGraph);
$totalRows_fmAvgLeadGraph = mysql_num_rows($fmAvgLeadGraph);

//Leads
$maxRows_frLeads = 40;
$pageNum_frLeads = 0;
if (isset($_GET['pageNum_frLeads'])) {
  $pageNum_frLeads = $_GET['pageNum_frLeads'];
}
$startRow_frLeads = $pageNum_frLeads * $maxRows_frLeads;

$SearchAd1_frLeads = "0";
if (isset($_GET['AdNo'])) {
  $SearchAd1_frLeads = $_GET['AdNo'];
}
$SearchAd2_frLeads = "10000";
if (isset($_GET['AdNo'])) {
  $SearchAd2_frLeads = $_GET['AdNo'];
}
$SearchSale1_frLeads = "0";
if (isset($_GET['SaleNo'])) {
  $SearchSale1_frLeads = $_GET['SaleNo'];
}
$SearchSale2_frLeads = "10000";
if (isset($_GET['SaleNo'])) {
  $SearchSale2_frLeads = $_GET['SaleNo'];
}
$Search_frLeads = "%";
if (isset($_GET['Search'])) {
  $Search_frLeads = $_GET['Search'];
}
$ActiveLead_frLeads = "-1";
if (isset($_GET['ActiveLead'])) {
  $ActiveLead_frLeads = $_GET['ActiveLead'];
}
$Callback_frLeads = "%";
if (isset($_GET['Callback'])) {
  $Callback_frLeads = $_GET['Callback'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_frLeads = sprintf("SELECT * FROM Leads WHERE (Leads.LeadNo = %s OR Leads.`Last Name` LIKE %s OR Leads.Address LIKE %s OR Leads.City LIKE %s OR Leads.Phone LIKE %s OR Leads.Amount LIKE %s) AND (Leads.SalesNo BETWEEN %s AND %s) AND (Leads.AdNo BETWEEN %s AND %s) AND (Leads.Active >= %s) AND (Leads.`Call Back` LIKE %s) ORDER BY `Date` DESC", GetSQLValueString($Search_frLeads, "text"),GetSQLValueString($Search_frLeads, "text"),GetSQLValueString($Search_frLeads, "text"),GetSQLValueString($Search_frLeads, "text"),GetSQLValueString($Search_frLeads, "text"),GetSQLValueString($Search_frLeads, "text"),GetSQLValueString($SearchSale1_frLeads, "int"),GetSQLValueString($SearchSale2_frLeads, "int"),GetSQLValueString($SearchAd1_frLeads, "int"),GetSQLValueString($SearchAd2_frLeads, "int"),GetSQLValueString($ActiveLead_frLeads, "int"),GetSQLValueString($Callback_frLeads, "text"));
$query_limit_frLeads = sprintf("%s LIMIT %d, %d", $query_frLeads, $startRow_frLeads, $maxRows_frLeads);
$frLeads = mysql_query($query_limit_frLeads, $Leadbook) or die(mysql_error());
$row_frLeads = mysql_fetch_assoc($frLeads);

if (isset($_GET['totalRows_frLeads'])) {
  $totalRows_frLeads = $_GET['totalRows_frLeads'];
} else {
  $all_frLeads = mysql_query($query_frLeads);
  $totalRows_frLeads = mysql_num_rows($all_frLeads);
}
$totalPages_frLeads = ceil($totalRows_frLeads/$maxRows_frLeads)-1;

$queryString_frLeads = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_frLeads") == false && 
        stristr($param, "totalRows_frLeads") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_frLeads = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_frLeads = sprintf("&totalRows_frLeads=%d%s", $totalRows_frLeads, $queryString_frLeads);

$currentPage = $_SERVER["PHP_SELF"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Lead Listing</title>
<meta charset="utf-8" />
<link rel="icon" href="favicon.ico">

<script src="assets/functions.js" type="text/javascript"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
      <li><a href="LeadTableipad.php">Lead Listing</a> </li>
      <li><a href="CustTableipad.php">Customer Listing</a></li>
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
<li><a href="Snapshotipad.php">Snapshot</a></li>
<li><a href="BlogTable.php">Blog</a></li>
</ul>
</nav>
<h1>Leads Online</h1>
</hgroup>
<!-- end #header --></header>

<section id="sidebar1">
<div>
    
<?php 
if ($_GET['ActiveLead'] == "1")
echo "Viewing Active Leads!<br />";
else 
echo "Viewing all Leads!<br />";  
?>
<form id="form1" name="form1" method="get" action="LeadTableipad.php">
<input name="Search" type="search" id="Search" autofocus value="<?php echo $_GET['Search']; ?>" size="18" />
<button class="magglass"type="submit"><img src="images/magglass.png" alt="Search" /></button>
<br />
<p>Enable  <input name="EnableNewCustomer"type="checkbox" value="checked" <?php echo $t1Newenable ?> onclick="submit()"/>
New
<input name="EnableSearchCustomer"type="checkbox" value="checked" <?php echo $t1Searchenable ?> onclick="submit()"/>
Search</p>
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
</select> <input type="button" name="b1" id="b1" value="New Lead" onclick="location.href='LeadInsert.php'">
</form>
<!-- end #search --></div>

<form id="form2" name="form2" method="post">
<input type="submit" name="button" id="button" value="Print" onclick="printpage()" />
</form>
<!-- end #print --> 

<div><button class="tableheader"type="submit">Records <?php echo ($startRow_frLeads + 1) ?> to <?php echo min($startRow_frLeads + $maxRows_frLeads, $totalRows_frLeads) ?> of <?php echo $totalRows_frLeads ?></button></div> 

<div>
<p>Leads Today...<strong><?php echo $totalRows_fmLeadtoday ?></strong></p>
<p>Leads to Process...<strong><?php echo $totalRows_fmLeadProcess ?></strong></p>
<p>Appointments Today...<strong><?php echo $totalRows_fmAptToday ?></strong></p>
<p>Appts. Tommorrow...<strong><?php echo $totalRows_fmAptTommorrow ?></strong></p>
<p>Avg Lead...<strong>
<?php do { ?>
<?php echo number_format($row_fmAvgLead['AVG(Leads.Amount)'],0); ?>
<?php } while ($row_fmAvgLead = mysql_fetch_assoc($fmAvgLead)); ?></strong></p>
</div>   



<div><button class="tableheader"type="submit">Search Leads</button></div>
<form id="form5" name="form5" method="get" action="LeadTableipad.php">
<p><input name="ActiveLead" type="checkbox" value="1" <?php echo $t1v ?> onclick="submit()" /> Active Leads<br />
<input name="NewCustomer"type="checkbox" value="1" <?php echo $t1new ?> onclick="submit()"/> Enable New Customer<br />
<input name="SearchCustomer" type="checkbox" value="1" <?php echo $t1search ?> onclick="submit()"/> Enable Locate Customer</p>
</form>
<!-- end #checkboxes -->
     
<div><button class="tableheader"type="submit">Active Salesman</button></div>
<form id="form7" name="form7" method="get">
<select name="SelectSaleman" id="SelectSaleman" tabindex="1" onchange="reloadLeadSale(this.form)">
<option value="value" <?php if (!(strcmp("value", $row_frsalesman['Salesman']))) {echo "selected=\"selected\"";} ?>>Select Salesman</option>
<?php do { ?>
<option value="<?php echo $row_frsalesman['SalesNo']?>"<?php if (!(strcmp($row_frsalesman['SalesNo'], $row_frsalesman['Salesman']))) {echo "selected=\"selected\"";} ?>><?php echo $row_frsalesman['Salesman']?></option>
<?php } while ($row_frsalesman = mysql_fetch_assoc($frsalesman));
$rows = mysql_num_rows($frsalesman);
if($rows > 0) {
mysql_data_seek($frsalesman, 0);
$row_frsalesman = mysql_fetch_assoc($frsalesman); } ?>
</select></form>

<div><button class="tableheader"type="submit">Active Advertisers</button></div>
<form id="form3" name="form3" method="get">
<select name="SelectAd" id="SelectAd" tabindex="1" onchange="reloadAds(this.form)">
<option value="" <?php if (!(strcmp("", $row_fradvert['Advertiser']))) {echo "selected=\"selected\"";} ?>>Select Ads</option>
<?php do { ?>
<option value="<?php echo $row_fradvert['AdNo']?>"<?php if (!(strcmp($row_fradvert['AdNo'], $row_fradvert['Advertiser']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fradvert['Advertiser']?></option>
<?php } while ($row_fradvert = mysql_fetch_assoc($fradvert));
$rows = mysql_num_rows($fradvert);
if($rows > 0) {
mysql_data_seek($fradvert, 0);
$row_fradvert = mysql_fetch_assoc($fradvert); } ?>
</select></form>
<!-- end #advertiser -->

<div><button class="tableheader"type="submit">Active Call Back</button></div>
<form id="form4" name="form4" method="get">
<select name="Callback" id="Callback" onchange="submit()">
<option value="" >Select Call Back</option>
<option value="Sold%">Sold</option>
<option value="Cancel%">Canceled</option>
<option value="Dead%">Dead</option>
<option value="Bought%">Bought</option>
<option value="Future%">Future Work</option>
<option value="Looks Good%">Looks Good</option>
<option value="Follow%">Follow Up</option>
<option value="Call%">Called</option>
</select></form>
<!-- end #call back -->

<!-- end #sidebar1 --></section>
<div id="titlerepeat">Admin: <?php echo $title ?> Listings</div>

<div id="addnew">
<?php if ($totalRows_frLeads == 0) { // Show if recordset empty ?>
There are no tasks defined. <a href="LeadInsert.php">Add one...</a>
<?php } // Show if recordset empty ?>
</div>

<table  id="nav">
<tr>
<td>
<?php if ($pageNum_frLeads > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_frLeads=%d%s", $currentPage, 0, $queryString_frLeads); ?>">First</a>
<?php } // Show if not first page ?></td>
<td><?php if ($pageNum_frLeads > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_frLeads=%d%s", $currentPage, max(0, $pageNum_frLeads - 1), $queryString_frLeads); ?>">Previous</a>
<?php } // Show if not first page ?></td>
<td><?php if ($pageNum_frLeads < $totalPages_frLeads) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_frLeads=%d%s", $currentPage, min($totalPages_frLeads, $pageNum_frLeads + 1), $queryString_frLeads); ?>">Next</a>
<?php } // Show if not last page ?></td>
<td><?php if ($pageNum_frLeads < $totalPages_frLeads) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_frLeads=%d%s", $currentPage, $totalPages_frLeads, $queryString_frLeads); ?>">Last</a>
<?php } // Show if not last page ?></td>
</tr>
</table>

<table width="80%" id="delform">
<tr>
<th><span>Num</span></th>
<th><span>Date</span></th>
<th><span>Last Name</span></th>
<th><span>Address</span></th>
<th><span>City</span></th>
<th><span>Phone</span></th>
<th><span>Amount</span></th>
<th><span>Call</span></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr> 
<?php do { ?> 
<tr class="formRow"> 
<?php echo $i++%2==0 ? "<tr>" : "<tr class='odd'>"; ?>
<td>
<?php if ($_GET['NewCustomer'] == "1" || $_GET['EnableNewCustomer'] == "checked") { ?>
<a href="CustInsert.php?LeadNo=<?php echo $row_frLeads['LeadNo']; ?>
&amp;Address=<?php echo $row_frLeads['Address']; ?>
&amp;City=<?php echo $row_frLeads['City']; ?>
&amp;State=<?php echo $row_frLeads['State']; ?>
&amp;Zip=<?php echo $row_frLeads['Zip Code']; ?>
&amp;Phone=<?php echo $row_frLeads['Phone']; ?>
&amp;SalesNo=<?php echo $row_frLeads['SalesNo']; ?>
&amp;Job=<?php echo $row_frLeads['JobNo']; ?>
&amp;Amount=<?php echo $row_frLeads['Amount']; ?>
&amp;Comments=<?php echo $row_frLeads['Coments']; ?>
&amp;First=<?php echo $row_frLeads['First']; ?>
&amp;Spouse=<?php echo $row_frLeads['Spouse']; ?>
&amp;Email=<?php echo $row_frLeads['Email']; ?>">
<?php } ?>

<?php if ($_GET['SearchCustomer'] == "1" || $_GET['EnableSearchCustomer'] == "checked") { ?>
<a href="CustEdit.php?LeadNo=<?php echo $row_frLeads['LeadNo']; ?>">
<?php } ?>

<?php echo $row_frLeads['LeadNo']; ?></a></td>

<td nowrap="nowrap"><?php echo date("M y", strtotime($row_frLeads['Date'])); ?></td>
<td><?php echo $row_frLeads['Last Name']; ?></td>
<td><?php echo $row_frLeads['Address']; ?></td>
<td><?php echo $row_frLeads['City']; ?></td>
<td nowrap="nowrap"><?php echo $row_frLeads['Phone']; ?></td>
<td class="tdAmount" nowrap="nowrap"><input type="text" size="9" value="<?php echo $row_frLeads['Amount']; ?>"/></td>
<td width="8"><?php echo $row_frLeads['Call Back']; ?></td>
<td width="4"><span><a href="LeadEdit.php?LeadNo=<?php echo $row_frLeads['LeadNo']; ?>">edit</a></span></td>
<td width="6"><span><a href="DeleteAddress.php?LeadNo=<?php echo $row_frLeads['LeadNo']; ?>">delete</a></span></td>
</tr>
<?php } while ($row_frLeads = mysql_fetch_assoc($frLeads)); ?>
</table>

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
mysql_free_result($fmLeadProcess);
mysql_free_result($fmLeadtoday);
mysql_free_result($fmAptToday);
mysql_free_result($fmAptTommorrow);
mysql_free_result($fmAvgLead);
mysql_free_result($fmLeadMonthGraph);
mysql_free_result($fmLeadYear);
mysql_free_result($fmAvgLeadGraph);
mysql_free_result($frLeads);
?>
