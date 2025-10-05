@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center gap-2 toolbar mb-3">
  <a href="{{ route('products.create') }}" class="btn btn-primary px-4">+ Create</a>
  <form method="GET" class="d-flex flex-wrap align-items-center gap-2 ms-auto">
    <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search…">
    <select class="form-select" name="category_id">
      <option value="">All categories</option>
      @foreach(($categoriesForSelect ?? []) as $id=>$name)
        <option value="{{ $id }}" @selected(request('category_id')==$id)>{{ $name }}</option>
      @endforeach
    </select>
    <select class="form-select" name="is_active">
      <option value="">Any status</option>
      <option value="1" @selected(request('is_active')==='1')>Active</option>
      <option value="0" @selected(request('is_active')==='0')>Inactive</option>
    </select>
    <input class="form-control" name="price_min" value="{{ request('price_min') }}" placeholder="Min price" type="number" step="0.01">
    <input class="form-control" name="price_max" value="{{ request('price_max') }}" placeholder="Max price" type="number" step="0.01">
    <select class="form-select" name="sort">
      <option value="">Sort by</option>
      @foreach(['name','-price','price','-created_at','created_at'] as $s)
        <option value="{{ $s }}" @selected(request('sort')===$s)>{{ $s }}</option>
      @endforeach
    </select>
    <select class="form-select" name="per_page">
      @foreach([15,25,50,100] as $pp)
        <option value="{{ $pp }}" @selected(request('per_page')==$pp)>{{ $pp }} / page</option>
      @endforeach
    </select>
    <button class="btn btn-ghost" type="submit">Filter</button>
    <a href="{{ route('products.index') }}" class="btn btn-ghost">Reset</a>
  </form>
</div>

<x-card-table :title="__('Products')">
  <thead>
    <tr>
      <th style="width:14rem">{{ __('Date') }}</th>
      <th>{{ __('SKU') }}</th>
      <th>{{ __('Name') }}</th>
      <th class="text-end">{{ __('Price') }}</th>
      <th class="text-end">{{ __('Quantity') }}</th>
      <th class="text-end" style="width:12rem">{{ __('Actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($products as $p)
      <tr>
        <td class="text-muted">{{ optional($p->created_at)->format('Y-m-d H:i') }}</td>
        <td class="fw-medium">{{ $p->sku }}</td>
        <td class="fw-semibold">{{ $p->name }}</td>
        <td class="text-end">{{ number_format($p->price, 2) }} {{ $p->currency }}</td>
        <td class="text-end">{{ $p->quantity }}</td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-secondary me-1" href="{{ route('products.show',$p) }}">View</a>
          <a class="btn btn-sm btn-outline-primary me-1" href="{{ route('products.edit',$p) }}">Edit</a>
          <form action="{{ route('products.destroy',$p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete item?')">
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
      <div class="text-muted small">Total: {{ $products->total() }}</div>
      {{ $products->withQueryString()->links() }}
    </div>
  </x-slot:footer>
</x-card-table>
@endsection
