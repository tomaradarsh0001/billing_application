<?php

namespace App\Http\Controllers;

use App\Models\BillingDetail;
use Illuminate\Http\Request;
use App\Models\HouseDetail;
use App\Models\OccupantDetail;
use App\Models\OccupantHouseStatus;


class BillingDetailController extends Controller
{
    public function index()
{
    $billingDetails = BillingDetail::with([
        'occupantHouseStatus.house', 
        'occupantHouseStatus.occupant'
    ])->get();

    return view('billing.billing_details.index', compact('billingDetails'));
}


    public function create()
    {
        $houses = HouseDetail::all(); 
        $occupants = OccupantDetail::all();
    
        return view('billing.billing_details.create', compact('houses', 'occupants'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'occ_id' => 'required|exists:occupant_house_status,id',
            'house_id' => 'required|exists:house_details,id',
            'occupant_id' => 'required|exists:occupant_details,id',
            'last_reading' => 'required|numeric|min:0',
            'last_pay_date' => 'required|date',
            'outstanding_dues' => 'required|numeric|min:0',
            'current_reading' => 'required|numeric|min:0',
            'current_charges' => 'required|numeric|min:0',
            'pay_date' => 'required|date',
            'status' => 'required|in:paid,unpaid,partially',
        ]);
    
       
        BillingDetail::create($validated);
        return redirect()->route('billing_details.index')->with('success', 'Billing Detail added successfully!');
    }
    

    public function show(BillingDetail $billingDetail)
    {
        $billingDetails = BillingDetail::with('houseDetail')->get();
        return view('billing.billing_details.show', compact('billingDetail'));
    }

    public function edit(BillingDetail $billingDetail)
    {
        $houseDetails = HouseDetail::all();
        $occupantHouse = OccupantHouseStatus::all();
        return view('billing.billing_details.edit', compact('billingDetail', 'houseDetails', 'occupantHouse'));
    }

    public function update(Request $request, BillingDetail $billingDetail)
    {
        $validated = $request->validate([
            'occ_id' => 'required|exists:occupant_house_status,id',
            'last_reading' => 'required|numeric',
            'last_pay_date' => 'required|date',
            'outstanding_dues' => 'required|numeric',
            'current_reading' => 'required|numeric',
            'current_charges' => 'required|numeric',
            'pay_date' => 'required|date',
            'status' => 'required|in:partially,paid,unpaid',
        ]);

        $billingDetail->update($validated);

        return redirect()->route('billing_details.index')->with('success', 'Billing Detail updated successfully!');
    }

    public function destroy(BillingDetail $billingDetail)
    {
        $billingDetail->delete();

        return redirect()->route('billing_details.index')->with('success', 'Billing Detail deleted successfully!');
    }
}
