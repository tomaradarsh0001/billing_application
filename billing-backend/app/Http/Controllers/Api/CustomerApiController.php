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
        $customers = Customer::with(['country', 'state', 'city', 'phoneCode'])->get();
        return response()->json(['success' => true, 'data' => $customers]);
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

        $customer = Customer::create($request->all());

        return response()->json(['success' => true, 'message' => 'Customer created successfully.', 'data' => $customer]);
    }

    public function show($id)
    {
        $customer = Customer::with(['country', 'state', 'city', 'phoneCode'])->find($id);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone_code_id' => 'required|exists:phone_codes,id',
            'phone_number' => 'required|string|max:15|unique:customers,phone_number,' . $id,
            'dob' => 'required|date',
            'aadhar_number' => 'required|string|max:12|unique:customers,aadhar_number,' . $id,
            'pan_number' => 'required|string|max:10|unique:customers,pan_number,' . $id,
            'gender' => 'required|string',
            'service_address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'pincode' => 'required|string|max:10',
        ]);

        $customer->update($request->all());

        return response()->json(['success' => true, 'message' => 'Customer updated successfully.', 'data' => $customer]);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }

        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully.']);
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json(['success' => true, 'data' => $states]);
    }

    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json(['success' => true, 'data' => $cities]);
    }

    public function getCountries()
    {
        $countries = Country::all();
        return response()->json(['success' => true, 'data' => $countries]);
    }

    public function getPhoneCodes()
    {
        $codes = PhoneCode::all();
        return response()->json(['success' => true, 'data' => $codes]);
    }
}
