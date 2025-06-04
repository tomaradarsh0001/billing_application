<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

   protected $fillable = [
        'house_id',
        'occupant_id',
        'reading_date',
        'last_meter_reading',
        'current_meter_reading',
        'current_units',
        'rate_per_unit',
        'current_charges',
        'outstanding_dues',
        'payment_status',
        'pay_date',
        'payment_method',
        'transaction_id'
    ];

    protected $casts = [
        'reading_date' => 'date',
        'pay_date' => 'date',
        'last_meter_reading' => 'decimal:2',
        'current_meter_reading' => 'decimal:2',
        'current_units' => 'decimal:2',
        'rate_per_unit' => 'decimal:2',
        'current_charges' => 'decimal:2',
        'outstanding_dues' => 'decimal:2'
    ];
    public function houseDetail()
    {
        return $this->belongsTo(HouseDetail::class, 'h_id');
    }
    public function occupantHouseStatus()
    {
        return $this->belongsTo(OccupantHouseStatus::class, 'occupant_house_status_id');
    }

    public function occupant()
    {
        return $this->belongsTo(OccupantDetail::class, 'occupant_id'); 
    }
    
    public function house()
    {
        return $this->belongsTo(HouseDetail::class, 'house_id'); // Explicit foreign key
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'billing_detail_id');
    }
    
}
