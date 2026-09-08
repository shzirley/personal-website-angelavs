<?php

return [
    // Static local sandbox: no database is required for navigation or forms.
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => storage_path('framework/sessions'),
    'cookie' => 'angelaos_session',
    'path' => '/',
    'domain' => null,
    'secure' => env('SESSION_SECURE_COOKIE', false),
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
];
