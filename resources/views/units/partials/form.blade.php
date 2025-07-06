<div class="space-y-4 text-sm text-white">
    <div>
        <label class="block text-purple-300">Building</label>
        <select name="building_id" class="w-full rounded px-4 py-2 bg-white text-black border border-white/10" required>
            <option value="">Select Building</option>
            @foreach ($buildings as $building)
                <option value="{{ $building->id }}"
                    {{ old('building_id', $unit->building_id ?? '') == $building->id ? 'selected' : '' }}>
                    {{ $building->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-purple-300">Unit Type</label>
            <select name="unit_type" class="w-full rounded px-4 py-2 bg-white text-black border border-white/10" required>
                @php $types = ['studio','bedsitter','1 bedroom','2 bedroom','3 bedroom','shop','standalone bungalow']; @endphp
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ old('unit_type', $unit->unit_type ?? '') == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-purple-300">Status</label>
            <select name="status" class="w-full rounded px-4 py-2 bg-white text-black border border-white/10" required>
                @foreach (['vacant','occupied','under maintenance'] as $status)
                    <option value="{{ $status }}" {{ old('status', $unit->status ?? '') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-purple-300">Rent (KSh)</label>
            <input type="number" name="rent" step="0.01" value="{{ old('rent', $unit->rent ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>

        <div>
            <label class="block text-purple-300">Deposit (KSh)</label>
            <input type="number" name="deposit" step="0.01" value="{{ old('deposit', $unit->deposit ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-purple-300">Lease Start</label>
            <input type="date" name="lease_date" value="{{ old('lease_date', $unit->lease_date ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
        </div>
        <div>
            <label class="block text-purple-300">Lease End</label>
            <input type="date" name="end_lease" value="{{ old('end_lease', $unit->end_lease ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
        </div>
    </div>

    <div class="pt-4">
        <button type="submit"
                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
            {{ $button }}
        </button>
    </div>
</div>
