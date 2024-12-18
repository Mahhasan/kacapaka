@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Vendors</h4>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#createForm">Add Vendor</button>
        </div>
        <div class="card-body">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Create Vendor Form --}}
            <div class="collapse mb-4" id="createForm">
                <form action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="org_name" class="form-label">Organization Name <span class="text-danger">*</span></label>
                            <input type="text" name="org_name" class="form-control" id="org_name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="person" class="form-label">Contact Person</label>
                            <input type="text" name="person" class="form-control" id="person">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control" id="phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" name="address" class="form-control" id="address"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea name="remark" class="form-control" id="remark" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" id="status" required>
                                <option value="good">Good</option>
                                <option value="bad">Bad</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Add Vendor</button>
                </form>
            </div>

            {{-- Vendor List --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Organization Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vendor->org_name }}</td>
                            <td>{{ $vendor->person }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ ucfirst($vendor->status) }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm-{{ $vendor->id }}">Edit</button>
                                <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        {{-- Edit Form --}}
                        <tr class="collapse" id="editForm-{{ $vendor->id }}">
                            <td colspan="6">
                                <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="org_name_{{ $vendor->id }}" class="form-label">Organization Name</label>
                                            <input type="text" name="org_name" class="form-control" id="org_name_{{ $vendor->id }}" value="{{ $vendor->org_name }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="person_{{ $vendor->id }}" class="form-label">Contact Person</label>
                                            <input type="text" name="person" class="form-control" id="person_{{ $vendor->id }}" value="{{ $vendor->person }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="phone_{{ $vendor->id }}" class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" id="phone_{{ $vendor->id }}" value="{{ $vendor->phone }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="address_{{ $vendor->id }}" class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control" id="address_{{ $vendor->id }}" value="{{ $vendor->address }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="remark_{{ $vendor->id }}" class="form-label">Remark</label>
                                            <textarea name="remark" class="form-control" id="remark_{{ $vendor->id }}" rows="2">{{ $vendor->remark }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status_{{ $vendor->id }}" class="form-label">Status</label>
                                            <select name="status" class="form-select" id="status_{{ $vendor->id }}">
                                                <option value="good" {{ $vendor->status == 'good' ? 'selected' : '' }}>Good</option>
                                                <option value="bad" {{ $vendor->status == 'bad' ? 'selected' : '' }}>Bad</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Update Vendor</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No vendors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            {{ $vendors->links() }}
        </div>
    </div>
</div>
@endsection