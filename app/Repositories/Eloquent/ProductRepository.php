<?php

namespace App\Repositories\Eloquent;

use App\DTO\Product\StoreProductDto;
use App\DTO\Product\UpdateProductDto;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Product::query()->with('category')->paginate($perPage);
    }

    public function filterPaginate(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query()->with('category');

        $query = $this->applyFilters($query, $filters);

        $perPage = max(1, min($perPage, 100));

        return $query->paginate($perPage)->appends($filters);
    }

    public function findById(int $id): Product
    {
        return Product::query()->with('category')->findOrFail($id);
    }

    public function create(StoreProductDto $dto): Product
    {
        $product = Product::query()->create([
            'category_id' => $dto->categoryId,
            'name' => $dto->name,
            'slug' => $dto->slug,
            'sku' => $dto->sku,
            'price' => $dto->price,
            'currency' => $dto->currency,
            'quantity' => $dto->quantity,
            'is_active' => $dto->isActive,
            'description' => $dto->description,
        ]);

        return $product->load('category');
    }

    public function update(Product $product, UpdateProductDto $dto): Product
    {
        $product->update([
            'category_id' => $dto->categoryId,
            'name' => $dto->name,
            'slug' => $dto->slug,
            'sku' => $dto->sku,
            'price' => $dto->price,
            'currency' => $dto->currency,
            'quantity' => $dto->quantity,
            'is_active' => $dto->isActive,
            'description' => $dto->description,
        ]);

        return $product->load('category');
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (array_key_exists('is_active', $filters) && $filters['is_active'] !== null && $filters['is_active'] !== '') {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        if (array_key_exists('price_min', $filters) && $filters['price_min'] !== null && $filters['price_min'] !== '') {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (array_key_exists('price_max', $filters) && $filters['price_max'] !== null && $filters['price_max'] !== '') {
            $query->where('price', '<=', $filters['price_max']);
        }

        if (!empty($filters['sort'])) {
            $this->applySort($query, $filters['sort']);
        } else {
            $query->orderByDesc('created_at');
        }

        return $query;
    }

    private function applySort(Builder $query, string $sort): void
    {
        $fields = array_map('trim', explode(',', $sort));
        $allowed = ['name', 'price', 'created_at', 'quantity'];

        foreach ($fields as $field) {
            if ($field === '') {
                continue;
            }

            $direction = str_starts_with($field, '-') ? 'desc' : 'asc';
            $column = ltrim($field, '-');

            if (in_array($column, $allowed, true)) {
                $query->orderBy($column, $direction);
            }
        }
    }
}
