<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::orderBy('position', 'asc')->get();
        return view('admin.expense_categories.index', compact('expenseCategories'));
    }

    public function create()
    {
        return view('admin.expense_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['exp_cat_name' => 'required|string|max:255|unique:expense_categories']);

        $position = $request->position ?? (ExpenseCategory::max('position') + 1);
        ExpenseCategory::create($request->all() + [
            'created_by' => Auth::id(),
            'position' => $position,
        ]);

        return redirect()->route('admin.expense-categories.index')->with('success', 'Expense category created successfully.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('admin.expense_categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate(['exp_cat_name' => 'required|string|max:255|unique:expense_categories,exp_cat_name,' . $expenseCategory->id]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $expenseCategory->update($data);

        return redirect()->route('admin.expense-categories.index')->with('success', 'Expense category updated successfully.');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return redirect()->route('admin.expense-categories.index')->with('success', 'Expense category deleted successfully.');
    }
}
