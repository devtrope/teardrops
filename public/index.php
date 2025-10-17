<?php

require __DIR__ . '/../vendor/autoload.php';

use Teardrops\Teardrops\Route;
use Teardrops\Teardrops\Router;

Route::get('/', function () {
    echo 'Home Page';
});

Route::get('/blog', function () {
    echo 'Blog Page';
});

$calledURI = $_SERVER['REQUEST_URI'] ?? '/';
Router::dispatch($calledURI);