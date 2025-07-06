@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="glass-effect p-6 rounded-xl">
        <h2 class="text-2xl font-semibold text-white mb-4">Assign More Units to {{ $tenant->full_name }}</h2>

        <form action="{{ route('tenants.assign', $tenant) }}" method="POST">
            @csrf

            <label class="block text-purple-300 mb-2">Select Vacant Units</label>
            <select name="unit_ids[]" multiple
                    class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">
                        {{ $unit->building->name }} – {{ ucfirst($unit->unit_type) }} {{ $unit->house_number ? '(#' . $unit->house_number . ')' : '' }}
                    </option>
                @endforeach
            </select>

            <small class="text-purple-400 block mb-4">Hold Ctrl / Cmd to select multiple units</small>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-purple-300">Lease Start Date</label>
                    <input type="date" name="lease_date" class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                </div>
                <div>
                    <label class="block text-purple-300">Lease End Date</label>
                    <input type="date" name="end_of_lease" class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                </div>
            </div>

            <button type="submit"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                Assign Units
            </button>
        </form>
    </div>
</div>
@endsection
