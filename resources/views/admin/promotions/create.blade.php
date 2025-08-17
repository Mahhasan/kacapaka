@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Add New Promotion</h1>
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.promotions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="promo_code" class="form-label">Promo Code*</label>
                        <input type="text" class="form-control @error('promo_code') is-invalid @enderror" id="promo_code" name="promo_code" value="{{ old('promo_code') }}" required>
                        @error('promo_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Discount Type*</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="Percentage" @selected(old('type') == 'Percentage')>Percentage</option>
                            <option value="Fixed Amount" @selected(old('type') == 'Fixed Amount')>Fixed Amount</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="value" class="form-label">Value*</label>
                        <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value" step="0.01" value="{{ old('value') }}" required>
                        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="usage_limit" class="form-label">Usage Limit (Optional)</label>
                        <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date*</label>
                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date*</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Promotion</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
