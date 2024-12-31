<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CustomerApiController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }
    public function show($id)
    {
        $customer = Customer::with(['city', 'state', 'country', 'phonecode'])->findOrFail($id);
        return response()->json($customer);
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone_code_id' => 'required|exists:phone_codes,id',
            'phone_number' => 'required|string|max:15',
            'dob' => 'required|date',
            'aadhar_number' => 'required|string|max:12',
            'pan_number' => 'required|string|max:10',
            'gender' => 'required|in:Male,Female,Other',
            'service_address' => 'required|string',
            'pincode' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_code_id' => $request->phone_code_id,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'aadhar_number' => $request->aadhar_number,
            'pan_number' => $request->pan_number,
            'gender' => $request->gender,
            'service_address' => $request->service_address,
            'pincode' => $request->pincode,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
        ]);

        return response()->json(['message' => 'Customer created successfully', 'customer' => $customer], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $id,
            'phone_code_id' => 'required|exists:phone_codes,id',
            'phone_number' => 'required|digits:10|unique:customers,phone_number,' . $id,
            'dob' => 'required|date',
            'aadhar_number' => 'required|digits:12|unique:customers,aadhar_number,' . $id,
            'pan_number' => 'required|size:10|unique:customers,pan_number,' . $id,
            'service_address' => 'required|string',
            'gender' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'pincode' => 'required|string|max:10',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer]);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
