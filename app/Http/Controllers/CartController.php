<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_Item;
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
            ]); 
         }
    }
}
