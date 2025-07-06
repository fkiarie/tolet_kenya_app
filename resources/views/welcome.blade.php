@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-800 to-indigo-900 text-white animate-fade-in">
    <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-10 max-w-xl w-full text-center border border-white/20">
        <div class="flex justify-center mb-6">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=128&q=80" alt="Tolet Kenya Logo" class="h-16 w-16 rounded-full shadow-lg border-2 border-white/30 bg-white/20">
        </div>
        <h1 class="text-5xl font-extrabold mb-4 text-white drop-shadow-lg">Welcome to <span class="text-purple-300">Tolet Kenya</span></h1>
        <p class="text-lg text-purple-100 mb-8">Your complete solution for managing properties, units, and tenants with ease.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="bg-white/90 text-indigo-800 font-semibold px-8 py-3 rounded-lg shadow-md hover:bg-white transition-all duration-200 border border-indigo-100">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 border border-indigo-700/30">
                Register
            </a>
        </div>
        <div class="mt-8 text-sm text-purple-200">
            <span>New here? <a href="{{ route('register') }}" class="underline hover:text-white">Create an account</a></span>
        </div>
    </div>
</div>
@endsection
