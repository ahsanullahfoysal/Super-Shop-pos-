<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function Product() {
        return $this->hasMany(Product::class);
    }
    public function SubCategory() {
        return $this->hasMany(SubCategory::class);
    }
    public function Sale() {
        return $this->hasMany(Sale::class);
    }
    public function Purchase() {
        return $this->hasMany(Purchase::class);
    }
}
