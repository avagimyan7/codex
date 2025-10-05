@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10 col-xl-8">
    <div class="card card-elevated border-0">
      <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">{{ __('Edit product') }}</h1>
        <span class="text-muted">#{{ $product->id }}</span>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('products.update', $product) }}" method="POST">
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
</div>
@endsection
