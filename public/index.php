<?php

require __DIR__ . '/../vendor/autoload.php';

use Teardrops\Teardrops\Route;
use Teardrops\Teardrops\Router;

Route::get('/', [\Teardrops\Teardrops\HomeController::class, 'index']);
Route::get('/blog', [\Teardrops\Teardrops\BlogController::class, 'index']);
Route::get('/blog/{slug}', [\Teardrops\Teardrops\BlogController::class, 'show']);
Route::post('/blog/add', [\Teardrops\Teardrops\BlogController::class, 'add']);

// TODO: Handle trailing slashes more gracefully
$calledURI = $_SERVER['REQUEST_URI'] ?? '/';
Router::dispatch($calledURI, $_SERVER['REQUEST_METHOD']);