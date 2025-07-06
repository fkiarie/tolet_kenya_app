<div class="space-y-4 text-sm text-white">
    <div>
        <label class="block text-purple-300">Building Name</label>
        <input type="text" name="name" value="{{ old('name', $building->name ?? '') }}"
               class="w-full rounded px-4 py-2 bg-white/10 text-white focus:outline-none border border-white/10" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-purple-300">City</label>
            <input type="text" name="city" value="{{ old('city', $building->city ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>

        <div>
            <label class="block text-purple-300">Town</label>
            <input type="text" name="town" value="{{ old('town', $building->town ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>
    </div>

    <div>
        <label class="block text-purple-300">Landlord</label>
        <select name="landlord_id" class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
            <option value="">Select Landlord</option>
            @foreach ($landlords as $landlord)
                <option value="{{ $landlord->id }}"
                    {{ old('landlord_id', $building->landlord_id ?? '') == $landlord->id ? 'selected' : '' }}>
                    {{ $landlord->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    @php $types = ['studio', 'bedsitter', '1 bedroom', '2 bedroom', '3 bedroom', 'shop', 'standalone bungalow']; @endphp
    @php $savedTypes = old('unit_types', json_decode($building->unit_types ?? '[]', true)); @endphp

    <div>
        <label class="block text-purple-300 mb-2">Unit Types & Counts</label>
        <div id="unit-types-wrapper">
            @if (!empty($savedTypes))
                @foreach ($savedTypes as $i => $unit)
                    <div class="flex gap-4 mb-2">
                        <select name="unit_types[{{ $i }}][type]" class="rounded px-3 py-2 bg-white/10 text-white">
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ $unit['type'] === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="unit_types[{{ $i }}][count]" placeholder="Count" value="{{ $unit['count'] ?? 1 }}" class="rounded px-3 py-2 bg-white/10 text-white w-24" />
                    </div>
                @endforeach
            @else
                <div class="flex gap-4 mb-2">
                    <select name="unit_types[0][type]" class="rounded px-3 py-2 bg-white/10 text-white">
                        @foreach ($types as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="unit_types[0][count]" placeholder="Count" class="rounded px-3 py-2 bg-white/10 text-white w-24" />
                </div>
            @endif
        </div>

        <button type="button" onclick="addUnitType()" class="text-sm text-purple-400 hover:text-white mt-2">+ Add Unit Type</button>
    </div>

    <div class="pt-4">
        <button type="submit"
                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
            {{ $button }}
        </button>
    </div>
</div>

<script>
let unitIndex = {{ count($savedTypes ?? [0]) }};
function addUnitType() {
    const wrapper = document.getElementById('unit-types-wrapper');
    const types = @json($types);
    const div = document.createElement('div');
    div.className = 'flex gap-4 mb-2';
    let select = `<select name="unit_types[${unitIndex}][type]" class="rounded px-3 py-2 bg-white text-black">`;
    types.forEach(type => {
        select += `<option value="${type}">${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
    });
    select += `</select>`;
    div.innerHTML = select + `<input type="number" name="unit_types[${unitIndex}][count]" placeholder="Count" class="rounded px-3 py-2 bg-white/10 text-white w-24" />`;
    wrapper.appendChild(div);
    unitIndex++;
}
</script>
