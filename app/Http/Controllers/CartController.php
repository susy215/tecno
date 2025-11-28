<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart_item;
use App\Helper\Cart;
use App\Models\Product;
use Inertia\Inertia;
use App\Http\Resources\CartResource;
use App\Models\UserAddress;


// use App\Http\Resources\CartResource;

class CartController extends Controller
{

    public function view(Request $request, Product $product)
    {
        $user = $request->user();
        if($user){
            $cartItems =Cart_item::where('user_id',$user->id)->get();
             $cartAddress = UserAddress::where('user_id',$user->id)->where('isMain',1)->first();
            if($cartItems->count() > 0){
                return Inertia::render(
                    'HomePage/CartList',[
                        'cartItems' => $cartItems,
                        'userAddress' => $cartAddress
                    ]
                );
            }

        }
        else{
            $cartItems = Cart::getCookieCartItems();
            if(count($cartItems)>0){
              $cartItems = new CartResource(Cart::getProductsAndCartItems());
              return Inertia::render('HomePage/CartList',['cartItems'=>$cartItems]);
            }else{
                return redirect()->back();
            }
        }
        // return Inertia::render('HomePage/CartList');
    }

    public function store(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();

        if ($user) {
            $cartItem = Cart_item::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if ($cartItem) {
                // Update the quantity
                $cartItem->increment('quantity', $quantity);
            } else {
                // Create a new cart item
                Cart_item::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // Handle guest users
            $cartItems = Cart::getCookieCartItems();
            $isProductExists = false;

            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    // Update the quantity
                    $item['quantity'] += $quantity;
                    $isProductExists = true;
                    break;
                }
            }

            if (!$isProductExists) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            Cart::setCookieCartItems($cartItems);
        }

        return redirect()->back()->with('success', 'Carrito actualizado exitosamente');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = $request->integer('quantity');
        $user = $request->user();
        if ($user) {
            Cart_item::where(['user_id' => $user->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);
        } else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
        }

        return redirect()->back();
    }
    public function delete(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            Cart_item::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first()?->delete();
            if (Cart_item::count() <= 0) {
                return redirect()->route('home.index')->with('info', 'Tu carrito está vacío');
            } else {
                return redirect()->back()->with('success', 'Artículo eliminado exitosamente');
            }
        } else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
            if (count($cartItems) <= 0) {
                return redirect()->route('home.index')->with('info', 'Tu carrito está vacío');
            } else {
                return redirect()->back()->with('success', 'Artículo eliminado exitosamente');
            }
        }
    }

}
