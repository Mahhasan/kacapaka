@extends('layouts.app')

@section('content')
<div class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Transaction Purposes</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Transaction Purpose -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-transaction-purpose')">+ New Transaction Purpose</button>
        </div>
        <div id="create-transaction-purpose" class="card-body d-none">
            <form action="{{ route('transaction-purposes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="ledger_type_id" class="col-sm-3 col-lg-2 col-form-label">Ledger Type</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select class="form-control form-control-sm" name="ledger_type_id" id="ledger_type_id" required>
                            <option value="" disabled selected>Select Ledger Type</option>
                            @foreach($ledgerTypes as $ledgerType)
                                <option value="{{ $ledgerType->id }}">{{ $ledgerType->name }}</option>
                            @endforeach
                        </select>
                        @error('ledger_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Transaction Purpose Name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Transaction Purpose Description"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i> Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-transaction-purpose')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Transaction Purposes -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ledger Type</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactionPurposes as $transactionPurpose)
                                <tr>
                                    <td>{{ $transactionPurpose->ledgerType->name }}</td>
                                    <td>{{ $transactionPurpose->name }}</td>
                                    <td>{{ $transactionPurpose->description }}</td>
                                    <td>
                                        <button class="badge badge-kacapaka-warning" onclick="toggleSection('edit-transaction-purpose-{{ $transactionPurpose->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('transaction-purposes.destroy', $transactionPurpose->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-transaction-purpose-{{ $transactionPurpose->id }}" class="d-none">
                                    <td colspan="4" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('transaction-purposes.update', $transactionPurpose->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <label for="ledger_type_id" class="col-sm-3 col-lg-2 col-form-label">Ledger Type</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select class="form-control form-control-sm" name="ledger_type_id" id="ledger_type_id" required>
                                                                @foreach($ledgerTypes as $ledgerType)
                                                                    <option value="{{ $ledgerType->id }}" {{ $ledgerType->id == $transactionPurpose->ledger_type_id ? 'selected' : '' }}>{{ $ledgerType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $transactionPurpose->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <textarea class="form-control" name="description" id="description">{{ $transactionPurpose->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-transaction-purpose-{{ $transactionPurpose->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No transaction purposes available.</td>
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
