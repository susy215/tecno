<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Products;
// Excel
use App\Exports\PaymentExport;
use App\Exports\ProductReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Notification;
// use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
class ReportController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('Admin/Reports/ReportIndex', [
            'notifications' => Notification::get(),
            'contnitification' => Notification::count(),
            'payments' =>Payment::Sum('amount'),
            'payment' =>Payment::Count(),
            'products' =>Product::Sum('total_price'),
            'product' =>Product::Count(),
        ]);
    }

    public function SaleReport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Payment::with('order.createdBy');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $totalAmountQuery = clone $query;

        $payments = $query->get()->map(function ($payment) {
            if ($payment->imagepay) {
                $payment->imagepay = asset('storage/' . $payment->imagepay);
            }
            return $payment;
        });

        $totalAmount = $totalAmountQuery->sum('amount');

        $paymentCount = $query->count();

        return Inertia::render('Admin/Reports/SaleReport', [
            'notifications' => Notification::get(),
            'contnitification' => Notification::count(),
            'payments' => $payments,
            'totalAmount' => $totalAmount,
            'paymentCount' => $paymentCount,
            'filters' => $request->only(['start_date', 'end_date']),
        ]);
    }

    public function BuyReport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Product::with('product_images');

        if ($startDate && $endDate) {
            $query->whereBetween('created_date', [$startDate, $endDate]);
        }

        $products = $query->get(); // Execute the query to get the products
        $totalCost = $products->sum('total_cost');
        $totalPrice = $products->sum('total_price');  // Calculate the total amount
        $productCount = $products->count(); // Count the products

        return Inertia::render('Admin/Reports/BuyReport', [
            'notifications' => Notification::get(),
            'contnitification' => Notification::count(),
            'products' => $products,
            'totalCost' => $totalCost,
            'totalPrice' => $totalPrice,
            'filters' => $request->only(['start_date', 'end_date']),
        ]);
    }

public function show($id)
{
    $order = Order::with(['order_items.product.category', 'order_items.product.product_images','createdBy','user_address_id','payment'])
                  ->findOrFail($id);
                return Inertia::render('Admin/Orders/Show', [
        'order' => $order,
    ]);
}
public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => '1',
        ]);
    }
    public function updateToCancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => '0',
        ]);
        return redirect()->route('orders.index')->with('success', 'El estado del pedido se ha actualizado a pendiente con éxito.');
    }

 public function export(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        return Excel::download(new PaymentExport($start_date, $end_date), 'SaleReport.xlsx');
    }

 public function exportProduct(Request $request)
 {
     $start_date = $request->input('start_date');
     $end_date = $request->input('end_date');
     return Excel::download(new ProductReportExport($start_date, $end_date), 'ProductReport.xlsx');
 }


 public function CustomerReport(Request $request)
 {
     $startDate = $request->query('start_date');
     $endDate = $request->query('end_date');

     $query = Payment::with('order.createdBy');

     if ($startDate && $endDate) {
         $query->whereBetween('created_at', [$startDate, $endDate]);
     }

     $totalAmountQuery = clone $query;

     $payments = $query->get()->map(function ($payment) {
         if ($payment->imagepay) {
             $payment->imagepay = asset('storage/' . $payment->imagepay);
         }
         return $payment;
     });

     $totalAmount = $totalAmountQuery->sum('amount');

     $paymentCount = $query->count();

     return Inertia::render('Admin/Reports/CustomerReport', [
         'notifications' => Notification::get(),
         'contnitification' => Notification::count(),
         'payments' => $payments,
         'totalAmount' => $totalAmount,
         'paymentCount' => $paymentCount,
         'filters' => $request->only(['start_date', 'end_date']),
     ]);
 }
}
