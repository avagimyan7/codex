@extends('layouts.app')

@section('content')
    <div class="not-prose space-y-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700">{{ __('Products') }}</a>
            <span>/</span>
            <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-700">{{ $product->name }}</a>
            <span>/</span>
            <span>{{ __('Edit') }}</span>
        </nav>

        <div class="card space-y-6">
            <header class="space-y-1">
                <h1 class="text-3xl font-semibold text-slate-900">{{ __('Edit product') }}</h1>
                <p class="text-sm text-slate-500">{{ __('Update pricing, stock levels and descriptions for this product.') }}</p>
            </header>

            <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                @include('products._form', ['product' => $product, 'categoriesForSelect' => $categoriesForSelect])

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn-primary">
                        {{ __('Save changes') }}
                    </button>
                    <a href="{{ route('products.show', $product) }}" class="btn-muted">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
