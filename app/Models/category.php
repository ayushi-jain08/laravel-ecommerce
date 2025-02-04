<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    public function sub_category(){
        return $this->hasMany(SubCategory::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
}