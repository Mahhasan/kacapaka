@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Add New Category</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Position</th>
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->position }}</td>
                            <td>
                                <img src="{{ asset($category->image) }}" alt="{{ $category->cat_name }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </td>
                            <td><strong>{{ $category->cat_name }}</strong></td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('d M, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No categories found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
