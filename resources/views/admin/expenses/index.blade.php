@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Expenses</h1>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Record New Expense</a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Recorded By</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M, Y') }}</td>
                            <td>{{ $expense->category->exp_cat_name }}</td>
                            <td>{{ Str::limit($expense->description, 50) }}</td>
                            <td><strong>৳{{ number_format($expense->amount, 2) }}</strong></td>
                            <td>{{ $expense->creator->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No expenses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
