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
  $updateSQL = sprintf("UPDATE Blog SET MsgDate=%s, Subject=%s, Rating=%s, PostBy=%s WHERE MsgNo=%s",
                       GetSQLValueString($_POST['MsgDate'], "date"),
                       GetSQLValueString($_POST['Subject'], "text"),
                       GetSQLValueString($_POST['Rating'], "int"),
                       GetSQLValueString($_POST['PostBy'], "text"),
                       GetSQLValueString($_POST['MsgNo'], "int"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($updateSQL, $Leadbook) or die(mysql_error());

  $updateGoTo = "BlogTable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


$var_Recordset1 = "-1";
if (isset($_GET['MsgNo'])) {
  $var_Recordset1 = $_GET['MsgNo'];
}
mysql_select_db($database_Leadbook, $Leadbook);
$query_Recordset1 = sprintf("SELECT Blog.MsgNo, Blog.Subject, Blog.Rating, Blog.PostBy, Blog.MsgDate FROM Blog WHERE Blog.MsgNo = %s", GetSQLValueString($var_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Leadbook) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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

<p>&nbsp;</p>
<div id="carbonForm">
<header id="header">
<h1>Blog</h1>
<!-- end #header --></header>

<aside id="mainContent" class="tddataleft">
<fieldset id="fieldcolor">
<form method="post" name="formEdit" id="formEdit" action="<?php echo $editFormAction; ?>">

  <table align="center">
      <tr valign="baseline">
      <td nowrap align="right">By:</td>
      <td><input type="text" name="PostBy" value="<?php echo htmlentities($row_Recordset1['PostBy'], ENT_COMPAT, 'utf-8'); ?>" size="25"><br>
          <input type="hidden" name="MsgDate" value="<?php echo htmlentities($row_Recordset1['MsgDate'], ENT_COMPAT, 'UTF-8'); ?>" size="25"></td>
    </tr>
        <tr valign="baseline">
      <td nowrap align="right">Rating:</td>
      <td><input type="text" name="Rating" value="<?php echo htmlentities($row_Recordset1['Rating'], ENT_COMPAT, 'utf-8'); ?>" size="10"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>Subject:</td>
      <td><textarea name="Subject" id="Subject" autofocus placeholder="subject" cols="70" rows="15"><?php echo htmlentities($row_Recordset1['Subject'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update post">
      <input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="formEdit">
  <input type="hidden" name="MsgNo" value="<?php echo $row_Recordset1['MsgNo']; ?>">
</form>
</fieldset>
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
