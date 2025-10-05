@csrf
@if(($method ?? null) === 'PUT')
    @method('PUT')
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required class="form-control @error('name') is-invalid @enderror">
        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="slug">{{ __('Slug') }}</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $category->slug) }}" class="form-control @error('slug') is-invalid @enderror">
        @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="parent_id">{{ __('Parent category') }}</label>
        <select id="parent_id" name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
            <option value="">{{ __('Root level') }}</option>
            @foreach(($categoriesForSelect ?? []) as $id => $name)
                <option value="{{ $id }}" @selected((string)old('parent_id', $category->parent_id) === (string)$id)>{{ $name }}</option>
            @endforeach
        </select>
        @error('parent_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label" for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <div class="form-check">
            <input id="is_active" name="is_active" type="checkbox" value="1" class="form-check-input" @checked(old('is_active', $category->is_active))>
            <label for="is_active" class="form-check-label">{{ __('Active') }}</label>
        </div>
        @error('is_active') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <button type="submit" class="btn btn-primary px-4">{{ __('Save') }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary px-4">{{ __('Cancel') }}</a>
</div>
