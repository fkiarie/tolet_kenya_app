<section class="bg-white/5 backdrop-blur-md rounded-xl shadow-lg p-6 md:p-10 text-white">
    <header>
        <h2 class="text-2xl font-semibold text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-purple-200">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm text-purple-200 mb-1">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 focus:ring-2 focus:ring-purple-500 focus:outline-none" />
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm text-purple-200 mb-1">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 focus:ring-2 focus:ring-purple-500 focus:outline-none" />
            @error('password', 'updatePassword')
                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm text-purple-200 mb-1">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 focus:ring-2 focus:ring-purple-500 focus:outline-none" />
            @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
