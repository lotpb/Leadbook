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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="Login.php";
  $loginUsername = $_POST['Email'];
  $LoginRS__query = sprintf("SELECT Email FROM Addressadmin WHERE Email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_Leadbook, $Leadbook);
  $LoginRS=mysql_query($LoginRS__query, $Leadbook) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forminsert")) {
  $insertSQL = sprintf("INSERT INTO Addressadmin (`First Name`, `Last Name`, Email, Adminpassword) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Adminpassword'], "text"));

  mysql_select_db($database_Leadbook, $Leadbook);
  $Result1 = mysql_query($insertSQL, $Leadbook) or die(mysql_error());
}

mysql_select_db($database_Leadbook, $Leadbook);
$query_admin = "SELECT * FROM Addressadmin";
$admin = mysql_query($query_admin, $Leadbook) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Register Login</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
-->
</style></head>

<body class="oneColFixCtrHdr">

<div id="carbonForm" align="center">
<header id="header">
<hgroup>
<h1>New Login Info</h1>
</hgroup>
<!-- end #header --></header>

<header>
<p>New Register to Login</p>
</header>
<aside id="mainContent">  
<div class="fieldContainer"> 
<form action="<?php echo $editFormAction; ?>" method="post" name="forminsert" id="forminsert">
<div class="formRow">
<div class="label"><label for="name">First Name:</label></div>
<div class="field"><input type="text" name="First_Name" value="" size="30" /></div></div>

<div class="formRow">
<div class="label"><label for="name">Last Name:</label></div>
<div class="field"><input type="text" name="Last_Name" value="" size="30" /></div></div>

<div class="formRow">
<div class="label"><label for="name">Email:</label></div>
<div class="field"><input type="text" name="Email" value="" size="30" /></div></div>

<div class="formRow">
<div class="label"><label for="name">Password:</label></div>
<div class="field"><input type="password" name="Adminpassword" value="" size="30" /></div></div>

<div class="formRow"> 
<div class="label"><label for="name">&nbsp;</label></div>
<div class="field"> <input type="submit" value="Register" /> <input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back()" />
<input type="hidden" name="MM_insert" value="forminsert" /></div></div>
</form>
</div>

  <!-- end #mainContent --></aside>
  <footer id="footer">
    <p>Register Login</p>
  <!-- end #footer --></footer>
<!-- end #container --></div>
</body>
</html>
<?php
mysql_free_result($admin);
?>
