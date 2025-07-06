@extends('tenants.onboard.layout', [
    'step' => 1,
    'progress' => 33,
    'title' => 'Tenant Basic Information',
    'action' => route('tenant.onboard.step1'),
    'back' => false,
    'button' => 'Next',
    'slot' => view('components.slot')->with([
        'fields' => [
            ['name' => 'full_name', 'label' => 'Full Name'],
            ['name' => 'email', 'label' => 'Email Address', 'type' => 'email'],
            ['name' => 'phone', 'label' => 'Phone Number']
        ]
    ])->render()
])
