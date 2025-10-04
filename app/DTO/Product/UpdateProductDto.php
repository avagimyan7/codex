<?php

namespace App\DTO\Product;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;

final readonly class UpdateProductDto
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

    public static function fromRequest(UpdateProductRequest $request, Product $product): self
    {
        $validated = $request->validated();

        return new self(
            categoryId: $validated['category_id'] ?? $product->category_id,
            name: $validated['name'] ?? $product->name,
            slug: $validated['slug'] ?? $product->slug,
            sku: $validated['sku'] ?? $product->sku,
            price: isset($validated['price']) ? (float) $validated['price'] : (float) $product->price,
            currency: $validated['currency'] ?? $product->currency,
            quantity: $validated['quantity'] ?? $product->quantity,
            isActive: $validated['is_active'] ?? $product->is_active,
            description: array_key_exists('description', $validated) ? $validated['description'] : $product->description,
        );
    }
}
