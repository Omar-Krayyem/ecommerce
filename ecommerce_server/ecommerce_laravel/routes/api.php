<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('refresh', 'refresh');
    Route::post('logout', 'logout');
});


// Route::middleware('auth:api')->group(function(){

    Route::group(['prefix' => 'admin'], function(){
        Route::group(['prefix' => 'product'], function(){
            Route::get('all', [ProductsController::class, "getAll"]);
            Route::get('/{product}', [ProductsController::class, "getById"]);
            Route::post('/store', [ProductsController::class, "store"]);
            Route::post('update/{id?}', [ProductsController::class, "update"]);
            Route::delete('destroy/{id}', [ProductsController::class, "destroy"]);
        });
    
        Route::group(['prefix' => 'category'], function(){
            Route::get('all', [AdminController::class, "getCategory"]);
            Route::get('/{category}', [AdminController::class, "getById"]);
            Route::post('/store', [AdminController::class, "store"]);
            Route::post('/update/{id?}', [AdminController::class, "update"]);
            Route::delete('destroy/{id}', [AdminController::class, "destroy"]);
        });
    
        Route::get('/customers', [AdminController::class, "getAll"]);
    });
    
    
    Route::group(['prefix' => 'client'], function(){
        Route::group(['prefix' => 'home'], function(){
            Route::get('all', [ProductsController::class, "getAll"]);
            Route::get('categories', [AdminController::class, "getCategory"]);
            Route::get('/category/{id?}', [AdminController::class, "getCategoryProducts"]);
        });
    
        Route::group(['prefix' => 'favorite'], function(){
            Route::get('/{id?}', [CustomersController::class, "getFavorites"]);
            Route::post('/add', [CustomersController::class, "addFavorite"]);
            Route::post('/destroy', [CustomersController::class, "destroy"]);
        });
    
        Route::group(['prefix' => 'cart'], function(){
            Route::get('/{user?}', [CustomersController::class, "getCart"]);
            Route::post('/add', [CustomersController::class, "addCartItem"]);
            Route::get('/destroy/{item}', [CustomersController::class, "deleteItem"]);
    
           
        });

    
    });
    
// });

