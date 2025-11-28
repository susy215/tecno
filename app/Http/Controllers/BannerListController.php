<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Inertia\Inertia;

class BannerListController extends Controller
{
    public function index()
    {
        $banners = Banner::get();
        return Inertia::render('HomePage/Components/Carousel.vue', [
            'banners' => $banners
        ]);
    }
}
