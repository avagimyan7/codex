<?php

namespace App\Repositories\Interfaces;

use App\DTO\Category\StoreCategoryDto;
use App\DTO\Category\UpdateCategoryDto;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): Category;

    public function create(StoreCategoryDto $dto): Category;

    public function update(Category $category, UpdateCategoryDto $dto): Category;

    public function delete(Category $category): void;

    /**
     * @return array<int, mixed>
     */
    public function tree(): array;
}
