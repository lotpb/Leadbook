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
<!DOCTYPE html>
<html lang="en">
<head>
<title>Leads Online</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="favicon.ico">

<link href="Stylesheets/Col2text.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/Addresstext.css" rel="stylesheet" type="text/css">
<link href="Stylesheets/Unitedbar.css" rel="stylesheet" type="text/css" media="all">
<style type="text/css"> 
<!-- 
#container {width:1000px; background: #FFFFFF; margin: -8px auto auto auto;
}
.fltrt {float: right; margin-left: 8px; }
.fltlft {float: left; margin-right: 8px; }
.clearfloat {clear:both; height:0; font-size: 1px; line-height: 0px; }
body {background:white;}
#stylemain { font-size:60px; margin-bottom:10px; font-style: normal;}
#stylebelow { font-size:30px; color: #999; margin-top:10px; margin-bottom:30px;font-style: normal;}
section {padding-top:20px;}
#heading{ font-size:14px;}
--> 
</style>

<!--[if IE 5]>
<link href="assets/UnitedtextIE5.css" rel="stylesheet" type="text/css" />
</style>
<![endif]--><!--[if IE]>
<link href="assets/UnitedtextIE.css" rel="stylesheet" type="text/css" />
</style>
<![endif]-->

</head>
<body class="twoColLiqLtHdr">

<div id="container"> 

<header id="header">
<nav id="stylefour"> 
<ul>
<li><a href="BrowserInfo.php"><img src="images/unitedlogo10.gif" alt="" ></a></li>
<li><a href="LeadTable.php">Leads</a></li>
<li><a href="CustTable.php">Customers</a></li>
<li><a href="ContactsTable.php">Contacts</a></li> 
<li><a href="EmployeeTable.php">Employee</a></li>
<li><a href="VendorTable.php">Vendors</a></li>
<li><a href="TaskTable.php">Tasks</a></li>
<li><a href="RegLoginTable.php">Registered Users</a></li>
<li><a href="Snapshot.php">Snapshot</a></li>
</ul>
</nav>  
  <!-- end #header --></header>
  
<aside id="mainContent">
<div id="div-social"> 
<!--<p id="heading">-->
<?php
if (isset($_COOKIE["user"]))
echo "Welcome " . $_COOKIE["user"] . "<br />" ;
else
echo "Welcome guest!<br />"; ?>


<ul id="home-social">
<li><a href="https://www.facebook.com/pbalsamo" target="_blank" class="facebook-large-icon"><img src="Fireworks/images.jpg" width="27" height="27"></a><span class="social-arrow-large"></span><span class="social-number-large"></span></li> 
<li><a href="https://twitter.com/intent/user?screen_name=unit7ed" class="twitter-large-icon"><img src="Fireworks/twitter-bird-white-on-blue.png" width="27" height="27"></a><span class="social-arrow-large"></span><span class="social-number-large"></span></li>
<li><a href="https://plus.google.com/111001579352959628787" target="_blank" class="google-large-icon"><img src="Fireworks/Google.jpg" width="27" height="27"></a><span class="social-arrow-large"></span><span class="social-number-large"></span></li> 
<li><a href="BlogTable.php"><img src="Fireworks/Blog.jpg" width="30" height="30"></a></span></li> 
</ul> 
</div>
<!--</p>  -->



<section align="center"><img src="images/overview_itunesinthecloud_hero.fw.png" /></section>

<h1 id="stylemain">Leads Online</h1>
<h6 id="stylebelow">Making data entry simple and easy!</h6>

<div class="divpromo">
<ul id="homepromo">
<li><a href="LeadInsert.php"><img src="Fireworks/newleadbook.jpg" width="237" height="190" ></a></li>
<li><a href="CustInsert.php"><img src="Fireworks/newcustbook.jpg" width="237" height="190" ></a></li>
<li><a href="Snapshot.php"><img src="Fireworks/snapshotbook.jpg" width="237" height="190" ></a></li>
<li><a href="Logout.php"><img src="Fireworks/logoutbook.jpg" width="237" height="190" ></a></li>
</ul>
</div>

	<!-- end #mainContent --></aside>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat">
<footer id="footer">
<p>&copy;copyright 2010 Leads Online Software.dev</p>
  <!-- end #footer --></footer>
<!-- end #container --></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">_uacct = "UA-3879990-1";urchinTracker();</script>
</body>
</html>