<?php

namespace App\Http\Controllers;

use App\Models\TransactionPurpose;
use App\Models\LedgerType;
use Illuminate\Http\Request;

class TransactionPurposeController extends Controller
{
    /**
     * Display a listing of the transaction purposes.
     */
    public function index()
    {
        $transactionPurposes = TransactionPurpose::with('ledgerType')->get();
        $ledgerTypes = LedgerType::all();
        return view('admin.ledger-management.transaction-purposes', compact('transactionPurposes', 'ledgerTypes'));
    }

    /**
     * Store a newly created transaction purpose in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ledger_type_id' => 'required|exists:ledger_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        TransactionPurpose::create([
            'ledger_type_id' => $request->ledger_type_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('transaction-purposes.index')->with('success', 'Transaction purpose created successfully.');
    }

    /**
     * Update the specified transaction purpose in storage.
     */
    public function update(Request $request, TransactionPurpose $transactionPurpose)
    {
        $request->validate([
            'ledger_type_id' => 'required|exists:ledger_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $transactionPurpose->update([
            'ledger_type_id' => $request->ledger_type_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('transaction-purposes.index')->with('success', 'Transaction purpose updated successfully.');
    }

    /**
     * Remove the specified transaction purpose from storage.
     */
    public function destroy(TransactionPurpose $transactionPurpose)
    {
        $transactionPurpose->delete();

        return redirect()->route('transaction-purposes.index')->with('success', 'Transaction purpose deleted successfully.');
    }
}
