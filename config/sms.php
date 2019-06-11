<?php

return [
    'driver' => env('SMS_DRIVER', 'sms.ru'),

    'drivers' => [
        'sms.ru' => [
            'app_id' => env('SMSRU_API_ID'),
            'url' => env('SMSRU_URL', 'https://sms.ru/sms/send'),
        ]
    ],
];