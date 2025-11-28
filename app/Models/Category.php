<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Policies\CategoryPolicy;

class Category extends Model
{
    use HasFactory;
    protected $fillable =['category','description'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
