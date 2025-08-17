@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Brands</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Add New Brand</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Position</th>
                            <th>Logo</th>
                            <th>Brand Name</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                        <tr>
                            <td>{{ $brand->position }}</td>
                            <td>
                                <img src="{{ $brand->logo ? asset('storage/' . $brand->logo) : 'https://placehold.co/60x60/EFEFEF/AAAAAA&text=No+Logo' }}" alt="{{ $brand->brand_name }}" class="rounded" width="50" height="50" style="object-fit: contain;">
                            </td>
                            <td><strong>{{ $brand->brand_name }}</strong></td>
                            <td>
                                @if($brand->is_active)
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No brands found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
