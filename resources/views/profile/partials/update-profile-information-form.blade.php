<section class="bg-white/5 backdrop-blur-md rounded-xl shadow-lg p-6 md:p-10 text-white">
    <header>
        <h2 class="text-2xl font-semibold text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-purple-200">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm mb-1 text-purple-200">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                   class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 focus:ring-2 focus:ring-purple-500 focus:outline-none" />
            @error('name')
                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm mb-1 text-purple-200">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 focus:ring-2 focus:ring-purple-500 focus:outline-none" />
            @error('email')
                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-orange-300">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-purple-400 hover:text-white focus:outline-none">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
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