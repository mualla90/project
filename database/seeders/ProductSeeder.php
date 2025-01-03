<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'T-Shirt',
            'type' => 'men',
            'photo' => 'tshirt.jpg',
            'price' => 100,
            'rate' => '4.5',
            'description' => 'A comfortable cotton t-shirt',
            'color' => 'blue',
            'category' => 'clothe',
            'created_at' => now(),
            'updated_at' => now()
    ]);
    }
}
