<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OccupantDetail;
use App\Models\OccupantHouseStatus;
use App\Models\HouseDetail;
use App\Models\PhoneCode;

class HouseOccupantDetailApiController extends Controller
{
    public function index()
    {
        $occupants = OccupantDetail::with(['house', 'phoneCode'])->get();
        return response()->json($occupants);
    }

    public function show($id)
    {
        $occupant = OccupantDetail::with(['house', 'phoneCode'])->findOrFail($id);
        return response()->json($occupant);
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
            'email' => 'nullable|email|max:255|unique:occupant_details,email',
            'occupation_date' => 'required|date',
        ]);

        $validated['unique_id'] = $uniqueId;

        $occupant = OccupantDetail::create($validated);

        OccupantHouseStatus::create([
            'occupant_id' => $occupant->id,
            'house_id' => $validated['h_id'],
            'status' => 'active',
            'added_date' => now(),
        ]);

        return response()->json(['message' => 'Occupant added successfully', 'occupant' => $occupant], 201);
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

        return response()->json(['message' => 'Occupant updated successfully', 'occupant' => $occupant]);
    }

    public function destroy($id)
    {
        $occupant = OccupantDetail::findOrFail($id);
        $occupant->delete();

        return response()->json(['message' => 'Occupant deleted successfully']);
    }
}
