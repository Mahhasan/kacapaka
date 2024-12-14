@extends('layouts.app')

@section('content')
<div name="header" class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Categories</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Category -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-category')">+ New Category</button>
        </div>
        <div id="create-category" class="card-body d-none">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Category Name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Category Description"></textarea>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label" for="is_active">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        Active
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-category')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Categories -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
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
                                    <td class="switch">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input toggle-status"
                                                type="checkbox"
                                                id="toggle-status-{{ $category->id }}"
                                                data-id="{{ $category->id }}"
                                                {{ $category->is_active ? 'checked' : '' }}>
                                            <label
                                                class="form-check-label"
                                                for="toggle-status-{{ $category->id }}">
                                                <span class="text-{{ $category->is_active ? 'primary' : 'danger' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="badge badge-kacapaka-warning" onclick="toggleSection('edit-category-{{ $category->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-category-{{ $category->id }}" class="d-none">
                                    <td colspan="5" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $category->name }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <textarea type="text" class="form-control" name="description" id="description">{{ $category->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <label class="form-check-label" for="is_active-{{ $category->id }}">
                                                            <input type="checkbox" name="is_active" id="is_active-{{ $category->id }}" class="form-check-input" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                                            Active
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-category-{{ $category->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                                </form>
                                            </div>
                                        </div>
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
