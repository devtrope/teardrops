<?php

require __DIR__ . '/../vendor/autoload.php';

use Teardrops\Teardrops\Route;

Route::get('/', function () {
    echo 'Home Page';
});

Route::get('/blog', function () {
    echo 'Blog Page';
});

$calledURI = $_SERVER['REQUEST_URI'] ?? '/';
call_user_func(Route::getRoutes()[$calledURI] ?? function () {
    http_response_code(404);
    echo '404 Not Found';
});