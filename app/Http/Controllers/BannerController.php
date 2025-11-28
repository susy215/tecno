<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

use App\Models\Notification;

class BannerController extends Controller
{
    public function index()
    {

        return Inertia::render('Admin/Banners/BannerIndex', [
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
            'banners' => Banner::all()->map(function ($banner){
                return [
                    'id' => $banner->id,
                    'image' => asset('storage/'. $banner->image),
                    'description' => $banner->description,
                ];
            }),
        ]);

    }
    public function create()
    {
        return Inertia::render('Admin/Banners/Create');
    }

    public function store(Request $request)
    {
        $image = $request->file('image') ? $request->file('image')->store('banners', 'public') : null;
        Banner::create([
            'description' => $request->description,
            'image' => $image,
        ]);

        return redirect()->route('banners.index')->with('success', 'banner creado exitosamente!');
    }

    public function edit(Banner $banner):Response
    {
        return Inertia::render('Admin/Banners/Edit', [
            'banner' => $banner,
            'image' => asset('storage/' . $banner->image)
        ]);

    }
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $image = $request->file('image')->store('banner_images', 'public');
        } else {
            $image = $banner->image;
        }
        $banner->update([
            'description' => $request->description,
            'image' => $image
        ]);

        return redirect()->route('banners.index')->with('success', 'banner actualizado correctamente.');
    }
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'banner eliminado exitosamente!.');
    }
}
