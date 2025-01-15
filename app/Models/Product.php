<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'type',
        'photo',
        'price',
        'rate',
        'size',
        'description',
        'color',
        'stock_quantity',
        'category',
    ];
    public function carts(){
        return $this->belongsToMany(Cart::class,'cart_items')->withPivot('quantity','price');
    }
    public function orders(){
        return $this->belongsToMany(Order::class);
    }
}
