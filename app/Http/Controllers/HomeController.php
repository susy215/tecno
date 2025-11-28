<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
          $banners = Banner::all()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'image' => asset('storage/' . $banner->image)
            ];
        });
        $query = Product::with('category', 'product_images');
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $query->where('published',1);
        $products = $query->paginate(8);

        return Inertia::render('HomePage/Index', [
            // 'users' => $user,
            'banners' => $banners,
            'products' => $products,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function show($id): Response
    {
        $product = Product::with(['category', 'product_images'])->findOrFail($id);
        return Inertia::render('HomePage/ProductDetail', [
            'product' => $product,
        ]);
    }

}
