<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    // protected $with = ['category'];

    // protected $appends = ['category_name'];

    public function category(){
        return $this->belongsTo(ProductCategory::class,'product_categories_id');
    }

    public function getCategoryNameAttribute(){
        $category = $this->category()->first(); 

        return $category->category;
    }

    public function products(){
        return $this->hasMany(Favorite::class, 'product_id');
    }
}
