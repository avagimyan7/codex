<?php

namespace App\DTO\Category;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;

final readonly class UpdateCategoryDto
{
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?int $parentId,
        public bool $isActive,
    ) {
    }

    public static function fromRequest(UpdateCategoryRequest $request, Category $category): self
    {
        $validated = $request->validated();

        return new self(
            name: $validated['name'] ?? $category->name,
            slug: $validated['slug'] ?? $category->slug,
            parentId: $validated['parent_id'] ?? $category->parent_id,
            isActive: $validated['is_active'] ?? $category->is_active,
        );
    }
}
