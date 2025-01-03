<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['men', 'women', 'kids']),
            'photo' => $this->faker->imageUrl,
            'price' => $this->faker->numberBetween(10, 1000),
            'rate' => $this->faker->randomFloat(1, 1, 5),
            'description' => $this->faker->paragraph,
            'color' => $this->faker->colorName,
            'category' => $this->faker->randomElement(['food', 'drink', 'clothe']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
