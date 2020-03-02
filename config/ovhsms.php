<?php

return [
    /**
     * Application Key
     */
    'app_key' => env('OVHSMS_APP_KEY'),

    /**
     * Application Secret
     */
    'app_secret' => env('OVHSMS_APP_SECRET'),

    /**
     * Consummer Key
     */
    'consumer_key' => env('OVHSMS_CONSUMER_KEY'),

    /**
     * Endpoint 
     */
    'endpoint' => env('OVHSMS_ENDPOINT'),

    /**
     * Endpoint 
     */
    'service_name' => env('OVHSMS_SERVICE_NAME'),

    /**
     * Trailing Slash 
     */
    'service_name' => env('OVHSMS_TRAILING_SLASH', true),

    /**
     * Verfify SSL 
     */
    'ssl_verify' => env('OVHSMS_VERIFY_SSL', true),
];
