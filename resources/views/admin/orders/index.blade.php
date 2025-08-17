@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Orders</h1>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>৳{{ number_format($order->total_amount, 2) }}</td>
                            <td><span class="badge bg-info-subtle text-info-emphasis rounded-pill">{{ $order->payment_status }}</span></td>
                            <td><span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">{{ $order->order_status }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
