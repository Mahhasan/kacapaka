@extends('layouts.app')

@section('content')
<style>
    .image-slot img {
        object-fit: cover;
        border-radius: 5px;
        width: 100%;
        height: 100%;
    }

    .image-slot .delete-btn, .image-slot .edit-btn {
        position: absolute;
        top: 5px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        cursor: pointer;
    }

    .image-slot .delete-btn { right: 5px; }
    .image-slot .edit-btn { right: 35px; }
</style>

<div name="header" class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Products</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Product -->
    <div class="mb-4">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-product')">+ New Product</button>
            </div>
        </div>
        <div id="create-product" class="d-none">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                <div class="card border border-light border-start-0 border-end-0 border-10 rounded-5">
                    <div class="card-body">
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
                            <label for="subcategory" class="col-sm-3 col-lg-2 col-form-label">Subcategory</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <select class="form-control" name="subcategory_id" id="subcategory">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border border-light border-start-0 border-end-0 border-10 rounded-5">
                    <div class="card-body">
                        <div class="row">
                            <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <textarea class="form-control" name="description" id="description" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border border-light border-start-0 border-end-0 border-10 rounded-5">
                    <div class="card-body rounded-5">
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
                    </div>
                </div>
                <div class="card border border-light border-start-0 border-end-0 border-10 rounded-5">
                    <div class="card-body rounded-5">
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
                    </div>
                </div>
                <div class="card border border-light border-start-0 border-end-0 border-10 rounded-5">
                    <div class="card-body rounded-5">
                        <!-- <div class="row">
                            <label for="image" class="col-sm-3 col-lg-2 col-form-label">Image</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div> -->
                        <!-- Main Image -->
                        <div class="mb-3">
                            <!-- <input type="file" class="input border-0 pt-2" id="" name="product_images[]" accept="image/*" multiple required> -->
                            <label class="form-label"><strong>Product Images <i class="bi bi-info-circle"></i></strong></label>
        <div id="image-upload-container" class="d-flex align-items-start gap-2 flex-wrap p-2 border rounded"
            style="background-color: #f8fbfc; min-height: 120px;">
            <!-- First Placeholder for Image Upload -->
            <div class="image-slot position-relative" style="width: 120px; height: 120px;">
                <label class="image-upload-btn d-flex justify-content-center align-items-center border rounded"
                    style="width: 100%; height: 100%; cursor: pointer; background-color: #ffffff;">
                    <input type="file" name="product_images[]" class="d-none image-input" accept="image/*">
                    <span class="text-muted fs-1">+</span>
                </label>
            </div>
        </div>
                        </div>
                    </div>
                </div>



                <div class="card border border-light border-start-0 border-end-0 border-10 rounded-5">
                    <div class="card-body rounded-5">
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
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- List of Products -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>P-Image</th>
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
                    <td>
                        @if($product->pictures)
                            <div class="existing-pictures">
                                @foreach(json_decode($product->product_images, true) as $image)
                                    <img class="mb-2 p-2" src="{{ asset('uploads/product-images/' . $image) }}" alt="{{ $product->name }} Image" height="180" width="260">
                                @endforeach
                            </div>
                        @else
                            No Images Available
                        @endif
                    </td>
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


<!-- JavaScript for Image Previews and Drag-and-Drop -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('image-upload-container');

        // Function to create a new empty image upload slot
        function createImageSlot() {
            const div = document.createElement('div');
            div.classList.add('image-slot', 'position-relative');
            div.style.width = '120px';
            div.style.height = '120px';

            div.innerHTML = `
                <label class="image-upload-btn d-flex justify-content-center align-items-center border rounded"
                    style="width: 100%; height: 100%; cursor: pointer; background-color: #ffffff;">
                    <input type="file" name="product_images[]" class="d-none image-input" accept="image/*">
                    <span class="text-muted fs-1">+</span>
                </label>
            `;

            container.appendChild(div);
            handleImageInput(div.querySelector('.image-input'), div);
        }

        // Function to handle image input change
        function handleImageInput(input, parentDiv) {
            input.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Replace the "+" placeholder with the image preview
                        parentDiv.innerHTML = `
                            <img src="${e.target.result}" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover;">
                            <button type="button" class="edit-btn">&#9998;</button>
                            <button type="button" class="delete-btn">&times;</button>
                        `;

                        // Handle Delete Button
                        parentDiv.querySelector('.delete-btn').addEventListener('click', function () {
                            parentDiv.remove();
                            // Add new slot if there are no remaining image slots
                            if (!container.querySelector('.image-input')) {
                                createImageSlot();
                            }
                        });

                        // Handle Edit Button
                        parentDiv.querySelector('.edit-btn').addEventListener('click', function () {
                            const newInput = document.createElement('input');
                            newInput.type = 'file';
                            newInput.accept = 'image/*';
                            newInput.addEventListener('change', function () {
                                const newFile = this.files[0];
                                if (newFile) {
                                    const newReader = new FileReader();
                                    newReader.onload = function (e) {
                                        parentDiv.querySelector('img').src = e.target.result;
                                    };
                                    newReader.readAsDataURL(newFile);
                                }
                            });
                            newInput.click();
                        });

                        // Add a new empty slot if no file input is found
                        if (!container.querySelector('.image-input')) {
                            createImageSlot();
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Initialize the first image slot if no input exists
        if (!container.querySelector('.image-input')) {
            createImageSlot();
        } else {
            // Initialize existing inputs
            container.querySelectorAll('.image-input').forEach(input => {
                handleImageInput(input, input.closest('.image-slot'));
            });
        }
    });
</script>









<script type="text/javascript">
    $(document).ready(function () {
        // Listen for changes in the category dropdown
        $('#category').on('change', function () {
            var categoryId = $(this).val(); // Get selected category ID

            // Clear the subcategory dropdown
            $('#subcategory').empty();
            $('#subcategory').append('<option value="">Select Subcategory</option>');

            // If a category is selected
            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId, // Route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Populate the subcategory dropdown with data
                        $.each(data, function (key, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    },
                    error: function () {
                        alert('Failed to fetch subcategories. Please try again.');
                    }
                });
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
