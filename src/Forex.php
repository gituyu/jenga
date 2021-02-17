<?php


namespace Finserve\Jenga;


class Forex
{
    public function getForex($baseCurrency = 'KES', $foreignCurrency = 'USD', $exchangeService = '1', $apiKey = '')
    {
        if ($exchangeService == '1' && $apiKey == '') {
            $freeKey = '6108d2b4725da8e77dda';
            $quote = $baseCurrency . '_' . $foreignCurrency;

            $url = 'https://free.currconv.com/api/v7/convert?q=' . $quote . '&compact=y&apiKey=' . $freeKey;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $curl_response = curl_exec($curl);

            $res = json_decode($curl_response, true);
            $value= $res[$quote]['val'];
            if (isset($value)){
                return $value;
            }
            return false;
        }
        return false;
    }
}