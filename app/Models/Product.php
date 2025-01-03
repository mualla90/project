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
        'category',
    ];
}
