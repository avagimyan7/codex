<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('categories.index') }}" class="text-lg font-semibold text-indigo-600">
                {{ config('app.name', __('Dashboard')) }}
            </a>
            <nav class="space-x-4">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    {{ __('Categories') }}
                </a>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    {{ __('Products') }}
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @include('components.flash')
        @yield('content')
    </main>
</body>
</html>
