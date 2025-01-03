<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProduct(Request $request){
        $query = $request->input('query');
        $product = Product::where('name', 'like', "%$query%") ->orWhere('category', 'like', "%$query%") ->get();
        if($product->isNotEmpty()){
            return response()->json([
                'data'=>$product,
                'status'=>1,
                'message'=>'successful search',
            ],200);
        }
        else{
            return response()->json([
                'data'=>[],
                'status'=>0,
                'message'=>'product not found',
            ],404);
        }
    }
    public function searchStore(Request $request)
    {
        $query = $request->input('query');
        $store = Store::where('name', 'like', "%$query%")
                      ->orWhere('location', 'like', "%$query%")
                      ->get();
        
        if ($store->isNotEmpty()) {
            return response()->json([
                'data' => $store,
                'status' => 1,
                'message' => 'successful search',
            ]);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'store not found',
            ]);
        }
    }
    

}

