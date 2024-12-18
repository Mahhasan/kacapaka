@extends('layouts.app')

@section('content')
<div class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Transactions</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Transaction -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-transaction')">+ New Transaction</button>
        </div>
        <div id="create-transaction" class="card-body d-none">
            <form action="{{ route('transaction-purposes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="ledger_type_id" class="col-sm-3 col-lg-2 col-form-label">Ledger Type</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select name="ledger_type_id" id="ledger_type_id" class="form-control form-control-sm" required>
                            <option value="">-- Select Ledger Type --</option>
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
                    <label for="amount" class="col-sm-3 col-lg-2 col-form-label">Amount</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="number" class="form-control form-control-sm" name="amount" id="amount" placeholder="Transaction Amount" required>
                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="transaction_date" class="col-sm-3 col-lg-2 col-form-label">Transaction Date</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="date" class="form-control form-control-sm" name="transaction_date" id="transaction_date" required>
                        @error('transaction_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea name="description" id="description" class="form-control form-control-sm" placeholder="Optional Description"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-transaction')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Transactions -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ledger Type</th>
                                <th>Amount</th>
                                <th>Transaction Date</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->ledgerType->name }}</td>
                                    <td>{{ number_format($transaction->amount, 2) }}</td>
                                    <td>{{ $transaction->transaction_date }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>
                                        <button class="badge badge-kacapaka-warning" onclick="toggleSection('edit-transaction-{{ $transaction->id }}')">Edit</button>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-transaction-{{ $transaction->id }}" class="d-none">
                                    <td colspan="5" class="bg-aliceblue">
                                        <form action="{{ route('transaction-purposes.update', $transaction->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <label for="ledger_type_id" class="col-sm-3 col-lg-2 col-form-label">Ledger Type</label>
                                                <div class="form-group col-sm-9 col-lg-10">
                                                    <select name="ledger_type_id" class="form-control form-control-sm">
                                                        @foreach($ledgerTypes as $ledgerType)
                                                            <option value="{{ $ledgerType->id }}" {{ $ledgerType->id == $transaction->ledger_type_id ? 'selected' : '' }}>{{ $ledgerType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="amount" class="col-sm-3 col-lg-2 col-form-label">Amount</label>
                                                <div class="form-group col-sm-9 col-lg-10">
                                                    <input type="number" class="form-control form-control-sm" name="amount" value="{{ $transaction->amount }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="transaction_date" class="col-sm-3 col-lg-2 col-form-label">Transaction Date</label>
                                                <div class="form-group col-sm-9 col-lg-10">
                                                    <input type="date" class="form-control form-control-sm" name="transaction_date" value="{{ $transaction->transaction_date }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                <div class="form-group col-sm-9 col-lg-10">
                                                    <textarea name="description" class="form-control">{{ $transaction->description }}</textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-outline-success">Update</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-transaction-{{ $transaction->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                        </form>
                                    </td>
                                </tr>   
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No ledger types available.</td>
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
