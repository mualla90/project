<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Order_Detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDO;

class OrderController extends Controller
{
    public function showUserOrder(){
       $userId=Auth::user()->id;
        $orders=Order::where('user_id',$userId)->get();
            if($orders == null){
            return response()->json([
                'orders'=>$orders,
                'message'=>'user does not have any order yet',
            ]);
        }
        return response()->json([
            'userOrders'=>$orders,
            'message'=>'UserOrder successfully returned',
            'status'=>1
        ]);
    }
    
    public function cancelUserOrder($id){
    $user=Auth::user();
    $order=Order::where('user_id',$user->id)->where('id',$id)->first();
        if($order){
            Order_Detail::where('order_id',$id)->delete();
            $order->delete();
            return response()->json([
                'message'=>'order canceled successfully'
            ]);
        }
        else{
            return response()->json([
                'message'=>'order not found',
            ]);
        }
    }
    public function updateUserOrder(){

    }
}
