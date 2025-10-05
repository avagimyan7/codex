@php
    /** @var \App\Models\Product $product */
    $categoryOptions = $categoriesForSelect ?? [];
    $currencyOptions = ['AMD' => 'AMD', 'USD' => 'USD', 'EUR' => 'EUR'];
@endphp

<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-form.select
            name="category_id"
            :value="$product->category_id"
            label="{{ __('Category') }}"
            :options="$categoryOptions"
            placeholder="{{ __('Select category') }}"
            required
        />
        <x-form.input
            name="name"
            :value="$product->name"
            label="{{ __('Name') }}"
            required
        />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-form.input
            name="slug"
            :value="$product->slug"
            label="{{ __('Slug') }}"
            placeholder="{{ __('Auto-generated if empty') }}"
        />
        <x-form.input
            name="sku"
            :value="$product->sku"
            label="{{ __('SKU') }}"
            required
        />
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <x-form.input
            name="price"
            type="number"
            step="0.01"
            min="0"
            :value="$product->price"
            label="{{ __('Price') }}"
            required
        />
        <x-form.select
            name="currency"
            :value="$product->currency ?? 'AMD'"
            label="{{ __('Currency') }}"
            :options="$currencyOptions"
            required
        />
        <x-form.input
            name="quantity"
            type="number"
            min="0"
            :value="$product->quantity ?? 0"
            label="{{ __('Quantity') }}"
        />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-form.select
            name="is_active"
            :value="$product->is_active ?? true"
            label="{{ __('Status') }}"
            :options="[1 => __('Active'), 0 => __('Inactive')]"
        />
    </div>

    <div>
        <x-form.textarea
            name="description"
            :value="$product->description"
            label="{{ __('Description') }}"
            rows="5"
            placeholder="{{ __('Describe the product...') }}"
        />
    </div>
</div>
