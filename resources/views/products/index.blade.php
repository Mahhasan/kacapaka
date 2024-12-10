@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Products Management</h1>
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#productForm">
                Add / Edit Product
            </button>
        </div>
        <div id="productForm" class="collapse">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                    <input type="hidden" name="category_id" id="category_id">
                    <input type="hidden" name="subcategory_id" id="subcategory_id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Product Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="discount_price" class="form-label">Discount Price</label>
                        <input type="number" class="form-control" id="discount_price" name="discount_price">
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Active</label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Product List</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Discount Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount_price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-button"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-discount-price="{{ $product->discount_price }}"
                                data-stock="{{ $product->stock }}"
                                data-category-id="{{ $product->category_id }}"
                                data-is-active="{{ $product->is_active }}">
                                Edit
                            </button>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            const form = document.getElementById('productForm');
            form.classList.add('show');

            document.getElementById('product_id').value = button.getAttribute('data-id');
            document.getElementById('name').value = button.getAttribute('data-name');
            document.getElementById('price').value = button.getAttribute('data-price');
            document.getElementById('discount_price').value = button.getAttribute('data-discount-price');
            document.getElementById('stock').value = button.getAttribute('data-stock');
            document.getElementById('category_id').value = button.getAttribute('data-category-id');
            document.getElementById('is_active').value = button.getAttribute('data-is-active');
        });
    });
</script>
@endsection
