@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Edit Expense</h1>
        <a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="expense_category_id" class="form-label">Expense Category*</label>
                        <select class="form-select @error('expense_category_id') is-invalid @enderror" id="expense_category_id" name="expense_category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('expense_category_id', $expense->expense_category_id) == $category->id)>{{ $category->exp_cat_name }}</option>
                            @endforeach
                        </select>
                        @error('expense_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">Amount (৳)*</label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" step="0.01" value="{{ old('amount', $expense->amount) }}" required>
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="expense_date" class="form-label">Expense Date*</label>
                        <input type="date" class="form-control @error('expense_date') is-invalid @enderror" id="expense_date" name="expense_date" value="{{ old('expense_date', $expense->expense_date) }}" required>
                        @error('expense_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                         <label for="description" class="form-label">Description*</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $expense->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                 <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" @if(old('is_active', $expense->is_active)) checked @endif>
                    <label class="form-check-label" for="is_active">Active Status</label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
