<?php require_once('Connections/Leadbook.php'); ?>
<?php
if (isset($_POST['name'])) {
$loginname=$_POST['name'];
setcookie("user", $loginname, time()+60*60*24*45); }

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "Login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Leadbook, $Leadbook);
  setcookie("useremail", $loginUsername, time()+60*60*24*45); //added line
  
  $LoginRS__query=sprintf("SELECT Email, Adminpassword FROM Addressadmin WHERE Email=%s AND Adminpassword=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Leadbook) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>
<link href="Stylesheets/Charcoal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
-->
</style>
</head>
<body class="oneColFixCtrHdr">

<div id="carbonForm" align="center">
<h1>Signup</h1>

<form id="form1" name="form1" method="post" action="<?php echo $loginFormAction; ?>">

<div class="fieldContainer">

<div class="formRow">
<div class="label"><label for="name">Full Name:</label></div>
<div class="field">
<input type="text" name="name" id="name" value="<?php echo $_COOKIE["user"]; ?>"/></div></div>

<div class="formRow">
<div class="label"><label for="email">Email:</label></div>
<div class="field">
<input type="email" name="email" id="email" value="<?php echo $_COOKIE["useremail"]; ?>" /></div></div>

<div class="formRow">
<div class="label"><label for="pass">Password:</label></div>
<div class="field">
<input type="password" name="password" id="password" autofocus value=""/></div></div>

</div> <!-- Closing fieldContainer -->

<div class="signupButton">  
<input type="submit" name="submit" id="submit" value="Log In" />
</div>

</form>
        
</div>

<h2 id="footer"></h2>
</body>
</html>