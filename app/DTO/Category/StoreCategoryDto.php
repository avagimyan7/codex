<?php

namespace App\DTO\Category;

use App\Http\Requests\Category\StoreCategoryRequest;

final readonly class StoreCategoryDto
{
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?int $parentId,
        public bool $isActive,
    ) {
    }

    public static function fromRequest(StoreCategoryRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            name: $validated['name'],
            slug: $validated['slug'] ?? null,
            parentId: $validated['parent_id'] ?? null,
            isActive: $validated['is_active'] ?? true,
        );
    }
}
