@extends('layouts.guest')

@section('content')
<div class="w-full max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center animate-fade-in">
    <!-- Image Section -->
    <div class="hidden md:block">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" alt="Register Visual" class="rounded-2xl shadow-lg object-cover w-full h-full">
    </div>

    <!-- Registration Form Section -->
    <div class="w-full max-w-md p-8 rounded-2xl glass-effect border border-white/10 shadow-2xl">
        <h2 class="text-3xl font-bold text-white mb-6 text-center tracking-tight">Create Your Account</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm text-purple-200 mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('name')
                    <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm text-purple-200 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('email')
                    <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm text-purple-200 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('password')
                    <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm text-purple-200 mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('password_confirmation')
                    <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm text-purple-400 hover:text-white transition" href="{{ route('login') }}">
                    Already registered?
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection