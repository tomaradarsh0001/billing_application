<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'app_logo',
        'app_tagline',
        'app_theme',
    ];
}
