<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::with('building');

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->sort === 'rent_asc') {
            $query->orderBy('rent', 'asc');
        } elseif ($request->sort === 'rent_desc') {
            $query->orderBy('rent', 'desc');
        } else {
            $query->latest(); // default
        }

        $units = $query->paginate(10);
        $buildings = \App\Models\Building::all();

        return view('units.index', compact('units', 'buildings'));
    }


    public function create()
    {
        $buildings = Building::all();
        return view('units.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_type' => 'required|in:studio,bedsitter,1 bedroom,2 bedroom,3 bedroom,shop,standalone bungalow',
            'status' => 'required|in:vacant,occupied,under maintenance',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'lease_date' => 'nullable|date',
            'end_lease' => 'nullable|date|after_or_equal:lease_date',
        ]);

        Unit::create($validated);
        return redirect()->route('units.index')->with('success', 'Unit added.');
    }

    public function show(Unit $unit)
    {
        return view('units.show', compact('unit'));
    }

    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        return view('units.edit', compact('unit', 'buildings'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_type' => 'required|in:studio,bedsitter,1 bedroom,2 bedroom,3 bedroom,shop,standalone bungalow',
            'status' => 'required|in:vacant,occupied,under maintenance',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'lease_date' => 'nullable|date',
            'end_lease' => 'nullable|date|after_or_equal:lease_date',
        ]);

        $unit->update($validated);
        return redirect()->route('units.index')->with('success', 'Unit updated.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted.');
    }
}
