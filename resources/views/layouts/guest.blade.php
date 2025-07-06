<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tolet Kenya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
        }
    </script>
    <style>
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
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white font-[Poppins] antialiased min-h-screen">
    <header class="glass-effect shadow-md py-4 px-6 flex items-center justify-between sticky top-0 z-50">
        <a href="/" class="text-2xl font-bold text-yellow-400 tracking-wide hover:text-yellow-300 transition">Tolet Kenya</a>
        <nav class="hidden md:flex space-x-4">
            <a href="/" class="text-gray-200 hover:text-yellow-400 transition">Home</a>
            <a href="/login" class="text-gray-200 hover:text-yellow-400 transition">Login</a>
            <a href="/register" class="text-gray-200 hover:text-yellow-400 transition">Register</a>
        </nav>
    </header>

    <main class="flex flex-col items-center justify-center min-h-[80vh] px-4">
        <div class="w-full max-w-2xl glass-effect rounded-2xl shadow-xl p-8 mt-8 animate-fade-in">
            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-400 text-center py-4 mt-8 text-sm">
        &copy; {{ date('Y') }} Tolet Kenya. All rights reserved.
    </footer>
</body>
</html>
