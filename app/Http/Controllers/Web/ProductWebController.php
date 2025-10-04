<?php

namespace App\Http\Controllers\Web;

use App\DTO\Product\StoreProductDto;
use App\DTO\Product\UpdateProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductWebController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryService $categoryService,
    ) {
    }

    public function index(Request $request): View
    {
        $perPage = (int) $request->integer('per_page', 15);
        $perPage = max(1, min($perPage, 100));

        $filters = [
            'search' => $request->string('search')->toString(),
            'category_id' => $request->filled('category_id') ? (int) $request->input('category_id') : null,
            'price_min' => $request->filled('price_min') ? $request->input('price_min') : null,
            'price_max' => $request->filled('price_max') ? $request->input('price_max') : null,
            'sort' => $request->query('sort'),
        ];

        if ($request->has('is_active')) {
            $filters['is_active'] = $request->input('is_active');
        }

        $filters = array_filter($filters, static fn ($value) => $value !== null && $value !== '');

        $products = $this->productService->paginate($filters, $perPage);

        $categoryOptions = $this->categoryService->activeList()
            ->pluck('name', 'id')
            ->toArray();

        $sortOptions = [
            'name' => __('Name (A-Z)'),
            '-price' => __('Price (high to low)'),
            '-created_at' => __('Newest first'),
        ];

        $viewFilters = [
            'search' => $request->query('search', ''),
            'category_id' => $request->query('category_id', ''),
            'is_active' => $request->query('is_active', ''),
            'price_min' => $request->query('price_min', ''),
            'price_max' => $request->query('price_max', ''),
            'sort' => $request->query('sort', ''),
            'per_page' => $perPage,
        ];

        return view('products.index', [
            'products' => $products,
            'filters' => $viewFilters,
            'categoryOptions' => $categoryOptions,
            'sortOptions' => $sortOptions,
        ]);
    }

    public function create(): View
    {
        $product = Product::make([
            'is_active' => true,
            'currency' => 'AMD',
            'quantity' => 0,
        ]);

        $categoriesForSelect = $this->categoryService->activeList()
            ->pluck('name', 'id')
            ->toArray();

        return view('products.create', [
            'product' => $product,
            'categoriesForSelect' => $categoriesForSelect,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $dto = StoreProductDto::fromRequest($request);
        $product = $this->productService->create($dto);

        return redirect()
            ->route('products.show', $product)
            ->with('success', __('Product created successfully.'));
    }

    public function show(Product $product): View
    {
        $product->load('category');

        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product): View
    {
        $product->load('category');

        $categories = $this->categoryService->activeList();
        if ($product->category && !$categories->contains('id', $product->category_id)) {
            $categories->push($product->category);
            $categories = $categories->sortBy('name');
        }

        $categoriesForSelect = $categories
            ->pluck('name', 'id')
            ->toArray();

        return view('products.edit', [
            'product' => $product,
            'categoriesForSelect' => $categoriesForSelect,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $dto = UpdateProductDto::fromRequest($request, $product);
        $updated = $this->productService->update($product, $dto);

        return redirect()
            ->route('products.show', $updated)
            ->with('success', __('Product updated successfully.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);

        return redirect()
            ->route('products.index')
            ->with('success', __('Product deleted successfully.'));
    }
}
