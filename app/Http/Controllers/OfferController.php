<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return view('admin.offers.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        Offer::create($request->only(['name', 'discount_percent', 'is_active']));

        return back()->with('success', 'Offer created successfully!');
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $offer->update($request->only(['name', 'discount_percent', 'is_active']));

        return back()->with('success', 'Offer updated successfully!');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return back()->with('success', 'Offer deleted successfully!');
    }
}

