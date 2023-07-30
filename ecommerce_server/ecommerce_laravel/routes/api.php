<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AdminController;

Route::get('/', function(){
    return view('welcome');
});

Route::get('/omar', function(){
    echo "omar";
});
