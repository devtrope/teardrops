<?php

use Ludens\Routing\Route;

Route::call([\App\Http\Controller\HomeController::class, 'index'])->when('/')->onGet();