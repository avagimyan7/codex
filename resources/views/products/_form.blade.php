@csrf
@if(($method ?? null) === 'PUT')
    @method('PUT')
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="form-control @error('name') is-invalid @enderror">
        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="slug">{{ __('Slug') }}</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="form-control @error('slug') is-invalid @enderror">
        @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="sku">{{ __('SKU') }}</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" class="form-control @error('sku') is-invalid @enderror">
        @error('sku') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="category_id">{{ __('Category') }}</label>
        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">{{ __('Select category') }}</option>
            @foreach(($categoriesForSelect ?? []) as $id => $name)
                <option value="{{ $id }}" @selected((string)old('category_id', $product->category_id) === (string)$id)>{{ $name }}</option>
            @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="price">{{ __('Price') }}</label>
        <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror">
        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="currency">{{ __('Currency') }}</label>
        <input id="currency" name="currency" type="text" value="{{ old('currency', $product->currency) }}" class="form-control @error('currency') is-invalid @enderror">
        @error('currency') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="quantity">{{ __('Quantity') }}</label>
        <input id="quantity" name="quantity" type="number" value="{{ old('quantity', $product->quantity) }}" class="form-control @error('quantity') is-invalid @enderror">
        @error('quantity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label" for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <div class="form-check">
            <input id="is_active" name="is_active" type="checkbox" value="1" class="form-check-input" @checked(old('is_active', $product->is_active))>
            <label for="is_active" class="form-check-label">{{ __('Active') }}</label>
        </div>
        @error('is_active') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <button type="submit" class="btn btn-primary px-4">{{ __('Save') }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary px-4">{{ __('Cancel') }}</a>
</div>
