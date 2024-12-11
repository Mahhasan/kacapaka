<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Categories</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Category -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-primary" onclick="toggleSection('create-category')">+ Add Category</button>
        </div>
        <div id="create-category" class="card-body d-none">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="is_active">Is Active</label>
                    <select name="is_active" id="is_active" class="form-control" required>
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>

    <!-- List of Categories -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="toggleSection('edit-category-{{ $category->id }}')">Edit</button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr id="edit-category-{{ $category->id }}" class="d-none">
                    <td colspan="5">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ $category->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="is_active">Is Active</label>
                                <select name="is_active" id="is_active" class="form-control" required>
                                    <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No categories available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function toggleSection(id) {
        const element = document.getElementById(id);
        element.classList.toggle('d-none');
    }
</script>
@endsection
