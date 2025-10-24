<?php

use Ludens\Routing\Route;

Route::get('/', [\App\Http\Controller\HomeController::class, 'index']);
