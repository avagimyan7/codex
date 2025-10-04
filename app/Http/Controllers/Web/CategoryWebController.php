<?php

namespace App\Http\Controllers\Web;

use App\DTO\Category\StoreCategoryDto;
use App\DTO\Category\UpdateCategoryDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryWebController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    public function index(Request $request): View
    {
        $perPage = (int) $request->integer('per_page', 15);
        $perPage = max(1, min($perPage, 100));

        $filters = [
            'search' => $request->string('search')->toString(),
            'parent_id' => $request->filled('parent_id') ? (int) $request->input('parent_id') : null,
        ];

        if ($request->has('is_active')) {
            $filters['is_active'] = $request->input('is_active');
        }

        $filters = array_filter($filters, static fn ($value) => $value !== null && $value !== '');

        $categories = $this->categoryService->paginate($filters, $perPage);

        $parentOptions = $this->categoryService->activeList()
            ->pluck('name', 'id')
            ->toArray();

        $viewFilters = [
            'search' => $request->query('search', ''),
            'is_active' => $request->query('is_active', ''),
            'parent_id' => $request->query('parent_id', ''),
            'per_page' => $perPage,
        ];

        return view('categories.index', [
            'categories' => $categories,
            'filters' => $viewFilters,
            'parentOptions' => $parentOptions,
        ]);
    }

    public function create(): View
    {
        $category = Category::make(['is_active' => true]);

        $categoriesForSelect = $this->categoryService->activeList()
            ->pluck('name', 'id')
            ->toArray();

        return view('categories.create', [
            'category' => $category,
            'categoriesForSelect' => $categoriesForSelect,
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $dto = StoreCategoryDto::fromRequest($request);
        $category = $this->categoryService->create($dto);

        return redirect()
            ->route('categories.show', $category)
            ->with('success', __('Category created successfully.'));
    }

    public function show(Category $category): View
    {
        $category->load(['parent']);

        return view('categories.show', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category): View
    {
        $category->load('parent');

        $categoriesForSelect = $this->categoryService->activeList()
            ->reject(fn (Category $item) => $item->id === $category->id)
            ->pluck('name', 'id')
            ->toArray();

        return view('categories.edit', [
            'category' => $category,
            'categoriesForSelect' => $categoriesForSelect,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $dto = UpdateCategoryDto::fromRequest($request, $category);
        $updated = $this->categoryService->update($category, $dto);

        return redirect()
            ->route('categories.show', $updated)
            ->with('success', __('Category updated successfully.'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);

        return redirect()
            ->route('categories.index')
            ->with('success', __('Category deleted successfully.'));
    }
}
