<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductWebControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_products(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertViewIs('products.index');
    }

    public function test_store_creates_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('products.store'), [
            'category_id' => $category->id,
            'name' => 'Test product',
            'slug' => 'test-product',
            'sku' => 'SKU12345',
            'price' => 199.99,
            'currency' => 'USD',
            'quantity' => 5,
            'is_active' => 1,
            'description' => 'Short description',
        ]);

        $createdProduct = Product::where('sku', 'SKU12345')->first();
        self::assertNotNull($createdProduct);

        $response->assertRedirect(route('products.show', $createdProduct));
        $this->assertDatabaseHas('products', [
            'sku' => 'SKU12345',
            'category_id' => $category->id,
        ]);
    }
}
