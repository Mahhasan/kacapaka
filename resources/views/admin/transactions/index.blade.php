@extends('layouts.app')
@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">Transactions Ledger</h1>
        <h4>Current Balance: <span class="text-success">৳{{ number_format($balance, 2) }}</span></h4>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Source</th>
                            <th class="text-end">Credit</th>
                            <th class="text-end">Debit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M, Y h:i A') }}</td>
                            <td>{{ $transaction->description }}</td>
                            <td>
                                @if($transaction->sourceable_type == 'App\Models\Order')
                                    <a href="{{ route('admin.orders.show', $transaction->sourceable_id) }}">Order #{{ $transaction->sourceable->order_number }}</a>
                                @elseif($transaction->sourceable_type == 'App\Models\Expense')
                                    <a href="{{ route('admin.expenses.edit', $transaction->sourceable_id) }}">Expense</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-end text-success">
                                @if($transaction->type == 'Credit')
                                    <strong>+ ৳{{ number_format($transaction->amount, 2) }}</strong>
                                @endif
                            </td>
                            <td class="text-end text-danger">
                                 @if($transaction->type == 'Debit')
                                    <strong>- ৳{{ number_format($transaction->amount, 2) }}</strong>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No transactions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
