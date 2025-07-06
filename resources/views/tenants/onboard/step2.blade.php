@include('tenants.onboard.layout', [
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
])
