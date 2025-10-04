@extends('layouts.app')

@section('content')
    <div class="not-prose space-y-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700">{{ __('Products') }}</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </nav>

        <div class="card space-y-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div class="space-y-1">
                    <h1 class="text-3xl font-semibold text-slate-900">{{ $product->name }}</h1>
                    <p class="text-sm text-slate-500">{{ __('SKU') }}: {{ $product->sku }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="btn-secondary">
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
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
                    <dt class="text-sm font-medium text-slate-500">{{ __('Slug') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->slug ?? __('—') }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Category') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->category?->name ?? __('—') }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Price') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ number_format($product->price, 2) }} {{ $product->currency }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Quantity') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->quantity }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Status') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        @if ($product->is_active)
                            <span class="badge-success">{{ __('Active') }}</span>
                        @else
                            <span class="badge-danger">{{ __('Inactive') }}</span>
                        @endif
                    </dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Created at') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->created_at?->format('Y-m-d H:i') ?? __('—') }}</dd>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50/40 p-4">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Updated at') }}</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->updated_at?->format('Y-m-d H:i') ?? __('—') }}</dd>
                </div>
            </dl>

            @if ($product->description)
                <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-5">
                    <h2 class="text-lg font-semibold text-slate-800">{{ __('Description') }}</h2>
                    <p class="mt-2 whitespace-pre-line text-sm text-slate-700">{{ $product->description }}</p>
                </div>
            @endif

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('products.index') }}" class="btn-muted">
                    {{ __('Back to list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
