@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Promotions / Coupons</h1>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Add New Promotion</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Promo Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promotion)
                        <tr>
                            <td><strong>{{ $promotion->promo_code }}</strong></td>
                            <td>{{ $promotion->type }}</td>
                            <td>{{ $promotion->type == 'Percentage' ? $promotion->value . '%' : '৳' . number_format($promotion->value, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($promotion->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($promotion->end_date)->format('d M, Y') }}</td>
                            <td>
                                @if($promotion->is_active)
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No promotions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
