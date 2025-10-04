<?php

use App\Http\Controllers\Web\CategoryWebController;
use App\Http\Controllers\Web\ProductWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('categories.index'));

Route::resource('categories', CategoryWebController::class);
Route::resource('products', ProductWebController::class);
