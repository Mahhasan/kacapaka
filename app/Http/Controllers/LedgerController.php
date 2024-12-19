<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\LedgerType;
use App\Models\TransactionPurpose;
use App\Models\TransactionItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{
    /**
     * Display a listing of the ledgers.
     */
    public function index()
    {
        $ledgers = Ledger::with(['ledgerType', 'transactionPurpose', 'transactionItem', 'vendor'])->get();
        $ledgerTypes = LedgerType::all();
        $transactionPurposes = TransactionPurpose::all();
        $transactionItems = TransactionItem::all();
        $vendors = Vendor::all();
        return view('admin.ledger-management.ledgers', compact('ledgers', 'ledgerTypes', 'transactionPurposes', 'transactionItems', 'vendors'));
    }

    /**
     * Store a newly created ledger in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ledger_type_id' => 'required|exists:ledger_types,id',
            'transaction_purpose_id' => 'required|exists:transaction_purposes,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'transaction_item_id' => 'nullable|exists:transaction_items,id',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'is_paid' => 'required|in:paid,due',
            'paid_date' => 'nullable|date',
            'buy_or_sell_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'voucher' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'created_by' => 'required|exists:users,id',
        ]);

       // Handle the voucher image upload directly in the public folder
        $voucherPath = null;
        if ($request->hasFile('voucher')) {
            $voucher = $request->file('voucher');

            // Generate a unique file name
            $voucherName = time() . '.' . $voucher->getClientOriginalExtension();

            // Define the public path where the voucher image will be stored
            $voucherPath = 'uploads/vouchers/' . $voucherName;

            // Move the file to the public folder
            $voucher->move(public_path('uploads/vouchers'), $voucherName);
        }

        // Store the ledger data
        $ledger = Ledger::create([
            'ledger_type_id' => $request->ledger_type_id,
            'transaction_purpose_id' => $request->transaction_purpose_id,
            'vendor_id' => $request->vendor_id,
            'transaction_item_id' => $request->transaction_item_id,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $request->total_amount,
            'is_paid' => $request->is_paid,
            'paid_date' => $request->paid_date,
            'buy_or_sell_date' => $request->buy_or_sell_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'voucher' => $voucherPath,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('ledgers.index')->with('success', 'Ledger created successfully.');
    }

    /**
     * Update the specified ledger in storage.
     */
    public function update(Request $request, Ledger $ledger)
    {
        $request->validate([
            'ledger_type_id' => 'required|exists:ledger_types,id',
            'transaction_purpose_id' => 'required|exists:transaction_purposes,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'transaction_item_id' => 'nullable|exists:transaction_items,id',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'is_paid' => 'required|in:paid,due',
            'paid_date' => 'nullable|date',
            'buy_or_sell_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'voucher' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'created_by' => 'required|exists:users,id',
        ]);

        // Handle the voucher image upload (if present)
        $voucherPath = $ledger->voucher;  // keep current voucher if no new image is uploaded
        if ($request->hasFile('voucher')) {
            // Delete the old voucher file if exists
            if ($ledger->voucher && file_exists(public_path($ledger->voucher))) {
                unlink(public_path($ledger->voucher)); // Delete the old file
            }

            // Get the new voucher file and store it in the public folder
            $voucher = $request->file('voucher');
            $voucherName = time() . '.' . $voucher->getClientOriginalExtension();
            $voucherPath = 'uploads/vouchers/' . $voucherName;

            // Move the new image to the public folder
            $voucher->move(public_path('uploads/vouchers'), $voucherName);
        }

         // Update the ledger data
        $ledger->update([
            'ledger_type_id' => $request->ledger_type_id,
            'transaction_purpose_id' => $request->transaction_purpose_id,
            'vendor_id' => $request->vendor_id,
            'transaction_item_id' => $request->transaction_item_id,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $request->total_amount,
            'is_paid' => $request->is_paid,
            'paid_date' => $request->paid_date,
            'buy_or_sell_date' => $request->buy_or_sell_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'voucher' => $voucherPath,
        ]);

        return redirect()->route('ledgers.index')->with('success', 'Ledger updated successfully.');
    }

    /**
     * Remove the specified ledger from storage.
     */
    public function destroy(Ledger $ledger)
    {
        // if ($ledger->voucher) {
        //     Storage::delete($ledger->voucher);
        // }
        if ($ledger->voucher) {
            $filePath = public_path('uploads/' . $ledger->voucher); // Get the full file path in public folder
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }
        }
        $ledger->delete();

        return redirect()->route('ledgers.index')->with('success', 'Ledger deleted successfully.');
    }
}
