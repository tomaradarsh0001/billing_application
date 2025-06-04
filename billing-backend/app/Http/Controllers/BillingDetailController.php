<?php

namespace App\Http\Controllers;

use App\Services\CommunicationService;
use App\Models\BillingDetail;
use Illuminate\Http\Request;
use App\Models\HouseDetail;
use App\Models\TaxCharge;
use App\Models\OccupantDetail;
use App\Models\PerUnitRate;
use App\Models\Transaction;
use App\Models\OccupantHouseStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Mail\BillingSummaryMail;
use Illuminate\Support\Facades\Mail;



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

        $unitRate = PerUnitRate::where('status', 1)->value('unit_rate');
        $taxation = TaxCharge::where('status', 1)->get();
        return view('billing.billing_details.create', compact('billingDetails','occupants', 'unitRate', 'taxation'));
    }
    
    public function store(Request $request)
    {
        Log::info('BillingDetailController@store: Received request data.', ['request_data' => $request->all()]);
    
        try {
            $lastReading = $request->last_reading;
            $currentReading = $request->current_reading;
            $remission = $request->remission;
            $totalUnits = $lastReading + $currentReading;
            $unitAfterRemission = $totalUnits - $remission;
            $billingDetail = BillingDetail::create([
                'house_id' => $request->house_id,
                'occupant_id' => $request->occupant_id,
                'last_pay_date' => $request->last_pay_date,
                'last_reading' => $request->last_reading,
                'outstanding_dues' => $request->outstanding_dues,
                'current_reading' => $request->current_reading,
                'current_charges' => $request->current_charges,
                'pay_date' => $request->pay_date,
                'remission' => $request->remission,
                'unit_after_remission' => $unitAfterRemission,
                'status' => $request->status,
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
        $occupants = OccupantDetail::all();
        $unitRate = PerUnitRate::where('status', 1)->value('unit_rate');
        $taxation = TaxCharge::where('status', 1)->get();
        return view('billing.billing_details.edit', compact('billingDetail', 'occupants',  'unitRate', 'taxation'));
    }

    public function update(Request $request, BillingDetail $billingDetail)
        {
            try {
                $validated = $request->validate([
                    'house_id' => 'nullable|exists:house_details,id',
                    'occupant_id' => 'nullable|exists:occupant_details,id',
                    'last_reading' => 'nullable|numeric',
                    'last_pay_date' => 'nullable|date',
                    'outstanding_dues' => 'nullable|numeric',
                    'current_reading' => 'nullable|numeric',
                    'current_charges' => 'nullable|numeric',
                    'pay_date' => 'nullable|date',
                    'remission' => 'nullable|numeric',
                    'unit_after_remission' => 'nullable|numeric',
                    'status' => 'nullable|in:New,Generated,Approved', // Ensure status is one of the enum values
                ]);
                $validated['status'] = $request->status ?? 'Generated';
                $lastReading = $request->last_reading ?? $billingDetail->last_reading;
                $currentReading = $request->current_reading ?? $billingDetail->current_reading;
                $remission = $request->remission ?? $billingDetail->remission;
                $totalUnits = $currentReading - $lastReading;
                $unitAfterRemission = $totalUnits - $remission;
                $validated['unit_after_remission'] = $unitAfterRemission;
                $billingDetail->update($validated);
                // $paymentLink = $this->generatePaymentLink($billingDetail);
                // $this->sendPaymentLinkToPhone($billingDetail->occupant->phone, $paymentLink);
                return redirect()->route('billing_details.index')->with('success', 'Billing Detail updated successfully!');
            } catch (\Exception $e) {
                \Log::error('BillingDetailController@update: Failed to update.', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Failed to update Billing Detail.');
            }
        }

    public function destroy(BillingDetail $billingDetail)
    {
        $billingDetail->delete();

        return redirect()->route('billing_details.index')->with('success', 'Billing Detail deleted successfully!');
    }

    
    public function generateBillingPdf(Request $request)
    {
        $currentReading = $request->current_reading;
        $lastReading = $request->last_reading;
        $remission = $request->remission;
        $outstandingDues = $request->outstanding_dues;
        $totalUnits = $currentReading + $lastReading;
        $unitAfterRemission = $totalUnits - $remission;
        $currentCharges = PerUnitRate::where('status', 1)->value('unit_rate');
        $currentAmount = $request->currentAmount;
        $taxation = TaxCharge::all();
        $totalTax = 0;
        $taxDetails = [];
        foreach ($taxation as $tax) {
            $taxAmount = ($currentAmount * $tax->tax_percentage) / 100;
            $totalTax += $taxAmount;
            $taxDetails[] = [
                'name' => $tax->tax_name,
                'percentage' => $tax->tax_percentage,
                'amount' => $taxAmount,
            ];
        }
        $occupant = OccupantDetail::where('h_id', $request->house_id)->first();
        $houses = HouseDetail::where('id', $request->house_id)->first();
        $sum = $currentReading - $remission;
        $totalSum = $sum * $currentCharges;
        $grossTotal = $totalSum + $outstandingDues + $totalTax;
        $data = [
            'house_id' => $request->house_id,
            'occupant_id' => $request->occupant_id,
            'first_name' => $occupant?->first_name,
            'last_name' => $occupant?->last_name,
            'mobile' => $occupant?->mobile,
            'email' => $occupant?->email,
            'unique_id' => $occupant?->unique_id,
            'hno' => $houses?->hno,
            'area' => $houses?->area,
            'last_pay_date' => $request->last_pay_date,
            'last_reading' => $lastReading,
            'outstanding_dues' => $outstandingDues,
            'current_reading' => $currentReading,
            'current_charges' => $currentCharges,
            'pay_date' => $request->pay_date,
            'remission' => $remission,
            'unit_after_remission' => $unitAfterRemission,
            'total_units' => $totalUnits,
            'taxes' => $taxDetails,
            'grossTotal' => $grossTotal
        ];
        $payment_link = Transaction::where('amount', $data['grossTotal'])
        ->where('billing_detail_id', $request->billingDetails['id'])
        ->value('payment_link');
        $data['payment_link'] = $payment_link;
        $pdf = Pdf::loadView('generatepdf', $data);
        $fileName = 'billing_summary_' . now()->format('Ymd_His') . '_' . Str::random(5) . '.pdf';
        $filePath = 'public/billing_pdfs/' . $fileName;
        Storage::put($filePath, $pdf->output());

        $billingDetail = BillingDetail::where('house_id', $request->house_id)->first();
        if ($billingDetail) {
            $billingDetail->pdf_path = $fileName;
            $billingDetail->save();
        }

        // Send email
        $email = isset($data['email']) ? $data['email'] : 'example@gmail.com';
        Mail::to($email)->send(new BillingSummaryMail($data, $pdf->output(), $fileName));
        
         // Send SMS/WhatsApp 
         $phoneNumber = $data['mobile'];  
         $email = $data['email'];  
         $name = $data['first_name'] . " " . $data['last_name'];  
         $pdfFileName =  $fileName; 
         
         $communicationService = new CommunicationService();
         $communicationService->sendBillingMessages($name, $phoneNumber, $email, $pdfFileName);
         return $pdf->download($fileName);
    }
    
    
}
