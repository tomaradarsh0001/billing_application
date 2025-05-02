<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseDetail extends Model
{
    use HasFactory;

    protected $table = 'house_details';

    protected $fillable = [
        'hno', 'house_type', 'meter_number', 'ews_qtr',
        'area', 'city', 'state', 'country', 'pincode'
    ];

    public function occupants()
    {
        return $this->hasOne(OccupantDetail::class, 'h_id');
    }
  
}
