<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('product')->where('user_id', auth()->id())->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return back()->with('success', 'Added to Wishlist!');
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();

        return back()->with('success', 'Removed from Wishlist!');
    }
}
