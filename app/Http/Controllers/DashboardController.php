<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Build the query
        $query = Order::with(['orderItems.product.category', 'orderItems.product.product_images'])
            ->where('created_by', $user->id);

        // Apply status filter if it's not "All"
        if ($request->has('status') && $request->input('status') !== '' && $request->input('status') !== 'All') {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        // Execute the query
        $orders = $query->get();

        return Inertia::render('HomePage/Dashboard', ['orders' => $orders]);
    }

}
