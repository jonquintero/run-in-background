<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'itunes' => [
        'base_uri' => env('ITUNES_BASE_URI'),
        'music' => env('ITUNES_MEDIA_MUSIC'),
        'movies' => env('ITUNES_MEDIA_MOVIES'),
        'ebook' => env('ITUNES_MEDIA_EBOOK'),

    ],

    'tvmaze' => [
        'base_uri' => env('TVMAZE_BASE_URI'),
    ],

    'searchpeople' => [
        'base_uri' => env('PEOPLE_BASE_URI'),
        'soap_method' => env('PEOPLE_SOAP_METHOD')
    ],

];
