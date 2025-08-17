<?php

// File: app/Http/Controllers/Admin/EmployeeController.php (NEWLY ADDED)

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetches users who are not customers.
        $employees = User::whereHas('roles', function($q){
            $q->where('name', '!=', 'Customer');
        })->with('employee')->latest()->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        // Exclude the 'Customer' role from the list
        $roles = Role::where('name', '!=', 'Customer')->pluck('name', 'name');
        return view('admin.employees.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'unique:employees,phone'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        Employee::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(User $employee)
    {
        $employee->load('employee'); // Eager load employee data
        $roles = Role::where('name', '!=', 'Customer')->pluck('name', 'name');
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'unique:employees,phone,' . ($employee->employee->id ?? '')],
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $employee->update(['password' => Hash::make($request->password)]);
        }

        $employee->syncRoles($request->role);

        $employee->employee()->updateOrCreate(
            ['user_id' => $employee->id],
            [
                'phone' => $request->phone,
                'joining_date' => $request->joining_date,
                'is_active' => $request->has('is_active'),
            ]
        );

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
