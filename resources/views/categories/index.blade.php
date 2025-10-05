@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center gap-2 toolbar mb-3">
  <a href="{{ route('categories.create') }}" class="btn btn-primary px-4">+ Create</a>
  <form method="GET" class="d-flex flex-wrap align-items-center gap-2 ms-auto">
    <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search…">
    <select class="form-select" name="parent_id">
      <option value="">All parents</option>
      @foreach(($parentOptions ?? []) as $id=>$name)
        <option value="{{ $id }}" @selected(request('parent_id')==$id)>{{ $name }}</option>
      @endforeach
    </select>
    <select class="form-select" name="is_active">
      <option value="">Any status</option>
      <option value="1" @selected(request('is_active')==='1')>Active</option>
      <option value="0" @selected(request('is_active')==='0')>Inactive</option>
    </select>
    <select class="form-select" name="per_page">
      @foreach([15,25,50,100] as $pp)
        <option value="{{ $pp }}" @selected(request('per_page')==$pp)>{{ $pp }} / page</option>
      @endforeach
    </select>
    <button class="btn btn-ghost" type="submit">Filter</button>
    <a href="{{ route('categories.index') }}" class="btn btn-ghost">Reset</a>
  </form>
</div>

<x-card-table :title="__('Categories')">
  <thead>
    <tr>
      <th style="width:14rem">{{ __('Date') }}</th>
      <th>{{ __('ID / Slug') }}</th>
      <th>{{ __('Name') }}</th>
      <th>{{ __('Parent') }}</th>
      <th class="text-center">{{ __('Active') }}</th>
      <th class="text-end" style="width:12rem">{{ __('Actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($categories as $category)
      <tr>
        <td class="text-muted">{{ optional($category->created_at)->format('Y-m-d H:i') }}</td>
        <td>
          <div class="fw-semibold">#{{ $category->id }}</div>
          <div class="text-muted small">{{ $category->slug }}</div>
        </td>
        <td class="fw-semibold">{{ $category->name }}</td>
        <td>{{ optional($category->parent)->name ?? '—' }}</td>
        <td class="text-center">
          @if($category->is_active)
            <span class="badge rounded-pill text-bg-success">{{ __('Yes') }}</span>
          @else
            <span class="badge rounded-pill text-bg-secondary">{{ __('No') }}</span>
          @endif
        </td>
        <td class="text-end">
          <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-secondary me-1">View</a>
          <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
          <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete item?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="text-center text-muted py-5">No data</td></tr>
    @endforelse
  </tbody>
  <x-slot:footer>
    <div class="d-flex justify-content-between align-items-center">
      <div class="text-muted small">Total: {{ $categories->total() }}</div>
      {{ $categories->withQueryString()->links() }}
    </div>
  </x-slot:footer>
</x-card-table>
@endsection
