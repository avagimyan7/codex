@php
    $success = session('success');
    $error = session('error');
@endphp

@if($success)
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow">
        {{ $success }}
    </div>
@endif

@if($error)
    <div class="mb-4 bg-red-100 text-red-800 px-4 py-2 rounded-lg shadow">
        {{ $error }}
    </div>
@endif
