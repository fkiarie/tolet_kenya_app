@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-white">Buildings</h2>
        <div class="flex items-center gap-4">
            <form method="GET" action="{{ route('buildings.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search buildings..."
                       class="rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                <button type="submit" class="ml-2 text-white bg-purple-600 px-3 py-2 rounded">Search</button>
            </form>
            <a href="{{ route('buildings.export') }}"
               class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                📤 Export All
            </a>
            <a href="{{ route('buildings.create') }}"
               class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2 rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                + Add Building
            </a>
        </div>
    </div>

    <div class="glass-effect rounded-xl p-6 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-purple-200 border-b border-white/10">
                    <th class="py-3">Name</th>
                    <th class="py-3">City</th>
                    <th class="py-3">Town</th>
                    <th class="py-3">Landlord</th>
                    <th class="py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @forelse ($buildings as $building)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4">{{ $building->name }}</td>
                        <td class="py-4">{{ $building->city }}</td>
                        <td class="py-4">{{ $building->town }}</td>
                        <td class="py-4">{{ $building->landlord->full_name ?? 'N/A' }}</td>
                        <td class="py-4 text-center space-x-2">
                            <a href="{{ route('buildings.show', $building->id) }}" class="text-blue-400">Show</a>
                            <a href="{{ route('buildings.edit', $building->id) }}" class="text-indigo-400">Edit</a>
                            <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this building?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-purple-300">No buildings found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $buildings->links() }}
        </div>
    </div>
</div>
@endsection
