<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $fillable = ['user_id', 'product_id'];

    protected $table = 'favorites';

    public function user(){
        return $this->belongsTo(Users::class,'user_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
