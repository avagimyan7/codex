@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">{{ __('Categories') }}</h1>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
            {{ __('Create category') }}
        </a>
    </div>

    <div class="mt-6 rounded-lg bg-white p-6 shadow">
        <form method="GET" action="{{ route('categories.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-form.input
                name="search"
                label="{{ __('Search') }}"
                :value="$filters['search'] ?? ''"
                placeholder="{{ __('Name or slug') }}"
            />
            <x-form.select
                name="is_active"
                label="{{ __('Status') }}"
                :value="$filters['is_active'] ?? ''"
                :options="['1' => __('Active'), '0' => __('Inactive')]"
                placeholder="{{ __('Any status') }}"
            />
            <x-form.select
                name="parent_id"
                label="{{ __('Parent category') }}"
                :value="$filters['parent_id'] ?? ''"
                :options="$parentOptions"
                placeholder="{{ __('Any parent') }}"
            />
            <x-form.select
                name="per_page"
                label="{{ __('Per page') }}"
                :value="$filters['per_page'] ?? 15"
                :options="[10 => 10, 15 => 15, 25 => 25, 50 => 50]"
            />
            <div class="sm:col-span-2 lg:col-span-4 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
                    {{ __('Filter') }}
                </button>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    {{ __('Reset') }}
                </a>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-hidden rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('ID') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Name') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Slug') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Parent') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Status') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Created at') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $category->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-indigo-600">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $category->parent?->name ?? __('—') }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if ($category->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $category->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                                <a href="{{ route('categories.edit', $category) }}" class="text-amber-600 hover:text-amber-800">{{ __('Edit') }}</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">{{ __('No categories found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->withQueryString()->links() }}
    </div>
@endsection
