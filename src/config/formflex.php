<?php

return [
    'base_url' => env('FFORMS_BASE_URL', 'https://local.formflex.pw'),

    'auth' => [
        'service_hmac_secret' => env('FFORMS_SERVICE_HMAC_SECRET'),
        'user_email' => env('FFORMS_USER_EMAIL')
    ],
];
