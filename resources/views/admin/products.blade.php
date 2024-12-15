@extends('layouts.app')

@section('content')
<div name="header" class="section-wrapper">
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
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Product Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Product Name" required>
                    </div>
                </div>
                <div class="row">
                    <label for="category_id" class="col-sm-3 col-lg-2 col-form-label">Category</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select class="form-control" name="category_id" id="category" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="subcategory_id" class="col-sm-3 col-lg-2 col-form-label">Subcategory</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select class="form-control" name="subcategory_id" id="subcategory">
                            <option value=""></option>
                        </select>
                    </div>
                </div>



                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea class="form-control" name="description" id="description" placeholder=""></textarea>
                    </div>
                </div>
                <div class="row">
                    <label for="price" class="col-sm-3 col-lg-2 col-form-label">Price</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control" name="price" id="price" step="0.01" placeholder="Product Price" required>
                    </div>
                </div>
                <div class="row">
                    <label for="discount_price" class="col-sm-3 col-lg-2 col-form-label">Discount Price</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control" name="discount_price" id="discount_price" step="0.01" placeholder="Discount Price">
                    </div>
                </div>
                <div class="row">
                    <label for="promotion_start_time" class="col-sm-3 col-lg-2 col-form-label">Promotion Start</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="datetime-local" class="form-control" name="promotion_start_time" id="promotion_start_time">
                    </div>
                </div>
                <div class="row">
                    <label for="promotion_end_time" class="col-sm-3 col-lg-2 col-form-label">Promotion End</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="datetime-local" class="form-control" name="promotion_end_time" id="promotion_end_time">
                    </div>
                </div>
                <div class="row">
                    <label for="stock" class="col-sm-3 col-lg-2 col-form-label">Stock</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock Quantity" required>
                    </div>
                </div>
                <div class="row">
                    <label for="position" class="col-sm-3 col-lg-2 col-form-label">Position</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control" name="position" id="position" placeholder="Position for Product View">
                    </div>
                </div>
                <div class="row">
                    <label for="tags" class="col-sm-3 col-lg-2 col-form-label">Tags</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select class="js-example-basic-multiple" multiple="multiple" style="width:100%" name="tags[]">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="image" class="col-sm-3 col-lg-2 col-form-label">Image</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input type="checkbox" name="has_delivery_free" id="has_delivery_free" class="form-check-input" value="0">
                        Free Delivery
                    </label>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        Active
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-product')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Products -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Special Price</th>
                        <th>Promotion Start</th>
                        <th>Promotion End</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Delivery Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->discount_price ?? '-' }}</td>
                    <td>{{ $product->promotion_start_time ? $product->promotion_start_time->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $product->promotion_end_time ? $product->promotion_end_time->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $product->has_delivery_free ? 'success' : 'warning' }}">
                            {{ $product->has_delivery_free ? 'Free' : 'Charged' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="toggleSection('edit-product-{{ $product->id }}')">Edit</button>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr id="edit-product-{{ $product->id }}" class="d-none">
                    <td colspan="10">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                            <div class="row mb-2">
                                <label for="name-{{ $product->id }}" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name-{{ $product->id }}" name="name" value="{{ $product->name }}" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="category_id-{{ $product->id }}" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category_id" id="category_id-{{ $product->id }}" class="form-select" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="subcategory_id-{{ $product->id }}" class="col-sm-2 col-form-label">Subcategory</label>
                                <div class="col-sm-10">
                                    <select name="subcategory_id" id="subcategory_id-{{ $product->id }}" class="form-select">
                                        <option value="">None</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="price-{{ $product->id }}" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="price-{{ $product->id }}" name="price" step="0.01" value="{{ $product->price }}" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="discount_price-{{ $product->id }}" class="col-sm-2 col-form-label">Discount Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="discount_price-{{ $product->id }}" name="discount_price" step="0.01" value="{{ $product->discount_price }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="stock-{{ $product->id }}" class="col-sm-2 col-form-label">Stock</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="stock-{{ $product->id }}" name="stock" value="{{ $product->stock }}" required>
                                </div>
                            </div>


                            <div class="row mb-2">
                                <label for="promotion_start_time-{{ $product->id }}" class="col-sm-2 col-form-label">Promotion Start</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" id="promotion_start_time-{{ $product->id }}" name="promotion_start_time" value="{{ $product->promotion_start_time ? $product->promotion_start_time->format('Y-m-d\TH:i') : '' }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="promotion_end_time-{{ $product->id }}" class="col-sm-2 col-form-label">Promotion End</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" id="promotion_end_time-{{ $product->id }}" name="promotion_end_time" value="{{ $product->promotion_end_time ? $product->promotion_end_time->format('Y-m-d\TH:i') : '' }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-sm-2 col-form-label">Tags</label>
                                <div class="col-sm-10">
                                    @foreach($tags as $tag)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="tags[]" value="{{ $tag->id }}" {{ $product->tags->contains($tag->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $tag->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="position-{{ $product->id }}" class="col-sm-2 col-form-label">Position</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="position-{{ $product->id }}" name="position" value="{{ $product->position }}">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <label class="form-check-label" for="has_delivery_free-{{ $product->id }}">
                                    <input type="checkbox" name="has_delivery_free" id="has_delivery_free-{{ $product->id }}" class="form-check-input"  value="1" {{ $product->has_delivery_free ? 'checked' : '' }}>
                                    Delivery Free
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <label class="form-check-label" for="is_active-{{ $product->id }}">
                                    <input type="checkbox" name="is_active" id="is_active-{{ $product->id }}" class="form-check-input" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                    Active
                                </label>
                            </div>
                                <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-product-{{ $product->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No products available.</td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>
<!-- For Category wise Subcategory view -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#category').on('change', function () {
            var categoryId = $(this).val();

            // If a category is selected
            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId, // URL of the backend method
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var subcategoryDropdown = $('#subcategory');
                        subcategoryDropdown.empty(); // Clear previous subcategories

                        subcategoryDropdown.append('<option value="">Select Subcategory</option>'); // Default option
                        $.each(data, function (key, subcategory) {
                            subcategoryDropdown.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory').empty(); // Clear subcategory dropdown if no category is selected
                $('#subcategory').append('<option value="">Select Subcategory</option>');
            }
        });
    });
</script>
<script>
    function toggleSection(id) {
        const element = document.getElementById(id);
        element.classList.toggle('d-none');
    }

    // Handle Status Toggle
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const productId = this.dataset.id;
            const isActive = this.checked ? 1 : 0;

            fetch(`/products/toggle-status/${productId}`, {
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

<!-- for Editable input field -->
<script type="text/javascript">
    // Initialize TinyMCE editor
    tinymce.init({
        selector: '#description',
        height: 400,
        plugins: 'advlist autolink lists link image charmap print preview anchor table code',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | table | code',
        image_advtab: true,
        content_css: '//www.tiny.cloud/css/codepen.min.css', // Optional: use custom styling
    });
</script>
@endsection
