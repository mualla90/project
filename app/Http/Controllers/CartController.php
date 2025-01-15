<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_Item;
use App\Models\Order;
use App\Models\Order_Detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart($id){
        $product=Product::find($id);
        $userId=Auth::user()->id;
        $cart=Cart::firstOrCreate([
            'user_id'=>$userId
        ]);
        $cart_item=Cart_Item::where('cart_id',$cart->id)->where('product_id',$id)->first();
         if($cart_item !== null){
             
             return response()->json([
                'success'=>true,
                'message'=>'product already in the cart',
             ]);
         }
          else{
            Cart_Item::create([
                'cart_id'=>$cart->id,
                'product_id'=>$id,
                'quantity'=>1,
                'price'=>$product->price,
            ]);
            return response()->json([    
                'message'=>'the product added successfully to cart',
            ],200); 
         }
    }
    public function showUserCart()
    {
        $user = Auth::user();
        $userCarts = $user->carts()->with('cartItems.product')->get();
        $cartDetails = $userCarts->map(function ($cart) {
                $products = $cart->cartItems->map(function ($cartItem) {
                    return [
                        'product_id' => $cartItem->product->id,
                        'product_name' => $cartItem->product->name,
                        'quantity' => $cartItem->quantity, 
                        'unit_price' => $cartItem->price,
                        'total_price' => $cartItem->price * $cartItem->quantity,
                    ];
                });
                
                return [
                    'cart_id' => $cart->id,
                    'products' => $products,
                ];
            });
        
        return response()->json($cartDetails);
    }
    public function confirmCart()
    {
        $user = Auth::user();
        $userCarts = $user->carts()->with('cartItems.product')->get();
        // return $userCarts;
        if($userCarts->isEmpty()){
            return response()->json([
                'message'=>'Cart is empty',
            ]);
        }
        
        foreach ($userCarts as $cart) {
            $totalAmount = $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->quantity;
            });
            
            $order = new Order();
            $order->user_id = $user->id;
            $order->order_date = now();
            $order->status = 'processing';
            $order->total_amount = $totalAmount;
            $order->save();
            
            foreach ($cart->cartItems as $cartItem) {
                $orderDetail = new Order_Detail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $cartItem->product->id;
                $orderDetail->quantity = $cartItem->quantity;
                $orderDetail->price = $cartItem->price;
                $orderDetail->save();

                // Update the stock quantity
                 $product = $cartItem->product;
                 $product->stock_quantity -= $cartItem->quantity;
                 $product->save();
            }
            $cart->cartItems()->delete();

            $cart->delete(); // Assuming you want to clear the cart after confirmation
        }
        
        return response()->json(['message' => 'Cart confirmed and order placed successfully.']);
    }
    
    
}

// public function showUserCart(){
//     $user=Auth::user();
//     $userCart=$user->carts()->with('cartItems')->get();
//     $cartItems = $userCart->pluck('cartItems')->flatten();
//     return response()->json($cartItems->pluck('quantity')->flatten());
//     return response()->json($userCart);
// }