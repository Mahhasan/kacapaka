<?php

namespace App\Http\Controllers;

use App\Models\TransactionPurpose;
use App\Models\LedgerType;
use Illuminate\Http\Request;

class TransactionPurposeController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = TransactionPurpose::with('ledgerType')->get(); // Fetch transactions with their ledger type
        $ledgerTypes = LedgerType::all(); // Fetch all ledger types for the dropdown
        return view('admin.transaction-purposes', compact('transactions', 'ledgerTypes'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ledger_type_id' => 'required|exists:ledger_types,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
            'transaction_date' => 'required|date',
        ]);

        TransactionPurpose::create([
            'ledger_type_id' => $request->ledger_type_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('transaction-purposes.index')->with('success', 'Transaction added successfully.');
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, TransactionPurpose $transaction)
    {
        $request->validate([
            'ledger_type_id' => 'required|exists:ledger_types,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update([
            'ledger_type_id' => $request->ledger_type_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('transaction-purposes.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(TransactionPurpose $transaction)
    {
        $transaction->delete();

        return redirect()->route('transaction-purposes.index')->with('success', 'Transaction deleted successfully.');
    }
}
