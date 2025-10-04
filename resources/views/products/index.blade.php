@extends('layouts.app')

@section('content')
    <div class="not-prose space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">{{ __('Products') }}</h1>
                <p class="text-sm text-slate-500">{{ __('Oversee your inventory with quick access to stock status and pricing.') }}</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn-primary">
                {{ __('Create product') }}
            </a>
        </div>

        <div class="card space-y-4">
            <form method="GET" action="{{ route('products.index') }}" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-form.input
                    name="search"
                    label="{{ __('Search') }}"
                    :value="$filters['search'] ?? ''"
                    placeholder="{{ __('Name or SKU') }}"
                />
                <x-form.select
                    name="category_id"
                    label="{{ __('Category') }}"
                    :value="$filters['category_id'] ?? ''"
                    :options="$categoriesForSelect"
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
                    name="per_page"
                    label="{{ __('Per page') }}"
                    :value="$filters['per_page'] ?? 15"
                    :options="[10 => 10, 15 => 15, 25 => 25, 50 => 50]"
                />
                <div class="flex flex-wrap items-center gap-3 md:col-span-2 lg:col-span-1">
                    <button type="submit" class="btn-primary">
                        {{ __('Filter') }}
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-muted">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <div class="card not-prose p-0">
            <div class="overflow-x-auto">
                <table class="table-clean table-auto w-full border text-sm text-gray-700">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('ID') }}</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('SKU') }}</th>
                            <th scope="col">{{ __('Category') }}</th>
                            <th scope="col">{{ __('Price') }}</th>
                            <th scope="col">{{ __('Quantity') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Created at') }}</th>
                            <th scope="col" class="text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="font-medium text-blue-600">{{ $product->name }}</td>
                                <td class="text-slate-500">{{ $product->sku }}</td>
                                <td class="text-slate-500">{{ $product->category?->name ?? __('—') }}</td>
                                <td class="text-slate-500">{{ number_format($product->price, 2) }} {{ $product->currency }}</td>
                                <td class="text-slate-500">{{ $product->quantity }}</td>
                                <td>
                                    @if ($product->is_active)
                                        <span class="badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-slate-500">{{ $product->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-3 text-sm">
                                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-700">{{ __('View') }}</a>
                                        <a href="{{ route('products.edit', $product) }}" class="text-amber-600 hover:text-amber-700">{{ __('Edit') }}</a>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-slate-500">{{ __('No products found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="not-prose">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
@endsection
