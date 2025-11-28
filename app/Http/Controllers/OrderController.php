<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Notification;
use App\Models\Product;
// use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Order::with(['orderItems.product.category', 'createdBy', 'userAddress', 'payment']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_date', [$startDate, $endDate]);
        }

        $orders = $query->paginate(10);

        return Inertia::render('Admin/Orders/OrderIndex', [
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
            'orders' => $orders,
            'filters' => $request->only(['start_date', 'end_date']),
        ]);
    }

    public function show($id)
    {
        $order = Order::with([
            'orderItems.product.category',
            'orderItems.product.product_images',
            'createdBy',
            'userAddress',
            'payment'
        ])->findOrFail($id);

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }


public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => '1',
            'updated_date'=>now(),
        ]);
      return redirect()->route('orders.index')->with('success', '¡El envío de la factura al cliente se ha realizado con éxito!');
    }

    public function updateToCancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => '0',
            'updated_date'=>now(),
        ]);
        return redirect()->route('orders.index')->with('dsuccess', '¡El estado del pedido ha sido actualizado a pendiente con éxito!');
    }

}




