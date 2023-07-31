<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AdminController;






Route::group(['prefix' => 'admin'], function(){
    Route::group(['prefix' => 'product'], function(){
        Route::get('all', [ProductsController::class, "getAll"]);
        Route::get('/{product}', [ProductsController::class, "getById"]);
        Route::post('/store', [ProductsController::class, "store"]);
        Route::post('/update/{id?}', [ProductsController::class, "update"]);
        Route::post('/destroy/{id?}', [ProductsController::class, "destroy"]);
    });

    Route::group(['prefix' => 'category'], function(){
        Route::get('all', [AdminController::class, "getCategory"]);
        Route::get('/{category}', [AdminController::class, "getById"]);
        Route::post('/store', [AdminController::class, "store"]);
        Route::post('/update/{id?}', [AdminController::class, "update"]);
        Route::post('/destroy/{id?}', [AdminController::class, "destroy"]);
    });

    Route::get('/customers', [AdminController::class, "getAll"]);
});


Route::group(['prefix' => 'client'], function(){
    Route::group(['prefix' => 'home'], function(){
        Route::get('all', [ProductsController::class, "getAll"]);
        Route::post('/category/{id?}', [CustomersController::class, "getCategoryProducts"]);
    });

    Route::group(['prefix' => 'favorite'], function(){
        Route::get('/{id?}', [CustomersController::class, "getFavorites"]);
        Route::post('/add', [CustomersController::class, "addFavorite"]);
        Route::get('/destroy/{id?}', [CustomersController::class, "destroy"]);
    });
});