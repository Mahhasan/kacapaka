<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     */
    public function index()
    {
        $vendors = Vendor::orderBy('id', 'desc')->paginate(5); // Paginate vendors
        return view('admin.ledger-management.vendors', compact('vendors'));
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'person' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:500',
            'remark' => 'nullable|string|max:500',
            'status' => 'required|in:good,bad',
        ]);

        Vendor::create($request->all());

        return redirect()->route('vendors.index')->with('success', 'Vendor added successfully.');
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'person' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:500',
            'remark' => 'nullable|string|max:500',
            'status' => 'required|in:good,bad',
        ]);

        $vendor->update($request->all());

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified vendor from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
