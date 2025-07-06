<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tolet Kenya - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind Animations & Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'pulse-slow': 'pulse 3s infinite'
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .glass-effect {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen text-white">
<!-- Navbar -->
<nav class="glass-effect sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Tolet Kenya</h1>
        <!-- Desktop Menu -->
        <div class="space-x-4 hidden md:flex items-center">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium px-3 py-2 rounded hover:bg-white/10 transition">Dashboard</a>
            <div class="relative group">
                <button class="text-sm font-medium px-3 py-2 rounded hover:bg-white/10 transition flex items-center focus:outline-none">
                    Manage
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="absolute left-0 mt-2 w-40 bg-white text-slate-900 rounded shadow-lg opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition pointer-events-none group-hover:pointer-events-auto group-focus-within:pointer-events-auto z-50">
                    <a href="{{ route('landlords.index') }}" class="block px-4 py-2 hover:bg-slate-100">Landlords</a>
                    <a href="{{ route('buildings.index') }}" class="block px-4 py-2 hover:bg-slate-100">Buildings</a>
                    <a href="{{ route('units.index') }}" class="block px-4 py-2 hover:bg-slate-100">Units</a>
                    <a href="{{ route('tenants.index') }}" class="block px-4 py-2 hover:bg-slate-100">Tenants</a>
                    <a href="{{ route('payments.index') }}" class="block px-4 py-2 hover:bg-slate-100">Payments</a>
                </div>
            </div>
          <!-- Profile & Logout -->
<div class="relative">
    <button id="profileDropdownBtn" class="text-sm font-medium px-3 py-2 rounded hover:bg-white/10 transition flex items-center focus:outline-none">
        {{ Auth::user()->name }}
        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-40 bg-white text-slate-900 rounded shadow-lg hidden z-50">
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-slate-100">Profile</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-slate-100">Logout</button>
        </form>
    </div>
</div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="max-w-7xl mx-auto py-10 px-6 sm:px-10 lg:px-16">
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm border border-green-200 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('profileDropdownBtn');
        const menu = document.getElementById('profileDropdownMenu');

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
</script>

</body>
</html>