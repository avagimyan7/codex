<?php

namespace App\Services;

use App\DTO\Product\StoreProductDto;
use App\DTO\Product\UpdateProductDto;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        if ($filters === []) {
            return $this->productRepository->paginate($perPage);
        }

        return $this->productRepository->filterPaginate($filters, $perPage);
    }

    public function find(int $id): Product
    {
        return $this->productRepository->findById($id);
    }

    public function create(StoreProductDto $dto): Product
    {
        $slug = $this->prepareSlug($dto->slug, $dto->name);

        $preparedDto = new StoreProductDto(
            categoryId: $dto->categoryId,
            name: $dto->name,
            slug: $slug,
            sku: $dto->sku,
            price: $dto->price,
            currency: $dto->currency,
            quantity: $dto->quantity,
            isActive: $dto->isActive,
            description: $dto->description,
        );

        return $this->productRepository->create($preparedDto);
    }

    public function update(Product $product, UpdateProductDto $dto): Product
    {
        $slug = $this->prepareSlug($dto->slug, $dto->name, $product->id);

        $preparedDto = new UpdateProductDto(
            categoryId: $dto->categoryId,
            name: $dto->name,
            slug: $slug,
            sku: $dto->sku,
            price: $dto->price,
            currency: $dto->currency,
            quantity: $dto->quantity,
            isActive: $dto->isActive,
            description: $dto->description,
        );

        return $this->productRepository->update($product, $preparedDto);
    }

    public function delete(Product $product): void
    {
        $this->productRepository->delete($product);
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
        $query = Product::withTrashed()->where('slug', $slug);
        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
