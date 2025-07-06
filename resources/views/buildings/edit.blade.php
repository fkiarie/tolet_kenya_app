@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="glass-effect p-6 rounded-xl">
        <h2 class="text-2xl font-semibold text-white mb-6">Edit Building</h2>
        <a href="{{ route('buildings.index') }}" class="inline-block text-sm text-purple-400 hover:text-white mb-4">&larr; Back to Buildings</a>

        <form action="{{ route('buildings.update', $building) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4 text-sm text-white">
                <div>
                    <label class="block text-purple-300">Building Name</label>
                    <input type="text" name="name" value="{{ old('name', $building->name) }}"
                           class="w-full rounded px-4 py-2 bg-white/10 border border-white/10" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-purple-300">City</label>
                        <input type="text" name="city" value="{{ old('city', $building->city) }}"
                               class="w-full rounded px-4 py-2 bg-white/10 border border-white/10" required>
                    </div>
                    <div>
                        <label class="block text-purple-300">Town</label>
                        <input type="text" name="town" value="{{ old('town', $building->town) }}"
                               class="w-full rounded px-4 py-2 bg-white/10 border border-white/10" required>
                    </div>
                </div>

                <div>
                    <label class="block text-purple-300">Landlord</label>
                    <select name="landlord_id" class="w-full rounded px-4 py-2 bg-white border border-white/10 text-blue-800" required>
                        <option value="">Select Landlord</option>
                        @foreach ($landlords as $landlord)
                            <option value="{{ $landlord->id }}" {{ $building->landlord_id == $landlord->id ? 'selected' : '' }}>{{ $landlord->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-4 mt-6">
                    <h3 class="text-xl text-white font-semibold">Unit Details</h3>
                    <div id="unitTypes">
                        @php
                            $types = ['studio','bedsitter','1 bedroom','2 bedroom','3 bedroom','shop','standalone bungalow'];
                            $savedTypes = old('unit_types', json_decode($building->unit_types ?? '[]', true));
                        @endphp
                        @foreach ($savedTypes as $i => $unit)
                            <div class="grid grid-cols-7 gap-2 items-end mb-3 border-b border-white/10 pb-3">
                                <div>
                                    <select name="unit_types[{{ $i }}][type]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10">
                                        @foreach ($types as $type)
                                            <option value="{{ $type }}" {{ $unit['type'] === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div><input type="text" name="unit_types[{{ $i }}][house_number]" value="{{ $unit['house_number'] ?? '' }}" placeholder="House #" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" required></div>
                                <div><input type="number" name="unit_types[{{ $i }}][rent]" value="{{ $unit['rent'] ?? '' }}" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01"></div>
                                <div><input type="number" name="unit_types[{{ $i }}][deposit]" value="{{ $unit['deposit'] ?? '' }}" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01"></div>
                                <div>
                                    <select name="unit_types[{{ $i }}][status]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10">
                                        <option value="vacant" {{ ($unit['status'] ?? '') === 'vacant' ? 'selected' : '' }}>Vacant</option>
                                        <option value="occupied" {{ ($unit['status'] ?? '') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="under maintenance" {{ ($unit['status'] ?? '') === 'under maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <input type="checkbox" name="unit_types[{{ $i }}][remove]" value="1" class="w-4 h-4" {{ ($unit['status'] ?? '') === 'occupied' ? 'disabled' : '' }}>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addUnitType()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Add Unit</button>
                </div>

                <div class="pt-6">
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                        Update Building
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let unitTypeIndex = {{ count($savedTypes) }};
function addUnitType() {
    const wrapper = document.getElementById('unitTypes');
    const html = `
    <div class="grid grid-cols-7 gap-2 items-end mb-3 border-b border-white/10 pb-3">
        <div>
            <select name="unit_types[${unitTypeIndex}][type]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10">
                <option value="studio">Studio</option>
                <option value="bedsitter">Bedsitter</option>
                <option value="1 bedroom">1 Bedroom</option>
                <option value="2 bedroom">2 Bedroom</option>
                <option value="3 bedroom">3 Bedroom</option>
                <option value="shop">Shop</option>
                <option value="standalone bungalow">Standalone Bungalow</option>
            </select>
        </div>
        <div><input type="text" name="unit_types[${unitTypeIndex}][house_number]" placeholder="House #" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" required></div>
        <div><input type="number" name="unit_types[${unitTypeIndex}][rent]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01"></div>
        <div><input type="number" name="unit_types[${unitTypeIndex}][deposit]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01"></div>
        <div>
            <select name="unit_types[${unitTypeIndex}][status]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10 text-blue-950">
                <option value="vacant">Vacant</option>
                <option value="occupied">Occupied</option>
                <option value="under maintenance">Under Maintenance</option>
            </select>
        </div>
        <div class="text-center">
            <input type="checkbox" name="unit_types[${unitTypeIndex}][remove]" value="1" class="w-4 h-4">
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    unitTypeIndex++;
}
</script>
@endsection
