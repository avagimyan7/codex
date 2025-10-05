@extends('layouts.app')

@section('content')
    <div class="not-prose space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">{{ __('Categories') }}</h1>
                <p class="text-sm text-slate-500">{{ __('Manage hierarchical groups to organise your product catalogue.') }}</p>
            </div>
            <a href="{{ route('categories.create') }}" class="btn-primary">
                {{ __('Create category') }}
            </a>
        </div>

        <div class="card space-y-4">
            <form method="GET" action="{{ route('categories.index') }}" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
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
                <div class="flex flex-wrap items-center gap-3 md:col-span-2 lg:col-span-1">
                    <button type="submit" class="btn-primary">
                        {{ __('Filter') }}
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn-muted">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <div class="card not-prose p-0">
            <div class="overflow-x-auto">
                <table class="table-clean table-auto w-full border text-sm text-gray-700">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('ID') }}</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Slug') }}</th>
                            <th scope="col">{{ __('Parent') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Created at') }}</th>
                            <th scope="col" class="text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td class="font-medium text-blue-600">{{ $category->name }}</td>
                                <td class="text-slate-500">{{ $category->slug }}</td>
                                <td class="text-slate-500">{{ $category->parent?->name ?? __('—') }}</td>
                                <td>
                                    @if ($category->is_active)
                                        <span class="badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-slate-500">{{ $category->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-3 text-sm">
                                        <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-700">{{ __('View') }}</a>
                                        <a href="{{ route('categories.edit', $category) }}" class="text-amber-600 hover:text-amber-700">{{ __('Edit') }}</a>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-500">{{ __('No categories found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="not-prose">
            {{ $categories->withQueryString()->links() }}
        </div>
    </div>
@endsection
