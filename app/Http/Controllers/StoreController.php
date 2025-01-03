<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(){
        $stores=Store::all();
        return response()->json($stores,200,['message'=>'all stores']);
    }
}
