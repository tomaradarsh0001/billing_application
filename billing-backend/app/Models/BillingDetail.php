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
        'last_pay_date',
        'last_reading',
        'outstanding_dues',
        'current_reading',
        'current_charges',
        'pay_date',
        'remission',
        'unit_after_remission',
        'status'
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
    
}
