<?php

namespace App\Repositories\Eloquent;

use App\DTO\Category\StoreCategoryDto;
use App\DTO\Category\UpdateCategoryDto;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Category::query()->with('children')->paginate($perPage);
    }

    public function findById(int $id): Category
    {
        return Category::query()->with('children')->findOrFail($id);
    }

    public function create(StoreCategoryDto $dto): Category
    {
        $category = Category::query()->create([
            'name' => $dto->name,
            'slug' => $dto->slug,
            'parent_id' => $dto->parentId,
            'is_active' => $dto->isActive,
        ]);

        return $category->load('children');
    }

    public function update(Category $category, UpdateCategoryDto $dto): Category
    {
        $category->update([
            'name' => $dto->name,
            'slug' => $dto->slug,
            'parent_id' => $dto->parentId,
            'is_active' => $dto->isActive,
        ]);

        return $category->load('children');
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    public function tree(): array
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with(['children' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();

        return $this->buildTree($categories);
    }

    private function buildTree(Collection $categories, ?int $parentId = null): array
    {
        return $categories
            ->where('parent_id', $parentId)
            ->map(function (Category $category) use ($categories) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'parent_id' => $category->parent_id,
                    'is_active' => (bool) $category->is_active,
                    'children' => $this->buildTree($categories, $category->id),
                ];
            })
            ->values()
            ->all();
    }
}
