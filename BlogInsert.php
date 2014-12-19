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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO Blog (MsgNo, MsgDate, Subject, Rating, PostBy) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['MsgNo'], "int"),
                       GetSQLValueString($_POST['MsgDate'], "date"),
                       GetSQLValueString($_POST['Subject'], "text"),
                       GetSQLValueString($_POST['Rating'], "int"),
                       GetSQLValueString($_POST['PostBy'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());

  $insertGoTo = "BlogTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Leadbook, $Leadbook);
$query_Recordset1 = "SELECT Blog.MsgNo, Blog.Subject, Blog.Rating, Blog.PostBy, Blog.MsgDate FROM Blog";
$Recordset1 = mysql_query($query_Recordset1, $Leadbook) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>New Blog</title>
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

<p>&nbsp;</p>
<div id="carbonForm">
<header id="header">
<h1>Blog</h1>
<!-- end #header --></header>

<aside id="mainContent" class="tddataleft">
  <form method="post" name="forminsert" id="forminsert" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td nowrap align="right">MsgDate:</td>
        <td><input type="date" name="MsgDate" value="<?php date_default_timezone_set('America/New_York'); echo date('Y-m-d H:i:s'); ?>" size="25"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Message:</td>
        <td><textarea type="text" name="Subject" value="" cols="70" rows="15"></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Rating:</td>
        <td><input type="text" name="Rating" value="5" size="10"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">PostBy:</td>
        <td><input type="text" name="PostBy" value="<?php echo $_COOKIE["user"]; ?>" size="40"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" value="Submit post">
            <input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="forminsert">
  </form>
  <p>&nbsp;</p>
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
mysql_free_result($Recordset1);
?>
