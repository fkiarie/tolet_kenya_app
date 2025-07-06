@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Payments</h1>
        <div class="space-x-2">
            <a href="{{ route('payments.export.pdf', request()->all()) }}"
               class="text-sm text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">
                Export PDF
            </a>
            <x-primary-button x-data="{}" x-on:click="$dispatch('open-modal', 'add-payment-modal')">
                + Add Payment
            </x-primary-button>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="mb-6 grid md:grid-cols-4 gap-4">
        <select name="month" class="rounded p-2 bg-white/10 text-white border border-white/20">
            <option value="">All Months</option>
            @foreach ($payments->pluck('month_for')->unique() as $month)
                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                </option>
            @endforeach
        </select>

        <select name="tenant_id" class="rounded p-2 bg-white/10 text-white border border-white/20">
            <option value="">All Tenants</option>
            @foreach ($tenants as $tenant)
                <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>{{ $tenant->full_name }}</option>
            @endforeach
        </select>

        <select name="unit_id" class="rounded p-2 bg-white/10 text-white border border-white/20">
            <option value="">All Units</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->house_number }}</option>
            @endforeach
        </select>

        <x-primary-button type="submit">Filter</x-primary-button>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white/5 backdrop-blur p-4 rounded-xl">
        <table class="min-w-full text-sm text-white">
            <thead class="text-purple-300 border-b border-purple-500">
                <tr>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Tenant</th>
                    <th class="p-2 text-left">Unit</th>
                    <th class="p-2 text-left">Month</th>
                    <th class="p-2 text-left">Amount</th>
                    <th class="p-2 text-left">Commission</th>
                    <th class="p-2 text-left">Landlord</th>
                    <th class="p-2 text-left">Method</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr class="border-t border-white/10">
                        <td class="p-2">{{ $payment->formatted_date }}</td>
                        <td class="p-2">{{ $payment->tenant->full_name }}</td>
                        <td class="p-2">{{ $payment->unit->house_number ?? '-' }}</td>
                        <td class="p-2">{{ $payment->formatted_month }}</td>
                        <td class="p-2">KSh {{ number_format($payment->amount) }}</td>
                        <td class="p-2">KSh {{ number_format($payment->commission_amount) }} ({{ $payment->commission_rate }}%)</td>
                        <td class="p-2">KSh {{ number_format($payment->landlord_amount) }}</td>
                        <td class="p-2">{{ $payment->method }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center p-4 text-purple-300">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $payments->links() }}</div>
</div>

<!-- Modal Form -->
<x-modal name="add-payment-modal" :show="false" focusable>
    <form method="POST" action="{{ route('payments.store') }}" class="bg-slate-900 p-6 space-y-4 text-white rounded-xl">
        @csrf

        <h2 class="text-lg font-bold text-white mb-4">Record New Payment</h2>

        <div>
            <label class="block text-sm text-purple-200">Tenant</label>
            <select name="tenant_id" id="tenant_id" required class="w-full rounded bg-white/10 text-blue-900 p-2 border border-white/20">
                <option value="">Select Tenant</option>
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-purple-200">Unit</label>
            <select name="unit_id" id="unit_id" required class="w-full rounded bg-white/10 text-blue-900 p-2 border border-white/20">
                <option value="">Select Unit</option>
            </select>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-purple-200">Month For</label>
                <input type="month" name="month_for" class="w-full rounded bg-white/10 text-white p-2 border border-white/20" required>
            </div>
            <div>
                <label class="block text-sm text-purple-200">Payment Date</label>
                <input type="date" name="payment_date" class="w-full rounded bg-white/10 text-white p-2 border border-white/20">
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm text-purple-200">Amount Paid</label>
                <input type="number" step="0.01" name="amount" id="amount" required class="w-full rounded bg-white/10 text-white p-2 border border-white/20">
            </div>
            <div>
                <label class="block text-sm text-purple-200">Commission Rate (%)</label>
                <input type="number" step="0.01" name="commission_rate" id="commission_rate" required class="w-full rounded bg-white/10 text-white p-2 border border-white/20">
            </div>
            <div>
                <label class="block text-sm text-purple-200">Commission (auto)</label>
                <input type="number" step="0.01" name="commission_amount" id="commission_amount" readonly class="w-full rounded bg-white/10 text-white p-2 border border-white/20">
            </div>
        </div>

        <div>
            <label class="block text-sm text-purple-200">Method</label>
            <input type="text" name="method" required class="w-full rounded bg-white/10 text-white p-2 border border-white/20">
        </div>

        <div>
            <label class="block text-sm text-purple-200">Reference (optional)</label>
            <input type="text" name="reference" class="w-full rounded bg-white/10 text-white p-2 border border-white/20">
        </div>

        <div>
            <label class="block text-sm text-purple-200">Notes</label>
            <textarea name="notes" rows="2" class="w-full rounded bg-white/10 text-white p-2 border border-white/20"></textarea>
        </div>

        <div class="text-right">
            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-primary-button class="ml-2">Save Payment</x-primary-button>
        </div>
    </form>
</x-modal>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const amountField = document.getElementById('amount');
        const rateField = document.getElementById('commission_rate');
        const commissionField = document.getElementById('commission_amount');

        function calculateCommission() {
            const amount = parseFloat(amountField.value) || 0;
            const rate = parseFloat(rateField.value) || 0;
            commissionField.value = ((rate / 100) * amount).toFixed(2);
        }

        amountField.addEventListener('input', calculateCommission);
        rateField.addEventListener('input', calculateCommission);

        const tenantSelect = document.getElementById('tenant_id');
        const unitSelect = document.getElementById('unit_id');

        tenantSelect.addEventListener('change', function () {
            const tenantId = this.value;
            unitSelect.innerHTML = '<option value="">Loading...</option>';

            if (!tenantId) {
                unitSelect.innerHTML = '<option value="">Select Unit</option>';
                return;
            }

            fetch(`/tenants/${tenantId}/units`)
                .then(res => res.json())
                .then(units => {
                    unitSelect.innerHTML = '<option value="">Select Unit</option>';
                    units.forEach(unit => {
                        unitSelect.innerHTML += `<option value="${unit.id}">${unit.label}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching units:', error);
                    unitSelect.innerHTML = '<option value="">Failed to load units</option>';
                });
        });
    });
</script>

@endsection
