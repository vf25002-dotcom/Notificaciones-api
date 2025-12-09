<?php

use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';

$response = Http::post('http://localhost:8000/api/v1/login', [
    'email' => 'Fonsi@gmail.com',
    'password' => 'Fonsi',
]);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
