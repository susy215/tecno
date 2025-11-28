<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'number', 'address', 'supplier_profile'];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
