<?php

require __DIR__ . '/../vendor/autoload.php';

use Teardrops\Teardrops\Route;

Route::get('/', function () {
    echo 'Home Page';
});

Route::get('/blog', function () {
    echo 'Blog Page';
});