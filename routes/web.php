<?php

use Ludens\Routing\Route;

Route::call([\App\Http\Controller\HomeController::class, 'index'])->when('/')->onGet();
Route::call([\App\Http\Controller\HomeController::class, 'about'])->when('/about')->onGet();
Route::call([\App\Http\Controller\ShopController::class, 'index'])->when('/shop')->onGet();
Route::call([\App\Http\Controller\ProductController::class, 'index'])->when('/products')->onPost();
Route::call([\App\Http\Controller\ProductController::class, 'display'])->when('/products/{id}')->onGet();
Route::call([\App\Http\Controller\CartController::class, 'index'])->when('/cart')->onGet();