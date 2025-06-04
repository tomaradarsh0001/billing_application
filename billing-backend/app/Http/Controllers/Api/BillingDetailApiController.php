<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BillingDetailApiController;
use App\Models\BillingDetail;
use Illuminate\Http\Request;
use App\Models\HouseDetail;
use App\Models\OccupantDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class BillingDetailApiController extends Controller
{
    public function index(): JsonResponse
    {
        $billingDetails = BillingDetail::with(['house', 'occupant'])->get();
        return response()->json(['success' => true, 'data' => $billingDetails], 200);
    }


 public function store(Request $request): JsonResponse
{
    $validated = $request->validate([
        'house_id' => 'required|exists:house_details,id',
        'occupant_id' => 'required|exists:occupant_details,id',
        'current_meter_reading' => 'required|numeric|min:0', 
        'reading_date' => 'required|date',
        'rate_per_unit' => 'required|numeric|min:0', 
    ]);

    try { 
        $previousReading = BillingDetail::where('house_id', $validated['house_id'])
            ->orderBy('reading_date', 'desc')
            ->first();

        $consumedUnits = $previousReading 
            ? $validated['current_meter_reading'] - $previousReading->current_meter_reading
            : $validated['current_meter_reading']; 

        if ($previousReading && $validated['current_meter_reading'] < $previousReading->current_meter_reading) {
            return response()->json([
                'success' => false,
                'message' => 'Current meter reading cannot be less than previous reading'
            ], 422);
        }

        $currentCharges = $consumedUnits * $validated['rate_per_unit'];

        $billingData = [
            'house_id' => $validated['house_id'],
            'occupant_id' => $validated['occupant_id'],
            'reading_date' => $validated['reading_date'],
            'last_meter_reading' => $previousReading ? $previousReading->current_meter_reading : 0,
            'last_units' => $previousReading ? $previousReading->current_units : 0,
            'current_meter_reading' => $validated['current_meter_reading'],
            'current_units' => $consumedUnits,
            'rate_per_unit' => $validated['rate_per_unit'],
            'current_charges' => $currentCharges,
        ];

        if ($previousReading && $previousReading->payment_status == 0) {
            $billingData['outstanding_dues'] = 
                ($previousReading->outstanding_dues ?? 0) + 
                ($previousReading->current_charges ?? 0);
        } else {
            $billingData['outstanding_dues'] = $previousReading->outstanding_dues ?? 0;
        }

        $billingDetail = BillingDetail::create($billingData);

        return response()->json([
            'success' => true,
            'message' => 'Meter reading recorded successfully',
            'data' => $billingDetail,
            'calculated_values' => [
                'current_units' => $consumedUnits,
                'current_charges' => $currentCharges
            ]
        ], 201);
    } catch (\Exception $e) {
        Log::error('BillingDetailApiController@store: Exception occurred.', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to record meter reading: ' . $e->getMessage()
        ], 500);
    }
}


    public function show($id): JsonResponse
    {
        $billingDetail = BillingDetail::with(['house', 'occupant'])->find($id);
    
        if (!$billingDetail) {
            return response()->json(['success' => false, 'message' => 'Billing detail not found'], 404);
        }
    
        $data = [
            'id' => $billingDetail->id,
            'house' => [
                'id' => $billingDetail->house->id ?? null,
                'hno' => $billingDetail->house->hno ?? 'N/A',
                'area' => $billingDetail->house->area ?? 'N/A',
            ],
            'occupant' => [
                'id' => $billingDetail->occupant->id ?? null,
                'first_name' => $detail->occupant->first_name ?? 'N/A',
                'last_name' => $detail->occupant->last_name ?? 'N/A',
            ],
            'last_pay_date' => $billingDetail->last_pay_date,
            'last_reading' => $billingDetail->last_reading,
            'outstanding_dues' => $billingDetail->outstanding_dues,
            'current_reading' => $billingDetail->current_reading,
            'current_charges' => $billingDetail->current_charges,
            'pay_date' => $billingDetail->pay_date,
            // 'status' => $billingDetail->status,
        ];
    
        return response()->json(['success' => true, 'data' => $data], 200);
    }
    

    public function update(Request $request, $id): JsonResponse
    {
        $billingDetail = BillingDetail::find($id);
    
        if (!$billingDetail) {
            return response()->json(['success' => false, 'message' => 'Billing detail not found'], 404);
        }
    
        $validated = $request->validate([
            'house_id' => 'required|exists:house_details,id',
            'occupant_id' => 'required|exists:occupant_details,id',
            'last_pay_date' => 'required|date',
            'last_reading' => 'required|numeric',
            'outstanding_dues' => 'required|numeric',
            'current_reading' => 'required|numeric',
            'current_charges' => 'required|numeric',
            'pay_date' => 'required|date',
            // 'status' => 'required|in:partially,paid,unpaid',
        ]);
    
        $billingDetail->update($validated);
        return response()->json(['success' => true, 'message' => 'Billing detail updated successfully', 'data' => $billingDetail], 200);
    }

    public function destroy($id): JsonResponse
    {
        $billingDetail = BillingDetail::find($id);
    
        if (!$billingDetail) {
            return response()->json(['success' => false, 'message' => 'Billing detail not found'], 404);
        }
    
        $billingDetail->delete();
        return response()->json(['success' => true, 'message' => 'Billing detail deleted successfully'], 200);
    }
}
