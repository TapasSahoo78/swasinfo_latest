<?php

return [
    'merchant_id' => env('PHONEPE_MERCHANT_ID'),
    'merchant_key' => env('PHONEPE_MERCHANT_KEY'),
    'merchant_salt' => env('PHONEPE_MERCHANT_SALT'),
    'base_url' => env('PHONEPE_BASE_URL', 'https://api.phonepe.com'),
];
