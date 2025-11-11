<?php

use Ludens\Routing\Route;

Route::call([\App\Http\Controller\HomeController::class, 'index'])->when('/')->onGet();
Route::call([\App\Http\Controller\HomeController::class, 'about'])->when('/about')->onGet();
Route::call([\App\Http\Controller\ShopController::class, 'index'])->when('/shop')->onGet();
Route::call([\App\Http\Controller\ProductController::class, 'index'])->when('/products')->onPost();
Route::call([\App\Http\Controller\ProductController::class, 'display'])->when('/products/{id}')->onGet();
Route::call([\App\Http\Controller\CartController::class, 'index'])->when('/cart')->onGet();
Route::call([\App\Http\Controller\CartController::class, 'add'])->when('/cart/add')->onPost();
Route::call([\App\Http\Controller\CartController::class, 'update'])->when('/cart/update')->onPost();
Route::call([\App\Http\Controller\CartController::class, 'delete'])->when('/cart/delete')->onPost();
Route::call([\App\Http\Controller\AuthController::class, 'login'])->when('/login')->onGet();
Route::call([\App\Http\Controller\AuthController::class, 'sign'])->when('/login')->onPost();
Route::call([\App\Http\Controller\AuthController::class, 'register'])->when('/register')->onGet();
Route::call([\App\Http\Controller\AuthController::class, 'add'])->when('/register')->onPost();