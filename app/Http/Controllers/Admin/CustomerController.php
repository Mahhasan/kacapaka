<?php

// File: app/Http/Controllers/Admin/CustomerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Assuming customers are in the User model
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * সব গ্রাহকের তালিকা দেখানোর জন্য।
     */
    public function index()
    {
        // এখানে শুধু সাধারণ ব্যবহারকারীদের (গ্রাহক) ফিল্টার করার লজিক যোগ করতে পারেন
        $customers = User::where('is_admin', false)->latest()->get(); // Example filter
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * একজন গ্রাহকের বিস্তারিত তথ্য দেখানোর জন্য।
     */
    public function show(User $customer)
    {
        // গ্রাহকের অর্ডার এবং অন্যান্য তথ্য লোড করুন
        $customer->load('orders');
        return view('admin.customers.show', compact('customer'));
    }
}
