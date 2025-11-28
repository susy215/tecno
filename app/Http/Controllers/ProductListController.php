<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Category;

class ProductListController extends Controller
{

    public function index(Request $request)
{

    $query = Product::with('category', 'product_images');
    if ($request->has('search') && !empty($request->search)) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }
    $query->where('published',1);
    $products = $query;
        // $products = Product::with('category', 'product_images')->where('published',1);
        $filterProducts = $products->filtered()->paginate()->withQueryString();
        $categories = Category::get();
    return Inertia::render('HomePage/FilterProductBy', [
        'categories'=>$categories,
        'products' => ProductResource::collection($filterProducts)
    ]);
}
}
