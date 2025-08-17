@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Edit Vendor</h1>
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vendor_name" class="form-label">Vendor Name*</label>
                        <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name" value="{{ old('vendor_name', $vendor->vendor_name) }}" required>
                        @error('vendor_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_person" class="form-label">Contact Person</label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone*</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $vendor->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $vendor->address) }}</textarea>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $vendor->position) }}">
                        @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" @if(old('is_active', $vendor->is_active)) checked @endif>
                    <label class="form-check-label" for="is_active">Active Status</label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
