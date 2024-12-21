<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        \Log::info('Request Data:', $request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
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
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'created_by' => 'required|exists:users,id',
        ]);

         // Handle Product images upload
    $uploadedImages = [];
    if ($request->hasFile('product_images')) {
        foreach ($request->file('product_images') as $image) {
            // Store image in public/uploads/product-images
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/product-images'), $imageName);  // Change to move to the correct folder
            $uploadedImages[] = 'uploads/product-images/' . $imageName;  // Store image path
        }
    }
    else {
        \Log::info('No files uploaded');  // Log if no files are uploaded
    }

    \Log::info('Uploaded Images:', $uploadedImages);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'has_delivery_free' => $request->has('has_delivery_free') ? 1 : 0,
            'product_images' => json_encode($uploadedImages), // Store image paths as JSON // Store as JSON array
            'created_by' => $request->created_by,
        ]);

        if ($request->tags) {
            $product->tags()->attach($request->tags);
        }

        // If a discount price is provided, store it in the discounts table
        if ($request->discount_price) {
            Discount::create([
                'product_id' => $product->id,
                'discount_price' => $request->discount_price,
                'promotion_start_time' => $request->promotion_start_time,
                'promotion_end_time' => $request->promotion_end_time,
            ]);
        }

        return back()->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'promotion_start_time' => 'nullable|date',
            'promotion_end_time' => 'nullable|date|after_or_equal:promotion_start_time',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'has_delivery_free' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:2048',
            'created_by' => 'required|exists:users,id',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'has_delivery_free' => $request->has('has_delivery_free') ? 1 : 0,
            'image' => $request->file('image') ? $request->file('image')->store('products', 'public') : $product->image,
            'created_by' => $request->created_by,
        ]);

        if ($request->tags) {
            $product->tags()->sync($request->tags);
        }

        // Update or create the discount
        if ($request->discount_price) {
            Discount::updateOrCreate(
                ['product_id' => $product->id], // Search for an existing discount for the product
                [
                    'discount_price' => $request->discount_price,
                    'promotion_start_time' => $request->promotion_start_time,
                    'promotion_end_time' => $request->promotion_end_time,
                ]
            );
        } else {
            // If no discount price is provided, delete the existing discount record
            Discount::where('product_id', $product->id)->delete();
        }

        return back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

   // In your ProductController
    public function getSubcategories($categoryId)
    {
        // Fetch subcategories based on the category ID
        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        // Return as JSON response
        return response()->json($subcategories);
    }
}
