<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return response()->json($products,200,['message'=>'all products']);
    }
    public function showProduct($id){
        $product=Product::find($id);
        return response()->json([
            'data'=>$product,
            'status'=>1,
            'message'=>'product details'
        ],200);
    }
}
