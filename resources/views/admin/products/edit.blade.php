@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Edit Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Product Information -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3"><h5 class="mb-0">Product Information</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name*</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                            @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Long Description</label>
                            <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white py-3"><h5 class="mb-0">Media</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                            <input class="form-control @error('thumbnail_image') is-invalid @enderror" type="file" id="thumbnail_image" name="thumbnail_image">
                            @error('thumbnail_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if($product->thumbnail_image)
                            <div class="mt-2"><img src="{{ asset('storage/' . $product->thumbnail_image) }}" alt="Current Thumbnail" class="rounded" width="100"></div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gallery Images</label>
                            <input class="form-control @error('gallery_images.*') is-invalid @enderror" type="file" id="gallery_images" name="gallery_images[]" multiple>
                             @error('gallery_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            @foreach($product->images as $image)
                            <div class="col-md-3 mb-3">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" class="img-fluid rounded">
                                    <form action="{{ route('admin.products.images.destroy', $image->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" style="line-height: 1;">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white py-3"><h5 class="mb-0">Pricing & Stock</h5></div>
                    <div class="card-body">
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="purchase_price" class="form-label">Purchase Price (৳)</label>
                                <input type="number" class="form-control" id="purchase_price" name="purchase_price" step="0.01" value="{{ old('purchase_price', $product->purchase_price) }}">
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="selling_price" class="form-label">Selling Price (৳)*</label>
                                <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" step="0.01" value="{{ old('selling_price', $product->selling_price) }}" required>
                                @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="discount_price" class="form-label">Discount Price (৳)</label>
                                <input type="number" class="form-control @error('discount_price') is-invalid @enderror" id="discount_price" name="discount_price" step="0.01" value="{{ old('discount_price', $product->discount_price) }}">
                                @error('discount_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity*</label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="discount_start_date" class="form-label">Discount Start Date</label>
                                <input type="date" class="form-control" id="discount_start_date" name="discount_start_date" value="{{ old('discount_start_date', $product->discount_start_date) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="discount_end_date" class="form-label">Discount End Date</label>
                                <input type="date" class="form-control" id="discount_end_date" name="discount_end_date" value="{{ old('discount_end_date', $product->discount_end_date) }}">
                            </div>
                             <div class="col-12 mb-3">
                                <label for="free_item" class="form-label">Free Item</label>
                                <input type="text" class="form-control" id="free_item" name="free_item" value="{{ old('free_item', $product->free_item) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping & Warranty -->
                <div class="card shadow-sm border-0 mt-4">
                     <div class="card-header bg-white py-3"><h5 class="mb-0">Shipping & Warranty</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="package_weight" class="form-label">Weight (kg)</label>
                                <input type="number" class="form-control @error('package_weight') is-invalid @enderror" id="package_weight" name="package_weight" step="0.01" value="{{ old('package_weight', $product->package_weight) }}">
                                @error('package_weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="package_length" class="form-label">Length (cm)</label>
                                <input type="number" class="form-control" id="package_length" name="package_length" step="0.01" value="{{ old('package_length', $product->package_length) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="package_width" class="form-label">Width (cm)</label>
                                <input type="number" class="form-control" id="package_width" name="package_width" step="0.01" value="{{ old('package_width', $product->package_width) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="package_height" class="form-label">Height (cm)</label>
                                <input type="number" class="form-control" id="package_height" name="package_height" step="0.01" value="{{ old('package_height', $product->package_height) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="warranty_type" class="form-label">Warranty Type</label>
                                <select class="form-select" name="warranty_type">
                                    <option value="">Select Type</option>
                                    <option value="No Warranty" @selected(old('warranty_type', $product->warranty_type) == 'No Warranty')>No Warranty</option>
                                    <option value="Brand Warranty" @selected(old('warranty_type', $product->warranty_type) == 'Brand Warranty')>Brand Warranty</option>
                                    <option value="Seller Warranty" @selected(old('warranty_type', $product->warranty_type) == 'Seller Warranty')>Seller Warranty</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="warranty_period" class="form-label">Warranty Period</label>
                                <input type="text" class="form-control" id="warranty_period" name="warranty_period" value="{{ old('warranty_period', $product->warranty_period) }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="warranty_policy" class="form-label">Warranty Policy</label>
                                <textarea class="form-control" id="warranty_policy" name="warranty_policy" rows="3">{{ old('warranty_policy', $product->warranty_policy) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Organization -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3"><h5 class="mb-0">Organization</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="sub_category_id" class="form-label">Category*</label>
                            <select class="form-select @error('sub_category_id') is-invalid @enderror" id="sub_category_id" name="sub_category_id" required>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @selected(old('sub_category_id', $product->sub_category_id) == $subCategory->id)>
                                        {{ $subCategory->category->cat_name }} > {{ $subCategory->subcat_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select class="form-select" id="brand_id" name="brand_id">
                                <option value="">Select a brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select class="form-select" id="tags" name="tags[]" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())))>{{ $tag->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit', $product->unit) }}">
                        </div>
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white py-3"><h5 class="mb-0">Actions</h5></div>
                    <div class="card-body">
                         <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" @if(old('is_active', $product->is_active)) checked @endif>
                            <label class="form-check-label" for="is_active">Publish Product</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
