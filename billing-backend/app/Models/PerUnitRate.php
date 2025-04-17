<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerUnitRate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'unit_rate',
        'from_date',
        'till_date',
        'status',
    ];
}
