<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optimove Logistics</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#111111] text-white">

    {{-- HERO --}}
    <header class="min-h-screen bg-cover bg-center relative"
        style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.85)),url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1350&q=80');">
        <div class="px-6 md:px-16 pt-5">
            {{-- NAVBAR --}}
            <nav class="flex items-center justify-between">
                <div class="text-xl md:text-2xl font-bold tracking-wide">
                    OPTI<span class="text-orange-500">MOVE</span>
                </div>

                <div class="flex items-center space-x-6 text-sm">
                    {{-- menu scroll di halaman yang sama --}}
                    <a href="{{ route('home') }}" class="hidden md:inline border-b-2 border-orange-500 pb-1">
                        Start
                    </a>
                    <a href="#services" class="hidden md:inline hover:text-gray-300">
                        Services
                    </a>
                    <a href="#about" class="hidden md:inline hover:text-gray-300">
                        Company
                    </a>

                    {{-- tombol Register & Login --}}
                    <a href="{{ route('register.page') }}"
                       class="hidden md:inline rounded-full border border-gray-600 px-4 py-2 hover:bg-white/5">
                        Register
                    </a>
                    <a href="{{ route('login.page') }}"
                       class="rounded-full bg-orange-600 hover:bg-orange-500 px-4 py-2">
                        Login
                    </a>
                </div>
            </nav>
        </div>

        {{-- HERO CONTENT --}}
        <div id="home" class="px-6 md:px-16 mt-24 md:mt-40 max-w-2xl">
            <h1 class="text-4xl md:text-6xl font-semibold leading-tight mb-4">
                Heavy &amp; Oversized<br>Logistics for Your Cargo
            </h1>
            <p class="text-gray-200 text-sm md:text-base mb-8">
                Optimove mengirimkan alat berat, kontainer proyek, dan barang sensitif ke seluruh Indonesia
                dengan armada khusus dan driver berpengalaman. Aman, presisi, dan tepat waktu.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#booking"
                   class="inline-flex items-center justify-center rounded-full bg-orange-600 hover:bg-orange-500 px-6 py-3 text-sm font-medium">
                    Request shipment now &rarr;
                </a>
                <a href="#tracking"
                   class="inline-flex items-center justify-center rounded-full border border-gray-500 px-6 py-3 text-sm font-medium text-gray-200 hover:bg-white/5">
                    Track existing order
                </a>
            </div>
        </div>
    </header>

    {{-- SERVICES GRID --}}
    <section id="services" class="py-20 px-6 md:px-16 bg-[#111111]">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-semibold mb-3">Our Services</h2>
            <p class="text-gray-400 text-sm md:text-base">
                Dari proyek konstruksi hingga logistik industri, Optimove membawa pergerakan ke situasi tersulit.
            </p>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            {{-- Card 1 --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] p-8 flex flex-col">
                <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-[radial-gradient(circle,rgba(216,68,25,0.2)_0%,transparent_70%)]"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-full bg-orange-600 flex items-center justify-center mb-5">
                        <span class="text-2xl">🚛</span>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Heavy &amp; Oversized Transport</h3>
                    <p class="text-gray-400 text-sm mb-6">
                        Pengiriman alat berat, crane, dan mesin industri dengan pengawalan dan izin rute lengkap.
                    </p>
                    <a href="#booking"
                       class="inline-flex items-center justify-between w-full rounded-full border border-gray-600 px-4 py-2 text-sm hover:bg-white/5">
                        <span>Request transport now</span><span>&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- Card 2 (highlight) --}}
            <div class="relative overflow-hidden rounded-2xl bg-white text-black p-8 flex flex-col">
                <div class="w-14 h-14 rounded-full bg-orange-600 flex items-center justify-center mb-5">
                    <span class="text-2xl text-white">🏗️</span>
                </div>
                <h3 class="font-semibold text-lg mb-2">
                    Project &amp; Site Logistics
                </h3>
                <p class="text-gray-700 text-sm mb-6">
                    Partner logistik untuk proyek konstruksi, solar farm, dan infrastruktur. Pengiriman modul prefabrikasi
                    dan material tepat waktu sesuai jadwal site.
                </p>
                <a href="#booking"
                   class="inline-flex items-center justify-between w-full rounded-full bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-500">
                    <span>Request transport now</span><span>&rarr;</span>
                </a>
            </div>

            {{-- Card 3 --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] p-8 flex flex-col">
                <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-[radial-gradient(circle,rgba(216,68,25,0.2)_0%,transparent_70%)]"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-full bg-orange-600 flex items-center justify-center mb-5">
                        <span class="text-2xl">📦</span>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Specialized Logistics</h3>
                    <p class="text-gray-400 text-sm mb-6">
                        Penanganan kargo sensitif, high‑value goods, dan kebutuhan logistik khusus dengan monitoring realtime.
                    </p>
                    <a href="#booking"
                       class="inline-flex items-center justify-between w-full rounded-full border border-gray-600 px-4 py-2 text-sm hover:bg-white/5">
                        <span>Request transport now</span><span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="py-20 px-6 md:px-16 bg-[#0a0a0a]">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10 items-center rounded-2xl bg-[#1a1a1a] p-8 md:p-12">
            <div>
                <img class="rounded-xl w-full object-cover"
                     src="https://images.unsplash.com/photo-1541417904950-b855846fe074?auto=format&fit=crop&w=900&q=80"
                     alt="Optimove operations">
            </div>
            <div>
                <h2 class="text-sm tracking-[0.3em] text-orange-500 mb-3">ABOUT OPTIMOVE</h2>
                <h3 class="text-2xl md:text-3xl font-semibold mb-4">
                    Smart logistics for heavy and time‑critical shipments.
                </h3>
                <p class="text-gray-300 text-sm md:text-base mb-5">
                    Optimove adalah perusahaan logistik yang fokus pada pengiriman alat berat dan kargo proyek.
                    Dengan jaringan mitra nasional, sistem pelacakan live, serta tim perencanaan rute berpengalaman,
                    kami memastikan setiap barang sampai tepat waktu dan dalam kondisi terbaik.
                </p>
                <button
                    class="rounded-full bg-orange-600 hover:bg-orange-500 px-6 py-3 text-sm font-medium">
                    Learn more about Optimove
                </button>
            </div>
        </div>
    </section>

    {{-- (OPSIONAL) SECTION BOOKING / TRACKING BISA DITAMBAH DI SINI --}}

</body>
</html>
