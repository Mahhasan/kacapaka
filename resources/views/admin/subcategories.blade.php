@extends('layouts.app')

@section('content')
<div name="header" class="content-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Sub-Categories</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Sub-Category -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-subcategory')">+ New Sub-Category</button>
        </div>
        <div id="create-subcategory" class="card-body d-none">
            <form action="{{ route('subcategories.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Sub-Category Name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="category_id" class="col-sm-3 col-lg-2 col-form-label">Category</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select class="form-select" name="category_id" id="category_id" required>
                            <option value="" selected disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Sub-Category Description"></textarea>
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

    <!-- List of Sub-Categories -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCategories as $subCategory)
                            <tr>
                                <td>{{ $subCategory->name }}</td>
                                <td>{{ $subCategory->category->name }}</td>
                                <td>{{ $subCategory->description }}</td>
                                <td class="switch">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input toggle-status"
                                            type="checkbox"
                                            id="toggle-status-{{ $subCategory->id }}"
                                            data-id="{{ $subCategory->id }}"
                                            {{ $subCategory->is_active ? 'checked' : '' }}>
                                        <label
                                            class="form-check-label"
                                            for="toggle-status-{{ $subCategory->id }}">
                                            <span class="text-{{ $subCategory->is_active ? 'info' : 'danger' }}">
                                                {{ $subCategory->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <button class="badge badge-info" onclick="toggleSection('edit-subcategory-{{ $subCategory->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                    <form action="{{ route('subcategories.destroy', $subCategory->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-subcategory-{{ $subCategory->id }}" class="d-none">
                                <td colspan="5" class="bg-aliceblue">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('subcategories.update', $subCategory->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                                                    <div class="form-group col-sm-9 col-lg-10">
                                                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $subCategory->name }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="category_id" class="col-sm-3 col-lg-2 col-form-label">Category</label>
                                                    <div class="form-group col-sm-9 col-lg-10">
                                                        <select class="form-select" name="category_id" id="category_id" required>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $category->id == $subCategory->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                    <div class="form-group col-sm-9 col-lg-10">
                                                        <textarea type="text" class="form-control" name="description" id="description">{{ $subCategory->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <label class="form-check-label" for="is_active-{{ $subCategory->id }}">
                                                        <input type="checkbox" name="is_active" id="is_active-{{ $subCategory->id }}" class="form-check-input" value="1" {{ $subCategory->is_active ? 'checked' : '' }}>
                                                        Active
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-subcategory-{{ $subCategory->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No sub-categories available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
