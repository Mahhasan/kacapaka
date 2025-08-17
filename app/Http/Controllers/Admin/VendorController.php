<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('position', 'asc')->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:vendors,phone',
            'email' => 'nullable|email|unique:vendors,email',
        ]);

        $position = $request->position ?? (Vendor::max('position') + 1);
        Vendor::create($request->all() + [
            'created_by' => Auth::id(),
            'position' => $position,
        ]);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:vendors,phone,' . $vendor->id,
            'email' => 'nullable|email|unique:vendors,email,' . $vendor->id,
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $vendor->update($data);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
