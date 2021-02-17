<?php

namespace App\Helpers;

use Finserve\Jenga\Jenga;

if (!function_exists('jengaCheckout')) {

    /**
     * return Jenga HTML
     *
     * @param  $amount
     * @param $orderReference
     * @param $callbackurl
     * @param string $custName
     * @param string $title
     * @param string $website
     * @param string $extraData
     * @param string $currency
     * @param string $outletCode
     * @param bool $is_sandbox
     * @return mixed
     */
    function jengaCheckout($amount, $orderReference, $callbackurl, $custName = 'Client', $title = 'Pay Via EazzyPay',$is_sandbox = true, $website = 'NA', $extraData = 'NA', $currency = "KES", $outletCode = "0000000000")
    {
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

        $jenga = new Jenga($username, $password, $api_key, $is_sandbox, $private_key);
        return $jenga->generateCheckout($amount, $orderReference, $callbackurl, $custName, $title, $website, $extraData, $currency, $outletCode, $is_sandbox, $btnClass);
    }

}