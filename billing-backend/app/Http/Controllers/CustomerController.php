<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\PhoneCode;
use App\Models\State;
use App\Models\City;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
    public function create()
    {
        $countries = Country::all();
        $phoneCodes = PhoneCode::all(); 
        return view('customers.create', compact('countries', 'phoneCodes'));
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json($cities);
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

        Customer::create([
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

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer = $customer->load(['city', 'state', 'country', 'phonecode']);
        // dd( $customer->city_id->name);
        return view('customers.show', compact('customer'));
    }
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $phoneCodes = PhoneCode::all(); 

        return view('customers.edit', compact('customer', 'countries', 'states', 'cities', 'phonecodes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
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
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone_code_id = $request->phone_code_id;
        $customer->phone_number = $request->phone_number;
        $customer->dob = $request->dob;
        $customer->aadhar_number = $request->aadhar_number;
        $customer->pan_number = $request->pan_number;
        $customer->service_address = $request->service_address;
        $customer->gender = $request->gender;
        $customer->country_id = $request->country_id;
        $customer->state_id = $request->state_id;
        $customer->city_id = $request->city_id;
        $customer->pincode = $request->pincode;

        $customer->save();
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
