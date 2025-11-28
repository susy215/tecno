<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Supplier;
use App\Models\ProductImage;
use App\Models\Cart_item;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    protected $fillable =['title','description','cost','price','qty','published','category_id','discount','sellingprice','supplier_id','product_images','updated_date','created_date'];

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function cart_item(){
        return $this->belongsTo(Cart_item::class);
    }
    public function OrderItem(){
        return $this->belongsTo(OrderItem::class);
    }
     //filter logic for price or categories or brands

     public function scopeFiltered($query)
     {
         return $query->where('published', true)
             ->when(request('categories'), function ($q) {
                 $q->whereIn('category_id', request('categories'));
             })
             ->when(request('prices'), function ($q) {
                 $q->whereBetween('price', [
                     request('prices.from', 0),
                     request('prices.to', 100000),
                 ]);
             });
     }

};

