<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'order_date',
        'status',
        'total_amount',
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
