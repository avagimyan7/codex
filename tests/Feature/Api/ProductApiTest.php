<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_product(): void
    {
        $category = Category::factory()->create();

        $payload = [
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'SKU12345',
            'price' => 199.99,
            'currency' => 'AMD',
            'quantity' => 10,
            'is_active' => true,
        ];

        $response = $this->postJson(route('api.v1.products.store'), $payload);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Test Product')
            ->assertJsonPath('data.category.id', $category->id);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'sku' => 'SKU12345',
        ]);
    }

    public function test_it_updates_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Old Name',
            'sku' => 'OLDSKU12',
            'price' => 100,
            'quantity' => 5,
        ]);

        $response = $this->putJson(route('api.v1.products.update', $product), [
            'name' => 'New Name',
            'sku' => 'NEWSKU34',
            'price' => 150.50,
            'quantity' => 8,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.name', 'New Name')
            ->assertJsonPath('data.price', 150.5)
            ->assertJsonPath('data.quantity', 8);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Name',
            'sku' => 'NEWSKU34',
            'price' => 150.50,
        ]);
    }

    public function test_it_shows_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Shown Product',
            'sku' => 'SHOWSKU1',
        ]);

        $response = $this->getJson(route('api.v1.products.show', $product));

        $response->assertOk()
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.category.id', $product->category_id);
    }

    public function test_it_lists_products_with_filters(): void
    {
        $categoryA = Category::factory()->create(['name' => 'Category A', 'slug' => 'category-a']);
        $categoryB = Category::factory()->create(['name' => 'Category B', 'slug' => 'category-b']);

        $matching = Product::factory()->create([
            'category_id' => $categoryA->id,
            'name' => 'Alpha Phone',
            'slug' => 'alpha-phone',
            'sku' => 'ALPHA001',
            'price' => 120,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'category_id' => $categoryA->id,
            'name' => 'Beta Tablet',
            'slug' => 'beta-tablet',
            'sku' => 'BETA002',
            'price' => 220,
            'is_active' => false,
        ]);

        Product::factory()->create([
            'category_id' => $categoryB->id,
            'name' => 'Gamma Laptop',
            'slug' => 'gamma-laptop',
            'sku' => 'GAMMA003',
            'price' => 320,
            'is_active' => true,
        ]);

        $response = $this->getJson(route('api.v1.products.index', [
            'search' => 'Alpha',
            'category_id' => $categoryA->id,
            'is_active' => 1,
            'price_min' => 100,
            'price_max' => 150,
        ]));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $matching->id);
    }

    public function test_it_sorts_products_by_price_desc(): void
    {
        $cheapest = Product::factory()->create(['price' => 100, 'sku' => 'CHEAP001']);
        $mid = Product::factory()->create(['price' => 200, 'sku' => 'MID001']);
        $expensive = Product::factory()->create(['price' => 300, 'sku' => 'EXPENS001']);

        $response = $this->getJson(route('api.v1.products.index', ['sort' => '-price']));

        $response->assertOk()
            ->assertJsonPath('data.0.id', $expensive->id)
            ->assertJsonPath('data.1.id', $mid->id)
            ->assertJsonPath('data.2.id', $cheapest->id);
    }

    public function test_it_deletes_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.v1.products.destroy', $product));

        $response->assertNoContent();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
