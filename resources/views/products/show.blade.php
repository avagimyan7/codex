@extends('layouts.app')

@section('content')
<x-flash />
<div class="container">
    <div class="card max-w-4xl mx-auto">
        <div class="card-header flex items-center justify-between">
            <span>{{ __('Product details') }}</span>
            <div class="flex items-center gap-3">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-ghost text-white/90">{{ __('Edit') }}</a>
                <a href="{{ route('products.index') }}" class="btn btn-ghost text-white/90">{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Name') }}</div>
                        <div class="text-lg font-semibold text-gray-900">{{ $product->name }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('SKU') }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ $product->sku ?: '—' }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Slug') }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ $product->slug }}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Price') }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ number_format($product->price, 2) }} {{ $product->currency }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Quantity') }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ $product->quantity }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Category') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ optional($product->category)->name ?? __('Unassigned') }}</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Status') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ $product->is_active ? __('Active') : __('Inactive') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Created at') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ optional($product->created_at)->format('Y-m-d H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Updated at') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ optional($product->updated_at)->format('Y-m-d H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Description') }}</div>
                        <div class="prose prose-sm max-w-none text-gray-700">{!! nl2br(e($product->description ?? __('No description'))) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
