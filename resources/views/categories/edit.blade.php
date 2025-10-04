@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('Categories') }}</a>
        <span class="mx-2">/</span>
        <a href="{{ route('categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-800">{{ $category->name }}</a>
        <span class="mx-2">/</span>
        <span>{{ __('Edit') }}</span>
    </nav>

    <div class="rounded-lg bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">{{ __('Edit category') }}</h1>
        <form action="{{ route('categories.update', $category) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PATCH')
            @include('categories._form', ['category' => $category, 'categoriesForSelect' => $categoriesForSelect])

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
                    {{ __('Save changes') }}
                </button>
                <a href="{{ route('categories.show', $category) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection
