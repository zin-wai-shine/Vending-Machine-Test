<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload dependencies
$router = require_once __DIR__ . '/../routes/web.php';

// Parse the request URI and method
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Dispatch the request
$router->dispatch($requestUri, $requestMethod);
