<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Optimove Logistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-about {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
                        url('https://images.unsplash.com/photo-1566576721346-d4a3b4eaeb55?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
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
                    <a href="{{ route('home') }}#start" class="text-gray-300 hover:text-white transition">Beranda</a>
                    <a href="{{ route('home') }}#services" class="text-gray-300 hover:text-white transition">Layanan</a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition border-b-2 border-orange-500 pb-1">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition">Kontak</a>

                    <!-- Guest Menu (Not Logged In) -->
                    <div id="guest-menu" class="flex items-center gap-3">
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
                <a href="{{ route('home') }}#start" class="block text-gray-300 hover:text-white py-2">Start</a>
                <a href="{{ route('home') }}#services" class="block text-gray-300 hover:text-white py-2">Services</a>
                <a href="{{ route('about') }}" class="block text-gray-300 hover:text-white py-2 border-l-4 border-orange-500 pl-3">Tentang Kami</a>
                <a href="{{ route('contact') }}" class="block text-gray-300 hover:text-white py-2">Kontak</a>

                <!-- Mobile Guest Menu -->
                <div id="mobile-guest-menu" class="space-y-3 pt-3 border-t border-gray-800">
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
    <section class="hero-about min-h-[60vh] flex items-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Tentang <span class="text-orange-500">Optimove</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                Mitra logistik terpercaya yang menghadirkan solusi pengiriman cepat, aman, dan efisien untuk mendukung bisnis Anda berkembang di seluruh Indonesia.
            </p>
        </div>
    </section>

    <!-- Company Story -->
    <section class="py-20 bg-[#111111]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold mb-6">Kisah <span class="text-orange-500">Kami</span></h2>
                    <div class="space-y-4 text-gray-300 leading-relaxed">
                        <p>
                            Optimove lahir dari kebutuhan akan layanan logistik yang dapat diandalkan untuk pengiriman barang berbagai skala di Indonesia. Dimulai dengan visi untuk menghubungkan bisnis dengan pelanggan  melalui pengiriman yang tepat waktu dan aman.
                        </p>
                        <p>
                            Sejak awal, kami fokus pada inovasi teknologi dan pelayanan pelanggan. Dengan tim yang berpengalaman dan armada yang terawat, kami terus berkembang menjadi salah satu pilihan utama untuk kebutuhan logistik di berbagai industri.
                        </p>
                        <p>
                            Hari ini, Optimove melayani ribuan pelanggan mulai dari UMKM hingga perusahaan besar, dengan komitmen yang sama mengantarkan setiap paket dengan integritas dan profesionalisme.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80"
                         alt="Our Story"
                         class="rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-20 bg-[#0d0d0d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Visi & Misi</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Vision -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-2xl p-10 border border-gray-800 hover:border-orange-600 transition shadow-xl">
                    <div class="bg-orange-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-3xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-6">Visi Kami</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Menjadi penyedia layanan logistik terdepan di Indonesia yang dipercaya untuk mengantarkan setiap kiriman dengan presisi, kecepatan, dan keamanan terbaik.
                    </p>
                </div>

                <!-- Mission -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-2xl p-10 border border-gray-800 hover:border-blue-600 transition shadow-xl">
                    <div class="bg-blue-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-3xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-6">Misi Kami</h3>
                    <ul class="space-y-3 text-gray-300 leading-relaxed text-lg">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-orange-500 mt-1"></i>
                            <span>Memberikan layanan logistik berkualitas tinggi dengan teknologi modern</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-orange-500 mt-1"></i>
                            <span>Membangun kepercayaan melalui transparansi dan komunikasi yang baik</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-orange-500 mt-1"></i>
                            <span>Mendukung pertumbuhan bisnis pelanggan dengan solusi pengiriman fleksibel</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-20 bg-[#111111]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Nilai-Nilai Kami</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Prinsip yang memandu setiap keputusan dan tindakan kami
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl p-6 border border-gray-800 hover:border-orange-600 transition text-center">
                    <div class="bg-orange-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-xl mb-2">Integritas</h4>
                    <p class="text-gray-400 text-sm">
                        Berkomitmen pada kejujuran dan transparansi dalam setiap layanan
                    </p>
                </div>

                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl p-6 border border-gray-800 hover:border-blue-600 transition text-center">
                    <div class="bg-blue-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-rocket text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-xl mb-2">Inovasi</h4>
                    <p class="text-gray-400 text-sm">
                        Terus berinovasi untuk memberikan solusi logistik terbaik
                    </p>
                </div>

                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl p-6 border border-gray-800 hover:border-green-600 transition text-center">
                    <div class="bg-green-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-xl mb-2">Kolaborasi</h4>
                    <p class="text-gray-400 text-sm">
                        Bekerja sama dengan pelanggan untuk mencapai tujuan bersama
                    </p>
                </div>

                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl p-6 border border-gray-800 hover:border-purple-600 transition text-center">
                    <div class="bg-purple-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-xl mb-2">Keunggulan</h4>
                    <p class="text-gray-400 text-sm">
                        Memberikan standar layanan tertinggi dalam setiap pengiriman
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-[#0d0d0d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Pencapaian Kami</h2>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-500 mb-2">5+</div>
                    <div class="text-gray-400">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-500 mb-2">10K+</div>
                    <div class="text-gray-400">Pengiriman Sukses</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-green-500 mb-2">500+</div>
                    <div class="text-gray-400">Klien Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-purple-500 mb-2">50+</div>
                    <div class="text-gray-400">Armada Siap</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-orange-600 to-red-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Siap Bekerja Sama dengan Kami?</h2>
            <p class="text-xl mb-8 text-gray-100">
                Mari wujudkan solusi logistik terbaik untuk bisnis Anda
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-orange-600 hover:bg-gray-100 px-8 py-4 rounded-full font-semibold text-lg transition transform hover:scale-105 shadow-lg inline-flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    Hubungi Kami
                </a>
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
                        Solusi logistik terpercaya untuk berbagai kebutuhan pengiriman barang di seluruh Indonesia.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}#services" class="hover:text-orange-500 transition">General Cargo</a></li>
                        <li><a href="{{ route('home') }}#services" class="hover:text-orange-500 transition">Large & Special Cargo</a></li>
                        <li><a href="{{ route('home') }}#services" class="hover:text-orange-500 transition">Express Delivery</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-orange-500 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-orange-500 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-phone mr-2 text-orange-500"></i>+62 812 3456 7890</li>
                        <li><i class="fas fa-envelope mr-2 text-orange-500"></i>info@optimove.id</li>
                        <li><i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>Malang, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 Optimove Logistics. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auth check functionality
        const token = localStorage.getItem('optimove_token');
        const guestMenu = document.getElementById('guest-menu');
        const userMenu = document.getElementById('user-menu');
        const mobileGuestMenu = document.getElementById('mobile-guest-menu');
        const mobileUserMenu = document.getElementById('mobile-user-menu');

        async function checkAuth() {
            if (!token) {
                showGuestMenu();
                return;
            }

            try {
                const response = await fetch('/api/auth/me', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const userData = await response.json();
                    if (userData && userData.name) {
                        showUserMenu(userData.name);
                    } else {
                        showGuestMenu();
                    }
                } else {
                    localStorage.removeItem('optimove_token');
                    showGuestMenu();
                }
            } catch (error) {
                localStorage.removeItem('optimove_token');
                showGuestMenu();
            }
        }

        function showGuestMenu() {
            guestMenu.classList.remove('hidden');
            guestMenu.classList.add('flex');
            userMenu.classList.add('hidden');
            userMenu.classList.remove('flex');
            mobileGuestMenu.classList.remove('hidden');
            mobileUserMenu.classList.add('hidden');
        }

        function showUserMenu(userName) {
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
                    console.error('Logout error:', error);
                }
            }
            localStorage.removeItem('optimove_token');
            window.location.href = '{{ route("home") }}';
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Initialize
        checkAuth();
    </script>
</body>
</html>
