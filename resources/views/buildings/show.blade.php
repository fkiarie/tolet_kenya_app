@extends('layouts.app')

@section('content')
<div class="glass-effect rounded-xl p-6 max-w-4xl mx-auto animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-white">{{ $building->name }}</h2>
        <a href="{{ route('buildings.index') }}" class="text-sm text-purple-400 hover:text-purple-200">&larr; Back to Buildings</a>
    </div>

    <div class="grid md:grid-cols-2 gap-8 text-sm text-purple-200">
        <div class="space-y-4">
            <p><strong class="text-white">City:</strong> {{ $building->city }}</p>
            <p><strong class="text-white">Town:</strong> {{ $building->town }}</p>
            <p><strong class="text-white">Landlord:</strong> {{ $building->landlord->full_name }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-semibold text-white mb-4">Units in This Building</h3>
        @forelse ($building->units as $unit)
            <div class="bg-white/5 text-white rounded-lg p-4 mb-3">
                <p class="text-sm"><strong>Type:</strong> {{ ucfirst($unit->unit_type) }}</p>
                <p class="text-sm"><strong>Status:</strong> {{ ucfirst($unit->status) }}</p>
                <p class="text-sm"><strong>Rent:</strong> KSh {{ number_format($unit->rent, 2) }}</p>
                <p class="text-sm"><strong>Deposit:</strong> KSh {{ number_format($unit->deposit, 2) }}</p>
                @if ($unit->lease_date)
                    <p class="text-sm"><strong>Lease Start:</strong> {{ \Carbon\Carbon::parse($unit->lease_date)->format('d M Y') }}</p>
                @endif
                @if ($unit->end_of_lease)
                    <p class="text-sm"><strong>Lease End:</strong> {{ \Carbon\Carbon::parse($unit->end_of_lease)->format('d M Y') }}</p>
                @endif
            </div>
        @empty
            <p class="text-purple-400">No units found for this building.</p>
        @endforelse
    </div>
</div>
@endsection
