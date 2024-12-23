<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;


class ConfigurationController extends Controller
{
    
    public function index()
    {
        $configurations = Configuration::all();
        return view('configuration.index', compact('configurations'));
    }
    public function create()
    {
        return view('configuration.create');
    }
    public function view($id)
    {
        $configuration = Configuration::findOrFail($id);

        return view('configuration.view', compact('configuration'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'app_tagline' => 'nullable|string|max:255',
            'app_theme' => 'required|string|max:7',
        ]);

        $data = $validated;

        // Handle file upload
        if ($request->hasFile('app_logo')) {
            $data['app_logo'] = $request->file('app_logo')->store('logos', 'public');
        }

        Configuration::create($data);

        return redirect()->route('configuration.index')->with('success', 'Configuration saved successfully!');
    }
    public function edit($id)
    {
        $configuration = Configuration::findOrFail($id);
        return view('configuration.edit', compact('configuration'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'app_tagline' => 'nullable|string|max:255',
            'app_theme' => 'required|string|max:7',
        ]);

        $configuration = Configuration::findOrFail($id);

        // Update fields
        $configuration->app_name = $request->app_name;
        $configuration->app_tagline = $request->app_tagline;
        $configuration->app_theme = $request->app_theme;

        // Handle file upload
        if ($request->hasFile('app_logo')) {
            // Delete the old logo if it exists
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

}
