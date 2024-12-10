<?php

namespace App\Http\Controllers;

use App\Models\RatingReview;
use Illuminate\Http\Request;

class RatingReviewController extends Controller
{
    public function index()
    {
        $reviews = RatingReview::with('user', 'product')->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        RatingReview::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}
