<?php
namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    public function index()
    {
        $productTags = ProductTag::with('product', 'tag')->get();
        return view('admin.product-tags.index', compact('productTags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'tag_id' => 'required|exists:tags,id',
        ]);

        ProductTag::create($request->only(['product_id', 'tag_id']));

        return back()->with('success', 'Tag associated with product successfully!');
    }

    public function destroy(ProductTag $productTag)
    {
        $productTag->delete();

        return back()->with('success', 'Tag removed from product successfully!');
    }

    // public function index()
    // {

    // }


    // public function create()
    // {

    // }


    // public function store(Request $request)
    // {

    // }


    // public function show(ProductTag $productTag)
    // {

    // }


    // public function edit(ProductTag $productTag)
    // {

    // }

    // public function update(Request $request, ProductTag $productTag)
    // {

    // }

    // public function destroy(ProductTag $productTag)
    // {

    // }
}





