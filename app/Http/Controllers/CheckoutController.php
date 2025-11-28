<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\Cart_item;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Notification;

use App\Models\UserAddress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Notifications\PaymentNotification;
use App\Events\PaymentMade;
use App\Models\Delivery;

class CheckoutController extends Controller
{
    public function view(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            $cartItems = Cart_item::where('user_id', $user->id)->get();
            $cartAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
            $delivery = Delivery::get();
            //  $cartAddress = UserAddress::where('user_id',$user->id);
            if ($cartItems->count() > 0) {
                return Inertia::render(
                    'HomePage/Checkout',
                    [
                        'cartItems' => $cartItems,
                        'userAddress' => $cartAddress,
                        'deliverys' => $delivery,
                    ]
                );
            }
        } else {
            $cartItems = Cart::getCookieCartItems();
            if (count($cartItems) > 0) {
                $cartItems = new CartResource(Cart::getProductsAndCartItems());
                return Inertia::render('HomePage/Checkout', ['cartItems' => $cartItems]);
            } else {
                return redirect()->back();
            }
        }
        //  return Inertia::render('HomePage/Checkout');
    }
    public function store(Request $request)
    {
        $user = $request->user();
        $carts = $request->input('carts', []);
        $products = $request->input('products', []);

        // Decode JSON if necessary
        if (is_string($carts)) {
            $carts = json_decode($carts, true);
        }

        if (is_string($products)) {
            $products = json_decode($products, true);
        }

        // Ensure that carts and products are arrays
        if (!is_array($carts)) {
            return redirect()->route('home.index')->with('error', 'Formato de datos del carrito no válido.');
        }

        if (!is_array($products)) {
            return redirect()->route('home.index')->with('error', 'Formato de datos del producto no válido.');
        }

        $mergedData = [];

        // Loop through the "carts" array and merge with "products" data
        foreach ($carts as $cartItem) {
            foreach ($products as $product) {
                if (isset($cartItem["product_id"]) && isset($product["id"]) && $cartItem["product_id"] == $product["id"]) {
                    // Merge the cart item with product data
                    $mergedData[] = array_merge($cartItem, [
                        "title" => $product["title"],
                        'price' => $product['price']
                    ]);
                }
            }
        }

        $lineItems = [];
        foreach ($mergedData as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'khr',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => (int)($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Process address
        $newAddress = $request->input('address', []);
        if (!empty($newAddress['address'])) {
            UserAddress::where('isMain', 1)->update(['isMain' => 0]);
            $address = new UserAddress();
            $address->phone = $request->phone;
            $address->address = $request->address;
            $address->delivery = $request->delivery;
            $address->user_id = $user->id;
            $address->isMain = 1;
            $address->save();
        } else {
            UserAddress::where('isMain', 1)->update(['isMain' => 0]);
            $address = new UserAddress();
            $address->phone = $request->phone;
            $address->address = $request->address;
            $address->delivery = $request->delivery;
            $address->user_id = $user->id;
            $address->isMain = 1;
            $address->save();
        }

        // Clear cart items from cookies
        Cart::setCookieCartItems([]);

        // Fetch the main address
        $mainAddress = $user->user_address()->where('isMain', 1)->first();
        if ($mainAddress) {
            // Create the order
            $order = new Order();
            $order->status = '0';
            $order->total_price = $request->input('total', 0);
            $order->created_by = $user->id;
            $order->user_address_id = $mainAddress->id;
            $order->created_date = now();
            $order->save();

            // Process order items
            $cartItems = Cart_item::where('user_id', $user->id)->get();
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price,
                ]);
                $cartItem->delete();
            }

            // Handle imagepay file upload
            $imagepay = $request->file('imagepay') ? $request->file('imagepay')->store('imagepay', 'public') : null;

            // Create payment record
            $paymentData = [
                'order_id' => $order->id,
                'amount' => $request->input('total', 0),
                'address' => $request->address,
                'phone' => $request->phone,
                'delivery' => $request->delivery,
                'imagepay' => $imagepay,
                'status' => '1',
                'type' => 'QRCode',
                'created_date' => now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ];
            // Payment::create($paymentData);
            // Notify admin
            $payment = Payment::create($paymentData);

            //Notification
            $notificationData = [
                'order_id' => $order->id,
                'name' => $user->name,
                'address' => $request->address,
                'amount' => $request->input('total', 0),
                'created_date' => now(),
            ];
            $notification = Notification::create($notificationData);
        }

        // Return success message
        return redirect()->route('home.index')->with('success', '¡Pedido y pago creados exitosamente!');
    }
}
