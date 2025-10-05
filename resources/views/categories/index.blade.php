@extends('layouts.app')

@section('content')
<x-flash />
<div class="container">
    <div class="toolbar">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">+ {{ __('Create') }}</a>
        <form method="GET" class="flex flex-wrap gap-3 ml-auto">
            <input name="search" value="{{ request('search', $filters['search'] ?? '') }}" placeholder="{{ __('Search…') }}" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <select name="parent_id" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">{{ __('All parents') }}</option>
                @foreach($parentOptions ?? [] as $id => $name)
                    <option value="{{ $id }}" @selected((string)request('parent_id', $filters['parent_id'] ?? '') === (string)$id)>{{ $name }}</option>
                @endforeach
            </select>
            <select name="is_active" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">{{ __('Any status') }}</option>
                <option value="1" @selected(request('is_active', $filters['is_active'] ?? '') === '1')>{{ __('Active') }}</option>
                <option value="0" @selected(request('is_active', $filters['is_active'] ?? '') === '0')>{{ __('Inactive') }}</option>
            </select>
            <select name="per_page" class="field rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                @foreach([10,15,25,50] as $size)
                    <option value="{{ $size }}" @selected((int)request('per_page', $filters['per_page'] ?? 15) === $size)>{{ $size }} / {{ __('page') }}</option>
                @endforeach
            </select>
            <button class="btn btn-ghost">{{ __('Filter') }}</button>
            <a href="{{ route('categories.index') }}" class="btn btn-ghost">{{ __('Reset') }}</a>
        </form>
    </div>

    <x-card-table :title="__('Categories')">
        <div class="overflow-x-auto">
            <table class="pretty-table">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('ID / Slug') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Parent') }}</th>
                        <th>{{ __('Active') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-100 transition">
                            <td>{{ optional($category->created_at)->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="font-medium text-gray-900">#{{ $category->id }}</div>
                                <div class="text-xs text-gray-500">{{ $category->slug }}</div>
                            </td>
                            <td class="font-medium text-gray-900">{{ $category->name }}</td>
                            <td>{{ optional($category->parent)->name ?? '—' }}</td>
                            <td>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $category->is_active ? __('Yes') : __('No') }}
                                </span>
                            </td>
                            <td class="text-right space-x-2">
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-ghost">{{ __('View') }}</a>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-ghost">{{ __('Edit') }}</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Delete item?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-ghost text-red-600">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8">{{ __('No data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->withQueryString()->links() }}
        </div>
    </x-card-table>
</div>
@endsection
