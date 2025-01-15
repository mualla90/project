<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;
use PhpParser\Node\Expr\FuncCall;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function cartItems(){
        return $this->hasMany(Cart_Item::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class,'cart_items')->withPivot('quantity','price');
    }
}
