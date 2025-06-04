<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerUnitRate;


class PerUnitRateWebController extends Controller
{
    public function index()
    {
        $rates = PerUnitRate::all();
        return view('per_unit_rates.index', compact('rates'));
    }

    public function create()
    {
        return view('per_unit_rates.create');
    }
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_rate' => 'required|numeric',
            'from_date' => 'nullable|date',  
            'till_date' => 'nullable|date', 
        ]);
    
        // Always deactivate existing active rate
        $existingActive = PerUnitRate::where('status', 1)->first();
    
        if ($existingActive) {
            $existingActive->status = 0;
            $existingActive->till_date = now(); 
            $existingActive->save();
        }
    
        $perUnitRate = new PerUnitRate();
        $perUnitRate->unit_rate = $validated['unit_rate'];
        $perUnitRate->status = 1; // Always set status to 1
        $perUnitRate->from_date = $validated['from_date'] ?? null;  
        $perUnitRate->till_date = null; // Since it's active, till_date is null
        $perUnitRate->save();
    
        return redirect()->route('per_unit_rates.index')->with('success', 'Per Unit Rate added successfully.');
    }
    
    

    public function edit($id)
    {
        $rate = PerUnitRate::findOrFail($id);
        return view('per_unit_rates.edit', compact('rate'));
    }

    public function update(Request $request, $id)
    {
        $rate = PerUnitRate::findOrFail($id);
        $validated = $request->validate([
            'unit_rate' => 'required|numeric',
            'from_date' => 'required|date',
            'till_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        $validated['status'] = $request->has('status') ? true : false;
        $rate->update($validated);
        return redirect()->route('per_unit_rates.index')->with('success', 'Rate updated');
    }

    public function destroy($id)
    {
        PerUnitRate::destroy($id);
        return redirect()->route('per_unit_rates.index')->with('success', 'Rate deleted');
    }
    
    public function toggleStatus($id)
    {
        $current = PerUnitRate::findOrFail($id);
        $totalRecords = PerUnitRate::count();
        if ($totalRecords == 1 && $current->status == 1) {
            return redirect()->back()->with('error', 'Status cannot be inactive. At least one active unit rate is required.');
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
                return redirect()->back()->with('error', 'Status cannot be inactive. At least one active unit rate is required.');
            }
            $current->status = 0;
            $current->till_date = now();
        }
        $current->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }


}
