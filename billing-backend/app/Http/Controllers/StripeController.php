<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use App\Models\BillingDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;


class StripeController extends Controller
{
    public function checkout()
    {
        return view('payment.checkout');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey('sk_test_51RIp3oEEvLc2MjBmsPRHfCmINTxF8QT4pz6jyf3EhSouHeArEjNmONXfHELrtvzI2JhGouV8To7UGa9TZh3OvHn100xWNIr5zf');
    
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Billing',
                        ],
                        'unit_amount' => $request->amount, 
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                    'billing_detail_id' => $request->id, 
                ],
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
            ]);
            Log::info('Stripe Checkout Session Created:', [
                'session_id' => $session->id,
                'payment_link' => $session->url,
                'amount' => $request->amount,
                'billing_detail_id' => $request->id,
            ]);
            Transaction::create([
                'billing_detail_id' => $request->id,
                'gateway_name' => 'stripe',
                'gateway_transaction_id' => $session->id,
                'amount' => $request->amount / 100,
                'status' => 'pending',
                'payment_link' => $session->url,
            ]);
    
            return response()->json([
                'session_id' => $session->id,
                'message' => 'Payment session created and transaction recorded.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
    
        if (!$sessionId) {
            return redirect()->route('payment.cancel')->with('error', 'Session ID is missing.');
        }
    
        try {
            Stripe::setApiKey('sk_test_51RIp3oEEvLc2MjBmsPRHfCmINTxF8QT4pz6jyf3EhSouHeArEjNmONXfHELrtvzI2JhGouV8To7UGa9TZh3OvHn100xWNIr5zf');
    
            $session = Session::retrieve($sessionId);
           
            $billingDetailId = $session->metadata->billing_detail_id ?? null;
            $amount = $session->amount_total / 100; 
    
            if ($session->payment_status === 'paid' && $billingDetailId) {
                $billing = BillingDetail::find($billingDetailId);
    
                if ($billing) {
                    $existingTransaction = Transaction::where('billing_detail_id', $billingDetailId)
                        ->where('amount', $amount)
                        ->where('status', 'pending')
                        ->first();
    
                    if ($existingTransaction) {
                        $existingTransaction->status = 'success';
                        $existingTransaction->gateway_transaction_id = $session->id;
                        $existingTransaction->save();
                    } else {
                        Transaction::create([
                            'billing_detail_id' => $billing->id,
                            'gateway_name' => 'stripe',
                            'gateway_transaction_id' => $session->id,
                            'amount' => $amount,
                            'status' => 'success',
                        ]);
                    }
    
                    $billing->payment_status = 1; 
                    $billing->save();
    
                } else {
                    \Log::error('Billing detail not found for ID: ' . $billingDetailId);
                    return redirect()->route('payment.cancel')->with('error', 'Billing details not found.');
                }
            } else {
                \Log::error('Payment not successful or missing billing detail ID. Session ID: ' . $sessionId);
                return redirect()->route('payment.cancel')->with('error', 'Payment failed or invalid session.');
            }
    
            return view('payment.success', ['session' => $session]);
    
        } catch (ApiErrorException $e) {
            \Log::error('Stripe API Error: ' . $e->getMessage());
            return redirect()->route('payment.cancel')->with('error', 'Failed to retrieve payment details from Stripe.');
        } catch (\Exception $e) {
            \Log::error('General Error: ' . $e->getMessage());
            return redirect()->route('payment.cancel')->with('error', 'An error occurred while processing your payment.');
        }
    }
    

    public function paymentCancel(Request $request)
    {
        $billingDetailId = $request->query('billing_id');

        if ($billingDetailId) {
            $billing = BillingDetail::find($billingDetailId);
    
            if ($billing) {
                $billing->payment_status = 0; 
                $billing->save();
    
                Transaction::create([
                    'billing_detail_id' => $billing->id,
                    'gateway_name' => 'stripe',
                    'gateway_transaction_id' => null,
                    'amount' => $billing->amount,
                    'status' => 'cancelled',
                ]);
            }
        }
        return view('payment.cancel');
    }
}
