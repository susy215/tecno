<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BannerListController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminProfile;

use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserProfileControllter;




// Rutas de roles y permissions movidas dentro del grupo /admin para evitar duplicados
// Route::resource('/roles', RoleController::class);
// Route::resource('/permissions', PermissionController::class);


Route::get('/', [HomeController::class, 'index'])->name('home.index');
// Route::get('/home', [HomeController::class, 'index'])->name('home.index'); // Duplicado - ya existe en la línea anterior
Route::get('/home/product/details/{id}', [HomeController::class, 'show'])->name('productDetail.show');


 Route::get('/history',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Userprofile', [UserProfileControllter::class, 'edit'])->name('Userprofile.edit');
Route::post('/userprofile/update', [UserProfileControllter::class, 'update'])->name('Userprofile.update');


// Route::middleware(['auth'])->group(function () {
//     Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
// });

Route::get('/language/{language}',function($language){
    Session::put('locale',$language);
    return redirect()->back();
   })->name('language');

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::resource('/notification',NotificationController::class);
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/profile', [AdminProfile::class, 'index'])->name('profile.index');
    Route::post('/prloefile/update', [AdminProfile::class, 'update'])->name('prloefile.edit');
    Route::resource('/users', UserController::class);
    Route::resource('/deliverys', DeliveryController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/categorys', CategoryController::class);
    Route::resource('/staffs', StaffController::class);
    Route::resource('/orders', OrderController::class);
    Route::resource('/reports', ReportController::class);
    Route::put('/orders/update-to-cancel/{id}',[OrderController::class,'updateToCancel'])->name('orders.updateToCancel');
    Route::resource('/banners', BannerController::class);
    Route::get('/clear/notification', [AdminController::class,'clear'])->name('clear.infor');
    //Product
    Route::resource('/products', ProductController::class);
    // Route::post('/products/store',[ProductController::class,'store'])->name('products.store'); // Duplicado - Route::resource ya crea esta ruta
    Route::put('/products/update-to-public/{id}',[ProductController::class,'updateToPublished'])->name('products.updateToPublished');
    Route::put('/products/update-to-unpublic/{id}',[ProductController::class,'updateToUnpublished'])->name('products.updateToUnpublished');
    Route::get('/sale-report', [ReportController::class, 'SaleReport'])->name('SaleReport.SaleReport');
    Route::get('/buy-report', [ReportController::class, 'BuyReport'])->name('BuyReport.BuyReport');
    Route::get('/customer-report', [ReportController::class, 'CustomerReport'])->name('CustomerReport.CustomerReport');
});

//Roles
Route::middleware(['auth', 'role:staff|admin'])->prefix('/admin')->group(function () {
    Route::resource('/notification',NotificationController::class);
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/profile', [AdminProfile::class, 'index'])->name('profile.index');
    Route::post('/prloefile/update', [AdminProfile::class, 'update'])->name('prloefile.edit');
    Route::resource('/deliverys', DeliveryController::class);
    Route::resource('/categorys', CategoryController::class);
    Route::resource('/orders', OrderController::class);
    Route::put('/orders/update-to-cancel/{id}',[OrderController::class,'updateToCancel'])->name('orders.updateToCancel');
    Route::put('/orders/{id}',[OrderController::class,'show']);
    Route::resource('/banners', BannerController::class);
    Route::get('/clear/notification', [AdminController::class,'clear'])->name('clear.infor');
    //Product
    Route::resource('/products', ProductController::class);
    // Route::post('/products/store',[ProductController::class,'store'])->name('products.store'); // Duplicado - Route::resource ya crea esta ruta
    Route::put('/products/update-to-public/{id}',[ProductController::class,'updateToPublished'])->name('products.updateToPublished');
    Route::put('/products/update-to-unpublic/{id}',[ProductController::class,'updateToUnpublished'])->name('products.updateToUnpublished');
    Route::get('/customer-report', [ReportController::class, 'CustomerReport'])->name('CustomerReport.CustomerReport');
});
// Excel
Route::get('/products/download', [ProductController::class, 'export'])->name('products.export');
Route::get('/reports/download', [ReportController::class, 'export'])->name('reports.export');
Route::get('/reports/prdocts/download', [ReportController::class, 'exportProduct'])->name('reportProduct.exportProduct');

Route::prefix('banner')->controller(BannerListController::class)->group(function ()  {
    Route::get('/','index')->name('banner.index');
});

Route::middleware(['auth',])->prefix('/auth')->group(function () {
//add to cart
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('view','view')->name('cart.view');
    Route::post('store/{product}','store')->name('cart.store');
    Route::patch('update/{product}','update')->name('cart.update');
    Route::delete('delete/{product}','delete')->name('cart.delete');
    //chekcout
    Route::prefix('checkout')->controller(CheckoutController::class)->group((function()  {
    Route::get('payment','view')->name('checkout.view');
    Route::post('order','store')->name('checkout.store');
    Route::get('success','success')->name('checkout.success');
    Route::get('cancel','cancel')->name('checkout.cancel');
}));


});

});
//Supplier
Route::resource('/suppliers', SupplierController::class);

Route::delete('/products/image/{id}',[ProductController::class,'deleteImage'])->name('products.image.delete');
Route::delete('/products/destory/{id}',[ProductController::class,'destory'])->name('products.destory');
// Route::put('/products/update/{id}',[ProductController::class,'update'])->name('products.update'); // Duplicado - Route::resource ya crea esta ruta dentro de /admin


//routes for products list and filter
Route::prefix('products')->controller(ProductListController::class)->group(function ()  {
    Route::get('/','index')->name('productList.index');
});

//socialite route
Route::get('/auth/{provider}/redirect',[ProviderController::class,'redirect']);
Route::get('/auth/{provider}/callback',[ProviderController::class,'callback']);




Route::get('/your-page', function () {
    return Inertia::render('YourPage');
});
require __DIR__.'/auth.php';
