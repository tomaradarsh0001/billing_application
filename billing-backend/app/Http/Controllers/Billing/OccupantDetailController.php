<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OccupantDetail;
use App\Models\HouseDetail;
use App\Models\PhoneCode;


class OccupantDetailController extends Controller
{
    public function index()
    {
        $occupants = OccupantDetail::with('house')->get();
        return view('billing.occupant_details.index', compact('occupants'));
    }

    public function create()
    {
        $houses = HouseDetail::all();
        $phoneCodes = PhoneCode::all(); 
        return view('billing.occupant_details.create', compact('houses', 'phoneCodes'));
    }


    public function store(Request $request)
    {
        $latestOccupant = OccupantDetail::orderBy('unique_id', 'desc')->first();
        $nextId = $latestOccupant ? (int) substr($latestOccupant->unique_id, 2) + 1 : 1;
        $uniqueId = 'OD' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        $validated = $request->validate([
            'h_id' => 'required|exists:house_details,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_code_id' => 'required|exists:phone_codes,id',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'occupation_date' => 'required|date',
        ]);
    
        $validated['unique_id'] = $uniqueId;
        OccupantDetail::create($validated);
        return redirect()->route('occupants.index')->with('success', 'Occupant added successfully.');
    }
    
    public function edit($id)
    {
        $occupant = OccupantDetail::findOrFail($id);
        $houses = HouseDetail::all();
        $phoneCodes = PhoneCode::all(); 
        return view('billing.occupant_details.edit', compact('occupant', 'houses', 'phoneCodes'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'h_id' => 'required|exists:house_details,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_code_id' => 'required|exists:phone_codes,id',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'occupation_date' => 'required|date',
        ]);
    
        $occupant = OccupantDetail::findOrFail($id);
        $occupant->update($validated);
    
        return redirect()->route('occupants.index')->with('success', 'Occupant updated successfully.');
    }

    public function show($id)
{
    $occupant = OccupantDetail::with(['house', 'phoneCode'])
        ->findOrFail($id);

    return view('billing.occupant_details.show', compact('occupant'));
}


    public function destroy($id)
    {
        $occupant = OccupantDetail::findOrFail($id);
        $occupant->delete();
        return redirect()->route('occupants.index')->with('success', 'Occupant deleted successfully.');
    }


}
