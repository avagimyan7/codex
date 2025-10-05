<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @php($hasViteBuild = file_exists(public_path('build/manifest.json')))
    @if($hasViteBuild)
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-nkO9ZAg/P6nxsVXniPdwWh05rq6ArtyTc95xJMu38xpv8uKXu95syEHCLEwM1c8I" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app-fallback.css') }}">
    @endif
</head>
<body class="app-gradient d-flex flex-column">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75 sticky-top shadow-sm" style="backdrop-filter: blur(12px);">
        <div class="container py-2">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#appNavbar" aria-controls="appNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="appNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-medium">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">{{ __('Products') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">{{ __('Categories') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container py-5">
            @if(session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>
    @if(!$hasViteBuild)
        <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js" integrity="sha384-o8zCwyKdnFnLKZg2nc9mNsLAO6WkcRPu0Nl3JErw/+IwIgrJXuDSs2LaXpUPc0kV" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kk+1TGVtC6nwL5Tx5ONx5Oxb0uJg1Q7mh+g/hqdAOov2K7P+h/rk1cxO7jLaQjhj" crossorigin="anonymous" defer></script>
        <script>
            window.axios = window.axios || axios;
            window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        </script>
    @endif
</body>
</html>
