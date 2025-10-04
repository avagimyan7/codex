@props([
    'name',
    'label',
    'value' => null,
    'rows' => 4,
    'placeholder' => null,
    'required' => false,
])

@php
    $fieldId = $attributes->get('id', $name);
    $fieldValue = old($name, $value);
@endphp

<div>
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <textarea
        id="{{ $fieldId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm']) }}
        @if($required) required @endif
    >{{ $fieldValue }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
