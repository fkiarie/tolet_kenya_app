<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Landlord;
use App\Models\Unit;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a paginated list of buildings with their associated landlords.
     *
     * Retrieves the latest buildings from the database, eager loads the related landlord data,
     * paginates the results (10 per page), and returns the 'buildings.index' view with the buildings data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $buildings = Building::with('landlord')->latest()->paginate(10);
        return view('buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new building.
     *
     * Retrieves all landlords to populate the landlord selection in the form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $landlords = Landlord::all();
        return view('buildings.create', compact('landlords'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required',
            'town' => 'required|string|max:100',
            'landlord_id' => 'required|exists:landlords,id',
            'unit_types' => 'required|array',
            'unit_types.*.type' => 'required|string',
            'unit_types.*.house_number' => 'required|string|max:50',
            'unit_types.*.rent' => 'required|numeric|min:0',
            'unit_types.*.deposit' => 'required|numeric|min:0',
            'unit_types.*.status' => 'required|string|in:vacant,occupied,under maintenance'
        ]);

        $unitEntries = $validated['unit_types'];
        $validated['unit_types'] = json_encode($unitEntries); // Still store unit config on building

        $building = Building::create($validated);

        foreach ($unitEntries as $unit) {
            Unit::create([
                'building_id' => $building->id,
                'unit_type' => $unit['type'],
                'house_number' => $unit['house_number'],
                'status' => $unit['status'],
                'rent' => $unit['rent'],
                'deposit' => $unit['deposit'],
                'lease_date' => null,
                'end_of_lease' => null,
            ]);
        }

        return redirect()->route('buildings.index')->with('success', 'Building and units created successfully.');
    }


    public function show(Building $building)
    {
        return view('buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        $landlords = Landlord::all();
        return view('buildings.edit', compact('building', 'landlords'));
    }
    // update building and units. 
    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'town' => 'required|string|max:100',
            'landlord_id' => 'required|exists:landlords,id',
            'unit_types' => 'required|array',
            'unit_types.*.type' => 'required|string',
            'unit_types.*.house_number' => 'required|string|max:50',
            'unit_types.*.rent' => 'required|numeric|min:0',
            'unit_types.*.deposit' => 'required|numeric|min:0',
            'unit_types.*.status' => 'required|string|in:vacant,occupied,under maintenance',
        ]);

        $unitTypes = $validated['unit_types'];
        $validated['unit_types'] = json_encode($unitTypes);

        // Update building info
        foreach ($unitTypes as $unit) {
            $existing = Unit::where('building_id', $building->id)
                ->where('house_number', $unit['house_number'])
                ->first();

            // Attempt delete only if not occupied
            if (!empty($unit['remove']) && $existing && $existing->status !== 'occupied') {
                $existing->delete();
                continue;
            }

            // Update existing unit
            if ($existing) {
                $existing->update([
                    'unit_type' => $unit['type'],
                    'rent' => $unit['rent'],
                    'deposit' => $unit['deposit'],
                    'status' => $unit['status'],
                ]);
            } else {
                // New unit
                Unit::create([
                    'building_id' => $building->id,
                    'unit_type' => $unit['type'],
                    'house_number' => $unit['house_number'],
                    'rent' => $unit['rent'],
                    'deposit' => $unit['deposit'],
                    'status' => $unit['status'],
                    'lease_date' => null,
                    'end_of_lease' => null,
                ]);
            }
        }




        return redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }
    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Building deleted successfully.');
    }
}
//