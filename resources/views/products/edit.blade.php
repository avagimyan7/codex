@extends('layouts.app')

@section('content')
<x-flash />
<div class="container">
    <div class="card max-w-4xl mx-auto">
        <div class="card-header flex items-center justify-between">
            <span>{{ __('Edit product') }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
                @include('products._form', [
                    'product' => $product,
                    'categoriesForSelect' => $categoriesForSelect,
                    'cancelUrl' => route('products.show', $product),
                    'method' => 'PUT',
                ])
            </form>
        </div>
    </div>
</div>
@endsection
