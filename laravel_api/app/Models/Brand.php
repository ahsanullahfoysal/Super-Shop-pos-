<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function product() {
        return $this->hasMany(Product::class);
    }
    public function sale() {
        return $this->hasMany(Sale::class);
    }
    public function purchase() {
        return $this->hasMany(Purchase::class);
    }
}
