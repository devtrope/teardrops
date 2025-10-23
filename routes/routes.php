<?php

use Ludens\Routing\Route;

Route::get('/', [\Teardrops\Teardrops\Http\Controller\HomeController::class, 'index']);
Route::get('/test', [\Teardrops\Teardrops\Http\Controller\HomeController::class, 'test']);
