<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductImage extends Model
{
    use HasFactory;
    protected $appends =['src'];
    protected $fillable = [
        'product_id',
        'image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSrcAttribute(){
        // Usar asset() para generar la URL correcta con el ASSET_URL si está configurado
        return asset($this->image);
    }
}
