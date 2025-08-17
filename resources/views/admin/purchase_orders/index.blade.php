@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Purchase Orders</h1>
        <a href="{{ route('admin.purchase-orders.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>New Purchase Order</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>PO Code</th>
                        <th>Vendor</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrders as $po)
                    <tr>
                        <td><strong>{{ $po->purchase_order_code }}</strong></td>
                        <td>{{ $po->vendor->vendor_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($po->order_date)->format('d M, Y') }}</td>
                        <td>৳{{ number_format($po->total_amount, 2) }}</td>
                        <td><span class="badge bg-info-subtle text-info-emphasis rounded-pill">{{ $po->order_status }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.purchase-orders.show', $po->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No purchase orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
