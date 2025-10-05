@extends('layouts.app')

@section('content')
    <div class="not-prose space-y-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-700">{{ __('Categories') }}</a>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </nav>

        <div class="card space-y-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div class="space-y-1">
                    <h1 class="text-3xl font-semibold text-slate-900">{{ $category->name }}</h1>
                    <p class="text-sm text-slate-500">{{ __('Slug') }}: {{ $category->slug ?? __('—') }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="btn-secondary">
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-muted text-red-600 hover:text-red-700">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>

            <dl class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Parent category') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $category->parent?->name ?? __('—') }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Status') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        @if ($category->is_active)
                            <span class="badge-success">{{ __('Active') }}</span>
                        @else
                            <span class="badge-danger">{{ __('Inactive') }}</span>
                        @endif
                    </dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Created at') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $category->created_at?->format('Y-m-d H:i') ?? __('—') }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Updated at') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $category->updated_at?->format('Y-m-d H:i') ?? __('—') }}</dd>
                </div>
            </dl>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('categories.index') }}" class="btn-muted">
                    {{ __('Back to list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
