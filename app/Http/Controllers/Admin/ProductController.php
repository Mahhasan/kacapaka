<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\ProductImage;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $products = Product::with(['subCategory.category', 'brand'])->orderBy('position', 'asc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::where('is_active', true)->get();
        $subCategories = SubCategory::where('is_active', true)->get();
        $tags = Tag::where('is_active', true)->get();
        return view('admin.products.create', compact('brands', 'subCategories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'discount_price' => 'nullable|numeric|lt:selling_price',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
            'package_weight' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $thumbnailPath = $this->uploadImage($request, 'thumbnail_image', 'products');
            $position = $request->position ?? (Product::max('position') + 1);

            $product = Product::create([
                'product_name' => $request->product_name,
                'slug' => Str::slug($request->product_name) . '-' . uniqid(),
                'sku' => $request->sku,
                'sub_category_id' => $request->sub_category_id,
                'brand_id' => $request->brand_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'purchase_price' => $request->purchase_price ?? 0,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'stock_quantity' => $request->stock_quantity,
                'unit' => $request->unit,
                'thumbnail_image' => $thumbnailPath,
                'position' => $position,
                'is_active' => $request->has('is_active'),
                'created_by' => Auth::id(),
                'package_weight' => $request->package_weight,
                'package_length' => $request->package_length,
                'package_width' => $request->package_width,
                'package_height' => $request->package_height,
                'warranty_type' => $request->warranty_type,
                'warranty_period' => $request->warranty_period,
                'warranty_policy' => $request->warranty_policy,
                'free_item' => $request->free_item,
                'discount_start_date' => $request->discount_start_date,
                'discount_end_date' => $request->discount_end_date,
            ]);

            if ($request->has('tags')) {
                $product->tags()->sync($request->tags);
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $path = $file->storeAs('uploads/products/gallery', uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
                    $product->images()->create(['image_url' => $path, 'created_by' => Auth::id()]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $brands = Brand::where('is_active', true)->get();
        $subCategories = SubCategory::where('is_active', true)->get();
        $tags = Tag::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'brands', 'subCategories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $thumbnailPath = $this->updateImage($request, 'thumbnail_image', 'products', $product->thumbnail_image);

            $product->update($request->except(['_token', '_method', 'tags', 'gallery_images', 'thumbnail_image']) + [
                'thumbnail_image' => $thumbnailPath,
                'is_active' => $request->has('is_active'),
            ]);

            if ($request->has('tags')) {
                $product->tags()->sync($request->tags);
            } else {
                $product->tags()->sync([]);
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $path = $file->storeAs('uploads/products/gallery', uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
                    $product->images()->create(['image_url' => $path, 'created_by' => Auth::id()]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $this->deleteImage($product->thumbnail_image);
            foreach($product->images as $image) {
                $this->deleteImage($image->image_url);
            }
            $product->delete();
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete product.');
        }
    }

    public function destroyImage(ProductImage $image)
    {
        $this->deleteImage($image->image_url);
        $image->delete();
        return back()->with('success', 'Image deleted successfully.');
    }
}
