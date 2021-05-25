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

    'company' => [
        'web' => env('COMPANY_WEB', 'www.eliteinsure.co.nz'),
        'url' => env('COMPANY_URL', 'https://eliteinsure.co.nz'),
    ],

    'survey' => [
        'questions' => [
            [
                'type' => 'boolean',
                'text' => 'Have you had a chance to discuss this cancellation with your Adviser?',
            ],
            [
                'type' => 'text',
                'text' => 'Who is your Adviser?',
            ],
            [
                'type' => 'boolean',
                'text' => 'Are you replacing your Partners Life Policy with one at another Provider?',
            ],
            [
                'type' => 'boolean',
                'text' => 'Did your Adviser explain the differences between your Partners Life Policy and your new replacement insurance Policy?',
            ],
            [
                'type' => 'boolean',
                'text' => 'Did your Adviser explain the risk of Non-Disclosure or Misstatement to you?',
            ],
            [
                'type' => 'boolean',
                'text' => 'Did your Adviser discuss both the benefits you forfeit and any risks you might be exposed to in cancelling your cover from us?',
            ],
            [
                'type' => 'text',
                'text' => 'Why are you cancelling your Policy with us?',
            ],
            [
                'type' => 'text',
                'text' => 'Who is your new insurer?',
            ],
            [
                'type' => 'text',
                'text' => 'What could we do to improve?',
            ],
        ],
    ],

];
