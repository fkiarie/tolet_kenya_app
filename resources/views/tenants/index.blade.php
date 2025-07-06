@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-white">Tenants</h2>
        <div class="flex items-center gap-4">
            <form method="GET" action="{{ route('tenants.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tenants..."
                       class="rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                <button type="submit" class="ml-2 text-white bg-purple-600 px-3 py-2 rounded">Search</button>
            </form>
            <a href="{{ route('tenants.export.all') }}"
               class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                📤 Export All
            </a>
            <a href="{{ route('tenant.onboard.step1') }}"
               class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2 rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                + Add Tenant
            </a>
        </div>
    </div>

    <div class="glass-effect rounded-xl p-6 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-purple-200 border-b border-white/10">
                    <th class="py-3">Photo</th>
                    <th class="py-3">Full Name</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">Phone</th>
                    <th class="py-3">Units</th>
                    <th class="py-3">Emergency Contact</th>
                    <th class="py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @forelse ($tenants as $tenant)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4">
                            @if ($tenant->photo)
                                <img src="{{ asset('storage/' . $tenant->photo) }}" alt="{{ $tenant->full_name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400 text-xs">No Photo</span>
                            @endif
                        </td>
                        <td class="py-4">{{ $tenant->full_name }}</td>
                        <td class="py-4">{{ $tenant->email }}</td>
                        <td class="py-4">{{ $tenant->phone }}</td>
                        <td class="py-4">
                            @forelse ($tenant->units as $unit)
                                <div class="text-xs text-purple-200">
                                    {{ $unit->building->name }} – {{ ucfirst($unit->unit_type) }}
                                    <br><span class="text-gray-400">Lease: {{ $unit->pivot->created_at->format('d M Y') }}</span>
                                </div>
                            @empty
                                <span class="text-gray-400">No units</span>
                            @endforelse
                        </td>
                        <td class="py-4">{{ $tenant->emergency_name }} ({{ $tenant->emergency_phone }})</td>
                        <td class="py-4 text-center space-x-2">
                            <a href="{{ route('tenants.edit', $tenant) }}" class="text-indigo-400">Edit</a>
                            <a href="{{ route('tenants.show', $tenant) }}" class="text-blue-400">View</a>
                            <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this tenant?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400">Delete</button>
                            </form>
                            <a href="{{ route('tenants.assign.form', $tenant) }}" class="text-green-400">+ Add Unit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-6 text-center text-purple-300">No tenants found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $tenants->links() }}
        </div>
    </div>
</div>
@endsection
