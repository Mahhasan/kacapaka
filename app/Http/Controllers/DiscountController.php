<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of discounts.
     */
    public function index()
    {
        $discounts = Discount::with('product')->get(); // Fetch all discounts with associated products
        $products = Product::all(); // Fetch all products for selection in forms

        return view('admin.discounts', compact('discounts', 'products'));
    }

    /**
     * Store a new discount in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_price' => 'required|numeric|min:0',
            'promotion_start_time' => 'nullable|date',
            'promotion_end_time' => 'nullable|date|after_or_equal:promotion_start_time',
        ]);

        Discount::create([
            'product_id' => $request->product_id,
            'discount_price' => $request->discount_price,
            'promotion_start_time' => $request->promotion_start_time,
            'promotion_end_time' => $request->promotion_end_time,
        ]);

        return back()->with('success', 'Discount created successfully.');
    }

    /**
     * Update an existing discount.
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_price' => 'required|numeric|min:0',
            'promotion_start_time' => 'nullable|date',
            'promotion_end_time' => 'nullable|date|after_or_equal:promotion_start_time',
        ]);

        $discount->update([
            'product_id' => $request->product_id,
            'discount_price' => $request->discount_price,
            'promotion_start_time' => $request->promotion_start_time,
            'promotion_end_time' => $request->promotion_end_time,
        ]);

        return back()->with('success', 'Discount updated successfully.');
    }

    /**
     * Delete a discount from the database.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Discount deleted successfully.');
    }
}
