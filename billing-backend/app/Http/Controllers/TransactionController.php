<?php

namespace App\Http\Controllers;

use App\Models\Transaction; 
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        $occ_name = $transactions->map(function($transaction) {
            return [
                'transaction_id' => $transaction->id,
                'occupant_full_name' => $transaction->billingDetail->occupant->first_name . ' ' . $transaction->billingDetail->occupant->last_name,
            ];
        });
                return view('transactions.index', compact('transactions', 'occ_name'));
    }
}
