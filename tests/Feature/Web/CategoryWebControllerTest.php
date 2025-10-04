<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryWebControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_categories(): void
    {
        Category::factory()->create();

        $response = $this->get(route('categories.index'));

        $response->assertOk();
        $response->assertViewIs('categories.index');
    }

    public function test_store_creates_category(): void
    {
        $parent = Category::factory()->create();

        $response = $this->post(route('categories.store'), [
            'name' => 'New Category',
            'slug' => 'new-category',
            'parent_id' => $parent->id,
            'is_active' => 1,
        ]);

        $createdCategory = Category::where('name', 'New Category')->first();
        self::assertNotNull($createdCategory);

        $response->assertRedirect(route('categories.show', $createdCategory));
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'parent_id' => $parent->id,
        ]);
    }
}
