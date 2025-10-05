@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10 col-xl-8">
    <div class="card card-elevated border-0">
      <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">{{ __('Edit category') }}</h1>
        <span class="text-muted">#{{ $category->id }}</span>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('categories.update', $category) }}" method="POST">
          @include('categories._form', [
              'category' => $category,
              'categoriesForSelect' => $categoriesForSelect,
              'cancelUrl' => route('categories.show', $category),
              'method' => 'PUT',
          ])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
