<?php

namespace App\Http\Controllers;

use App\Models\BillingDetail;
use Illuminate\Http\Request;
use App\Models\HouseDetail;
use App\Models\OccupantDetail;
use App\Models\OccupantHouseStatus;
use Illuminate\Support\Facades\Log;


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
        $occupants = OccupantDetail::all();
        $billingDetails = BillingDetail::all();
        // dd( $billingDetails);
        return view('billing.billing_details.create', compact('billingDetails','occupants'));
    }
    
    public function store(Request $request)
    {
        Log::info('BillingDetailController@store: Received request data.', ['request_data' => $request->all()]);
    
        try {
            $billingDetail = BillingDetail::create([
                'house_id' => $request->house_id,
                'occupant_id' => $request->occupant_id,
                'last_pay_date' => $request->last_pay_date,
                'last_reading' => $request->last_reading,
                'outstanding_dues' => $request->outstanding_dues,
                'current_reading' => $request->current_reading,
                'current_charges' => $request->current_charges,
                'pay_date' => $request->pay_date,
                // 'status' => $request->status,
            ]);
    
            if ($billingDetail) {
                Log::info('BillingDetailController@store: Billing detail successfully created.', ['billing_detail' => $billingDetail]);
            } else {
                Log::error('BillingDetailController@store: Failed to create billing detail.');
            }
    
            return redirect()->route('billing_details.index')->with('success', 'Billing Details saved successfully!');
        } catch (\Exception $e) {
            Log::error('BillingDetailController@store: Exception occurred.', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to add billing detail.');
        }
    }
    
    

    public function show(BillingDetail $billingDetail)
    {
        $billingDetail->load([
            'occupantHouseStatus.house', 
            'occupantHouseStatus.occupant'
        ]);
    
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
            'house_id' => 'required|exists:house_details,id',
            'occupant_id' => 'required|exists:occupant_details,id',
            'last_reading' => 'required|numeric',
            'last_pay_date' => 'required|date',
            'outstanding_dues' => 'required|numeric',
            'current_reading' => 'required|numeric',
            'current_charges' => 'required|numeric',
            'pay_date' => 'required|date',
            // 'status' => 'required|in:partially,paid,unpaid',
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
