<?php

namespace App\Http\Controllers;

use App\Models\BillingDetail;
use Illuminate\Http\Request;
use App\Models\HouseDetail;

class BillingDetailController extends Controller
{
    public function index()
    {
        $billingDetails = BillingDetail::with('houseDetail')->get();
        return view('billing.billing_details.index', compact('billingDetails'));
    }

    public function create()
    {
        $houseDetails = HouseDetail::all();
        return view('billing.billing_details.create', compact('houseDetails'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'h_id' => 'required|exists:house_details,id',
            'last_reading' => 'required|numeric',
            'last_pay_date' => 'required|date',
            'outstanding_dues' => 'required|numeric',
            'current_reading' => 'required|numeric',
            'current_charges' => 'required|numeric',
            'pay_date' => 'required|date',
            'status' => 'required|in:partially,paid,unpaid',
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
        return view('billing.billing_details.edit', compact('billingDetail', 'houseDetails'));
    }

    public function update(Request $request, BillingDetail $billingDetail)
    {
        $validated = $request->validate([
            'h_id' => 'required|exists:house_details,id',
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
