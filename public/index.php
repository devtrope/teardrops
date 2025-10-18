<?php

require __DIR__ . '/../vendor/autoload.php';

use Teardrops\Teardrops\Request;
use Teardrops\Teardrops\Route;
use Teardrops\Teardrops\Router;

Route::get('/', [\Teardrops\Teardrops\HomeController::class, 'index']);

Router::dispatch(new Request());