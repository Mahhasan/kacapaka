@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Order Details</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to Orders</a>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order #{{ $order->order_number }}</h5>
                    <span class="text-muted">{{ $order->created_at->format('F d, Y h:i A') }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->thumbnail_image ? asset('storage/' . $item->product->thumbnail_image) : '[https://placehold.co/60x60](https://placehold.co/60x60)' }}" class="rounded me-3" width="50" alt="">
                                            <div>
                                                <strong>{{ $item->product->product_name }}</strong>
                                                <div class="text-muted small">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">৳{{ number_format($item->price_per_unit, 2) }}</td>
                                    <td class="text-end">৳{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal</td>
                                    <td class="text-end">৳{{ number_format($order->sub_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Discount</td>
                                    <td class="text-end text-danger">- ৳{{ number_format($order->discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Shipping Cost</td>
                                    <td class="text-end">+ ৳{{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end fs-5">Grand Total</td>
                                    <td class="text-end fs-5">৳{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3"><h5 class="mb-0">Customer Details</h5></div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->customer->name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                    <p><strong>Shipping Address:</strong><br>
                        {{ $order->shippingAddress->address_line_1 }}, {{ $order->shippingAddress->city }}
                    </p>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3"><h5 class="mb-0">Update Status</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="order_status" class="form-label">Order Status</label>
                            <select name="order_status" id="order_status" class="form-select">
                                <option value="Pending" @selected($order->order_status == 'Pending')>Pending</option>
                                <option value="Processing" @selected($order->order_status == 'Processing')>Processing</option>
                                <option value="Shipped" @selected($order->order_status == 'Shipped')>Shipped</option>
                                <option value="Delivered" @selected($order->order_status == 'Delivered')>Delivered</option>
                                <option value="Cancelled" @selected($order->order_status == 'Cancelled')>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                <option value="Unpaid" @selected($order->payment_status == 'Unpaid')>Unpaid</option>
                                <option value="Paid" @selected($order->payment_status == 'Paid')>Paid</option>
                                <option value="Failed" @selected($order->payment_status == 'Failed')>Failed</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
