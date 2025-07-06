@extends('layouts.app')

@section('content')
<div class="glass-effect rounded-xl p-6 max-w-xl mx-auto animate-fade-in">
    <h2 class="text-2xl font-semibold text-white mb-6">{{ $unit->unit_type }} Unit</h2>

    <div class="space-y-4 text-sm text-purple-200">
        <p><strong class="text-white">Building:</strong> {{ $unit->building->name }}</p>
        <p><strong class="text-white">Status:</strong> {{ ucfirst($unit->status) }}</p>
        <p><strong class="text-white">Rent:</strong> KSh {{ number_format($unit->rent, 2) }}</p>
        <p><strong class="text-white">Deposit:</strong> KSh {{ number_format($unit->deposit, 2) }}</p>
        <p><strong class="text-white">Lease Start:</strong> {{ $unit->lease_date }}</p>
        <p><strong class="text-white">Lease End:</strong> {{ $unit->end_lease }}</p>
    </div>
</div>
@endsection
