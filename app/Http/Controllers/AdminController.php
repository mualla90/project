<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\ValidType;
use App\Rules\ValidCategory;
use App\Models\Product;
class AdminController extends Controller
{
    public function showUsers(){
        $users=User::all();
        return response()->json([
            'users'=>$users,
            'message'=>'users retrived successfully',
            'status'=>1,
        ]);
    }
    public function addProduct(Request $request){
        $product=$request->validate([
            'name'=>['required','string','max:10'],
            'type'=>['required',new ValidType],
            'photo'=>['required'],
            'color'=>['required'],
            'price'=>['required'],
            'rate'=>['required'],
            'description'=>['required'],
            'category'=>['required',new ValidCategory],
            'stock_quantity'=>['required'],
        ]);
        Product::create($product);
        return response()->json([
            'product'=>$product,
            'message'=>'product added successfully',
            'status'=>1,
        ]);
    }
    public function editProduct(Request $request,$id){
        $product=Product::findOrFail($id);
        $validatedData=$request->validate([
            'name'=>['required','string','max:10'],
            'type'=>['required',new ValidType],
            'photo'=>['required'],
            'color'=>['required'],
            'price'=>['required'],
            'rate'=>['required'],
            'description'=>['required'],
            'category'=>['required',new ValidCategory],
            'stock_quantity'=>['required'],
        ]);
        $product->update($validatedData);
        return response([
            'product'=>$product,
            'message'=>'the product updated successuflly',
            'status'=>1,
        ]);
    }
}
