@extends('layouts.app')

@section('content')
<div class="glass-effect rounded-xl p-6 max-w-3xl mx-auto animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-white">{{ $landlord->full_name }}</h2>
        <a href="{{ route('landlords.index') }}" class="text-sm text-purple-400 hover:text-purple-200">&larr; Back to Landlords</a>
    </div>

    <div class="grid md:grid-cols-2 gap-8 text-sm text-purple-200">
        <div class="space-y-4">
            <p><strong class="text-white">Business:</strong> {{ $landlord->business_name ?? '—' }}</p>
            <p><strong class="text-white">Phone:</strong> {{ $landlord->phone }}</p>
            <p><strong class="text-white">Email:</strong> {{ $landlord->email }}</p>
            <p><strong class="text-white">ID Number:</strong> {{ $landlord->id_number }}</p>
        </div>

        <div class="pt-4 md:pt-0">
            <strong class="text-white block mb-2">Photo:</strong>
            <img src="{{ asset('storage/' . $landlord->photo) }}" alt="Landlord Photo"
                 class="w-40 h-40 object-cover rounded-lg border">
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-semibold text-white mb-4">Owned Buildings</h3>
        @forelse ($landlord->buildings as $building)
            <div class="bg-white/5 text-white rounded-lg p-4 mb-3">
                <h4 class="text-lg font-medium">{{ $building->name }}</h4>
                <p class="text-sm text-purple-200">{{ $building->city }}, {{ $building->town }}</p>
            </div>
        @empty
            <p class="text-purple-400">No buildings registered under this landlord.</p>
        @endforelse
    </div>
</div>
@endsection
