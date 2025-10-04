@php
    /** @var \App\Models\Category $category */
    $parentOptions = $categoriesForSelect ?? [];
@endphp

<div class="grid gap-4 sm:grid-cols-2">
    <x-form.input
        name="name"
        :value="$category->name"
        label="{{ __('Name') }}"
        required
    />
    <x-form.input
        name="slug"
        :value="$category->slug"
        label="{{ __('Slug') }}"
        placeholder="{{ __('Auto-generated if empty') }}"
    />
</div>
<div class="grid gap-4 sm:grid-cols-2 mt-4">
    <x-form.select
        name="parent_id"
        :value="$category->parent_id"
        label="{{ __('Parent category') }}"
        :options="$parentOptions"
        placeholder="{{ __('No parent') }}"
    />
    <x-form.select
        name="is_active"
        :value="$category->is_active ?? true"
        label="{{ __('Status') }}"
        :options="[1 => __('Active'), 0 => __('Inactive')]"
    />
</div>
