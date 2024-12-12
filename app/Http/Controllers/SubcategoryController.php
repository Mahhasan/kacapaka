<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.subcategories', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        SubCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return back()->with('success', 'Sub-category created successfully.');
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $subCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return back()->with('success', 'Sub-category updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return back()->with('success', 'Sub-category deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->update(['is_active' => $request->is_active]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}
