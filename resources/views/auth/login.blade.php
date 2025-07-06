@extends('layouts.guest')

@section('content')
<div class="w-full max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center animate-fade-in">
    <!-- Image Section -->
    <div class="hidden md:block">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" alt="Login Visual" class="rounded-2xl shadow-lg object-cover w-full h-full">
    </div>

    <!-- Login Form Section -->
    <div class="w-full max-w-md p-8 rounded-2xl glass-effect border border-white/10 shadow-2xl">
        <h2 class="text-3xl font-bold text-white mb-6 text-center tracking-tight">Login to Your Account</h2>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-400 bg-green-900/30 px-4 py-2 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm text-purple-200 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm text-purple-200 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full rounded-lg px-4 py-2 bg-white/10 text-white border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-purple-200">
                    <input type="checkbox" name="remember" class="mr-2 rounded bg-white/10 border-white/20">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-white transition">Forgot Password?</a>
            </div>

            <button type="submit"
                    class="w-full mt-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                Sign In
            </button>
        </form>

        <p class="text-center text-sm text-purple-300 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-purple-400 hover:text-white font-medium">Create one</a>
        </p>
    </div>
</div>
@endsection
