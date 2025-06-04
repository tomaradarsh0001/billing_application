<?php

namespace App\Http\Controllers;

use App\Models\TaxCharge;
use Illuminate\Http\Request;

class TaxChargeController extends Controller
{
    public function index()
    {
        $taxes = TaxCharge::all();
        return view('charges.index', compact('taxes'));
    }
    
    public function create()
    {
        return view('charges.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tax_name' => 'required|string|max:255',
            'tax_percentage' => 'required|numeric|min:0',
            'from_date' => 'required|date',
            'till_date' => 'nullable|date|after_or_equal:from_date',
            'status' => 'nullable|boolean',
        ]);
    
        TaxCharge::create($request->all());
    
        return redirect()->route('tax-charges.index')->with('success', 'Tax Charge created.');
    }
    
    public function edit(TaxCharge $tax_charge)
    {
        return view('charges.edit', compact('tax_charge'));
    }
    
    public function update(Request $request, TaxCharge $tax_charge)
    {
        $request->validate([
            'tax_name' => 'required|string|max:255',
            'tax_percentage' => 'required|numeric|min:0',
            'from_date' => 'required|date',
            'till_date' => 'nullable|date|after_or_equal:from_date',
            'status' => 'nullable|boolean',
        ]);
    
        $tax_charge->update($request->all());
    
        return redirect()->route('tax-charges.index')->with('success', 'Tax Charge updated.');
    }
    
    public function destroy(TaxCharge $tax_charge)
    {
        $tax_charge->delete();
    
        return redirect()->route('tax-charges.index')->with('success', 'Tax Charge deleted.');
    }

    public function toggleStatus($id)
{
    $current = TaxCharge::findOrFail($id);

    if ($current->status) {
        $current->status = 0;
        $current->till_date = now();
    } else {
        $current->status = 1;
        $current->till_date = null;
    }

    $current->save();

    return redirect()->back()->with('success', 'Status updated successfully.');
}



    
}
