<?php

namespace App\Http\Controllers;

class ConfigurationController extends Controller
{
    public function create()
    {
        return view('configuration.create');
    }
}
