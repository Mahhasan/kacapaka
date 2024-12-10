<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with('product', 'order.user')->get();
        return view('admin.order-items.index', compact('orderItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        OrderItem::create($request->only(['order_id', 'product_id', 'quantity', 'price']));

        return back()->with('success', 'Order item added successfully!');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return back()->with('success', 'Order item removed successfully!');
    }
}
