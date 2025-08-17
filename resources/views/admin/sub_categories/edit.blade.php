@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Edit Sub-Category</h1>
        <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.sub-categories.update', $subCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="category_id" class="form-label">Parent Category*</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $subCategory->category_id) == $category->id)>{{ $category->cat_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="subcat_name" class="form-label">Sub-Category Name*</label>
                    <input type="text" class="form-control @error('subcat_name') is-invalid @enderror" id="subcat_name" name="subcat_name" value="{{ old('subcat_name', $subCategory->subcat_name) }}" required>
                    @error('subcat_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $subCategory->position) }}">
                    @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" @if(old('is_active', $subCategory->is_active)) checked @endif>
                    <label class="form-check-label" for="is_active">Active Status</label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Sub-Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
