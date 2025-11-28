<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Http\Resources\UserResource;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Supplier;
use App\Models\Notification;


class AdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/AdminIndex',
        [
            'paymant'=>Payment::count(),
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
            'users' =>User::count(),
            'roles'=>Role::count(),
            'permissions'=>Permission::count(),
            'products'=>Product::count(),
            'staffs'=>Staff::count(),
            'categorys'=>Category::count(),
            'orders'=>Order::count(),
            'suppliers'=>Supplier::count(),
            'payments'=>Payment::sum('amount'),
            'productCost'=>Product::sum('total_cost'),

        ]
    );

    }
    public function clear(){
        Notification::truncate();
    }
}
