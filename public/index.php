<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../storage/logs/app_errors.log');

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload dependencies
$router = require_once __DIR__ . '/../routes/api.php';

// Parse the request URI and method
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($requestUri, $requestMethod);
} catch (Exception $exception) {
    error_log("Uncaught Exception: " . $exception->getMessage());
    error_log($exception->getTraceAsString());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
}
