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
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-xl font-bold tracking-wide">
                        OPTI<span class="text-orange-500">MOVE</span>
                    </span>
                </a>

                <!-- Menu -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-lg hover:bg-white/5 transition text-sm">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('tracking.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-lg hover:bg-white/5 transition text-sm">
                        <i class="fas fa-search-location mr-2"></i>Tracking
                    </a>

                    <!-- User Menu -->
                    <div class="relative" id="userMenuWrapper">
                        <button onclick="toggleUserMenu()"
                                class="flex items-center gap-2 text-gray-300 hover:text-white px-3 py-2 rounded-lg hover:bg-white/5 transition text-sm">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span id="userName">User</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-[#1a1a1a] border border-gray-800 rounded-lg shadow-xl z-50">
                            <a href="#" onclick="logout(event)" class="block px-4 py-3 text-sm text-gray-300 hover:bg-orange-600 hover:text-white transition rounded-lg">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
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

        // Get user info (hanya jika ada token)
        if (token && document.getElementById('userName')) {
            axios.get('/api/auth/me')
                .then(response => {
                    document.getElementById('userName').textContent = response.data.name;
                })
                .catch(error => {
                    console.error('Error loading user:', error);
                    // Jangan redirect di sini, biar halaman yang handle
                });
        }

        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function logout(event) {
            event.preventDefault();

            axios.post('/api/auth/logout')
                .then(() => {
                    localStorage.removeItem('optimove_token');
                    window.location.href = '/login';
                })
                .catch(() => {
                    localStorage.removeItem('optimove_token');
                    window.location.href = '/login';
                });
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('#userMenuWrapper')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }
    </script>

    @yield('scripts')
</body>
</html>
