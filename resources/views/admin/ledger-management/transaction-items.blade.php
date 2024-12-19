@extends('layouts.app')

@section('content')
<div class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Transaction Items</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Transaction Item -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-transaction-item')">+ New Transaction Item</button>
        </div>
        <div id="create-transaction-item" class="card-body d-none">
            <form action="{{ route('transaction-items.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="transaction_purpose_id" class="col-sm-3 col-lg-2 col-form-label">Transaction Purpose</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select class="form-control form-control-sm" name="transaction_purpose_id" id="transaction_purpose_id" required>
                            <option value="" disabled selected>Select Transaction Purpose</option>
                            @foreach($transactionPurposes as $transactionPurpose)
                                <option value="{{ $transactionPurpose->id }}">{{ $transactionPurpose->name }}</option>
                            @endforeach
                        </select>
                        @error('transaction_purpose_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Transaction Item Name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i> Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-transaction-item')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Transaction Items -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Transaction Purpose</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactionItems as $transactionItem)
                                <tr>
                                    <td>{{ $transactionItem->transactionPurpose->name }}</td>
                                    <td>{{ $transactionItem->name }}</td>
                                    <td>
                                        <button class="badge badge-kacapaka-warning" onclick="toggleSection('edit-transaction-item-{{ $transactionItem->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('transaction-items.destroy', $transactionItem->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-transaction-item-{{ $transactionItem->id }}" class="d-none">
                                    <td colspan="3" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('transaction-items.update', $transactionItem->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <label for="transaction_purpose_id" class="col-sm-3 col-lg-2 col-form-label">Transaction Purpose</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select class="form-control form-control-sm" name="transaction_purpose_id" id="transaction_purpose_id" required>
                                                                @foreach($transactionPurposes as $transactionPurpose)
                                                                    <option value="{{ $transactionPurpose->id }}" {{ $transactionPurpose->id == $transactionItem->transaction_purpose_id ? 'selected' : '' }}>{{ $transactionPurpose->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $transactionItem->name }}" required>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-transaction-item-{{ $transactionItem->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No transaction items available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSection(id) {
        const element = document.getElementById(id);
        element.classList.toggle('d-none');
    }
</script>
@endsection
