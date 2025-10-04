<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numberBetween(1, 99999),
            'sku' => strtoupper(Str::random(8)).$this->faker->unique()->numberBetween(100, 999),
            'price' => $this->faker->randomFloat(2, 10, 9999),
            'currency' => 'AMD',
            'quantity' => $this->faker->numberBetween(0, 1000),
            'is_active' => $this->faker->boolean(90),
            'description' => $this->faker->sentence(),
        ];
    }
}
