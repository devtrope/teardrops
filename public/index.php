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

Route::get('/blog/{slug}', function () {
    echo 'Blog Page avec slug';
});

Route::get('/blog/all', function () {
    echo 'Blog Page avec tous les articles';
});

$calledURI = rtrim($_SERVER['REQUEST_URI'], '/') ?? '/';
Router::dispatch($calledURI);