<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer');

        if ($request->has('status') && $request->status != '') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'customer', 'shippingAddress');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
            'payment_status' => 'required|in:Paid,Unpaid,Failed',
        ]);

        $order->order_status = $request->order_status;
        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
