<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem;
use App\Models\TransactionPurpose;
use Illuminate\Http\Request;

class TransactionItemController extends Controller
{
    /**
     * Display a listing of the transaction items.
     */
    public function index()
    {
        $transactionItems = TransactionItem::with('transactionPurpose')->get();
        $transactionPurposes = TransactionPurpose::all();
        return view('admin.ledger-management.transaction-items', compact('transactionItems', 'transactionPurposes'));
    }

    /**
     * Store a newly created transaction item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_purpose_id' => 'required|exists:transaction_purposes,id',
            'name' => 'required|string|max:255',
        ]);

        TransactionItem::create([
            'transaction_purpose_id' => $request->transaction_purpose_id,
            'name' => $request->name,
        ]);

        return redirect()->route('transaction-items.index')->with('success', 'Transaction item created successfully.');
    }

    /**
     * Update the specified transaction item in storage.
     */
    public function update(Request $request, TransactionItem $transactionItem)
    {
        $request->validate([
            'transaction_purpose_id' => 'required|exists:transaction_purposes,id',
            'name' => 'required|string|max:255',
        ]);

        $transactionItem->update([
            'transaction_purpose_id' => $request->transaction_purpose_id,
            'name' => $request->name,
        ]);

        return redirect()->route('transaction-items.index')->with('success', 'Transaction item updated successfully.');
    }

    /**
     * Remove the specified transaction item from storage.
     */
    public function destroy(TransactionItem $transactionItem)
    {
        $transactionItem->delete();

        return redirect()->route('transaction-items.index')->with('success', 'Transaction item deleted successfully.');
    }
}
