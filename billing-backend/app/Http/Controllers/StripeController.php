<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('payment.checkout');
    }

    public function createCheckoutSession(Request $request)
    {
        try {
            Stripe::setApiKey('sk_test_51RIp3oEEvLc2MjBmsPRHfCmINTxF8QT4pz6jyf3EhSouHeArEjNmONXfHELrtvzI2JhGouV8To7UGa9TZh3OvHn100xWNIr5zf');
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Product Name', 
                            ],
                            'unit_amount' => 25,
                        ],
                        'quantity' => 1, 
                    ],
                ],
                'mode' => 'payment', 
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}', // Success URL after payment
                'cancel_url' => route('payment.cancel'), 
            ]);

            return redirect()->away($session->url);
        } catch (ApiErrorException $e) {
            \Log::error('Stripe API Error: ' . $e->getMessage());
            return redirect()->route('payment.cancel')->with('error', 'Payment could not be processed. Please try again.');
        }
    }
    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if ($sessionId) {
            try {
                Stripe::setApiKey('sk_test_51RIp3oEEvLc2MjBmsPRHfCmINTxF8QT4pz6jyf3EhSouHeArEjNmONXfHELrtvzI2JhGouV8To7UGa9TZh3OvHn100xWNIr5zf');
                $session = Session::retrieve($sessionId);
                return view('payment.success', ['session' => $session]);
            } catch (ApiErrorException $e) {
                \Log::error('Stripe API Error: ' . $e->getMessage());
                return redirect()->route('payment.cancel')->with('error', 'Failed to retrieve payment details.');
            }
        }
        return redirect()->route('payment.cancel');
    }
    public function paymentCancel()
    {
        return view('payment.cancel');
    }
}
