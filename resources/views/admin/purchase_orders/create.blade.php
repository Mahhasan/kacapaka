@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">New Purchase Order</h1>
        <a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <form action="{{ route('admin.purchase-orders.store') }}" method="POST">
        @csrf
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="vendor_id" class="form-label">Vendor*</label>
                        <select name="vendor_id" id="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                            @endforeach
                        </select>
                        @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="order_date" class="form-label">Order Date*</label>
                        <input type="date" name="order_date" id="order_date" class="form-control @error('order_date') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                        @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="order_status" class="form-label">Status</label>
                        <select name="order_status" id="order_status" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="Received">Received</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white py-3"><h5 class="mb-0">Order Items</h5></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Cost Per Unit (৳)</th>
                            <th>Total (৳)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="po-items-body">
                        <!-- Items will be added here by JS -->
                    </tbody>
                </table>
                <button type="button" id="add-item-btn" class="btn btn-success"><i class="bi bi-plus"></i> Add Item</button>
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">Create Purchase Order</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addItemBtn = document.getElementById('add-item-btn');
    const itemsBody = document.getElementById('po-items-body');
    const products = @json($products);
    let itemIndex = 0;

    addItemBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="items[${itemIndex}][product_id]" class="form-select product-select" required>
                    <option value="">Select Product</option>
                    ${products.map(p => `<option value="${p.id}">${p.product_name}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity-input" value="1" min="1" required></td>
            <td><input type="number" name="items[${itemIndex}][cost]" class="form-control cost-input" step="0.01" min="0" required></td>
            <td><input type="text" class="form-control total-cost" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item-btn"><i class="bi bi-trash"></i></button></td>
        `;
        itemsBody.appendChild(row);
        itemIndex++;
    });

    itemsBody.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('cost-input')) {
            const row = e.target.closest('tr');
            const quantity = row.querySelector('.quantity-input').value || 0;
            const cost = row.querySelector('.cost-input').value || 0;
            row.querySelector('.total-cost').value = (quantity * cost).toFixed(2);
        }
    });

    itemsBody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@endpush
@endsection
