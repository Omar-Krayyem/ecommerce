<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->integer('user_types_id');
        });

        Schema::create('user_types', function(Blueprint $table){
            $table->id();
            $table->string('type')->unique();
        });

        Schema::create('products', function(Blueprint $table){
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->integer('price');
            $table->integer('product_categories_id');
        });

        Schema::create('product_categories', function(Blueprint $table){
            $table->id();
            $table->string('category')->unique();
        });

        Schema::create('favorites', function(Blueprint $table){
            $table->id();
            $table->integer('products_id');
            $table->integer('users_id');
        });

        Schema::create('carts', function(Blueprint $table){
            $table->id();
            $table->integer('total');
            $table->integer('users_id');
        });

        Schema::create('cart_items', function(Blueprint $table){
            $table->id();
            $table->integer('quantity');
            $table->integer('carts_id');
            $table->integer('products_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
