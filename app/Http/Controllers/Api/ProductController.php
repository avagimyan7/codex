<?php

namespace App\Http\Controllers\Api;

use App\DTO\Product\StoreProductDto;
use App\DTO\Product\UpdateProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(Request $request): ProductCollection
    {
        $perPage = (int) $request->integer('per_page', 15);
        $perPage = max(1, min($perPage, 100));

        $filters = $request->only([
            'search',
            'category_id',
            'is_active',
            'price_min',
            'price_max',
            'sort',
        ]);

        $normalizedFilters = [];
        foreach ($filters as $key => $value) {
            if ($value === null) {
                continue;
            }
            if ($value === '' && $value !== '0') {
                continue;
            }
            $normalizedFilters[$key] = $value;
        }

        $products = $this->productService->paginate($normalizedFilters, $perPage);

        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $dto = StoreProductDto::fromRequest($request);

        $product = $this->productService->create($dto);

        return ProductResource::make($product)->response()->setStatusCode(201);
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product->load('category'));
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $dto = UpdateProductDto::fromRequest($request, $product);

        $updated = $this->productService->update($product, $dto);

        return ProductResource::make($updated);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->delete($product);

        return response()->json(null, 204);
    }
}
