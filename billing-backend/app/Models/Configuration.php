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
        'app_font_primary',
        'app_font_secondary',
        'app_theme_primary_light',
        'app_theme_primary_dark',
        'app_theme_secondary_light',
        'app_theme_secondary_dark',
        'app_theme_background',
        'app_theme_text_primary',
        'app_theme_text_secondary',
        'app_theme_svg_login',
        'app_theme_svg_signup',
        'app_theme_links',
    ];
}
