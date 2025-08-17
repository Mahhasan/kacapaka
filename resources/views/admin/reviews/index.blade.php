@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Product Reviews</h1>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->product->product_name }}</td>
                            <td>{{ $review->customer->name }}</td>
                            <td>{{ $review->rating }} <i class="bi bi-star-fill text-warning"></i></td>
                            <td>{{ Str::limit($review->review_text, 50) }}</td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Approved</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Pending</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_approved" value="{{ $review->is_approved ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success me-2">
                                        {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No reviews found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
