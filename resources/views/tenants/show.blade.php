@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="glass-effect p-6 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-white">Tenant Details</h2>
            <a href="{{ route('tenants.index') }}" class="text-purple-400 text-sm hover:text-white">&larr; Back</a>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm text-purple-200 mb-6">
            <p><strong class="text-white">Name:</strong> {{ $tenant->full_name }}</p>
            <p><strong class="text-white">Email:</strong> {{ $tenant->email }}</p>
            <p><strong class="text-white">Phone:</strong> {{ $tenant->phone }}</p>
            <p><strong class="text-white">ID:</strong> {{ $tenant->id_number }}</p>
            <p><strong class="text-white">Emergency:</strong> {{ $tenant->emergency_name }} ({{ $tenant->emergency_phone }})</p>
        </div>

        <div class="mb-6">
            <strong class="text-white block mb-2">Passport Photo:</strong>
            <img src="{{ asset('storage/' . $tenant->photo) }}" alt="Passport" class="w-24 h-24 object-cover rounded-lg border">
        </div>

        <h3 class="text-xl text-white font-semibold mb-4">Assigned Units</h3>
        <div class="space-y-3 text-sm text-white">
            @forelse ($tenant->units as $unit)
                <div class="p-4 bg-white/5 rounded border border-white/10">
                    <p><strong>Building:</strong> {{ $unit->building->name }}</p>
                    <p><strong>Unit:</strong> {{ ucfirst($unit->unit_type) }} ({{ $unit->house_number ?? 'N/A' }})</p>
                    <p><strong>Rent:</strong> KSh {{ number_format($unit->rent) }}</p>
                    <p><strong>Lease:</strong> {{ \Carbon\Carbon::parse($unit->pivot->lease_date)->format('d M Y') }} → {{ \Carbon\Carbon::parse($unit->pivot->end_of_lease)->format('d M Y') }}</p>
                </div>
            @empty
                <p class="text-purple-300">No units assigned.</p>
            @endforelse
        </div>
    </div>
</div>
@if ($tenant->units->isNotEmpty())
<div class="mt-10 bg-white/5 p-6 rounded-xl border border-white/10">
    <h3 class="text-xl font-semibold text-white mb-4">Unassign Units</h3>

    <form method="POST" action="{{ route('tenants.unassign', $tenant) }}">
        @csrf

        <div class="mb-4">
            <label class="block text-purple-300 mb-2">Select Units to Unassign</label>
            <select name="unit_ids[]" multiple required
                class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                @foreach ($tenant->units as $unit)
                    <option value="{{ $unit->id }}">
                        {{ $unit->building->name }} – {{ ucfirst($unit->unit_type) }}
                        {{ $unit->house_number ? '(#' . $unit->house_number . ')' : '' }}
                        @if($unit->pivot->lease_date)
                            (Lease: {{ \Carbon\Carbon::parse($unit->pivot->lease_date)->format('M d, Y') }} - 
                            {{ \Carbon\Carbon::parse($unit->pivot->end_of_lease)->format('M d, Y') }})
                        @endif
                    </option>
                @endforeach
            </select>
            <small class="text-purple-400">Hold Ctrl / Cmd to select multiple</small>
        </div>

        <button type="submit"
                class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-pink-700 transition">
            Unassign Selected Units
        </button>
    </form>
</div>
@endif

@endsection
