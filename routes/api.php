<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Bridge\AuthCode;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'Register']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('details', [AuthController::class, 'details']);
    Route::get('showStores',[StoreController::class,'index']);
    Route::get('showProducts',[ProductController::class,'index']);
    Route::post('searchProduct',[SearchController::class,'searchProduct']);
    Route::post('searchStore',[SearchController::class,'searchStore']);
    Route::post('showProductDetails/{id}',[ProductController::class,'showProduct']);
});
