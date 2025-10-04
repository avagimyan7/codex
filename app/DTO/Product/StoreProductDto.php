<?php

namespace App\DTO\Product;

use App\Http\Requests\Product\StoreProductRequest;

final readonly class StoreProductDto
{
    public function __construct(
        public int $categoryId,
        public string $name,
        public ?string $slug,
        public string $sku,
        public float $price,
        public string $currency,
        public int $quantity,
        public bool $isActive,
        public ?string $description,
    ) {
    }

    public static function fromRequest(StoreProductRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            categoryId: $validated['category_id'],
            name: $validated['name'],
            slug: $validated['slug'] ?? null,
            sku: $validated['sku'],
            price: (float) $validated['price'],
            currency: $validated['currency'] ?? 'AMD',
            quantity: $validated['quantity'] ?? 0,
            isActive: $validated['is_active'] ?? true,
            description: $validated['description'] ?? null,
        );
    }
}
