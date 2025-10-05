<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="container-page flex flex-col gap-4 py-4 md:flex-row md:items-center md:justify-between">
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-blue-600 text-white text-xl font-bold shadow-sm">LC</span>
                    <div class="leading-tight">
                        <span class="block text-lg font-semibold">{{ config('app.name', 'Laravel') }}</span>
                        <span class="block text-sm text-slate-500">{{ __('Inventory Dashboard') }}</span>
                    </div>
                </a>
                <nav class="flex items-center gap-2">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center rounded-md px-4 py-2 text-sm font-medium transition {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-blue-50' }}">
                        {{ __('Products') }}
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center rounded-md px-4 py-2 text-sm font-medium transition {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-blue-50' }}">
                        {{ __('Categories') }}
                    </a>
                </nav>
            </div>
        </header>

        <main class="flex-1 py-10">
            <div class="container-page space-y-6">
                @include('components.flash')
                <div class="prose prose-slate max-w-none">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="container-page py-4 text-sm text-slate-500">
                &copy; {{ now()->year }} {{ config('app.name', 'Laravel') }}. {{ __('All rights reserved.') }}
            </div>
        </footer>
    </div>
</body>

</html>
