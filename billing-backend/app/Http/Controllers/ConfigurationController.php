<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ConfigurationController extends Controller
{
    
    public function index()
    {
        $configurations = Configuration::all();
        return view('configuration.index', compact('configurations'));
    }
    public function view($id)
    {
        $configuration = Configuration::findOrFail($id);
        return view('configuration.view', compact('configuration'));
    }
    public function create()
    {
        $response = Http::get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCas7Ce7ycj4zRlD3fx53GvhreTVS-g6TI');
        $fonts = $response->successful() ? $response->json()['items'] : [];
        return view('configuration.create', compact('fonts'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_purpose' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'app_tagline' => 'nullable|string|max:255',
            'app_font_primary' => 'nullable|string|max:255',
            'app_font_secondary' => 'nullable|string|max:255',
            'app_theme_primary_light' => 'nullable|string',
            'app_theme_primary_dark' => 'nullable|string',
            'app_theme_secondary_light' => 'nullable|string',
            'app_theme_secondary_dark' => 'nullable|string',
            'app_theme_background' => 'nullable|string',
            'app_theme_text_primary' => 'nullable|string',
            'app_theme_text_secondary' => 'nullable|string',        
            'app_theme_svg_login' => 'nullable|string',        
            'app_theme_svg_signup' => 'nullable|string',        
            'app_theme_links' => 'nullable|string',        
        ]);

        $data = $validated;
        if ($request->hasFile('app_logo')) {
            $data['app_logo'] = $request->file('app_logo')->store('logos', 'public');
        }
        Configuration::create($data);
        return redirect()->route('configuration.index')->with('success', 'Configuration saved successfully!');
    }
    public function edit($id)
    {
        $configuration = Configuration::findOrFail($id);
        $response = Http::get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCas7Ce7ycj4zRlD3fx53GvhreTVS-g6TI');
        $googleFonts = [];
        if ($response->successful()) {
            $fonts = $response->json()['items'];
            $googleFonts = collect($fonts)->pluck('family'); 
        }
        return view('configuration.edit', compact('configuration', 'googleFonts'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_purpose' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'app_tagline' => 'nullable|string|max:255',
            'app_font_primary' => 'nullable|string|max:255',
            'app_font_secondary' => 'nullable|string|max:255',
            'app_theme_primary_light' => 'nullable|string',
            'app_theme_primary_dark' => 'nullable|string',
            'app_theme_secondary_light' => 'nullable|string',
            'app_theme_secondary_dark' => 'nullable|string',
            'app_theme_background' => 'nullable|string',
            'app_theme_text_primary' => 'nullable|string',
            'app_theme_text_secondary' => 'nullable|string',        
            'app_theme_svg_login' => 'nullable|string',        
            'app_theme_svg_signup' => 'nullable|string',        
            'app_theme_links' => 'nullable|string',                
        ]);
        $configuration = Configuration::findOrFail($id);
        $configuration->app_name = $request->app_name;
        $configuration->app_purpose = $request->app_purpose;
        $configuration->app_tagline = $request->app_tagline;
        $configuration->app_font_primary = $request->app_font_primary;
        $configuration->app_font_secondary = $request->app_font_secondary;
        $configuration->app_theme_primary_light = $request->app_theme_primary_light;
        $configuration->app_theme_primary_dark = $request->app_theme_primary_dark;
        $configuration->app_theme_secondary_light = $request->app_theme_secondary_light;
        $configuration->app_theme_secondary_dark = $request->app_theme_secondary_dark;
        $configuration->app_theme_background = $request->app_theme_background;
        $configuration->app_theme_text_primary = $request->app_theme_text_primary;
        $configuration->app_theme_text_secondary = $request->app_theme_text_secondary;
        $configuration->app_theme_svg_login = $request->app_theme_svg_login;
        $configuration->app_theme_svg_signup = $request->app_theme_svg_signup;
        $configuration->app_theme_links = $request->app_theme_links;
        if ($request->hasFile('app_logo')) {
            if ($configuration->app_logo && \Storage::exists($configuration->app_logo)) {
                \Storage::delete($configuration->app_logo);
            }
            $configuration->app_logo = $request->file('app_logo')->store('logos', 'public');
        }
        $configuration->save();
        return redirect()->route('configuration.index')->with('success', 'Configuration updated successfully!');
    }
    public function destroy($id)
    {
        $configuration = Configuration::findOrFail($id);
        if ($configuration->app_logo && \Storage::exists($configuration->app_logo)) {
            \Storage::delete($configuration->app_logo);
        }
        $configuration->delete();
        return redirect()->route('configuration.index')->with('success', 'Configuration deleted successfully.');
    }
    public function checkAppName(Request $request)
{
    $appName = $request->input('app_name');
    $exists = Configuration::where('app_name', $appName)->exists();
    return response()->json(['exists' => $exists]);
}
public function checkAppNameEdit(Request $request)
{
    $appName = $request->input('app_name'); 
    $appId = $request->input('id'); 
    $app = Configuration::find($appId); 
    if (!$app) {
        return response()->json(['exists' => false]); 
    }
    $exists = Configuration::where('app_name', $appName)
        ->where('id', '!=', $appId)
        ->exists();
    if ($appName === $app->app_name) {
        $exists = false;
    }
    return response()->json(['exists' => $exists]);
    }
}
