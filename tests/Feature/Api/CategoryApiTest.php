<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_category(): void
    {
        $payload = [
            'name' => 'Electronics',
            'is_active' => true,
        ];

        $response = $this->postJson(route('api.v1.categories.store'), $payload);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Electronics')
            ->assertJsonPath('data.is_active', true);

        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics',
        ]);
    }

    public function test_it_updates_category(): void
    {
        $category = Category::factory()->create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
        $parent = Category::factory()->create([
            'name' => 'Parent',
            'slug' => 'parent',
        ]);

        $response = $this->putJson(route('api.v1.categories.update', $category), [
            'name' => 'Smartphones',
            'parent_id' => $parent->id,
            'is_active' => false,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.name', 'Smartphones')
            ->assertJsonPath('data.parent_id', $parent->id)
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Smartphones',
            'parent_id' => $parent->id,
            'is_active' => false,
        ]);
    }

    public function test_it_lists_categories(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.categories.index'));

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_it_deletes_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson(route('api.v1.categories.destroy', $category));

        $response->assertNoContent();

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    public function test_it_returns_tree(): void
    {
        $parent = Category::factory()->create([
            'name' => 'Root',
            'slug' => 'root-category',
        ]);

        $child = Category::factory()->create([
            'name' => 'Child',
            'slug' => 'child-category',
            'parent_id' => $parent->id,
        ]);

        Category::factory()->create([
            'name' => 'Inactive',
            'slug' => 'inactive-category',
            'parent_id' => $parent->id,
            'is_active' => false,
        ]);

        $response = $this->getJson(route('api.v1.categories.tree'));

        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.children.0.id', $child->id)
            ->assertJsonMissing(['slug' => 'inactive-category']);
    }
}
