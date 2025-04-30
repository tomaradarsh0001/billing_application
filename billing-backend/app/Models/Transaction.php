<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'billing_detail_id',
        'gateway_name',
        'gateway_transaction_id',
        'amount',
        'status',
        'payment_link'
    ];

    /**
     * Get the billing detail associated with the transaction.
     */
    public function billingDetail()
    {
        return $this->belongsTo(BillingDetail::class);
    }
}
