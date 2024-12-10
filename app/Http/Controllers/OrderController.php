<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
            'payment_status' => 'required|string|in:unpaid,paid',
            'transaction_id' => 'nullable|string|max:255',
            'total_price' => 'required|numeric|min:0',
            'delivery_type' => 'required|string|in:free,paid',
            'delivery_charge' => 'required_if:delivery_type,paid|numeric|min:0',
        ]);

        $order = Order::create($request->only([
            'user_id',
            'order_status',
            'payment_status',
            'transaction_id',
            'total_price',
            'delivery_type',
            'delivery_charge',
        ]));

        // Attach order items
        foreach ($request->input('items', []) as $item) {
            $product = Product::findOrFail($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Order created successfully!');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
            'payment_status' => 'required|string|in:unpaid,paid',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        $order->update($request->only(['order_status', 'payment_status', 'transaction_id']));

        return back()->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully!');
    }
}
