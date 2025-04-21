<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_name',
        'tax_percentage',
        'from_date',
        'till_date',
        'status',
    ];
    
}
