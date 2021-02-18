<?php

namespace Finserve\Jenga;
include_once("../vendor/autoload.php");


/**
 *Jenga class
 *
 * @author gituyu
 */
class Jenga
{
    protected $username, $password, $api_key, $merchantCode, $merchantName, $plainText, $token, $basic, $is_sandbox, $private_key;

    /**
     *
     * @param $username
     * @param $password
     * @param $api_key
     * @param bool $is_sandbox
     * @param string $private_key
     */

    public function __construct($username = null, $password = null, $api_key = null, $is_sandbox = false, $private_key = 'privatekey.pem')
    {

        if (function_exists('config')) {
            $environment = config('jenga.JENGA_ENVIRONMENT');
            if (!isset($environment)||$is_sandbox==false) {
                $this->is_sandbox = $environment;
            }
            if (!isset($username)) {
                $username = config('jenga.JENGA_USERNAME');
            }
            if (!isset($password)) {
                $password = config('jenga.JENGA_PASSWORD');
            }
            if (!isset($api_key)) {
                $api_key = config('jenga.JENGA_API_KEY');
            }
            if (!isset($private_key)) {
                $private_key = config('jenga.JENGA_PRIVATE_KEY');
            }
            if (!isset($website)) {
                $website = config('jenga.JENGA_MERCHANT_WEBSITE');
            }
            if (!isset($extraData)) {
                $extraData = config('jenga.JENGA_EXTRA_DATA');
            }
            if (!isset($btnClass)) {
                $btnClass = config('jenga.JENGA_CHECKOUT_BUTTON_CLASS');
            }
            if (!isset($callbackurl)) {
                $callbackurl = config('jenga.JENGA_CALLBACK_DEFAULT');
            }
            if (!isset($this->endpoint)) {
                $this->endpoint = config('jenga.JENGA_BASE_ENDPOINT');
            }
            if (!isset($this->merchantName)) {
                $this->merchantName = config('jenga.JENGA_MERCHANT_NAME');
            }
            if (!isset($this->merchantCode)) {
                $this->merchantCode = config('jenga.JENGA_MERCHANT_CODE');
            }
//        $this->phone = config('jenga.JENGA_PHONE');
//        $this->endpoint = config('JENGA_BASE_ENDPOINT');
//        $this->website = config('JENGA_MERCHANT_WEBSITE');
//        $this->logo = config('JENGA_CHECKOUT_LOGO_URL');
//        $this->country_code = config('JENGA_COUNTRY_CODE');
        } else {

            $this->is_sandbox = $is_sandbox;
            $this->username = $username;
            $this->password = $password;
            $this->api_key = $api_key;
            $this->merchantCode = $username;
            $this->basic = $api_key;
            $this->private_key = $private_key;
        }
        $this->token = $this->generateAccessToken() ?? '';
        $this->phone = '00';
        $this->endpoint = 'https://api.equitybankgroup.com/identity-sandbox/';
        $this->account_id = $username;
        $this->country_code = 'KE';
        $this->plaintext = $this->merchantCode . $this->country_code . date('y-m-d'); //5502947979KE2020-02-12
        $this->token = $this->generateAccessToken();
        $this->payment_secret = $this->generatePaymentToken(false, $this->is_sandbox);
        if ($this->payment_secret == '') {
            die('Authentication Error: Token not generated');
        }
        if ($this->payment_secret == '') {
            die('Authentication Error: Checkout Token not generated');
        }
    }

