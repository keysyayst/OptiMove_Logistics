<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Optimove Logistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-contact {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
                        url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?auto=format&fit=crop&w=1350&q=80');
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
                    <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition border-b-2 border-orange-500 pb-1">Kontak</a>

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
                <a href="{{ route('about') }}" class="block text-gray-300 hover:text-white py-2">Tentang Kami</a>
                <a href="{{ route('contact') }}" class="block text-gray-300 hover:text-white py-2 border-l-4 border-orange-500 pl-3">Kontak</a>

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
    <section class="hero-contact min-h-[50vh] flex items-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Hubungi <span class="text-orange-500">Kami</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                Kami siap membantu Anda dengan pertanyaan, konsultasi, atau layanan logistik yang Anda butuhkan
            </p>
        </div>
    </section>

    <!-- Contact Info & Form -->
    <section class="py-20 bg-[#111111]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div>
                    <h2 class="text-4xl font-bold mb-8">Informasi <span class="text-orange-500">Kontak</span></h2>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4 bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] p-6 rounded-xl border border-gray-800 hover:border-orange-600 transition">
                            <div class="bg-orange-600 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-1">Alamat Kantor</h4>
                                <p class="text-gray-400">
                                    Jl. Raya Logistik No. 123<br>
                                    Malang, Jawa Timur 65141<br>
                                    Indonesia
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] p-6 rounded-xl border border-gray-800 hover:border-blue-600 transition">
                            <div class="bg-blue-600 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-1">Telepon</h4>
                                <p class="text-gray-400">
                                    +62 812 3456 7890<br>
                                    +62 341 123 4567<br>
                                    <span class="text-sm">(Senin - Sabtu, 08:00 - 17:00 WIB)</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] p-6 rounded-xl border border-gray-800 hover:border-green-600 transition">
                            <div class="bg-green-600 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-1">Email</h4>
                                <p class="text-gray-400">
                                    info@optimove.id<br>
                                    support@optimove.id<br>
                                    cs@optimove.id
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] p-6 rounded-xl border border-gray-800 hover:border-purple-600 transition">
                            <div class="bg-purple-600 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-1">Jam Operasional</h4>
                                <p class="text-gray-400">
                                    Senin - Jumat: 08:00 - 17:00 WIB<br>
                                    Sabtu: 08:00 - 14:00 WIB<br>
                                    Minggu & Libur: Tutup
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8">
                        <h4 class="font-bold text-lg mb-4">Ikuti Kami</h4>
                        <div class="flex gap-4">
                            <a href="https://www.facebook.com/index.php/" class="bg-[#1a1a1a] hover:bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="https://www.instagram.com/index.php/" class="bg-[#1a1a1a] hover:bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="https://www.twitter.com/index.php/" class="bg-[#1a1a1a] hover:bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="https://www.linkedin.com/index.php/" class="bg-[#1a1a1a] hover:bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a href="https://wa.me/qr/DQFZP74VO7RWK1" class="bg-[#1a1a1a] hover:bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-2xl p-8 border border-gray-800">
                    <h3 class="text-3xl font-bold mb-6">Kirim Pesan</h3>

                    <form id="contactForm" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-300">Nama Lengkap</label>
                            <input type="text"
                                   name="name"
                                   required
                                   class="w-full bg-[#0d0d0d] border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition"
                                   placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-300">Email</label>
                            <input type="email"
                                   name="email"
                                   required
                                   class="w-full bg-[#0d0d0d] border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition"
                                   placeholder="email@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-300">No. Telepon</label>
                            <input type="tel"
                                   name="phone"
                                   required
                                   class="w-full bg-[#0d0d0d] border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition"
                                   placeholder="+62 812 3456 7890">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-300">Subjek</label>
                            <select name="subject"
                                    required
                                    class="w-full bg-[#0d0d0d] border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition">
                                <option value="">Pilih Subjek</option>
                                <option value="inquiry">Pertanyaan Umum</option>
                                <option value="quotation">Permintaan Penawaran</option>
                                <option value="complaint">Keluhan</option>
                                <option value="partnership">Kerjasama</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-300">Pesan</label>
                            <textarea name="message"
                                      required
                                      rows="5"
                                      class="w-full bg-[#0d0d0d] border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition resize-none"
                                      placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 px-6 py-4 rounded-lg font-semibold text-lg transition transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Pesan
                        </button>
                    </form>

                    <div id="formMessage" class="hidden mt-4 p-4 rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 bg-[#0d0d0d]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Lokasi <span class="text-orange-500">Kami</span></h2>
                <p class="text-gray-400 text-lg">Kunjungi kantor kami untuk konsultasi langsung</p>
            </div>

            <div class="rounded-2xl overflow-hidden border border-gray-800 shadow-2xl">
                <!-- Map Section - Kost Putri Yaumil -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.567892345678!2d112.58718461477123!3d-7.930178479420123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7883519d02fd9f%3A0x5d06bcdad8ec012d!2sKost%20Putri%20Yaumil!5e0!3m2!1sid!2sid!4v1735104000000!5m2!1sid!2sid"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="grayscale">
                </iframe>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-[#111111]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Pertanyaan <span class="text-orange-500">Umum</span></h2>
                <p class="text-gray-400 text-lg">Temukan jawaban atas pertanyaan yang sering diajukan</p>
            </div>

            <div class="space-y-4">
                <details class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl border border-gray-800 p-6 group">
                    <summary class="font-bold text-lg cursor-pointer flex justify-between items-center">
                        Bagaimana cara melacak kiriman saya?
                        <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-gray-400 mt-4 leading-relaxed">
                        Anda dapat melacak kiriman melalui menu Tracking di website kami dengan memasukkan nomor resi yang diberikan saat pembuatan pengiriman.
                    </p>
                </details>

                <details class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl border border-gray-800 p-6 group">
                    <summary class="font-bold text-lg cursor-pointer flex justify-between items-center">
                        Berapa lama waktu pengiriman?
                        <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-gray-400 mt-4 leading-relaxed">
                        Waktu pengiriman bervariasi tergantung jenis layanan dan jarak. Express Delivery: 1-2 hari, General Cargo: 3-5 hari, Special Cargo disesuaikan dengan kebutuhan.
                    </p>
                </details>

                <details class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl border border-gray-800 p-6 group">
                    <summary class="font-bold text-lg cursor-pointer flex justify-between items-center">
                        Bagaimana cara mendapatkan penawaran harga?
                        <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-gray-400 mt-4 leading-relaxed">
                        Silakan isi form kontak di halaman ini atau hubungi CS kami langsung. Tim kami akan memberikan penawaran terbaik sesuai kebutuhan Anda.
                    </p>
                </details>

                <details class="bg-gradient-to-br from-[#1a1a1a] to-[#0d0d0d] rounded-xl border border-gray-800 p-6 group">
                    <summary class="font-bold text-lg cursor-pointer flex justify-between items-center">
                        Apakah tersedia layanan pickup?
                        <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-gray-400 mt-4 leading-relaxed">
                        Ya, kami menyediakan layanan penjemputan barang. Silakan hubungi customer service kami untuk menjadwalkan pickup.
                    </p>
                </details>
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

        // Contact Form Handler
        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const messageDiv = document.getElementById('formMessage');

            // Simulate form submission (replace with actual API call)
            try {
                // Show loading state
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-blue-600 text-white';
                messageDiv.textContent = 'Mengirim pesan...';
                messageDiv.classList.remove('hidden');

                // Simulate API delay
                await new Promise(resolve => setTimeout(resolve, 1500));

                // Success message
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-green-600 text-white';
                messageDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Pesan berhasil dikirim! Kami akan menghubungi Anda segera.';

                // Reset form
                this.reset();

                // Hide message after 5 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);

            } catch (error) {
                // Error message
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-600 text-white';
                messageDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Terjadi kesalahan. Silakan coba lagi.';
            }
        });

        // Initialize
        checkAuth();
    </script>
</body>
</html>
