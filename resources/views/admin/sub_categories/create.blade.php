@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Add New Sub-Category</h1>
        <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.sub-categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_id" class="form-label">Parent Category*</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select a parent category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->cat_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="subcat_name" class="form-label">Sub-Category Name*</label>
                    <input type="text" class="form-control @error('subcat_name') is-invalid @enderror" id="subcat_name" name="subcat_name" value="{{ old('subcat_name') }}" required>
                    @error('subcat_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}">
                    <small class="text-muted">Leave empty for auto-increment.</small>
                    @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Sub-Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
