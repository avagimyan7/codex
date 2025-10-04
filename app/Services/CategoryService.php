<?php

namespace App\Services;

use App\DTO\Category\StoreCategoryDto;
use App\DTO\Category\UpdateCategoryDto;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate($perPage);
    }

    public function find(int $id): Category
    {
        return $this->categoryRepository->findById($id);
    }

    public function create(StoreCategoryDto $dto): Category
    {
        $slug = $this->prepareSlug($dto->slug, $dto->name);

        $preparedDto = new StoreCategoryDto(
            name: $dto->name,
            slug: $slug,
            parentId: $dto->parentId,
            isActive: $dto->isActive,
        );

        return $this->categoryRepository->create($preparedDto);
    }

    public function update(Category $category, UpdateCategoryDto $dto): Category
    {
        $slug = $this->prepareSlug($dto->slug, $dto->name, $category->id);

        $preparedDto = new UpdateCategoryDto(
            name: $dto->name,
            slug: $slug,
            parentId: $dto->parentId,
            isActive: $dto->isActive,
        );

        return $this->categoryRepository->update($category, $preparedDto);
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }

    /**
     * @return array<int, mixed>
     */
    public function tree(): array
    {
        return $this->categoryRepository->tree();
    }

    private function prepareSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $baseSlug = $slug ? Str::slug($slug) : Str::slug($name);
        if ($baseSlug === '' || $baseSlug === null) {
            $baseSlug = Str::uuid()->toString();
        }

        $uniqueSlug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($uniqueSlug, $ignoreId)) {
            $uniqueSlug = $baseSlug.'-'.$counter++;
        }

        return $uniqueSlug;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = Category::withTrashed()->where('slug', $slug);
        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
