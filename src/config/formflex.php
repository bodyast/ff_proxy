<?php

return [
    'base_url' => env('FORMFLEX_BASE_URL', 'https://local.formflex.pw'),

    'auth' => [
        'type' => env('FORMFLEX_AUTH_TYPE', 'bearer'),

        'bearer_token' => env('FORMFLEX_TOKEN'),

        'api_key' => env('FORMFLEX_API_KEY'),
        'api_key_header' => env('FORMFLEX_API_KEY_HEADER', 'X-API-KEY'),
    ],
];
