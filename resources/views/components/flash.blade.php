@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded shadow-sm border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded shadow-sm border border-red-200">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-3 rounded shadow-sm border border-red-200">
        <p class="font-semibold">{{ __('Please fix the following errors:') }}</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
