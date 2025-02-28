<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'occ_id',
        'house_id', 'occupant_id',
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
    }
    public function occupantHouseStatus()
    {
        return $this->belongsTo(OccupantHouseStatus::class, 'occupant_house_status_id');
    }
    
}
