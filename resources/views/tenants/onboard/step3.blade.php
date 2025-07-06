@extends('tenants.onboard.layout', [
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
                'options' => $units->mapWithKeys(fn($u) => [$u->id => $u->building->name . ' – ' . ucfirst($u->unit_type)])->toArray()
            ]
        ]
    ])->render()
])
