<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Optimove Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#111111] text-white">
    <!-- Navbar Dark Theme -->
    <nav class="bg-gradient-to-r from-[#1a1a1a] to-[#0d0d0d] border-b border-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide hover:opacity-80 transition">
                    OPTI<span class="text-orange-500">MOVE</span>
                </a>

                <!-- Menu Kanan -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-lg hover:bg-white/5 transition text-sm">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="{{ route('tracking.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-lg hover:bg-white/5 transition text-sm">
                        <i class="fas fa-search-location mr-2"></i>Tracking
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <script>
        const token = localStorage.getItem('optimove_token');

        // Setup Axios dengan token
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
    </script>

    @yield('scripts')
</body>
</html>
