@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Edit Expense Category</h1>
        <a href="{{ route('admin.expense-categories.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.expense-categories.update', $expenseCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exp_cat_name" class="form-label">Category Name*</label>
                    <input type="text" class="form-control @error('exp_cat_name') is-invalid @enderror" id="exp_cat_name" name="exp_cat_name" value="{{ old('exp_cat_name', $expenseCategory->exp_cat_name) }}" required>
                    @error('exp_cat_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" @if(old('is_active', $expenseCategory->is_active)) checked @endif>
                    <label class="form-check-label" for="is_active">Active Status</label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
