**Installtion**<br>
``
composer require gituyu/jenga
``
On Laravel, do publish package files.
``
php artsan vendor:publish
``
Select  ``Provider: Finserve\Jenga\JengaServiceProvider`` or ``Tag: jenga-config``

**Usage**<br>
In laravel controller use helper ``
jengaCheckout($amount, $orderReference, $callbackurl, $custName = 'Client', $title = 'Pay Via EazzyPay',$is_sandbox = true, $website = 'NA', $extraData = 'NA', $currency = "KES", $outletCode = "0000000000")*``
As used in example below,the output is a HTML string which should be injected on the checkout page. The visible part is a Payment Button that redirect to EazzyPayment Checkout Portal.After the client completes payment they are redirected back and a callback is triggered on payment update.

``
$payment_button= \App\Helpers\jengaCheckout(22,'dff','https://webhook.site/0a75a3f0-b545-4ce3-8c1f-926e7bded3df','John Doe','Pay now',true);
``

**Configuration**<br>
Once you publish package files, a configuration in *config/jenga.php* is created.
Alternatively:
At your project root, create a .env file set these configs:

`JENGA_USERNAME=[username]` <br>
`JENGA_PASSWORD=[password]` <br>
`JENGA_API_KEY=[api_key]` <br>
`JENGA_PRIVATE_KEY=[/relative/path/to/private.pem]` <br>
`JENGA_BASE_ENDPOINT=https://uat.jengahq.io`<br>


**NB: The package is autodiscovered by laravel:** For Laravel older version (less than 5.5) users, open the Config/App.php file and add `\Finserve\Jenga\JengaServiceProvider::class` under providers
and ` 'Jenga'=> \Finserve\Jenga\JengaServiceProvider::class` under aliases.

**Forex**<br>
It supports optional paramenters. Supported service are:
1. [currencyconverterapi.com ](www.currencyconverterapi.com).

⋅⋅⋅API (https://free.currconv.com/api/) Limits to 100Req/min updates are quotes upto 45min.

``
getForex($baseCurrency = 'KES', $foreignCurrency = 'USD', $exchangeService = '1', $apiKey = '')
``
Example:
``
    $forex=(new \Finserve\Jenga\Forex())->getForex('USD','KES');
``
**Callback**<br>
Usage:
``
Route::get('/callback/route/here', function () {
    $data=\Finserve\Jenga\Callback();
    //Do something
});
``
Formated to as below:
```json
{
  "customernumber": "A N Other",
  "customermobileNumber": "",
  "customerRef": null,
  "txDate": "2018-11-27 00:00:00.0",
  "txRef": " S2596405",
  "txPaymentMode": "TPG",
  "txAmount": "10",
  "txTill": null,
  "txBillNumber": "A N Other",
  "txOrderAmount": "",
  "txServiceCharge": "",
  "txServedBy": "EQ",
  "txAdditionalInfo": "MPS 254723000000 MKR35QEKV7 A N Other/537620",
  "bnkRef": " S2596405",
  "bnkTransactionType": "C",
  "bnkAccount": "0111234241028"
}
```
