<?php

namespace App\Repositories\Eloquent;

use App\DTO\Category\StoreCategoryDto;
use App\DTO\Category\UpdateCategoryDto;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Category::query()->with('parent')->paginate($perPage);
    }

    public function filterPaginate(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Category::query()->with('parent');

        $query = $this->applyFilters($query, $filters);

        $perPage = max(1, min($perPage, 100));

        return $query->paginate($perPage)->appends($filters);
    }

    public function findById(int $id): Category
    {
        return Category::query()->with(['children', 'parent'])->findOrFail($id);
    }

    public function create(StoreCategoryDto $dto): Category
    {
        $category = Category::query()->create([
            'name' => $dto->name,
            'slug' => $dto->slug,
            'parent_id' => $dto->parentId,
            'is_active' => $dto->isActive,
        ]);

        return $category->load(['children', 'parent']);
    }

    public function update(Category $category, UpdateCategoryDto $dto): Category
    {
        $category->update([
            'name' => $dto->name,
            'slug' => $dto->slug,
            'parent_id' => $dto->parentId,
            'is_active' => $dto->isActive,
        ]);

        return $category->load(['children', 'parent']);
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

    public function getActiveList(): Collection
    {
        return Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
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

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if (array_key_exists('is_active', $filters) && $filters['is_active'] !== null && $filters['is_active'] !== '') {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        if (!empty($filters['parent_id'])) {
            $query->where('parent_id', $filters['parent_id']);
        }

        return $query->orderBy('name');
    }
}
