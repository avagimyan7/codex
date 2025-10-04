@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('Products') }}</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-800">{{ $product->name }}</a>
        <span class="mx-2">/</span>
        <span>{{ __('Edit') }}</span>
    </nav>

    <div class="rounded-lg bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">{{ __('Edit product') }}</h1>
        <form action="{{ route('products.update', $product) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PATCH')
            @include('products._form', ['product' => $product, 'categoriesForSelect' => $categoriesForSelect])

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
                    {{ __('Save changes') }}
                </button>
                <a href="{{ route('products.show', $product) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection
