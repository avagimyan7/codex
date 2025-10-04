<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryTree = [
            'Electronics & Gadgets' => [
                'Smartphones & Tablets' => 12,
                'Computers & Laptops' => 10,
                'Audio & Headphones' => 8,
            ],
            'Home, Garden & DIY' => [
                'Kitchen Appliances' => 9,
                'Furniture & Decor' => 7,
                'Tools & Home Improvement' => 6,
            ],
            'Sports & Outdoor' => [
                'Fitness & Training' => 8,
                'Cycling & Mobility' => 6,
                'Camping & Hiking' => 6,
            ],
        ];

        foreach ($categoryTree as $rootName => $children) {
            $rootCategory = Category::factory()
                ->active()
                ->create([
                    'name' => $rootName,
                    'slug' => Str::slug($rootName),
                    'parent_id' => null,
                ]);

            Product::factory()
                ->count(3)
                ->active()
                ->pricedBetween(150000, 650000)
                ->for($rootCategory)
                ->state(new Sequence(
                    ['currency' => 'AMD'],
                    ['currency' => 'USD'],
                    ['currency' => 'EUR'],
                ))
                ->create();

            foreach ($children as $childName => $productCount) {
                $childCategory = Category::factory()
                    ->active()
                    ->childOf($rootCategory)
                    ->create([
                        'name' => $childName,
                        'slug' => Str::slug($rootName.'-'.$childName),
                    ]);

                Product::factory()
                    ->count(max(1, $productCount - 1))
                    ->active()
                    ->pricedBetween(10000, 350000)
                    ->for($childCategory)
                    ->state(new Sequence(
                        ['currency' => 'AMD'],
                        ['currency' => 'USD'],
                        ['currency' => 'AMD'],
                        ['currency' => 'EUR'],
                    ))
                    ->create();

                Product::factory()
                    ->inactive()
                    ->lowStock()
                    ->inCurrency('AMD')
                    ->for($childCategory)
                    ->create();
            }

            Category::factory()
                ->inactive()
                ->childOf($rootCategory)
                ->create([
                    'name' => $rootName.' Clearance',
                    'slug' => Str::slug($rootName.'-clearance'),
                ]);
        }
    }
}
