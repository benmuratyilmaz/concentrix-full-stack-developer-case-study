<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'getAllProduct']);
Route::post('/products/new', [ProductController::class, 'newProduct']);
Route::get('/products/export', [ProductController::class, 'exportProduct']);
Route::get('/products/{id}', [ProductController::class, 'getDetailProduct']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);

