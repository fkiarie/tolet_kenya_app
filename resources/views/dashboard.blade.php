@extends('layouts.app')

@section('content')
<div class="animate-fade-in">
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2">Dashboard Overview</h2>
        <p class="text-purple-300">Welcome to your property management panel</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Landlords</h3>
            <p class="text-3xl font-semibold">{{ $landlords }}</p>
        </div>
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Buildings</h3>
            <p class="text-3xl font-semibold">{{ $buildings }}</p>
        </div>
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Total Units</h3>
            <p class="text-3xl font-semibold">{{ $units }}</p>
            <div class="text-sm text-purple-300 mt-1">Vacant: {{ $unitsVacant }} | Occupied: {{ $unitsOccupied }}</div>
        </div>
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Tenants</h3>
            <p class="text-3xl font-semibold">{{ $tenants }}</p>
        </div>
    </div>

    <!-- Payments Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Payments Collected</h3>
            <p class="text-3xl font-semibold">KSh {{ number_format($paymentsTotal, 2) }}</p>
        </div>
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Paid Units</h3>
            <p class="text-3xl font-semibold">{{ $paidUnits }}</p>
        </div>
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
            <h3 class="text-purple-200 text-sm">Unpaid Units</h3>
            <p class="text-3xl font-semibold">{{ $unpaidUnits }}</p>
        </div>
        <div class="glass-effect rounded-xl p-6 hover-lift animate-slide-up">
    <h3 class="text-purple-200 text-sm">Commission Earned</h3>
    <p class="text-3xl font-semibold">KSh {{ number_format($totalCommission, 2) }}</p>
</div>

    </div>

    <div class="glass-effect rounded-xl p-6 mt-10 animate-slide-up">
        <h3 class="text-xl font-semibold mb-4">Recent Activity</h3>
        <div class="space-y-4 text-sm">
            @foreach ($latestTenants as $tenant)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <div>
                        <p class="font-medium text-white">{{ $tenant->full_name }}</p>
                        <p class="text-purple-300">{{ $tenant->email }}</p>
                    </div>
                    <span class="text-purple-400">{{ $tenant->created_at->diffForHumans() }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
