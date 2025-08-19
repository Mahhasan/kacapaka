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
                            <div class="mt-2"><img src="{{ asset($product->thumbnail_image) }}" alt="Current Thumbnail" class="rounded" width="100"></div>
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
                                    <img src="{{ asset($image->image_url) }}" class="img-fluid rounded">
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
                <!-- ... (Other sections like Pricing, Shipping, etc. are similar to create form but with populated values) ... -->
            </div>
            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- ... (Organization & Actions sections) ... -->
            </div>
        </div>
    </form>
</div>
@endsection
