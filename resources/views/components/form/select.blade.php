@props([
    'name',
    'label',
    'options' => [],
    'value' => null,
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
    <select
        id="{{ $fieldId }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm']) }}
        @if($required) required @endif
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $fieldValue === (string) $optionValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
