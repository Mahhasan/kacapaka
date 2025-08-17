<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('vendor')->latest()->get();
        return view('admin.purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $vendors = Vendor::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get(['id', 'product_name']);
        return view('admin.purchase_orders.create', compact('vendors', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = collect($request->items)->sum(function ($item) {
                return $item['quantity'] * $item['cost'];
            });

            $purchaseOrder = PurchaseOrder::create([
                'vendor_id' => $request->vendor_id,
                'purchase_order_code' => 'PO-' . time() . rand(10, 99),
                'order_date' => $request->order_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount ?? 0,
                'order_status' => $request->order_status ?? 'Pending',
                'created_by' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_per_unit' => $item['cost'],
                    'total_cost' => $item['quantity'] * $item['cost'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create Purchase Order: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('vendor', 'items.product');
        return view('admin.purchase_orders.show', compact('purchaseOrder'));
    }
}
