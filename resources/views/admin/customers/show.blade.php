@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Customer Details</h1>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <img src="https://placehold.co/100x100/EFEFEF/AAAAAA&text={{ substr($customer->name, 0, 1) }}" class="rounded-circle mb-3" alt="">
                    <h4>{{ $customer->name }}</h4>
                    <p class="text-muted">{{ $customer->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3"><h5 class="mb-0">Order History</h5></div>
                <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order->id) }}"><strong>{{ $order->order_number }}</strong></a></td>
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td>৳{{ number_format($order->total_amount, 2) }}</td>
                                    <td><span class="badge bg-success-subtle text-success-emphasis rounded-pill">{{ $order->order_status }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">No orders from this customer.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
