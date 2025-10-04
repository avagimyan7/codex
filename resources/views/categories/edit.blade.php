@extends('layouts.app')

@section('content')
    <div class="not-prose space-y-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-700">{{ __('Categories') }}</a>
            <span>/</span>
            <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-700">{{ $category->name }}</a>
            <span>/</span>
            <span>{{ __('Edit') }}</span>
        </nav>

        <div class="card space-y-6">
            <header class="space-y-1">
                <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit category') }}</h1>
                <p class="text-sm text-slate-500">{{ __('Update category details and hierarchy placement.') }}</p>
            </header>

            <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                @include('categories._form', ['category' => $category, 'categoriesForSelect' => $categoriesForSelect])

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn-primary">
                        {{ __('Save changes') }}
                    </button>
                    <a href="{{ route('categories.show', $category) }}" class="btn-muted">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
