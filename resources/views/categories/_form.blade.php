@csrf
@if(($method ?? null) === 'PUT')
    @method('PUT')
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="slug">{{ __('Slug') }}</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $category->slug) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="parent_id">{{ __('Parent category') }}</label>
        <select id="parent_id" name="parent_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">{{ __('Root level') }}</option>
            @foreach($categoriesForSelect as $id => $name)
                <option value="{{ $id }}" @selected((string)old('parent_id', $category->parent_id) === (string)$id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex items-center gap-3">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->is_active)) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="is_active" class="text-sm font-medium text-gray-700">{{ __('Active') }}</label>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1" for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-ghost">{{ __('Cancel') }}</a>
</div>
