<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingDetail;


class BillingDetailApiController extends Controller
{
    public function index()
    {
        $bills = BillingDetail::with(['HouseDetail'])->get();
        return response()->json($bills);
    }
    public function show($id)
    {
        $bills = BillingDetail::with(['HouseDetail'])->findOrFail($id);
        return response()->json($bills);
    }
    public function store(Request $request)
    {
        $bills = BillingDetail::create($request->only([
            'h_id',
            'last_reading',
            'last_pay_date',
            'outstanding_dues',
            'current_reading',
            'current_charges',
            'pay_date',
            'status',
        ]));
    
        return response()->json(['message' => 'Bill created successfully', 'billing' => $bills], 201);
    }
    

    public function update(Request $request, $id)
    {
        $bills = BillingDetail::findOrFail($id);

        $bills->update($request->only([
             'h_id',
             'last_reading',
             'last_pay_date',
             'outstanding_dues',
             'current_reading',
             'current_charges',
             'pay_date',
             'status',
         ]));

        return response()->json(['message' => 'Bill updated successfully', 'billing' => $bills]);
    }


    public function destroy($id)
    {
        $bills = BillingDetail::findOrFail($id);
        $bills->delete();

        return response()->json(['message' => 'Bill deleted successfully']);
    }
}
