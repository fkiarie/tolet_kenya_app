<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantOnboardingController extends Controller
{
    public function step1()
    {
        return view('tenants.onboard.step1', [
            'step' => 1,
            'progress' => 33,
            'title' => 'Tenant Basic Information',
            'action' => route('tenant.onboard.step1'),
            'back' => null,
            'button' => 'Next',
            'slot' => view('components.slot')->with([
                'fields' => [
                    ['name' => 'full_name', 'label' => 'Full Name'],
                    ['name' => 'email', 'label' => 'Email Address', 'type' => 'email'],
                    ['name' => 'phone', 'label' => 'Phone Number']
                ]
            ])->render()
        ]);
    }

    public function postStep1(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        session(['tenant_onboard.step1' => $data]);
        return redirect()->route('tenant.onboard.step2');
    }

    public function step2()
    {
        return view('tenants.onboard.step2', [
            'step' => 2,
            'progress' => 66,
            'title' => 'ID and Emergency Contact',
            'action' => route('tenant.onboard.step2'),
            'back' => route('tenant.onboard.step1'),
            'button' => 'Next',
            'slot' => view('components.slot')->with([
                'fields' => [
                    ['name' => 'id_number', 'label' => 'ID / Passport Number'],
                    ['name' => 'emergency_name', 'label' => 'Emergency Contact Name'],
                    ['name' => 'emergency_phone', 'label' => 'Emergency Contact Phone']
                ]
            ])->render()
        ]);
    }

    public function postStep2(Request $request)
    {
        $data = $request->validate([
            'id_number' => 'required|string|max:50',
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
        ]);

        session(['tenant_onboard.step2' => $data]);
        return redirect()->route('tenant.onboard.step3');
    }

public function step3()
{
    $units = Unit::where('status', 'vacant')->with('building')->get();

    $unitOptions = $units->mapWithKeys(fn($u) => [
        $u->id => $u->building->name . ' – ' . ucfirst($u->unit_type)
    ])->toArray();

    return view('tenants.onboard.step3', compact('units') + [
        'step' => 3,
        'progress' => 100,
        'title' => 'Tenant Photo and Unit Assignment',
        'action' => route('tenant.onboard.step3'),
        'back' => route('tenant.onboard.step2'),
        'button' => 'Finish',
        'slot' => view('components.slot')->with([
            'fields' => [
                ['name' => 'photo', 'label' => 'Upload Photo', 'type' => 'file'],
                [
                    'name' => 'unit_ids[]',
                    'label' => 'Assign Units',
                    'type' => 'select',
                    'multiple' => true,
                    'options' => $unitOptions
                ]
            ]
        ])->render()
    ]);
}



    public function postStep3(Request $request)
    {
        $data = $request->validate([
            'photo' => 'required|image|max:2048',
            'unit_ids' => 'nullable|array',
            'unit_ids.*' => 'exists:units,id',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        session(['tenant_onboard.step3' => $data]);
        return redirect()->route('tenant.onboard.complete');
    }

    public function complete()
    {
        $data = array_merge(
            session('tenant_onboard.step1', []),
            session('tenant_onboard.step2', []),
            session('tenant_onboard.step3', [])
        );

        $tenant = Tenant::create($data);

        if (!empty($data['unit_ids'])) {
            $tenant->units()->attach($data['unit_ids']);
            Unit::whereIn('id', $data['unit_ids'])->update(['status' => 'occupied']);
        }

        session()->forget('tenant_onboard');

        return redirect()->route('tenants.index')->with('success', 'Tenant onboarded successfully.');
    }
}
