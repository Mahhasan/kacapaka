@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Purchase Order Details</h1>
        <a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5>PO Code: {{ $purchaseOrder->purchase_order_code }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Vendor:</strong> {{ $purchaseOrder->vendor->vendor_name }}</p>
            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('d M, Y') }}</p>
            <p><strong>Status:</strong> {{ $purchaseOrder->order_status }}</p>
            <table class="table mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Cost Per Unit</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseOrder->items as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>৳{{ number_format($item->cost_per_unit, 2) }}</td>
                        <td>৳{{ number_format($item->total_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Grand Total:</td>
                        <td>৳{{ number_format($purchaseOrder->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
