@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="glass-effect p-6 rounded-xl">
        <h2 class="text-2xl font-semibold text-white mb-6">Add New Building</h2>
        <a href="{{ route('buildings.index') }}" class="inline-block text-sm text-purple-400 hover:text-white mb-4">&larr; Back to Buildings</a>

        <form action="{{ route('buildings.store') }}" method="POST">
            @csrf

            <div class="space-y-4 text-sm text-white">
                <div>
                    <label class="block text-purple-300">Building Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full rounded px-4 py-2 bg-white/10 border border-white/10" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-purple-300">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full rounded px-4 py-2 bg-white/10 border border-white/10" required>
                    </div>
                    <div>
                        <label class="block text-purple-300">Town</label>
                        <input type="text" name="town" value="{{ old('town') }}"
                               class="w-full rounded px-4 py-2 bg-white/10 border border-white/10" required>
                    </div>
                </div>

                <div>
                    <label class="block text-purple-300">Landlord</label>
                    <select name="landlord_id" class="w-full rounded px-4 py-2 bg-white/10 border border-white/10 text-black" required>
                        <option value="">Select Landlord</option>
                        @foreach ($landlords as $landlord)
                            <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-4 mt-6">
                    <h3 class="text-xl text-white font-semibold">Units</h3>
                    <div id="unitTypes">
                        <div class="grid grid-cols-6 gap-2 items-end mb-3">
                            <div>
                                <label class="block text-purple-300">Type</label>
                                <select name="unit_types[0][type]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10 text-black">
                                    <option value="studio">Studio</option>
                                    <option value="bedsitter">Bedsitter</option>
                                    <option value="1 bedroom">1 Bedroom</option>
                                    <option value="2 bedroom">2 Bedroom</option>
                                    <option value="3 bedroom">3 Bedroom</option>
                                    <option value="shop">Shop</option>
                                    <option value="standalone bungalow">Standalone Bungalow</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-purple-300">House #</label>
                                <input type="text" name="unit_types[0][house_number]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" required>
                            </div>
                            <div>
                                <label class="block text-purple-300">Rent</label>
                                <input type="number" name="unit_types[0][rent]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01">
                            </div>
                            <div>
                                <label class="block text-purple-300">Deposit</label>
                                <input type="number" name="unit_types[0][deposit]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01">
                            </div>
                            <div>
                                <label class="block text-purple-300">Status</label>
                                <select name="unit_types[0][status]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10 text-black">
                                    <option value="vacant">Vacant</option>
                                    <option value="occupied">Occupied</option>
                                    <option value="under maintenance">Under Maintenance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="addUnitType()"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Add Unit</button>
                </div>

                <div class="pt-6">
                    <button type="submit"
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                        Save Building
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let unitTypeIndex = 1;
function addUnitType() {
    const wrapper = document.getElementById('unitTypes');
    const html = `
    <div class="grid grid-cols-6 gap-2 items-end mb-3">
        <div>
            <select name="unit_types[${unitTypeIndex}][type]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10 text-black">
                <option value="studio">Studio</option>
                <option value="bedsitter">Bedsitter</option>
                <option value="1 bedroom">1 Bedroom</option>
                <option value="2 bedroom">2 Bedroom</option>
                <option value="3 bedroom">3 Bedroom</option>
                <option value="shop">Shop</option>
                <option value="standalone bungalow">Standalone Bungalow</option>
            </select>
        </div>
        <div><input type="text" name="unit_types[${unitTypeIndex}][house_number]" placeholder="A103" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10 text-white" required></div>
        <div><input type="number" name="unit_types[${unitTypeIndex}][rent]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01"></div>
        <div><input type="number" name="unit_types[${unitTypeIndex}][deposit]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10" step="0.01"></div>
        <div>
            <select name="unit_types[${unitTypeIndex}][status]" class="w-full rounded px-3 py-2 bg-white/10 border border-white/10 text-black">
                <option value="vacant">Vacant</option>
                <option value="occupied">Occupied</option>
                <option value="under maintenance">Under Maintenance</option>
            </select>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    unitTypeIndex++;
}
</script>
@endsection
