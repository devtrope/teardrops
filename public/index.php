<?php

require_once dirname(__DIR__) . '../vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Parse the request URL to get the controller and method
$trimedURI = trim($request, '/');
$explodedURI = explode('/', $trimedURI);

$controller = $explodedURI[0] ?: 'home';
$method = $explodedURI[1] ?? 'index';

// Verify if the controller and method exist
$controllerClass = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';

if (! class_exists($controllerClass)) {
    http_response_code(404);
    echo "Controller not found";
    exit;
}

$controllerInstance = new $controllerClass();
if (! method_exists($controllerInstance, $method)) {
    http_response_code(404);
    echo "Method not found";
    exit;
}

// Call the method on the controller instance
try {
    $response = call_user_func_array([$controllerInstance, $method], array_slice($explodedURI, 2));
} catch (Exception $e) {
    http_response_code(500);
    echo "Internal Server Error: " . $e->getMessage();
    exit;
}