<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $categories = Category::orderBy('position', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'position' => 'nullable|integer',
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'categories');
        $position = $request->position ?? (Category::max('position') + 1);

        Category::create([
            'cat_name' => $request->cat_name,
            'slug' => Str::slug($request->cat_name),
            'description' => $request->description,
            'image' => $imagePath,
            'position' => $position,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories,cat_name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'position' => 'nullable|integer',
        ]);

        $imagePath = $this->updateImage($request, 'image', 'categories', $category->image);

        $category->update([
            'cat_name' => $request->cat_name,
            'slug' => Str::slug($request->cat_name),
            'description' => $request->description,
            'image' => $imagePath,
            'position' => $request->position ?? $category->position,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->deleteImage($category->image);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
