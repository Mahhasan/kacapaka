<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('sourceable')->latest()->get();

        $balance = Transaction::select(DB::raw('SUM(CASE WHEN type = "Credit" THEN amount ELSE -amount END) as total'))->value('total');

        return view('admin.transactions.index', compact('transactions', 'balance'));
    }
}
