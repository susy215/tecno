<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Inertia\inertia;
use Inertia\Response;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use App\Policies\ProductPolicy;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Resources\ProductResource;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\SupplierResource;
// Excel
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Notification;



class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with('category', 'product_images');

// Apply published filter
if ($request->has('published') && $request->input('published') !== '') {
$published = $request->input('published');
$query->where('published', $published);
}

// Apply inStock filter
if ($request->has('inStock')) {
    if ($request->input('inStock') == 1) {
        $query->where('qty', '>', 0);
    } else if ($request->input('inStock') == 0) {
        $query->where('qty', '<=', 0);
    }
}

  // Apply search filter
    if ($request->has('search') && !empty($request->search)) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }
    // Paginate the results
    $products = $query->paginate(7);
    // Fetch related data
    $categories = Category::all();
    $suppliers = Supplier::all();

    // Return the data to the Inertia.js component
    return Inertia::render('Admin/Products/ProductIndex', [
        'notifications' =>Notification::get(),
        'contnitification' =>Notification::count(),
        'products' => $products,
        'categories' => CategoryResource::collection($categories),
        'suppliers' => SupplierResource::collection($suppliers),
    ]);
}


    public function create(): Response
    {

        Gate::authorize('create', Product::class);
        $supplier = Supplier::all();
        $categories = Category::all();
        return Inertia::render('Admin/Products/Create',[
            'categories' =>CategoryResource::collection($categories),
            'suppliers' =>SupplierResource::collection($supplier),
        ]);

    }

    public function store(Request $request)
    {

        $product = new Product;
        $product->title = $request->title;
        $product->cost = $request->cost;
        $product->price = $request->price;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->discount = $request->discount;
        $product->sellingprice = $request->sellingprice;
        $product->total_price = $request->total_price;
        $product->total_cost = $request->total_cost;
        $product->created_date = now();
        $product->updated_date = now();
        $product->save();

        if ($request->hasFile('product_images')) {
            $productImages = $request->file('product_images');
            $imagePath = public_path('product_images');
            
            // Crear el directorio si no existe
            if (!File::isDirectory($imagePath)) {
                File::makeDirectory($imagePath, 0755, true, true);
            }
            
            foreach ($productImages as $image) {
                // Generate a unique name for the image using timestamp and random string
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                // Store the image in the public folder with the unique name
                $image->move($imagePath, $uniqueName);
                // Create a new product image record with the product_id and unique name
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName,
                ]);
            }
        }
        return redirect()->route('products.index')->with('success', '¡La información del producto ha sido creada con éxito!');
    }
    public function edit(Product $product):Response
    {
        Gate::authorize('create', Product::class);
        return Inertia::render('Admin/Products/Edit',[
            'product' => new ProductResource($product),
            'categories'=> CategoryResource::collection(Category::all()),
            // 'discounts' =>DiscountResource::collection(Discount::all()),
            'suppliers' =>SupplierResource::collection(Supplier::all()),

            ]);
    }


    public function deleteImage($id)
    {
        // Gate::authorize('deleteImage', $productImage);
        $image = ProductImage::where('id', $id)->delete();
        return back();
    }


    //update
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Actualizar campos del producto usando input() con valores por defecto
        // Esto evita null values si algún campo no se envía
        if ($request->has('title')) {
            $product->title = $request->input('title');
        }
        if ($request->has('cost')) {
            $product->cost = $request->input('cost');
        }
        if ($request->has('price')) {
            $product->price = $request->input('price');
        }
        if ($request->has('qty')) {
            $product->qty = $request->input('qty');
        }
        if ($request->has('description')) {
            $product->description = $request->input('description');
        }
        if ($request->has('category_id')) {
            $product->category_id = $request->input('category_id');
        }
        if ($request->has('supplier_id')) {
            $product->supplier_id = $request->input('supplier_id');
        }
        if ($request->has('discount')) {
            $product->discount = $request->input('discount');
        }
        if ($request->has('sellingprice')) {
            $product->sellingprice = $request->input('sellingprice');
        }
        if ($request->has('total_price')) {
            $product->total_price = $request->input('total_price');
        }
        if ($request->has('total_cost')) {
            $product->total_cost = $request->input('total_cost');
        }
        $product->updated_date = now()->format('Y-m-d');

        // Check if product images were uploaded
        if ($request->hasFile('product_images')) {
            $productImages = $request->file('product_images');
            $imagePath = public_path('product_images');
            
            // Crear el directorio si no existe
            if (!File::isDirectory($imagePath)) {
                File::makeDirectory($imagePath, 0755, true, true);
            }
            
            // Loop through each uploaded image
            foreach ($productImages as $image) {
                // Generate a unique name for the image using timestamp and random string
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store the image in the public folder with the unique name
                $image->move($imagePath, $uniqueName);

                // Create a new product image record with the product_id and unique name
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName,
                ]);
            }
        }
        $product->update();
        return redirect()->route('products.index')->with('success', '¡La información del producto ha sido actualizada con éxito!');
    }


    public function destroy(Product $product)
    {
            Gate::authorize('delete', $product);
            DB::transaction(function () use ($product) {
                // Delete dependent rows
                DB::table('cart_items')->where('product_id', $product->id)->delete();

                // Delete the product
                $product->delete();
            });

            return back()->with('dsuccess', 'បានលុបព័ត៌មានទំនិញជោគជ័យ!');
     }
     public function updateToPublished(Request $request, $id)
     {
         $product = Product::findOrFail($id);
         $product->update([
             'published' => 1,
         ]);
         return redirect()->route('products.index')->with('success', '¡El producto ha sido puesto a la venta con éxito!');
     }
     public function updateToUnpublished(Request $request, $id)
     {
         $product = Product::findOrFail($id);
         $product->update([
             'published' => 0,
         ]);
         return redirect()->route('products.index')->with('success', 'បានលាក់ទំនិញជោគជ័យ!');
     }

     public function show($id):Response
{
    $categories = Category::all();
$suppliers = Supplier::all();
    $product = Product::with(['category', 'product_images','supplier'])->findOrFail($id);
                return Inertia::render('Admin/Products/ProductDetail', [
                    // 'product' => new ProductResource($product),
                'products' => $product,
                'notifications' =>Notification::get(),
                'contnitification' =>Notification::count(),
     ]);
}

// Excel
public function export()
    {
        return Excel::download(new ProductExport,'product.xlsx');
    }

}



