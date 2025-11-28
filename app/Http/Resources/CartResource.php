<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helper\Cart;
use App\Models\Product;
use App\Models\Discount;


class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$products, $cartItems] = $this->resource;

        return [
            'count' => Cart::getCount(),
            'total' => $products->reduce(fn (?float $carry, Product $product) => $carry + $product->price * $cartItems[$product->id]['quantity']),
            // 'discounts' => $discounts->reduce(fn (?float $carry, Discount $discount) => $carry + (($products->find($discount->product_id)->price ?? 0) * ($productDiscount[$discount->product_id]['percentage'] ?? 0) / 100), 0),
            'items' => $cartItems,
            'products' => ProductResource::collection($products),
        ];

    }
}
