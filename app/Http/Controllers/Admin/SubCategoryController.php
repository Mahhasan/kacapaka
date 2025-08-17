<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->orderBy('position', 'asc')->get();
        return view('admin.sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('cat_name', 'asc')->get();
        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcat_name' => 'required|string|max:255',
            'position' => 'nullable|integer',
        ]);

        $position = $request->position ?? (SubCategory::max('position') + 1);

        SubCategory::create([
            'category_id' => $request->category_id,
            'subcat_name' => $request->subcat_name,
            'slug' => Str::slug($request->subcat_name),
            'position' => $position,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub-category created successfully.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::where('is_active', true)->orderBy('cat_name', 'asc')->get();
        return view('admin.sub_categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcat_name' => 'required|string|max:255',
            'position' => 'nullable|integer',
        ]);

        $subCategory->update([
            'category_id' => $request->category_id,
            'subcat_name' => $request->subcat_name,
            'slug' => Str::slug($request->subcat_name),
            'position' => $request->position ?? $subCategory->position,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub-category updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub-category deleted successfully.');
    }
}
