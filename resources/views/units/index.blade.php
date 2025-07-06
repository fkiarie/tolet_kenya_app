@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-white">Units</h2>
    </div>

    <!-- Filters -->
    <form method="GET" class="glass-effect mb-6 rounded-xl p-4 grid md:grid-cols-4 gap-4 text-white">
        <div>
            <label class="block text-sm text-purple-200 mb-1">Building</label>
            <select name="building_id" class="w-full rounded bg-white/10 border border-white/20 px-3 py-2">
                <option value="">All</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-purple-200 mb-1">Status</label>
            <select name="status" class="w-full rounded bg-white/10 border border-white/20 px-3 py-2">
                <option value="">All</option>
                <option value="vacant" {{ request('status') == 'vacant' ? 'selected' : '' }}>Vacant</option>
                <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="under maintenance" {{ request('status') == 'under maintenance' ? 'selected' : '' }}>Under Maintenance</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-purple-200 mb-1">Sort By</label>
            <select name="sort" class="w-full rounded bg-white/10 border border-white/20 px-3 py-2">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                <option value="rent_asc" {{ request('sort') == 'rent_asc' ? 'selected' : '' }}>Rent Low → High</option>
                <option value="rent_desc" {{ request('sort') == 'rent_desc' ? 'selected' : '' }}>Rent High → Low</option>
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="bg-purple-700 hover:bg-purple-800 transition text-white w-full px-4 py-2 rounded-lg">
                Apply
            </button>
        </div>
    </form>

    <div class="glass-effect rounded-xl p-6">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-purple-200 border-b border-white/10">
                    <th class="py-3">Building</th>
                    <th class="py-3">House Number</th>
                    <th class="py-3">Unit Type</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Rent</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @forelse ($units as $unit)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4">{{ $unit->building->name }}</td>
                        <td class="py-4">{{ $unit->house_number }}</td>
                        <td class="py-4 capitalize">{{ $unit->unit_type }}</td>
                        <td class="py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @class([
                                    'bg-green-600/20 text-green-400' => $unit->status === 'vacant',
                                    'bg-red-600/20 text-red-400' => $unit->status === 'occupied',
                                    'bg-yellow-600/20 text-yellow-300' => $unit->status === 'under maintenance'
                                ])">
                                {{ ucfirst($unit->status) }}
                            </span>
                        </td>
                        <td class="py-4">KSh {{ number_format($unit->rent, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-purple-300">No units found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $units->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
