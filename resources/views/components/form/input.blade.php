@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
])

@php
    $fieldId = $attributes->get('id', $name);
    $fieldValue = old($name, $value);
@endphp

<div class="space-y-1">
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input
        id="{{ $fieldId }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $fieldValue }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-gray-300 bg-white text-sm shadow-sm transition focus:border-blue-500 focus:ring-blue-500']) }}
        @if($required) required @endif
    >
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
