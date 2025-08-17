<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $brands = Brand::orderBy('position', 'asc')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255|unique:brands',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $logoPath = $this->uploadImage($request, 'logo', 'brands');
        $position = $request->position ?? (Brand::max('position') + 1);

        Brand::create([
            'brand_name' => $request->brand_name,
            'slug' => Str::slug($request->brand_name),
            'logo' => $logoPath,
            'position' => $position,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255|unique:brands,brand_name,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $logoPath = $this->updateImage($request, 'logo', 'brands', $brand->logo);

        $brand->update([
            'brand_name' => $request->brand_name,
            'slug' => Str::slug($request->brand_name),
            'logo' => $logoPath,
            'position' => $request->position ?? $brand->position,
            'is_active' => $request->has('is_active'),
        ]);
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $this->deleteImage($brand->logo);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
