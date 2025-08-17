<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Stats Cards Data
        $totalSales = Order::where('order_status', 'Delivered')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::role('Customer')->count();
        $pendingOrders = Order::where('order_status', 'Pending')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Recent Orders
        $recentOrders = Order::with('customer')->latest()->take(5)->get();

        // Sales Chart Data (Last 7 Days)
        $salesByDay = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy(fn ($item) => Carbon::parse($item->date)->format('Y-m-d'));

        $dateRange = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dateRange->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        $salesDataPoints = $dateRange->map(fn ($date) => $salesByDay->get($date)->total ?? 0);
        $chartLabels = $dateRange->map(fn ($date) => Carbon::parse($date)->format('M d'));

        $salesData = ['labels' => $chartLabels, 'data' => $salesDataPoints];

        return view('home', compact(
            'totalSales', 'totalOrders', 'totalCustomers', 'pendingOrders',
            'totalProducts', 'totalCategories', 'recentOrders', 'salesData'
        ));
    }
}
