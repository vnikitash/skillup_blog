<?php


return [
    'telegram' => [
        'token' => env('TELEGRAM_TOKEN'),
        'host' => "https://api.telegram.org/bot" . env('TELEGRAM_TOKEN') . "/%s"
    ],
    'viber' => [
        'token' => env('VIBER_TOKEN')
    ]
];