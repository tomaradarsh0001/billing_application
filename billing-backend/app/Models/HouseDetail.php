<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseDetail extends Model
{
    use HasFactory;

    protected $table = 'house_details';

    protected $fillable = [
        'hno', 
        'area', 
        'landmark', 
        'city', 
        'state', 
        'country', 
        'pincode',
    ];

    public function occupants()
    {
        return $this->hasOne(OccupantDetail::class, 'h_id');
    }
  
}
