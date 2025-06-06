<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BillingDetailApiController;
use App\Models\BillingDetail;
use Illuminate\Http\Request;
use App\Models\HouseDetail;
use App\Models\PerUnitRate;
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
        'house_id'          => 'required|exists:house_details,id',
        'occupant_id'       => 'required|exists:occupant_details,id',
        'last_pay_date'     => 'nullable|date',
        'outstanding_dues'  => 'nullable|numeric',
        'curr_meter_reading'=> 'required|numeric', 
        'current_charges'   => 'nullable|numeric',
        'pay_date'          => 'nullable|date',
    ]);

    try {
        $existing = BillingDetail::where('house_id', $validated['house_id'])
            ->orderBy('created_at', 'desc')
            ->first();

        $lastMeter = 0;
        $previousCurrMeter = 0;

        if ($existing) {
    $previousCurrMeter = $existing->curr_meter_reading ?? 0;
    $validated['last_meter_reading'] = $previousCurrMeter;

    if ($existing->payment_status == 0) {
        
$lastPaid = BillingDetail::where('house_id', $validated['house_id'])
    ->where('payment_status', 1)
    ->orderBy('created_at', 'desc')
    ->first();

$query = BillingDetail::where('house_id', $validated['house_id'])
    ->where('payment_status', 0);

if ($lastPaid) {
    $query->where('created_at', '>', $lastPaid->created_at);
}

$validated['last_reading'] = $query->sum('current_reading');


        $validated['outstanding_dues'] =
            ($validated['outstanding_dues'] ?? 0) +
            ($existing->outstanding_dues ?? 0) +
            ($existing->current_charges ?? 0);
    } else {
        $validated['last_reading'] = 0;
        $validated['outstanding_dues'] = 0;
    }
} else {
    $validated['last_meter_reading'] = 0;
    $validated['last_reading'] = 0;
}

$unitRate = PerUnitRate::where('status', 1)->value('unit_rate');


      $validated['current_reading'] = $validated['curr_meter_reading'] - $validated['last_meter_reading'];

if ($validated['current_reading'] < 0) {
    return response()->json([
        'success' => false,
        'message' => 'Current meter reading must be greater than or equal to last reading.',
    ], 422);
}

// Set current_charges = current_reading * 8
$validated['current_charges'] = $validated['current_reading'] * $unitRate;


        $billingDetail = BillingDetail::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Billing detail added successfully',
            'data' => $billingDetail
        ], 201);
    } catch (\Exception $e) {
        Log::error('BillingDetailApiController@store: Exception occurred.', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to add billing detail'
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
