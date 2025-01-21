<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'h_id',
        'last_reading',
        'last_pay_date',
        'outstanding_dues',
        'current_reading',
        'current_charges',
        'pay_date',
        'status',
    ];

    public function houseDetail()
    {
        return $this->belongsTo(HouseDetail::class, 'h_id');
    }}
