@extends('layouts.app')

@section('content')
<x-flash />
<div class="container">
    <div class="card max-w-4xl mx-auto">
        <div class="card-header flex items-center justify-between">
            <span>{{ __('Category details') }}</span>
            <div class="flex items-center gap-3">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-ghost text-white/90">{{ __('Edit') }}</a>
                <a href="{{ route('categories.index') }}" class="btn btn-ghost text-white/90">{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Name') }}</div>
                        <div class="text-lg font-semibold text-gray-900">{{ $category->name }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Slug') }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ $category->slug }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Parent') }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ optional($category->parent)->name ?? '—' }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Status') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ $category->is_active ? __('Active') : __('Inactive') }}</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Created at') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ optional($category->created_at)->format('Y-m-d H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Updated at') }}</div>
                        <div class="text-sm font-medium text-gray-800">{{ optional($category->updated_at)->format('Y-m-d H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ __('Description') }}</div>
                        <div class="prose prose-sm max-w-none text-gray-700">{!! nl2br(e($category->description ?? __('No description'))) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
