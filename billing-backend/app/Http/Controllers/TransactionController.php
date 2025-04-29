<?php

namespace App\Http\Controllers;

use App\Models\Transaction;  // Assuming your transaction model is named "Transaction"
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Fetch all transactions from the database
        $transactions = Transaction::all();

        // Pass transactions to the view
        return view('transactions.index', compact('transactions'));
    }
}
