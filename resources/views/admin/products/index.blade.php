@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Add New Product</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->thumbnail_image ? asset('storage/' . $product->thumbnail_image) : 'https://placehold.co/60x60/EFEFEF/AAAAAA&text=No+Image' }}" alt="{{ $product->product_name }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $product->product_name }}</strong><br>
                                <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $product->subCategory->subcat_name ?? 'N/A' }}</td>
                            <td>
                                @if($product->discount_price)
                                    <del class="text-muted">৳{{ number_format($product->selling_price, 2) }}</del><br>
                                    <strong>৳{{ number_format($product->discount_price, 2) }}</strong>
                                @else
                                    <strong>৳{{ number_format($product->selling_price, 2) }}</strong>
                                @endif
                            </td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
