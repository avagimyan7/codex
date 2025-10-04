<?php

namespace App\Repositories\Interfaces;

use App\DTO\Product\StoreProductDto;
use App\DTO\Product\UpdateProductDto;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function filterPaginate(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): Product;

    public function create(StoreProductDto $dto): Product;

    public function update(Product $product, UpdateProductDto $dto): Product;

    public function delete(Product $product): void;
}
