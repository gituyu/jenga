<?php

return [
    'JENGA_USERNAME' => env('JENGA_USERNAME', false),
    'JENGA_PASSWORD' => env('JENGA_PASSWORD', false),
    'JENGA_API_KEY' => env('JENGA_API_KEY', false),
    'JENGA_PRIVATE_KEY' => env('JENGA_PRIVATE_KEY', storage_path() . 'private.pem]'),
    'JENGA_BASE_ENDPOINT' => env('JENGA_BASE_ENDPOINT', 'https://uat.jengahq.io'),
    'JENGA_ACCOUNT_ID' => env('JENGA_ACCOUNT_ID', '123456'),
    'JENGA_CURRENCY_DEFAULT' => env('JENGA_CURRENCY_DEFAULT', 'KES'),
    'JENGA_CALLBACK_DEFAULT' => env('JENGA_CALLBACK_DEFAULT', 'https://webhook.site/0a75a3f0-b545-4ce3-8c1f-926e7bded3df'),

    'JENGA_MERCHANT_NAME' => env('JENGA_MERCHANT_NAME', '123456'),
    'JENGA_MERCHANT_WEBSITE' => env('JENGA_MERCHANT_WEBSITE', ''),
    'JENGA_MERCHANT_OUTLET_CODE' => env('JENGA_MERCHANT_OUTLET_CODE', ''),
    'JENGA_EXTRA_DATA' => env('JENGA_EXTRA_DATA', 'NA'),
    'JENGA_CHECKOUT_LOGO_URL' => env('JENGA_CHECKOUT_LOGO_URL', 'NA'),
    'JENGA_CHECKOUT_BUTTON_CLASS' => env('JENGA_CHECKOUT_BUTTON_CLASS', 'btn btn-primary col-md-4'),
];