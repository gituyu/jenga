<?php
require "../vendor/autoload.php";
use Finserve\Jenga\Jenga;
header("Content-Type: text/html");

?>
<!doctype html>
<html lang="en"> <title>Jenga Example</title>
 <body>
 <h1>EazzyPay Jenga Example</h1>

<!-- <iframe name="eazzycheckout-payment-form" id="frame" src="/"></iframe>-->

 <?php


 $jenga=new Jenga('5502947979','U9pG1tHCrzDR9PLXYrMZ3fwxtjAp2x0v2','UWZQZFI4Q2xUbThiaWhUeUkweFdUNVNhV0pHUHlUTlQ6TG1XR0JGNllnUTJyaVVacg==',true);
 echo 'FOREX FOR USD KES: <b>';
 echo \Finserve\Jenga\Forex::getForex('USD','KES');
 echo '</b>';
 echo '<br>';
 echo 'Notification Secret: ';
// echo $jenga->generateAccessToken(true);
 echo $jenga->generatePaymentToken($isNotificationSecret=false,$is_sandbox=true);
 echo '<br>';
 echo 'Checkout Page for 12 bob: ';
 /**
  * Generate Checkout Redirection for use in Jenga PGW Checkout and Callback Auth.
  * @param $amount
  * @param $orderReference
  * @param $callbackurl
  * @param string $custName
  * @param $title
  * @param string $website
  * @param string $extraData
  * @param string $currency
  * @param string $outletCode
  * @param bool $is_sandbox
  * @return false|mixed [type] [Payment Token or Notification Secret string]
  */
echo $jenga->generateCheckout(12,'AB1','https://webhook.site/0a75a3f0-b545-4ce3-8c1f-926e7bded3df','John Doe','Buy Now on Offer');
?>

 </body>
 </html>