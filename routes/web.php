<?php

use App\Http\Controllers\Web\CategoryWebController;
use App\Http\Controllers\Web\ProductWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('products.index'));

Route::resource('products', ProductWebController::class);
Route::resource('categories', CategoryWebController::class);
