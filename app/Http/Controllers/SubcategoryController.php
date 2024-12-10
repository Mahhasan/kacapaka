<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        $categories = Category::all();
        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:subcategories',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create($request->only(['name', 'slug', 'description', 'is_active', 'category_id']));

        return back()->with('success', 'Subcategory created successfully!');
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:subcategories,slug,' . $subcategory->id,
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory->update($request->only(['name', 'slug', 'description', 'is_active', 'category_id']));

        return back()->with('success', 'Subcategory updated successfully!');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return back()->with('success', 'Subcategory deleted successfully!');
    }
}
