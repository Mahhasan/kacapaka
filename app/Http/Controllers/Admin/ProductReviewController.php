<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['product', 'customer'])->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Request $request, ProductReview $review)
    {
        $review->is_approved = $request->has('is_approved');
        $review->is_active = $request->has('is_active');
        $review->save();

        return redirect()->route('admin.reviews.index')->with('success', 'Review status updated.');
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}
