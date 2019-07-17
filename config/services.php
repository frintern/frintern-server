<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1682670775322787',
        'client_secret' => 'ae2583db4b0d69a65dd0b59fa3cc043a',
        'redirect' => 'http://www.meetrabbi.com/login/facebook',
    ],

    'google' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'linkedin' => [
        'client_id' => '77ch44vedai0xn',
        'client_secret' => 'yfivnL6tqCmtZVRV',
        'redirect' => 'http://www.meetrabbi.com/auth/linkedin',
    ],

    'twitter' => [
        'client_id'    => 'RZANZ8cPw1bR0gST1T989EW3k',
        'client_secret' => 'A6vHse5OlOc7oV9ML9qqllc1bqK5EpklPDj8kAv7KkPobqEzm0',
        'redirect'  => 'https://www.meetrabbi.com',

    ],

];
