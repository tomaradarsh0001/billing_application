<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
    public function create()
    {
        return view('customers.create');
    }
    public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers',
        'phone_number' => 'required|string|max:15',
        'service_address' => 'required|string',
        'dob' => 'required|date',
        'aadhar_number' => 'required|string|max:12',
        'pan_number' => 'required|string|max:10',
        'gender' => 'required|in:Male,Female,Other',
    ]);

    Customer::create($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
}
public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }
    
public function update(Request $request, Customer $customer)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email,' . $customer->id,
        'phone_number' => 'nullable|string|max:15',
        'service_address' => 'nullable|string',
        'dob' => 'nullable|date',
        'aadhar_number' => 'nullable|string|max:12',
        'pan_number' => 'nullable|string|max:10',
        'gender' => 'nullable|in:Male,Female,Other',
    ]);

    $customer->update($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
}
public function destroy(Customer $customer)
{
    $customer->delete();
    return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
}

}
