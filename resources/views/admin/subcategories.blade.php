@extends('layouts.app')

@section('content')
<div name="header" class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage subcategories</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add subcategory -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-subcategory')">+ New subcategory</button>
        </div>
        <div id="create-subcategory" class="card-body d-none">
            <form action="{{ route('subcategories.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="subcategory Name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="subcategory Description"></textarea>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label" for="is_active">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        Active
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-subcategory')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of subcategories -->
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
                            @forelse($subcategories as $subcategory)
                                <tr>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ $subcategory->description }}</td>
                                    <td class="switch">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input toggle-status"
                                                type="checkbox"
                                                id="toggle-status-{{ $subcategory->id }}"
                                                data-id="{{ $subcategory->id }}"
                                                {{ $subcategory->is_active ? 'checked' : '' }}>
                                            <label
                                                class="form-check-label"
                                                for="toggle-status-{{ $subcategory->id }}">
                                                <span class="text-{{ $subcategory->is_active ? 'primary' : 'danger' }}">
                                                    {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="badge badge-kacapaka-warning" onclick="toggleSection('edit-subcategory-{{ $subcategory->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-subcategory-{{ $subcategory->id }}" class="d-none">
                                    <td colspan="5" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $subcategory->name }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                                                        <div class="col-sm-10">
                                                            <select name="category_id" id="category_id" class="form-control">
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <textarea type="text" class="form-control" name="description" id="description">{{ $subcategory->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <label class="form-check-label" for="is_active-{{ $subcategory->id }}">
                                                            <input type="checkbox" name="is_active" id="is_active-{{ $subcategory->id }}" class="form-check-input" value="1" {{ $subcategory->is_active ? 'checked' : '' }}>
                                                            Active
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-subcategory-{{ $subcategory->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No subcategories available.</td>
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
            const subcategoryId = this.dataset.id;
            const isActive = this.checked ? 1 : 0;

            fetch(`/subcategories/toggle-status/${subcategoryId}`, {
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
