<?php

namespace App\Http\Controllers\api;

use App\Models\Configuration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ConfigurationApiController extends Controller
{
    public function fetchConfiguration($id)
{
    $configuration = Configuration::find($id);
    if (!$configuration) {
        return Response::json(['error' => 'Configuration not found'], 404);
    }
    return Response::json(['data' => $configuration], 200);
}
}
