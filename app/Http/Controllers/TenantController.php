<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query();

        if ($search = $request->input('search')) {
            $query->where('full_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('emergency_name', 'like', "%$search%")
                ->orWhere('emergency_phone', 'like', "%$search%");
        }

        $tenants = $query->with('units.building')->latest()->paginate(10);
        return view('tenants.index', compact('tenants'));
    }
    /**
     * Export all tenants and their associated units as a CSV file.
     *
     * This method retrieves all tenants along with their related units and buildings,
     * then generates a CSV file containing the following columns:
     * - Full Name
     * - Email
     * - Phone
     * - Emergency Name
     * - Emergency Phone
     * - Units (formatted as "Building Name - Unit Type", separated by semicolons)
     *
     * The CSV is streamed directly to the browser as a downloadable file named "tenants.csv".
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportAll()
    {
        $tenants = Tenant::with('units.building')->get();

        $csvHeader = ['Full Name', 'Email', 'Phone', 'Emergency Name', 'Emergency Phone', 'Units'];

        $callback = function () use ($tenants, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($tenants as $tenant) {
                $unitList = $tenant->units->map(function ($u) {
                    return $u->building->name . ' - ' . ucfirst($u->unit_type);
                })->implode('; ');

                fputcsv($file, [
                    $tenant->full_name,
                    $tenant->email,
                    $tenant->phone,
                    $tenant->emergency_name,
                    $tenant->emergency_phone,
                    $unitList
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=tenants.csv"
        ]);
    }
    // public function create()
    // {
    //     return view('tenants.create');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:tenants,email',
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Tenant::create($validated);
        return redirect()->route('tenants.index')->with('success', 'Tenant added.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load('units.building');
        return view('tenants.show', compact('tenant'));
    }


    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $tenant->update($validated);
        return redirect()->route('tenants.index')->with('success', 'Tenant updated.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant deleted.');
    }
    /**
     * Display the form to assign a unit to the specified tenant.
     *
     * Retrieves all units that are either vacant or already assigned to the given tenant,
     * including their associated building information. Passes the tenant and the filtered
     * units to the 'tenants.assign' view for rendering the assignment form.
     *
     * @param  \App\Models\Tenant  $tenant  The tenant to whom a unit may be assigned.
     * @return \Illuminate\View\View        The view displaying the assignment form.
     */
    public function assignForm(Tenant $tenant)
    {
        $units = Unit::where(function ($query) use ($tenant) {
            $query->where('status', 'vacant')
                ->orWhereHas('tenants', function ($q) use ($tenant) {
                    $q->where('tenants.id', $tenant->id);
                });
        })->with('building')->get();
        return view('tenants.assign', compact('tenant', 'units'));
    }

    /**
     * Assigns one or more units to a tenant with specified lease dates.
     *
     * Validates the incoming request to ensure required fields are present:
     * - 'unit_ids': array of unit IDs to assign
     * - 'lease_date': start date of the lease
     * - 'end_of_lease': end date of the lease (must be after or equal to lease_date)
     *
     * For each unit:
     * - Checks if the unit is not already occupied.
     * - Ensures the tenant is not already assigned to the unit.
     * - Attaches the unit to the tenant with lease details in the pivot table.
     * - Updates the unit's status to 'occupied' and sets lease dates.
     *
     * All operations are performed within a database transaction to ensure atomicity.
     *
     * Redirects to the tenant's detail page with a success message upon completion.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing assignment data.
     * @param  \App\Models\Tenant        $tenant   The tenant to whom units are being assigned.
     * @return \Illuminate\Http\RedirectResponse   Redirects to the tenant's detail page with a success message.
     */
    public function assign(Request $request, Tenant $tenant)
    {
        $data = $request->validate([
            'unit_ids' => 'required|array',
            'lease_date' => 'required|date',
            'end_of_lease' => 'required|date|after_or_equal:lease_date',
        ]);

        DB::transaction(function () use ($data, $tenant) {
            $units = Unit::whereIn('id', $data['unit_ids'])->get()->keyBy('id');

            foreach ($data['unit_ids'] as $unitId) {
                $unit = $units->get($unitId);

                if ($unit && $unit->status !== 'occupied') {
                    // Avoid duplicate assignment
                    if (!$tenant->units()->where('units.id', $unitId)->exists()) {
                        $tenant->units()->attach($unitId, [
                            'lease_date' => $data['lease_date'],
                            'end_of_lease' => $data['end_of_lease'],
                        ]);

                        // Update unit status to occupied
                        $unit->update([
                            'status' => 'occupied',
                            'lease_date' => $data['lease_date'],
                            'end_of_lease' => $data['end_of_lease'],
                        ]);
                    }
                }
            }
        });

        return redirect()->route('tenants.show', $tenant)->with('success', 'Units assigned successfully.');
    }


public function unassign(Request $request, Tenant $tenant)
{
    $data = $request->validate([
        'unit_ids' => 'required|array',
        'unit_ids.*' => 'exists:units,id',
    ]);

    DB::transaction(function () use ($data, $tenant) {
        foreach ($data['unit_ids'] as $unitId) {
            $tenant->units()->detach($unitId);

            $unit = Unit::find($unitId);
            if ($unit) {
                $unit->update([
                    'status' => 'vacant',
                    'lease_date' => null,
                    'end_of_lease' => null,
                ]);
            }
        }
    });

    return redirect()->route('tenants.show', $tenant)
        ->with('success', 'Units unassigned and marked as vacant.');
}
/**
 * Return a JSON response with the units assigned to the specified tenant.
 *
 * @param  \App\Models\Tenant  $tenant  The tenant whose units are being retrieved.
 * @return \Illuminate\Http\JsonResponse  JSON response containing an array of units (id and house_number).
 */
public function units(Tenant $tenant)
{
    $units = $tenant->units()->with('building')->get();

    $results = $units->map(function ($unit) {
        return [
            'id' => $unit->id,
            'label' => $unit->building->name . ' - ' . $unit->house_number,
        ];
    });

    return response()->json($results);
}

}
// End of file: app/Http/Controllers/TenantController.php
// This file is part of the ToLet Kenya property management system.
// It handles tenant management including listing, creating, updating, deleting, and assigning units to tenants.
// It also supports exporting tenant data to CSV format.