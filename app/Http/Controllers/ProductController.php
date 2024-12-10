<?php

// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
class ProductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-create', ['only' => ['store']]);
         $this->middleware('permission:product-edit', ['only' => ['update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->get();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('products.index', compact('products', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'category_id' => 'required|exists:categories,id',
            // 'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required',
            // 'description' => 'nullable',
            // 'price' => 'required|numeric',
            // 'discount_price' => 'nullable|numeric',
            // 'stock' => 'required|integer',
            // 'image' => 'required|string',
            // 'is_active' => 'required|boolean',
            // 'position' => 'required|integer',
            // 'has_free_delivery' => 'required|boolean',
            // 'delivery_charge' => 'nullable|numeric',
            // 'created_by' => 'required|exists:users,id',
        ]);

        Product::create($request->all());
        return back()->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'stock' => 'required|integer',
            'image' => 'required|string',
            'is_active' => 'required|boolean',
            'position' => 'required|integer',
            'has_free_delivery' => 'required|boolean',
            'delivery_charge' => 'nullable|numeric',
            'created_by' => 'required|exists:users,id',
        ]);

        $product->update($request->all());
        return back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}
