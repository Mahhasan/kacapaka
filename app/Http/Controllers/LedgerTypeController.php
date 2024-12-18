<?php

namespace App\Http\Controllers;

use App\Models\LedgerType;
use Illuminate\Http\Request;

class LedgerTypeController extends Controller
{
    public function index()
    {
        $ledgerTypes = LedgerType::all();
        return view('admin.ledger-types', compact('ledgerTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ledger_types,name',
            'description' => 'nullable|string|max:500',
        ]);

        LedgerType::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Ledger Type created successfully.');
    }

    public function update(Request $request, LedgerType $ledgerType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ledger_types,name,' . $ledgerType->id,
            'description' => 'nullable|string|max:500',
        ]);

        $ledgerType->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Ledger Type updated successfully.');
    }

    public function destroy(LedgerType $ledgerType)
    {
        $ledgerType->delete();
        return back()->with('success', 'Ledger Type deleted successfully.');
    }
}