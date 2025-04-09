<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupantDetail extends Model
{
    use HasFactory;

    protected $table = 'occupant_details';

    protected $fillable = [
        'unique_id', 
        'h_id', 
        'first_name', 
        'last_name', 
        'phone_code_id',
        'mobile', 
        'email', 
        'occupation_date',
    ];

    public function house()
    {
        return $this->belongsTo(HouseDetail::class, 'h_id');
    }
    public function phoneCode()
    {
        return $this->belongsTo(PhoneCode::class);
    }
  
}
