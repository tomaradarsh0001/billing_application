<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupantHouseStatus extends Model
{
    use HasFactory;
    protected $table = 'occupant_house_status';

    protected $fillable = [
        'occupant_id',
        'house_id',
        'status',
        'added_date',
    ];
    public function occupant()
    {
        return $this->belongsTo(OccupantDetail::class, 'occupant_id'); 
    }
    
    public function house()
    {
        return $this->belongsTo(HouseDetail::class, 'house_id'); // Explicit foreign key
    }
    
}
