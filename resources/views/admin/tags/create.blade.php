@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Add New Tag</h1>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tag_name" class="form-label">Tag Name*</label>
                    <input type="text" class="form-control @error('tag_name') is-invalid @enderror" id="tag_name" name="tag_name" value="{{ old('tag_name') }}" required>
                    @error('tag_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}">
                    <small class="text-muted">Leave empty for auto-increment.</small>
                    @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
