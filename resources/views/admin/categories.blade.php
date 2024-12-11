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
                <div class="form-check mb-3">
                    <label class="form-check-label" for="is_active">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        Active
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleSection('create-category')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Categories -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
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
                                <td>
                                    <div class="form-check form-switch" style="padding-left: 2.5em;">
                                        <input 
                                            class="form-check-input toggle-status" 
                                            type="checkbox" 
                                            id="toggle-status-{{ $category->id }}" 
                                            data-id="{{ $category->id }}" 
                                            {{ $category->is_active ? 'checked' : '' }}>
                                        <label 
                                            class="form-check-label" 
                                            for="toggle-status-{{ $category->id }}" style="margin-left: 0rem;">
                                            <span class="text-{{ $category->is_active ? 'info' : 'danger' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <button class="badge badge-info" onclick="toggleSection('edit-category-{{ $category->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-category-{{ $category->id }}" class="d-none">
                                <td colspan="5" class="bg-light">
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
                                        <div class="form-check mb-3">
                                            <label class="form-check-label" for="is_active-{{ $category->id }}">
                                                <input type="checkbox" name="is_active" id="is_active-{{ $category->id }}" class="form-check-input" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                                Active
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-success btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleSection('edit-category-{{ $category->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
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
        </div>
    </div>
</div>

<script>
    function toggleSection(id) {
        const element = document.getElementById(id);
        element.classList.toggle('d-none');
    }

    // Handle Status Toggle
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const categoryId = this.dataset.id;
            const isActive = this.checked ? 1 : 0;

            fetch(`/categories/toggle-status/${categoryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = this.nextElementSibling.querySelector('span');
                    label.className = `text-${isActive ? 'success' : 'danger'}`;
                    label.textContent = isActive ? 'Active' : 'Inactive';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked; // Revert toggle if error
            });
        });
    });
</script>
@endsection
