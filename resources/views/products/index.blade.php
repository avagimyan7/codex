@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">{{ __('Products') }}</h1>
        <a href="{{ route('products.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
            {{ __('Create product') }}
        </a>
    </div>

    <div class="mt-6 rounded-lg bg-white p-6 shadow">
        <form method="GET" action="{{ route('products.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-form.input
                name="search"
                label="{{ __('Search') }}"
                :value="$filters['search'] ?? ''"
                placeholder="{{ __('Name, SKU or slug') }}"
            />
            <x-form.select
                name="category_id"
                label="{{ __('Category') }}"
                :value="$filters['category_id'] ?? ''"
                :options="$categoryOptions"
                placeholder="{{ __('Any category') }}"
            />
            <x-form.select
                name="is_active"
                label="{{ __('Status') }}"
                :value="$filters['is_active'] ?? ''"
                :options="['1' => __('Active'), '0' => __('Inactive')]"
                placeholder="{{ __('Any status') }}"
            />
            <x-form.select
                name="sort"
                label="{{ __('Sort by') }}"
                :value="$filters['sort'] ?? ''"
                :options="$sortOptions"
                placeholder="{{ __('Default') }}"
            />
            <x-form.input
                name="price_min"
                type="number"
                step="0.01"
                min="0"
                label="{{ __('Min price') }}"
                :value="$filters['price_min'] ?? ''"
            />
            <x-form.input
                name="price_max"
                type="number"
                step="0.01"
                min="0"
                label="{{ __('Max price') }}"
                :value="$filters['price_max'] ?? ''"
            />
            <x-form.select
                name="per_page"
                label="{{ __('Per page') }}"
                :value="$filters['per_page'] ?? 15"
                :options="[10 => 10, 15 => 15, 25 => 25, 50 => 50]"
            />
            <div class="sm:col-span-2 lg:col-span-4 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
                    {{ __('Filter') }}
                </button>
                <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    {{ __('Reset') }}
                </a>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-hidden rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('ID') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Name') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('SKU') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Price') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Quantity') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Category') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Status') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Created at') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $product->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-indigo-600">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $product->sku }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ number_format($product->price, 2) }} {{ $product->currency }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $product->quantity }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $product->category?->name ?? __('—') }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if ($product->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $product->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-amber-600 hover:text-amber-800">{{ __('Edit') }}</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-sm text-gray-500">{{ __('No products found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->withQueryString()->links() }}
    </div>
@endsection
