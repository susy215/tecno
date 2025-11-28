<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Supplier;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
// use Illuminate\Support\Facades\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Suppliers/SuppliertIndex', [
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
            'suppliers' => Supplier::all()->map(function ($supplier){

                return [

                    'id' => $supplier->id,
                    'name' => $supplier->name,
                    'email' => $supplier->email,
                    'number' => $supplier->number,
                    'address' => $supplier->address,
                    'supplier_profile' => asset('storage/'. $supplier->supplier_profile)
                ];
            }),
        ]);
    }
    public function create()
    {
        return Inertia::render('Admin/Suppliers/Create');
    }

    public function store(Request $request){

        $supplier_profile = $request->file('supplier_profile') ? $request->file('supplier_profile')->store('suppliers', 'public') : null;
        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'address' => $request->address,
            'supplier_profile' => $supplier_profile,
        ]);
        return redirect()->route('suppliers.index')->with('success', '¡El proveedor ha sido creado con éxito!');
    }

    public function edit(Supplier $supplier):Response
    {
        return Inertia::render('Admin/Suppliers/Edit', [
            'supplier' => $supplier,
            'supplier_profile' => asset('storage/' . $supplier->supplier_profile)
        ]);

    }
    public function update(Request $request, $id)
    {

        $supplier = Supplier::findOrFail($id);

        if ($request->hasFile('supplier_profile')) {
            if ($supplier->supplier_profile) {
                Storage::disk('public')->delete($supplier->supplier_profile);
            }
            $supplier_profile = $request->file('supplier_profile')->store('suppliers', 'public');
        } else {
            $supplier_profile = $supplier->supplier_profile;
        }
        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'address' => $request->address,
            'supplier_profile' => $supplier_profile,
        ]);

        return redirect()->route('suppliers.index')->with('success', '¡La información del proveedor se ha actualizado con éxito!');
    }


    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('dsuccess', '¡La información del proveedor se ha eliminado con éxito!');
    }
    public function deleteImage($id)
    {
        // Gate::authorize('deleteImage', $productImage);
        $supplier_profile = Supplier::where('id', $id)->delete();
        return back();
    }
}
