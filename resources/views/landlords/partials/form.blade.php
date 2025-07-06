<div class="space-y-4 text-sm text-white">
    <div>
        <label class="block text-purple-300">Full Name</label>
        <input type="text" name="full_name" value="{{ old('full_name', $landlord->full_name ?? '') }}"
               class="w-full rounded px-4 py-2 bg-white/10 text-white focus:outline-none border border-white/10" required>
    </div>

    <div>
        <label class="block text-purple-300">Business Name</label>
        <input type="text" name="business_name" value="{{ old('business_name', $landlord->business_name ?? '') }}"
               class="w-full rounded px-4 py-2 bg-white/10 text-white focus:outline-none border border-white/10">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-purple-300">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $landlord->phone ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>

        <div>
            <label class="block text-purple-300">Email</label>
            <input type="email" name="email" value="{{ old('email', $landlord->email ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-purple-300">ID Number</label>
            <input type="text" name="id_number" value="{{ old('id_number', $landlord->id_number ?? '') }}"
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" required>
        </div>

        <div>
            <label class="block text-purple-300">Passport Photo</label>
            <input type="file" name="photo" class="w-full text-white">
        </div>
    </div>

    <div class="pt-4">
        <button type="submit"
                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
            {{ $button }}
        </button>
    </div>
</div>
