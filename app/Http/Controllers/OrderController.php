<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showUserOrder(){
       $userId=Auth::user()->id;
        $orders=Order::where('user_id',$userId)->get();
            if($orders !== null){
            return response()->json([
                'orders'=>$orders,
                'message'=>'user does not have any order yet',
            ]);
        }
            else{
                return response()->json($orders);
            }
    }
    public function addUserCartToOrder(){
        
    }
}
