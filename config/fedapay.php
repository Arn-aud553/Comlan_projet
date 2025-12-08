<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FedaPay API Keys
    |--------------------------------------------------------------------------
    |
    | Here you may specify your FedaPay API keys. You should use different
    | keys for your development and production environments.
    |
    */

    'public_key' => env('FEDAPAY_PUBLIC_KEY'),
    'secret_key' => env('FEDAPAY_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | FedaPay Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    | Supported: "sandbox", "live"
    |
    */

    'environment' => env('FEDAPAY_ENVIRONMENT', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | FedaPay Callback URL
    |--------------------------------------------------------------------------
    |
    | This is the URL where FedaPay will redirect users after payment.
    | Make sure this URL is accessible from the internet.
    |
    */

    'callback_url' => env('FEDAPAY_CALLBACK_URL', env('APP_URL') . '/client/media/{id}/pay/callback'),

    /*
    |--------------------------------------------------------------------------
    | FedaPay Webhook URL
    |--------------------------------------------------------------------------
    |
    | This is the URL where FedaPay will send webhook notifications.
    | Make sure this URL is accessible from the internet.
    |
    */

    'webhook_url' => env('FEDAPAY_WEBHOOK_URL', env('APP_URL') . '/fedapay/webhook'),

    /*
    |--------------------------------------------------------------------------
    | FedaPay Currency
    |--------------------------------------------------------------------------
    |
    | The currency code for transactions. Default is XOF (Franc CFA).
    |
    */

    'currency' => env('FEDAPAY_CURRENCY', 'XOF'),

    /*
    |--------------------------------------------------------------------------
    | FedaPay API Version
    |--------------------------------------------------------------------------
    |
    | The API version to use for FedaPay requests.
    |
    */

    'api_version' => env('FEDAPAY_API_VERSION', 'v1'),
];
