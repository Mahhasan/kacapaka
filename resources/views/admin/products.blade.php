@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Products</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Product -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-product')">+ New Product</button>
        </div>
        <div id="create-product" class="card-body d-none">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Product Name" required>
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
                        <select name="category_id" id="category_id" class="form-control form-control-sm">
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
                    <label for="subcategory_id" class="col-sm-3 col-lg-2 col-form-label">Subcategory</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select name="subcategory_id" id="subcategory_id" class="form-control form-control-sm">
                            <option value="">None</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="price" class="col-sm-3 col-lg-2 col-form-label">Price</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control form-control-sm" name="price" id="price" step="0.01" required>
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="discount_price" class="col-sm-3 col-lg-2 col-form-label">Discount Price</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control form-control-sm" name="discount_price" id="discount_price" step="0.01">
                    </div>
                </div>
                <div class="row">
                    <label for="stock" class="col-sm-3 col-lg-2 col-form-label">Stock</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control form-control-sm" name="stock" id="stock" required>
                    </div>
                </div>
                <div class="row">
                    <label for="promotion_start_time" class="col-sm-3 col-lg-2 col-form-label">Promotion Start</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="datetime-local" class="form-control form-control-sm" name="promotion_start_time" id="promotion_start_time">
                    </div>
                </div>
                <div class="row">
                    <label for="promotion_end_time" class="col-sm-3 col-lg-2 col-form-label">Promotion End</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="datetime-local" class="form-control form-control-sm" name="promotion_end_time" id="promotion_end_time">
                    </div>
                </div>
                <div class="row">
                    <label for="position" class="col-sm-3 col-lg-2 col-form-label">Position</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control form-control-sm" name="position" id="position" value="0">
                    </div>
                </div>
                <div class="row">
                    <label for="tags" class="col-sm-3 col-lg-2 col-form-label">Tags</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select name="tags[]" id="tags" class="form-control form-control-sm" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="image" class="col-sm-3 col-lg-2 col-form-label">Image</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="file" class="form-control form-control-sm" name="image" id="image">
                    </div>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label" for="delivery_free">
                        <input type="checkbox" name="delivery_free" id="delivery_free" class="form-check-input" value="1">
                        Free Delivery
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-product')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Products -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Stock</th>
                            <th>Free Delivery</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->discount_price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->delivery_free ? 'Yes' : 'No' }}</td>
                                <td>
                                    <button class="badge badge-info" onclick="toggleSection('edit-product-{{ $product->id }}')">Edit</button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Edit Product Row -->
                            <tr id="edit-product-{{ $product->id }}" class="d-none">
                                <td colspan="7" class="bg-aliceblue">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT
