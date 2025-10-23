<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/helpers.php';

use Teardrops\Teardrops\Request;
use Teardrops\Teardrops\Route;
use Teardrops\Teardrops\Router;

Route::get('/', [\Teardrops\Teardrops\HomeController::class, 'index']);

Router::dispatch(new Request());