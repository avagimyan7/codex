@csrf
@if(($method ?? null) === 'PUT')
    @method('PUT')
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="slug">{{ __('Slug') }}</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="sku">{{ __('SKU') }}</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="category_id">{{ __('Category') }}</label>
        <select id="category_id" name="category_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">{{ __('Select category') }}</option>
            @foreach($categoriesForSelect as $id => $name)
                <option value="{{ $id }}" @selected((string)old('category_id', $product->category_id) === (string)$id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="price">{{ __('Price') }}</label>
        <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="currency">{{ __('Currency') }}</label>
            <input id="currency" name="currency" type="text" value="{{ old('currency', $product->currency) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="quantity">{{ __('Quantity') }}</label>
            <input id="quantity" name="quantity" type="number" value="{{ old('quantity', $product->quantity) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1" for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="flex items-center gap-3">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $product->is_active)) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="is_active" class="text-sm font-medium text-gray-700">{{ __('Active') }}</label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-ghost">{{ __('Cancel') }}</a>
</div>
