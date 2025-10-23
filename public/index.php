<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/helpers.php';
require __DIR__ . '/bootstrap.php';

use Ludens\Http\Request;
use Ludens\Routing\Route;
use Ludens\Routing\Router;

Route::get('/', [\Teardrops\Teardrops\HomeController::class, 'index']);

Router::dispatch(new Request());