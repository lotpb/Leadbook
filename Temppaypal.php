<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<form id="pkg1" name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

                    <input type="hidden" name="cmd" value="_xclick"/>
                    <input type="hidden" name="business" value="seller_1360303883_biz@gmail.com"/>
                    <input type="hidden" name="currency_code" value="USD"/>
                    <input type="hidden" name="item_name" value="Digital Download"/>
                    <input type="hidden" name="amount" value="$<?php  echo $price1 ?>"/>
                    <input type="hidden" name="return" value="https://www.sandbox.paypal.com/cgi-bin/success.php"/>
                    <input type="hidden" name="notify_url" value="notify.php"/>
                    <input type="image" src="http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif"  name="submit" alt="Make payments with PayPal - it's fast, free and secure!"/>

                </form>
<?php             
$auth_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . $app_id . "&redirect_uri=" . urlencode($canvas_page);

     $signed_request = $_REQUEST["signed_request"];

     list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

     $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

     if (empty($data["user_id"])) {
            echo("<script> top.location.href='" . $auth_url . "'</script>");
     } else {
            echo ("Welcome User: " . $data["user_id"]);

             $profilepic = "https://graph.facebook.com/". $data["user_id"] ."/picture?type=large";

            echo ("<br><br><img src='$profilepic'>");
     }    
	 ?>            
<body>
</body>
</html>