<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    public function type(){
        return $this->belongsTo(UserType::class,'user_types_id');
    }

    // public function favorite(){
    //     return $this->hasMany(Favorite::class, 'user_id');
    // }
}
