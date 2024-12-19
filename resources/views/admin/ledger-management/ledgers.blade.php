@extends('layouts.app')

@section('content')
<div class="section-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Ledgers</h4>
                    <button class="btn btn-primary btn-sm" onclick="toggleSection('create-ledger-section')">+ Add Ledger</button>
                </div>

                <div id="create-ledger-section" class="card-body d-none">
                    <form action="{{ route('ledgers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                        <!-- Ledger Type -->
                        <div class="row">
                            <label for="ledger_type_id" class="col-sm-3 col-lg-2 col-form-label">Ledger Type</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <select name="ledger_type_id" id="ledger_type_id" class="form-control" required>
                                    @foreach($ledgerTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Transaction Purpose -->
                        <div class="row">
                            <label for="transaction_purpose_id" class="col-sm-3 col-lg-2 col-form-label">Transaction Purpose</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <select name="transaction_purpose_id" id="transaction_purpose_id" class="form-control" required>
                                    @foreach($transactionPurposes as $purpose)
                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Vendor -->
                        <div class="row">
                            <label for="vendor_id" class="col-sm-3 col-lg-2 col-form-label">Vendor</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <select name="vendor_id" id="vendor_id" class="form-control">
                                    <option value="">-- Select Vendor --</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->person }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Transaction Item -->
                        <div class="row">
                            <label for="transaction_item_id" class="col-sm-3 col-lg-2 col-form-label">Transaction Item</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <select name="transaction_item_id" id="transaction_item_id" class="form-control">
                                    <option value="">-- Select Transaction Item --</option>
                                    @foreach($transactionItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Other fields -->
                        <div class="row">
                            <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <label for="quantity" class="col-sm-3 col-lg-2 col-form-label">Quantity</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="number" name="quantity" id="quantity" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="unit_price" class="col-sm-3 col-lg-2 col-form-label">Unit Price</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="total_amount" class="col-sm-3 col-lg-2 col-form-label">Total Amount</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="is_paid" class="col-sm-3 col-lg-2 col-form-label">Is Paid?</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <select name="is_paid" id="is_paid" class="form-control" required>
                                    <option value="due">Due</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label for="paid_date" class="col-sm-3 col-lg-2 col-form-label">Paid Date</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="date" name="paid_date" id="paid_date" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label for="buy_or_sell_date" class="col-sm-3 col-lg-2 col-form-label">Buy/Sell Date</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="date" name="buy_or_sell_date" id="buy_or_sell_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="payment_method" class="col-sm-3 col-lg-2 col-form-label">Payment Method</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="text" name="payment_method" id="payment_method" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label for="transaction_id" class="col-sm-3 col-lg-2 col-form-label">Transaction ID</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="text" name="transaction_id" id="transaction_id" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label for="voucher" class="col-sm-3 col-lg-2 col-form-label">Voucher</label>
                            <div class="form-group col-sm-9 col-lg-10">
                                <input type="file" name="voucher" id="voucher" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-9 col-lg-10 offset-sm-3 offset-lg-2">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                                <button type="button" class="btn btn-secondary btn-sm ms-2" onclick="toggleSection('create-ledger-section')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ledger Type</th>
                                <th>Transaction Purpose</th>
                                <th>Vendor</th>
                                <th>Transaction Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Amount</th>
                                <th>Voucher</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ledgers as $ledger)
                                <tr>
                                    <td>{{ $ledger->ledgerType->name ?? 'N/A' }}</td>
                                    <td>{{ $ledger->transactionPurpose->name ?? 'N/A' }}</td>
                                    <td>{{ $ledger->vendor->name ?? 'N/A' }}</td>
                                    <td>{{ $ledger->transactionItem->name ?? 'N/A' }}</td>
                                    <td>{{ $ledger->quantity }}</td>
                                    <td>{{ $ledger->unit_price }}</td>
                                    <td>{{ $ledger->total_amount }}</td>
                                    <td>
                                        @if($ledger->voucher)
                                            <a href="{{ asset($ledger->voucher) }}" target="_blank">View</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <button class="badge badge-warning" onclick="toggleSection('edit-ledger-{{ $ledger->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('ledgers.destroy', $ledger->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-ledger-{{ $ledger->id }}" class="d-none">
                                    <td colspan="12" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('ledgers.update', $ledger->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                                                    <div class="row">
                                                        <label for="ledger_type_id" class="col-sm-3 col-lg-2 col-form-label">Ledger Type</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select name="ledger_type_id" class="form-control form-control-sm" required>
                                                                <option value="">Select Ledger Type</option>
                                                                @foreach($ledgerTypes as $type)
                                                                    <option value="{{ $type->id }}" {{ $type->id == $ledger->ledger_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
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
                                                        <label for="transaction_purpose_id" class="col-sm-3 col-lg-2 col-form-label">Transaction Purpose</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select name="transaction_purpose_id" class="form-control form-control-sm" required>
                                                                <option value="">Select Purpose</option>
                                                                @foreach($transactionPurposes as $purpose)
                                                                    <option value="{{ $purpose->id }}" {{ $purpose->id == $ledger->transaction_purpose_id ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="vendor_id" class="col-sm-3 col-lg-2 col-form-label">Vendor</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select name="vendor_id" class="form-control form-control-sm">
                                                                <option value="">Select Vendor</option>
                                                                @foreach($vendors as $vendor)
                                                                    <option value="{{ $vendor->id }}" {{ $vendor->id == $ledger->vendor_id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="transaction_item_id" class="col-sm-3 col-lg-2 col-form-label">Transaction Item</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select name="transaction_item_id" class="form-control form-control-sm">
                                                                <option value="">Select Item</option>
                                                                @foreach($transactionItems as $item)
                                                                    <option value="{{ $item->id }}" {{ $item->id == $ledger->transaction_item_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <textarea class="form-control" name="description" id="description" placeholder="Description">{{ $ledger->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="quantity" class="col-sm-3 col-lg-2 col-form-label">Quantity</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="number" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', $ledger->quantity) }}" placeholder="Quantity" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="unit_price" class="col-sm-3 col-lg-2 col-form-label">Unit Price</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="number" step="0.01" class="form-control" name="unit_price" id="unit_price" value="{{ old('unit_price', $ledger->unit_price) }}" placeholder="Unit Price" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="total_amount" class="col-sm-3 col-lg-2 col-form-label">Total Amount</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="number" step="0.01" class="form-control" name="total_amount" id="total_amount" value="{{ old('total_amount', $ledger->total_amount) }}" placeholder="Total Amount" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="is_paid" class="col-sm-3 col-lg-2 col-form-label">Is Paid</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <select name="is_paid" class="form-control form-control-sm" required>
                                                                <option value="due" {{ $ledger->is_paid == 'due' ? 'selected' : '' }}>Due</option>
                                                                <option value="paid" {{ $ledger->is_paid == 'paid' ? 'selected' : '' }}>Paid</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="paid_date" class="col-sm-3 col-lg-2 col-form-label">Paid Date</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="date" class="form-control" name="paid_date" id="paid_date" value="{{ old('paid_date', $ledger->paid_date) }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="buy_or_sell_date" class="col-sm-3 col-lg-2 col-form-label">Buy/Sell Date</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="date" class="form-control" name="buy_or_sell_date" id="buy_or_sell_date" value="{{ old('buy_or_sell_date', $ledger->buy_or_sell_date) }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="payment_method" class="col-sm-3 col-lg-2 col-form-label">Payment Method</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control" name="payment_method" id="payment_method" value="{{ old('payment_method', $ledger->payment_method) }}" placeholder="Payment Method">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="transaction_id" class="col-sm-3 col-lg-2 col-form-label">Transaction ID</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $ledger->transaction_id) }}" placeholder="Transaction ID">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="voucher" class="col-sm-3 col-lg-2 col-form-label">Voucher Image</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="file" class="form-control" name="voucher" id="voucher">
                                                            @if($ledger->voucher)
                                                                <div class="mt-2">
                                                                    <label>Current Voucher</label>
                                                                    <a href="{{ asset($ledger->voucher) }}" target="_blank">View Current Voucher</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-ledger-{{ $ledger->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No ledgers found.</td>
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
