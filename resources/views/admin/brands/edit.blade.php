@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Edit Brand</h1>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="brand_name" class="form-label">Brand Name*</label>
                    <input type="text" class="form-control @error('brand_name') is-invalid @enderror" id="brand_name" name="brand_name" value="{{ old('brand_name', $brand->brand_name) }}" required>
                    @error('brand_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Brand Logo</label>
                    <input class="form-control @error('logo') is-invalid @enderror" type="file" id="logo" name="logo">
                    @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if($brand->logo)
                        <div class="mt-2"><img src="{{ asset('storage/' . $brand->logo) }}" alt="Current Logo" class="rounded" width="100"></div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $brand->position) }}">
                    @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" @if(old('is_active', $brand->is_active)) checked @endif>
                    <label class="form-check-label" for="is_active">Active Status</label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
