<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCode extends Model
{
    use HasFactory;
    
    protected $table = 'phone_codes'; 

    protected $fillable = ['iso', 'name', 'iso3', 'numcode', 'phonecode'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

}
