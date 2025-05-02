<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HouseDetail;


class HouseDetailController extends Controller
{
    public function index()
    {
        $houses = HouseDetail::all();
        return view('billing.house_details.index', compact('houses'));
    }

    public function create()
    {
        return view('billing.house_details.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hno' => 'required|string',
            'house_type' => 'nullable|string',
            'meter_number' => 'nullable|string',
            'ews_qtr' => 'nullable|string',
            'area' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',
        ]);

        HouseDetail::create($request->all());

        return redirect()->route('houses.index')->with('success', 'House details added successfully!');
    }

    public function edit($id)
    {
        $house = HouseDetail::findOrFail($id);
        return view('billing.house_details.edit', compact('house'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'hno' => 'required|string',
            'house_type' => 'nullable|string',
            'meter_number' => 'nullable|string',
            'ews_qtr' => 'nullable|string',
            'area' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',
        ]);
    
        $house = HouseDetail::findOrFail($id);
        $house->update($validated);
    
        return redirect()->route('houses.index')->with('success', 'House details updated successfully!');
    }
    
    public function destroy($id)
    {
        $house = HouseDetail::findOrFail($id);
        $house->delete();
        return redirect()->route('houses.index')->with('success', 'Occupant deleted successfully.');
    }
}
