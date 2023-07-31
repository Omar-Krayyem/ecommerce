<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AdminController;


Route::group(['prefix' => 'product'], function(){
    Route::get('all', [ProductsController::class, "getAll"]);
    Route::get('/{product}', [ProductsController::class, "getById"]);
    Route::post('/store', [ProductsController::class, "store"]);
    Route::post('/update/{id?}', [ProductsController::class, "update"]);
    Route::post('/destroy/{id?}', [ProductsController::class, "destroy"]);
});



