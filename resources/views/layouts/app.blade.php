<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-app-gradient text-gray-900 min-h-screen flex flex-col">
    <div class="flex-1">
        <header class="py-6">
            <div class="max-w-6xl mx-auto px-4">
                <nav class="flex items-center justify-between bg-white/10 backdrop-blur rounded-2xl px-6 py-4 shadow-lg text-white">
                    <div class="text-lg font-semibold tracking-wide">{{ config('app.name', 'Dashboard') }}</div>
                    <div class="flex items-center gap-4 text-sm font-medium">
                        <a href="{{ route('products.index') }}" class="transition {{ request()->routeIs('products.*') ? 'text-white' : 'text-white/70 hover:text-white' }}">{{ __('Products') }}</a>
                        <a href="{{ route('categories.index') }}" class="transition {{ request()->routeIs('categories.*') ? 'text-white' : 'text-white/70 hover:text-white' }}">{{ __('Categories') }}</a>
                    </div>
                </nav>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-4 py-10">
            @yield('content')
        </main>
    </div>
</body>
</html>
