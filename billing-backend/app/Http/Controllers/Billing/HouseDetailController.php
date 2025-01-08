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
        $request->validate([
            'hno' => 'required',
            'area' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);

        HouseDetail::create($request->all());

        return redirect()->route('houses.index')->with('success', 'House details added successfully!');
    }

    public function destroy($id)
    {
        $house = HouseDetail::findOrFail($id);
        $house->delete();
        return redirect()->route('houses.index')->with('success', 'Occupant deleted successfully.');
    }
}
