<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subcategory', 'tags'])->get();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $tags = Tag::all();

        return view('admin.products', compact('products', 'categories', 'subcategories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'promotion_start_time' => 'nullable|date',
            'promotion_end_time' => 'nullable|date|after_or_equal:promotion_start_time',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'has_delivery_free' => 'nullable|boolean',
            'tags' => 'nullable|array', // Tags array
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'promotion_start_time' => $request->promotion_start_time,
            'promotion_end_time' => $request->promotion_end_time,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'has_delivery_free' => $request->has('delivery_free') ? 1 : 0,
            'image' => $request->file('image') ? $request->file('image')->store('products', 'public') : null,
        ]);

        if ($request->tags) {
            $product->tags()->attach($request->tags);
        }

        return back()->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'promotion_start_time' => 'nullable|date',
            'promotion_end_time' => 'nullable|date|after_or_equal:promotion_start_time',
            'position' => 'nullable|integer|min:0',
            'delivery_free' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'promotion_start_time' => $request->promotion_start_time,
            'promotion_end_time' => $request->promotion_end_time,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'has_delivery_free' => $request->has('delivery_free') ? 1 : 0,
            'image' => $request->file('image') ? $request->file('image')->store('products', 'public') : $product->image,
        ]);

        if ($request->tags) {
            $product->tags()->sync($request->tags);
        }

        return back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}
