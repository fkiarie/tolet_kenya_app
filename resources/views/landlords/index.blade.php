@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-white">Landlords</h2>
        <div class="flex items-center gap-4">
            <form method="GET" action="{{ route('landlords.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search landlords..."
                       class="rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                <button type="submit" class="ml-2 text-white bg-purple-600 px-3 py-2 rounded">Search</button>
            </form>
            <a href="{{ route('landlords.export') }}"
               class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                📤 Export All
            </a>
             <a href="{{ route('landlords.create') }}"
               class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2 rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                + Add Landlord
            </a>
        </div>
    </div>

    <div class="glass-effect rounded-xl p-6 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-purple-200 border-b border-white/10">
                    <th class="py-3">Full Name</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">Phone</th>
                    <th class="py-3">ID Number</th>
                    <th class="py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @forelse ($landlords as $landlord)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4">{{ $landlord->full_name }}</td>
                        <td class="py-4">{{ $landlord->email }}</td>
                        <td class="py-4">{{ $landlord->phone }}</td>
                        <td class="py-4">{{ $landlord->id_number }}</td>
                        <td class="py-4 text-center space-x-2">
                            <a href="{{ route('landlords.show', $landlord) }}" class="text-blue-400">Show</a>
                            <a href="{{ route('landlords.edit', $landlord) }}" class="text-indigo-400">Edit</a>
                            <form action="{{ route('landlords.destroy', $landlord) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this landlord?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-purple-300">No landlords found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $landlords->links() }}
        </div>
    </div>
</div>
@endsection
