<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\CreatePermissionRequest;

use App\Models\Notification;

class PermissionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Permissions/PermissionIndex',[
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
           'permission' => PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render("Admin/Permissions/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePermissionRequest $request)
    {
        Permission::create($request->validated());
        return to_route('permissions.index')->with('success','¡Permiso creado exitosamente!');
    }

    // public function destroyImage(Product $product)
    // {
    //     // Ensure the user is authorized to delete the product image
    //     $this->authorize('update', $product);

    //     // Delete the image file from storage
    //     if ($product->image_path && Storage::exists($product->image_path)) {
    //         Storage::delete($product->image_path);
    //     }

    //     // Remove the image path from the database
    //     $product->image_path = null;
    //     $product->save();
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): Response
    {
        return Inertia::render("Admin/Permissions/Edit",[
            'permission' => new PermissionResource($permission)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return to_route('permissions.index')->with('success','¡Permiso actualizado exitosamente!');
    }

    // public function deleteImage($id)
    // {
    //     $image = ProductImage::where('id', $id)->delete();
    //     return redirect()->route('admin.products.index')->with('success', 'Image deleted successfully.');
    // }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('dsuccess','¡La información de permisos ha sido eliminada con éxito!');
    }
}