    /**
     * Generate authentication access token for use with all the requests to Jenga API.
     * @param bool $is_sandbox
     * @return false|mixed [type] [Access Token]
     */
    public function generateAccessToken($is_sandbox = '')
    {
        if ($is_sandbox == '') {
            $is_sandbox = $this->is_sandbox;
        }
        if ($this->is_sandbox) {
            $url = "https://sandbox.jengahq.io/identity-test/v2/token";
        } else {
            $url = "https://uat.jengahq.io/identity/v2/token";
        }
        $plainText = $this->plainText;
        $token = $this->token;
        $basic = $this->api_key;

//        $privateKey = openssl_pkey_get_private(("file://" . $this->private_key));
//        openssl_sign($plainText, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=" . $this->merchantCode . "&password=" . $this->password . "&grant_type=password",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $this->basic,
                "cache-control: no-cache",
                "Content-Type: application/x-www-form-urlencoded",
            )
        ));
        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
            return $err;
        }
        $access_token = json_decode($result);
        if (isset($access_token->access_token)) {
            return $access_token->access_token;
        }
        return $result;
    }

    /**
     * Generate Payment Token & Notification Secret for use in Jenga PGW Checkout and Callback Auth.
     * @param bool $isNotificationSecret
     * @param bool $is_sandbox
     * @return false|mixed [type] [Payment Token or Notification Secret string]
     */
    public function generatePaymentToken($isNotificationSecret = false, $is_sandbox = '')
    {
        if ($is_sandbox == '') {
            $is_sandbox = $this->is_sandbox;
        }
        if ($is_sandbox) {
            $url = "https://api-test.equitybankgroup.com/v1/token";
        } else {
            $url = "https://api.equitybankgroup.com/v1/token";
        }
//        $privateKey = openssl_pkey_get_private(("file://" . $this->private_key));
//        openssl_sign($this->plainText, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "merchantCode=" . $this->merchantCode . "&password=" . $this->password . "&grant_type=password",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $this->basic,
                "cache-control: no-cache",
                "Content-Type: application/x-www-form-urlencoded",
            )
        ));
        $result = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return $err;
        }
        $result_json = json_decode($result, true);
        if (isset($result_json['notification-secret']) && isset($result_json['payment-token'])) {

            if ($isNotificationSecret == true) {
                return $result_json['notification-secret'];

            }
            return $result_json['payment-token'];
        }

        return 'Checkouttoken:' . $result;
    }

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
    public function generateCheckout($amount, $orderReference, $callbackurl, string $custName = 'Client', $title = 'Pay Via EazzyPay', $website = 'NA', $extraData = 'NA', $currency = "KES", $outletCode = "0000000000", $is_sandbox = '', $btnClass = 'btn btn-primary col-md-4')
    {
        if ($is_sandbox == '') {
            $is_sandbox = $this->is_sandbox;
        }
        $order = $orderReference;
        $amount = intval(($amount * 100) . '');
        $expiry = date('Y-m-d', strtotime('+5 years')) . 'T19:00:00';
        if (isset($this->merchantName)) {
            $merchantName = $this->merchantName;
        } else {
            $merchantName = 'MERCHANT NAME';
        }
        if ($is_sandbox) {
            $url = "https://api-test.equitybankgroup.com/v2/checkout/launch";
        } else {
            $url = "https://api.equitybankgroup.com/v2/checkout/launch";
        }

        return $html = " <form
         id='eazzycheckout-payment-form'
         action='" . $url . "' method='POST'>
     <input type='hidden' value='" .
            $this->payment_secret
            . "' id='token' name='token'>
     <input type='hidden' value='" .
            $amount
            . "' id='amount' name='amount'>
     <input type='hidden' value='" .
            $order
            . "' id='orderReference' name='orderReference'>
     <input type='hidden' value='" .
            $this->merchantCode
            . "' id='merchantCode' name='merchantCode'>
     <input type='hidden' value='" .
            $merchantName
            . "'  id='merchant' name='merchant' >
     <input type='hidden' value='" .
            $currency
            . "' id='currency' name='currency'>
     <input type='hidden' value='" .
            $custName
            . "' id='custName' name='custName'>
     <input type='hidden' value='" .
            $outletCode
            . "'  id='outletCode' name='outletCode'>
     <input type='hidden' value='" .
            $extraData
            . "' id='extraData' name='extraData' >
     <input type='hidden'  id='popupLogo' name='popupLogo'>
     <input type='hidden' value='" .
            $callbackurl
            . "' id='ez1_callbackurl' name='ez1_callbackurl'>
     <!--     <input type='type='hidden'' id='ez2_callbackurl' name='ez2_callbackurl'>-->
     <input type='hidden' value='" .
            $expiry
            . "' id='expiry' name='expiry'>
     <button type='submit' id='submit-cg' role='button' class='" . $btnClass . "'
            >" . $title . "</button>
 </form>";

    }

}
