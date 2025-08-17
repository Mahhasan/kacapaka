<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('position', 'asc')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|unique:promotions',
            'type' => 'required|in:Percentage,Fixed Amount',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $position = $request->position ?? (Promotion::max('position') + 1);
        Promotion::create($request->all() + [
            'created_by' => Auth::id(),
            'position' => $position,
        ]);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'promo_code' => 'required|string|unique:promotions,promo_code,' . $promotion->id,
            'type' => 'required|in:Percentage,Fixed Amount',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $promotion->update($data);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted successfully.');
    }
}
