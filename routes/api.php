<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);

    Route::get('products', [\App\Http\Controllers\Api\ProductController::class, 'index'])->name('products.index');
    Route::post('products', [\App\Http\Controllers\Api\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'show'])->name('products.show');
    Route::put('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('categories-tree', [\App\Http\Controllers\Api\CategoryController::class, 'tree'])->name('categories.tree');
});
