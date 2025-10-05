@extends('layouts.app')

@section('content')
<x-flash />
<div class="container">
    <div class="toolbar">
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ {{ __('Create') }}</a>
        <form method="GET" class="flex flex-wrap gap-3 ml-auto">
            <input name="search" value="{{ request('search', $filters['search'] ?? '') }}" placeholder="{{ __('Search…') }}" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <select name="category_id" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">{{ __('All categories') }}</option>
                @foreach($categoryOptions ?? [] as $id => $name)
                    <option value="{{ $id }}" @selected((string)request('category_id', $filters['category_id'] ?? '') === (string)$id)>{{ $name }}</option>
                @endforeach
            </select>
            <select name="is_active" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">{{ __('Any status') }}</option>
                <option value="1" @selected(request('is_active', $filters['is_active'] ?? '') === '1')>{{ __('Active') }}</option>
                <option value="0" @selected(request('is_active', $filters['is_active'] ?? '') === '0')>{{ __('Inactive') }}</option>
            </select>
            <input type="number" step="0.01" name="price_min" value="{{ request('price_min', $filters['price_min'] ?? '') }}" placeholder="{{ __('Min price') }}" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <input type="number" step="0.01" name="price_max" value="{{ request('price_max', $filters['price_max'] ?? '') }}" placeholder="{{ __('Max price') }}" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <select name="sort" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">{{ __('Sort by') }}</option>
                @foreach(($sortOptions ?? []) as $value => $label)
                    <option value="{{ $value }}" @selected(request('sort', $filters['sort'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="per_page" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                @foreach([10,15,25,50] as $size)
                    <option value="{{ $size }}" @selected((int)request('per_page', $filters['per_page'] ?? 15) === $size)>{{ $size }} / {{ __('page') }}</option>
                @endforeach
            </select>
            <button class="btn btn-ghost">{{ __('Filter') }}</button>
            <a href="{{ route('products.index') }}" class="btn btn-ghost">{{ __('Reset') }}</a>
        </form>
    </div>

    <x-card-table :title="__('Products')">
        <div class="overflow-x-auto">
            <table class="pretty-table">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('SKU') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr class="hover:bg-gray-100 transition">
                            <td>{{ optional($p->created_at)->format('Y-m-d H:i') }}</td>
                            <td>{{ $p->sku }}</td>
                            <td class="font-medium text-gray-900">{{ $p->name }}</td>
                            <td>{{ number_format($p->price, 2) }} {{ $p->currency }}</td>
                            <td>{{ $p->quantity }}</td>
                            <td class="text-right space-x-2">
                                <a href="{{ route('products.show', $p) }}" class="btn btn-ghost">{{ __('View') }}</a>
                                <a href="{{ route('products.edit', $p) }}" class="btn btn-ghost">{{ __('Edit') }}</a>
                                <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Delete item?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-ghost text-red-600">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8">{{ __('No data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </x-card-table>
</div>
@endsection
