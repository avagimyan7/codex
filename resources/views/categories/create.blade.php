@extends('layouts.app')

@section('content')
<x-flash />
<div class="container">
    <div class="card max-w-4xl mx-auto">
        <div class="card-header flex items-center justify-between">
            <span>{{ __('Create category') }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @include('categories._form', [
                    'category' => $category,
                    'categoriesForSelect' => $categoriesForSelect,
                    'cancelUrl' => route('categories.index'),
                ])
            </form>
        </div>
    </div>
</div>
@endsection
