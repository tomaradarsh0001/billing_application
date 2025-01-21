<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingDetail;


class BillingDetailApiController extends Controller
{
    public function index()
    {
        $bills = BillingDetail::all();
        return response()->json($bills);
    }
    public function show($id)
    {
        $bills = BillingDetail::with(['HouseDetail'])->findOrFail($id);
        return response()->json($bills);
    }
    public function store(Request $request)
    {
        $request->validate([
            'h_id' => 'required|exists:house_details,id',
            'last_reading' => 'required|numeric',
            'last_pay_date' => 'required|date',
            'outstanding_dues' => 'required|numeric',
            'current_reading' => 'required|numeric',
            'current_charges' => 'required|numeric',
            'pay_date' => 'required|date',
            'status' => 'required|in:partially,paid,unpaid',
        ]);

        $bills = BillingDetail::create([
            'h_id' => $request->h_id,
            'last_reading' => $request->last_reading,
            'last_pay_date' => $request->last_pay_date,
            'outstanding_dues' => $request->outstanding_dues,
            'current_reading' => $request->current_reading,
            'current_charges' => $request->current_charges,
            'pay_date' => $request->pay_date,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Bill created successfully', 'billing' => $bills], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'h_id' => 'required|exists:house_details,id',
            'last_reading' => 'required|numeric',
            'last_pay_date' => 'required|date',
            'outstanding_dues' => 'required|numeric',
            'current_reading' => 'required|numeric',
            'current_charges' => 'required|numeric',
            'pay_date' => 'required|date',
            'status' => 'required|in:partially,paid,unpaid',
        ]);

        $bills = BillingDetail::findOrFail($id);
        $bills->update($request->all());

        return response()->json(['message' => 'Bill updated successfully', 'billing' => $bills]);
    }

    public function destroy($id)
    {
        $bills = BillingDetail::findOrFail($id);
        $bills->delete();

        return response()->json(['message' => 'Bill deleted successfully']);
    }
}
