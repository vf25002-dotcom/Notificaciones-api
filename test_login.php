<?php

use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';

$response = Http::post('http://localhost:8000/api/v1/login', [
    'username' => 'admin',
    'password' => 'password',
]);

echo $response->body();
