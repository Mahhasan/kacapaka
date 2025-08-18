@extends('layouts.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-6">Admin Dashboard</h1>
            <!-- <p class="text-muted">Welcome back, {{ Auth::user()->name }}!</p> -->
        </div>
    </div>

    <div class="row g-4 mt-2">
        <!-- Total Sales Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0"><div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-currency-dollar fs-4"></i></div></div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title text-muted mb-1">Total Sales</h5>
                            <h4 class="mb-0">৳ {{ number_format($totalSales ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Orders Card -->
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0"><div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-box-seam fs-4"></i></div></div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title text-muted mb-1">Total Orders</h5>
                                <h4 class="mb-0">{{ $totalOrders ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Pending Orders Card -->
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.orders.index', ['status' => 'Pending']) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0"><div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-clock-history fs-4"></i></div></div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title text-muted mb-1">Pending Orders</h5>
                                <h4 class="mb-0">{{ $pendingOrders ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Total Customers Card -->
        <div class="col-xl-3 col-md-6">
             <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0"><div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-people fs-4"></i></div></div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title text-muted mb-1">Total Customers</h5>
                                <h4 class="mb-0">{{ $totalCustomers ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Total Products Card -->
        <div class="col-xl-3 col-md-6">
             <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0"><div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-tag fs-4"></i></div></div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title text-muted mb-1">Total Products</h5>
                                <h4 class="mb-0">{{ $totalProducts ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Total Categories Card -->
        <div class="col-xl-3 col-md-6">
             <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0"><div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-grid fs-4"></i></div></div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title text-muted mb-1">Total Categories</h5>
                                <h4 class="mb-0">{{ $totalCategories ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                 <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i>Sales Overview (Last 7 Days)</h5></div>
                <div class="card-body"><canvas id="salesChart" height="150"></canvas></div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Recent Orders</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"><strong>{{ $order->order_number }}</strong></a><br>
                                        <small class="text-muted">{{ $order->customer->name ?? 'N/A' }}</small>
                                    </td>
                                    <td class="text-end">
                                        <strong>৳{{ number_format($order->total_amount, 2) }}</strong><br>
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">{{ $order->order_status }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="text-center text-muted">No recent orders.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="[https://cdn.jsdelivr.net/npm/chart.js](https://cdn.jsdelivr.net/npm/chart.js)"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($salesData['labels'] ?? []),
                datasets: [{
                    label: 'Sales',
                    data: @json($salesData['data'] ?? []),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush
@endsection
