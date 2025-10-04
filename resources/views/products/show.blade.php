@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('Products') }}</a>
        <span class="mx-2">/</span>
        <span>{{ $product->name }}</span>
    </nav>

    <div class="rounded-lg bg-white p-6 shadow">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">{{ $product->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('SKU') }}: {{ $product->sku }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center rounded-md border border-amber-300 bg-amber-50 px-3 py-2 text-sm font-medium text-amber-700 hover:bg-amber-100">
                    {{ __('Edit') }}
                </a>
                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-md border border-red-300 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>

        <dl class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Slug') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $product->slug ?? __('—') }}</dd>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Category') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $product->category?->name ?? __('—') }}</dd>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Price') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ number_format($product->price, 2) }} {{ $product->currency }}</dd>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Quantity') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $product->quantity }}</dd>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Status') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if ($product->is_active)
                        <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                    @else
                        <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">{{ __('Inactive') }}</span>
                    @endif
                </dd>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Created at') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at?->format('Y-m-d H:i') ?? __('—') }}</dd>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Updated at') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $product->updated_at?->format('Y-m-d H:i') ?? __('—') }}</dd>
            </div>
        </dl>

        @if ($product->description)
            <div class="mt-6 rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-600">{{ __('Description') }}</h2>
                <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                {{ __('Back to list') }}
            </a>
        </div>
    </div>
@endsection
