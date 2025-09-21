#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

exec(__DIR__ . '/daemon.php');

// Simple CLI PoC
$apiUrl = getenv('POC_API_URL') ?: 'http://127.0.0.1:8000/api/health';

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    echo "Error: $err\n";
    exit(1);
}

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Invalid JSON: $response\n";
    exit(1);
}

echo "Message from API: " . ($data['status'] ?? 'No message') . "\n";

