<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optimove - Heavy & Oversized Logistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
                        url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-[#1a2332] text-white">
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-[#1a2332]/95 backdrop-blur-sm border-b border-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wide">
                    OPTI<span class="text-orange-500">MOVE</span>
                </a>

                <!-- Navigation Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#start" class="text-gray-300 hover:text-white transition">Start</a>
                    <a href="#services" class="text-gray-300 hover:text-white transition">Services</a>

                    <!-- Guest Menu (Not Logged In) -->
                    <div id="guest-menu" class="flex items-center gap-3">
                        <a href="#company" class="text-gray-300 hover:text-white transition">Company</a>
                        <a href="{{ route('register.page') }}" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition">
                            Register
                        </a>
                        <a href="{{ route('login.page') }}" class="bg-orange-600 hover:bg-orange-500 px-5 py-2 rounded-lg font-medium transition">
                            Login
                        </a>
                    </div>

                    <!-- User Menu (Logged In) -->
                    <div id="user-menu" class="hidden items-center gap-3">
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition flex items-center gap-2">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('tracking.index') }}" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition flex items-center gap-2">
                            <i class="fas fa-search-location"></i>
                            Tracking
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button onclick="toggleUserDropdown()"
                                    class="flex items-center gap-2 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 px-5 py-2 rounded-lg font-medium transition">
                                <i class="fas fa-user-circle text-lg"></i>
                                <span id="user-name-display">User</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-[#1a1a1a] border border-gray-800 rounded-lg shadow-2xl overflow-hidden">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm text-gray-300 hover:bg-orange-600 hover:text-white transition">
                                    <i class="fas fa-dashboard mr-2"></i>Dashboard
                                </a>
                                <a href="#" onclick="handleLogout(event)" class="block px-4 py-3 text-sm text-gray-300 hover:bg-red-600 hover:text-white transition border-t border-gray-800">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#0d1117] border-t border-gray-800">
            <div class="px-4 py-4 space-y-3">
                <a href="#start" class="block text-gray-300 hover:text-white py-2">Start</a>
                <a href="#services" class="block text-gray-300 hover:text-white py-2">Services</a>

                <!-- Mobile Guest Menu -->
                <div id="mobile-guest-menu" class="space-y-3 pt-3 border-t border-gray-800">
                    <a href="#company" class="block text-gray-300 hover:text-white py-2">Company</a>
                    <a href="{{ route('register.page') }}" class="block text-center bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg transition">
                        Register
                    </a>
                    <a href="{{ route('login.page') }}" class="block text-center bg-orange-600 hover:bg-orange-500 px-4 py-2 rounded-lg transition">
                        Login
                    </a>
                </div>

                <!-- Mobile User Menu -->
                <div id="mobile-user-menu" class="hidden space-y-3 pt-3 border-t border-gray-800">
                    <div class="text-sm text-orange-400 py-2 font-semibold">
                        <i class="fas fa-user-circle mr-2"></i>
                        Hai, <span id="mobile-user-name">User</span>
                    </div>
                    <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-white py-2">
                        <i class="fas fa-dashboard mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('tracking.index') }}" class="block text-gray-300 hover:text-white py-2">
                        <i class="fas fa-search-location mr-2"></i>Tracking
                    </a>
                    <a href="#" onclick="handleLogout(event)" class="block text-red-400 hover:text-red-300 py-2">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="start" class="hero-bg min-h-screen flex items-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Heavy & Oversized<br>
                    <span class="text-orange-500">Logistics</span> for Your Cargo
                </h1>
                <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                    Optimove mengirimkan alat berat, kontainer proyek, dan barang sensitif
                    ke seluruh Indonesia dengan armada khusus dan driver berpengalaman.
                    Aman, presisi, dan tepat waktu.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('dashboard') }}" class="bg-orange-600 hover:bg-orange-500 px-8 py-4 rounded-full font-semibold text-lg transition transform hover:scale-105 shadow-lg inline-flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Request shipment now
                    </a>
                    <a href="{{ route('tracking.index') }}" class="bg-white/10 backdrop-blur hover:bg-white/20 border border-white/20 px-8 py-4 rounded-full font-semibold text-lg transition transform hover:scale-105 inline-flex items-center gap-2">
                        <i class="fas fa-search-location"></i>
                        Track existing order
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-[#111111]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Layanan Kami</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Solusi logistik terpadu untuk berbagai kebutuhan pengiriman barang berat dan oversize
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-2xl p-8 border border-gray-800 hover:border-orange-600 transition transform hover:scale-105 shadow-xl">
                    <div class="bg-orange-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-truck-monster text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Heavy Equipment</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Pengiriman alat berat seperti excavator, bulldozer, dan crane dengan trailer khusus dan izin lengkap.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-2xl p-8 border border-gray-800 hover:border-orange-600 transition transform hover:scale-105 shadow-xl">
                    <div class="bg-blue-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-industry text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Project Cargo</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Kontainer proyek, modul bangunan, dan peralatan industri berukuran besar dengan handling khusus.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-2xl p-8 border border-gray-800 hover:border-orange-600 transition transform hover:scale-105 shadow-xl">
                    <div class="bg-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-shipping-fast text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Express Delivery</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Layanan cepat untuk barang sensitif dengan monitoring 24/7 dan asuransi penuh.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Section -->
    <section id="company" class="py-20 bg-[#0d0d0d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">Kenapa Pilih Optimove?</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-orange-600 rounded-full w-12 h-12 flex items-center justify-center">
                                    <i class="fas fa-check text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl mb-2">Armada Khusus</h4>
                                <p class="text-gray-400">Trailer lowbed, flatbed, dan truk khusus untuk berbagai jenis kargo</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-600 rounded-full w-12 h-12 flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl mb-2">Asuransi Penuh</h4>
                                <p class="text-gray-400">Perlindungan komprehensif untuk setiap pengiriman</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-green-600 rounded-full w-12 h-12 flex items-center justify-center">
                                    <i class="fas fa-map-marked-alt text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl mb-2">Real-time Tracking</h4>
                                <p class="text-gray-400">Pantau posisi kargo Anda kapan saja, dimana saja</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80"
                         alt="Logistics"
                         class="rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#111111] border-t border-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">OPTI<span class="text-orange-500">MOVE</span></h3>
                    <p class="text-gray-400 text-sm">
                        Solusi logistik terpercaya untuk pengiriman alat berat dan kargo besar di Indonesia.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-orange-500 transition">Heavy Equipment</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Project Cargo</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Express Delivery</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-orange-500 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Karir</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-phone mr-2 text-orange-500"></i>+62 812 3456 7890</li>
                        <li><i class="fas fa-envelope mr-2 text-orange-500"></i>info@optimove.id</li>
                        <li><i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 Optimove Logistics. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        console.log('🚀 Welcome page loaded');

        // Check authentication immediately
        const token = localStorage.getItem('optimove_token');
        console.log('Token found:', token ? 'YES' : 'NO');

        const guestMenu = document.getElementById('guest-menu');
        const userMenu = document.getElementById('user-menu');
        const mobileGuestMenu = document.getElementById('mobile-guest-menu');
        const mobileUserMenu = document.getElementById('mobile-user-menu');

        async function checkAuth() {
            if (!token) {
                console.log('❌ No token - showing guest menu');
                showGuestMenu();
                return;
            }

            console.log('🔍 Validating token...');

            try {
                const response = await fetch('/api/auth/me', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                console.log('API Response status:', response.status);

                if (response.ok) {
                    const userData = await response.json();
                    console.log('✅ User data:', userData);

                    if (userData && userData.name) {
                        showUserMenu(userData.name);
                    } else {
                        console.log('⚠️ Invalid user data');
                        showGuestMenu();
                    }
                } else {
                    console.log('❌ API returned error:', response.status);
                    localStorage.removeItem('optimove_token');
                    showGuestMenu();
                }
            } catch (error) {
                console.error('❌ Auth check failed:', error);
                localStorage.removeItem('optimove_token');
                showGuestMenu();
            }
        }

        function showGuestMenu() {
            console.log('📋 Showing guest menu');
            guestMenu.classList.remove('hidden');
            guestMenu.classList.add('flex');
            userMenu.classList.add('hidden');
            userMenu.classList.remove('flex');
            mobileGuestMenu.classList.remove('hidden');
            mobileUserMenu.classList.add('hidden');
        }

        function showUserMenu(userName) {
            console.log('👤 Showing user menu for:', userName);
            guestMenu.classList.add('hidden');
            guestMenu.classList.remove('flex');
            userMenu.classList.remove('hidden');
            userMenu.classList.add('flex');
            mobileGuestMenu.classList.add('hidden');
            mobileUserMenu.classList.remove('hidden');

            document.getElementById('user-name-display').textContent = userName;
            document.getElementById('mobile-user-name').textContent = userName;
        }

        function toggleUserDropdown() {
            const dropdown = document.getElementById('user-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.closest('[onclick="toggleUserDropdown()"]')) {
                const dropdown = document.getElementById('user-dropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        });

        async function handleLogout(event) {
            event.preventDefault();
            console.log('🚪 Logging out...');

            const token = localStorage.getItem('optimove_token');
            if (token) {
                try {
                    await fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });
                } catch (error) {
                    console.error('Logout API error:', error);
                }
            }

            localStorage.removeItem('optimove_token');
            console.log('✅ Token removed, reloading...');
            window.location.reload();
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        document.getElementById('mobile-menu')?.classList.add('hidden');
                    }
                }
            });
        });

        // Initialize authentication check
        checkAuth();
    </script>
</body>
</html>
