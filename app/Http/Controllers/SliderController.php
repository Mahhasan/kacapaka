<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('position')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'is_active' => 'boolean',
            'position' => 'required|integer',
        ]);

        $data = $request->only(['is_active', 'position']);
        $data['image'] = $request->file('image')->store('sliders', 'public');

        Slider::create($data);

        return back()->with('success', 'Slider created successfully!');
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'is_active' => 'boolean',
            'position' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['is_active', 'position']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return back()->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        return back()->with('success', 'Slider deleted successfully!');
    }
}
