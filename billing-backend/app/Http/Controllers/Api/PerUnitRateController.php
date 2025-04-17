<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerUnitRate;


class PerUnitRateController extends Controller
{
    public function index()
    {
        return response()->json(PerUnitRate::where('status', 1)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_rate' => 'required|numeric',
            'from_date' => 'required|date',
            'till_date' => 'nullable|date|after_or_equal:from_date',
            'status' => 'required|boolean',
        ]);

        $rate = PerUnitRate::create($validated);

        return response()->json([
            'message' => 'Rate added successfully',
            'data' => $rate,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $rate = PerUnitRate::findOrFail($id);

        $validated = $request->validate([
            'unit_rate' => 'required|numeric',
            'from_date' => 'required|date',
            'till_date' => 'nullable|date|after_or_equal:from_date',
            'status' => 'required|boolean',
        ]);

        $rate->update($validated);

        return response()->json([
            'message' => 'Rate updated successfully',
            'data' => $rate,
        ]);
    }

    public function show($id)
    {
        return response()->json(PerUnitRate::findOrFail($id));
    }

    public function destroy($id)
    {
        PerUnitRate::destroy($id);

        return response()->json(['message' => 'Rate deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $current = PerUnitRate::findOrFail($id);
        $totalRecords = PerUnitRate::count();
    
        if ($totalRecords == 1 && $current->status == 1) {
            return response()->json(['error' => 'Cannot deactivate the only active unit rate.'], 400);
        }
    
        if (!$current->status) {
            PerUnitRate::where('status', 1)
                ->where('id', '!=', $current->id)
                ->update([
                    'status' => 0,
                    'till_date' => now(),
                ]);
    
            $current->status = 1;
            $current->till_date = null;
        } else {
            $activeCount = PerUnitRate::where('status', 1)->count();
    
            if ($activeCount <= 1) {
                return response()->json(['error' => 'Cannot deactivate the only active unit rate.'], 400);
            }
    
            $current->status = 0;
            $current->till_date = now();
        }
    
        $current->save();
    
        return response()->json([
            'message' => 'Status toggled successfully.',
            'data' => $current,
        ]);
    }
    

}
