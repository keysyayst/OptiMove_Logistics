<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pengiriman - Optimove</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-[#111111] text-white">
    <!-- Header -->
    <nav class="bg-gradient-to-r from-orange-600 to-red-600 shadow-xl border-b border-orange-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <i class="fas fa-shipping-fast text-white text-2xl mr-3"></i>
                    <div>
                        <span class="text-white text-xl font-bold tracking-wide">OPTI<span class="text-yellow-300">MOVE</span></span>
                        <span class="text-xs text-orange-100 block">Tracking System</span>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('home') }}" class="text-white hover:bg-orange-700 px-4 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="{{ route('dashboard') }}" class="text-white hover:bg-orange-700 px-4 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-dashboard mr-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-12">
        <!-- Search Box -->
        <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 p-8 mb-8 shadow-2xl">
            <div class="text-center mb-6">
                <div class="inline-block bg-orange-600/20 rounded-full p-4 mb-4">
                    <i class="fas fa-search-location text-5xl text-orange-500"></i>
                </div>
                <h1 class="text-4xl font-bold mb-2">Lacak Pengiriman Anda</h1>
                <p class="text-gray-400">Masukkan kode pengiriman untuk melihat status paket real-time</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto">
                <input
                    type="text"
                    id="tracking-input"
                    placeholder="Contoh: SHIP-20251224-0001"
                    class="flex-1 bg-black/40 border border-gray-700 rounded-lg px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-center sm:text-left"
                    onkeypress="if(event.key === 'Enter') searchTracking()"
                >
                <button
                    onclick="searchTracking()"
                    class="bg-orange-600 hover:bg-orange-500 px-8 py-4 rounded-lg font-semibold transition transform hover:scale-[1.02] shadow-lg">
                    <i class="fas fa-search mr-2"></i>Lacak Sekarang
                </button>
            </div>

            <p id="search-error" class="text-red-400 text-sm mt-4 text-center hidden"></p>

            <!-- Quick Info -->
            <div class="mt-8 pt-8 border-t border-gray-800">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                        <div>
                            <p class="font-semibold text-gray-300">Real-time Update</p>
                            <p class="text-gray-500 text-xs">Tracking diperbarui otomatis</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-shield-alt text-blue-500 text-xl mt-1"></i>
                        <div>
                            <p class="font-semibold text-gray-300">Aman & Terpercaya</p>
                            <p class="text-gray-500 text-xs">Data terenkripsi</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-clock text-orange-500 text-xl mt-1"></i>
                        <div>
                            <p class="font-semibold text-gray-300">24/7 Monitoring</p>
                            <p class="text-gray-500 text-xs">Lacak kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading-state" class="hidden text-center py-16">
            <div class="inline-block bg-[#1a1a1a] rounded-2xl border border-gray-800 p-12">
                <i class="fas fa-spinner fa-spin text-7xl text-orange-500 mb-4"></i>
                <p class="text-gray-400 text-lg">Mencari data pengiriman...</p>
                <p class="text-gray-500 text-sm mt-2">Mohon tunggu sebentar</p>
            </div>
        </div>

        <!-- Tracking Result -->
        <div id="tracking-result" class="hidden space-y-6">
            <!-- Shipment Info -->
            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Kode Pengiriman</p>
                            <h2 class="text-3xl font-bold" id="shipment-code"></h2>
                            <p class="text-sm text-gray-400 mt-2" id="shipment-service"></p>
                        </div>
                        <span id="shipment-status-badge" class="px-5 py-2 rounded-full text-sm font-semibold shadow-lg"></span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Pengirim -->
                        <div class="bg-black/40 rounded-xl p-5 border border-blue-800/30">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-600 rounded-full p-3 mr-3">
                                    <i class="fas fa-user text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-400 uppercase tracking-wide">Pengirim</p>
                                    <p class="font-semibold text-lg" id="sender-name"></p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-300 flex items-start gap-2">
                                <i class="fas fa-map-marker-alt text-blue-400 mt-1"></i>
                                <span id="sender-location"></span>
                            </p>
                        </div>

                        <!-- Penerima -->
                        <div class="bg-black/40 rounded-xl p-5 border border-green-800/30">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-600 rounded-full p-3 mr-3">
                                    <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-green-400 uppercase tracking-wide">Penerima</p>
                                    <p class="font-semibold text-lg" id="receiver-name"></p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-300 flex items-start gap-2">
                                <i class="fas fa-location-arrow text-green-400 mt-1"></i>
                                <span id="receiver-location"></span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-800">
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-1">Berat</p>
                            <p class="font-semibold" id="shipment-weight"></p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-1">Layanan</p>
                            <p class="font-semibold capitalize" id="shipment-service-type"></p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-1">Jenis Barang</p>
                            <p class="font-semibold capitalize" id="item-type"></p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-1">Jumlah</p>
                            <p class="font-semibold" id="item-quantity"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                <div class="px-6 sm:px-8 py-6 border-b border-gray-800">
                    <h3 class="text-2xl font-bold flex items-center">
                        <div class="bg-purple-600 rounded-full p-2 mr-3">
                            <i class="fas fa-route text-white"></i>
                        </div>
                        Riwayat Pengiriman
                    </h3>
                </div>

                <div class="p-6 sm:p-8">
                    <div id="tracking-timeline" class="space-y-6"></div>

                    <div id="no-tracking" class="hidden text-center py-16">
                        <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400 text-lg">Belum ada riwayat tracking</p>
                        <p class="text-gray-500 text-sm mt-2">Tracking akan muncul setelah paket diproses</p>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="text-center">
                <button onclick="resetSearch()" class="bg-gray-800 hover:bg-gray-700 px-8 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-search mr-2"></i>Lacak Pengiriman Lain
                </button>
            </div>
        </div>

        <!-- Not Found State -->
        <div id="not-found-state" class="hidden text-center py-16">
            <div class="inline-block bg-[#1a1a1a] rounded-2xl border border-gray-800 p-12">
                <i class="fas fa-box-open text-7xl text-gray-600 mb-4"></i>
                <h3 class="text-2xl font-bold mb-3">Pengiriman Tidak Ditemukan</h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">
                    Kode pengiriman tidak valid atau tidak ditemukan dalam sistem.
                    Pastikan Anda memasukkan kode dengan benar.
                </p>
                <button onclick="resetSearch()" class="bg-orange-600 hover:bg-orange-500 px-8 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-16 py-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; 2024 Optimove Logistics. All rights reserved.</p>
            <p class="mt-2">Heavy & Oversized Logistics for Your Cargo</p>
        </div>
    </footer>

    <script>
        const statusLabels = {
            'pending': 'Menunggu Pickup',
            'picked_up': 'Sudah Diambil',
            'in_transit': 'Dalam Perjalanan',
            'arrived_at_hub': 'Tiba di Hub',
            'out_for_delivery': 'Siap Diantar',
            'delivered': 'Terkirim'
        };

        const statusColors = {
            'pending': 'bg-yellow-600 text-yellow-100',
            'picked_up': 'bg-blue-600 text-blue-100',
            'in_transit': 'bg-purple-600 text-purple-100',
            'arrived_at_hub': 'bg-orange-600 text-orange-100',
            'out_for_delivery': 'bg-indigo-600 text-indigo-100',
            'delivered': 'bg-green-600 text-green-100'
        };

        const statusIcons = {
            'pending': 'fa-clock',
            'picked_up': 'fa-hand-holding',
            'in_transit': 'fa-truck',
            'arrived_at_hub': 'fa-warehouse',
            'out_for_delivery': 'fa-shipping-fast',
            'delivered': 'fa-check-circle'
        };

        const statusGradients = {
            'pending': 'from-yellow-600/20 to-yellow-800/20 border-yellow-700/50',
            'picked_up': 'from-blue-600/20 to-blue-800/20 border-blue-700/50',
            'in_transit': 'from-purple-600/20 to-purple-800/20 border-purple-700/50',
            'arrived_at_hub': 'from-orange-600/20 to-orange-800/20 border-orange-700/50',
            'out_for_delivery': 'from-indigo-600/20 to-indigo-800/20 border-indigo-700/50',
            'delivered': 'from-green-600/20 to-green-800/20 border-green-700/50'
        };

        async function searchTracking() {
            const input = document.getElementById('tracking-input');
            const code = input.value.trim();
            const errorMsg = document.getElementById('search-error');

            errorMsg.classList.add('hidden');
            errorMsg.textContent = '';

            if (!code) {
                errorMsg.textContent = '⚠️ Masukkan kode pengiriman';
                errorMsg.classList.remove('hidden');
                input.focus();
                return;
            }

            showLoading();

            try {
                const res = await axios.get(`/api/tracking/code/${code}`);

                if (res.data.success) {
                    displayTrackingResult(res.data);
                } else {
                    showNotFound();
                }
            } catch (error) {
                console.error('Error:', error);
                if (error.response && error.response.status === 404) {
                    showNotFound();
                } else {
                    errorMsg.textContent = '❌ Terjadi kesalahan. Silakan coba lagi.';
                    errorMsg.classList.remove('hidden');
                    hideLoading();
                }
            }
        }

        function showLoading() {
            document.getElementById('loading-state').classList.remove('hidden');
            document.getElementById('tracking-result').classList.add('hidden');
            document.getElementById('not-found-state').classList.add('hidden');
        }

        function hideLoading() {
            document.getElementById('loading-state').classList.add('hidden');
        }

        function showNotFound() {
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('tracking-result').classList.add('hidden');
            document.getElementById('not-found-state').classList.remove('hidden');
        }

        function resetSearch() {
            document.getElementById('tracking-input').value = '';
            document.getElementById('tracking-result').classList.add('hidden');
            document.getElementById('not-found-state').classList.add('hidden');
            document.getElementById('tracking-input').focus();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function displayTrackingResult(data) {
            hideLoading();
            document.getElementById('tracking-result').classList.remove('hidden');
            document.getElementById('not-found-state').classList.add('hidden');

            const shipment = data.shipment;
            const histories = data.tracking_histories || [];

            // Shipment Info
            document.getElementById('shipment-code').textContent = shipment.shipment_code;
            document.getElementById('shipment-service').textContent = `${shipment.weight} kg • ${shipment.service_type.toUpperCase()}`;

            const statusBadge = document.getElementById('shipment-status-badge');
            statusBadge.textContent = statusLabels[shipment.status] || shipment.status;
            statusBadge.className = `px-5 py-2 rounded-full text-sm font-semibold shadow-lg ${statusColors[shipment.status]}`;

            document.getElementById('sender-name').textContent = shipment.sender_name;
            document.getElementById('sender-location').textContent = `${shipment.sender_city}, ${shipment.sender_province}`;

            document.getElementById('receiver-name').textContent = shipment.receiver_name;
            document.getElementById('receiver-location').textContent = `${shipment.receiver_city}, ${shipment.receiver_province}`;

            document.getElementById('shipment-weight').textContent = shipment.weight + ' kg';
            document.getElementById('shipment-service-type').textContent = shipment.service_type;
            document.getElementById('item-type').textContent = shipment.item_type || '-';
            document.getElementById('item-quantity').textContent = (shipment.item_quantity || 1) + ' unit';

            // Timeline
            const timeline = document.getElementById('tracking-timeline');
            const noTracking = document.getElementById('no-tracking');

            if (histories.length === 0) {
                timeline.innerHTML = '';
                noTracking.classList.remove('hidden');
            } else {
                noTracking.classList.add('hidden');
                timeline.innerHTML = histories.map((item, index) => `
                    <div class="relative flex gap-6 ${index < histories.length - 1 ? 'pb-6' : ''}">
                        <!-- Timeline Line -->
                        ${index < histories.length - 1 ? '<div class="absolute left-6 top-14 bottom-0 w-0.5 bg-gray-800"></div>' : ''}

                        <!-- Icon -->
                        <div class="relative z-10 flex-shrink-0">
                            <div class="${statusColors[item.status].split(' ')[0]} rounded-full p-4 shadow-2xl ${index === 0 ? 'animate-pulse-slow' : ''}">
                                <i class="fas ${statusIcons[item.status]} text-white text-xl"></i>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="bg-gradient-to-br ${statusGradients[item.status]} border rounded-xl p-5 hover:shadow-lg transition">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-3 mb-3">
                                    <div>
                                        <h4 class="font-bold text-xl mb-1">${item.status_label}</h4>
                                        <p class="text-sm text-gray-400">
                                            <i class="fas fa-clock mr-1"></i>${item.tracked_at_formatted}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusColors[item.status]}">
                                        ${item.status}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-300 mb-3 flex items-start gap-2">
                                    <i class="fas fa-map-marker-alt text-orange-500 mt-1"></i>
                                    <span>${item.location}</span>
                                </p>
                                <p class="text-sm text-gray-400 leading-relaxed">${item.description}</p>
                                ${item.updated_by ? `<p class="text-xs text-gray-500 mt-3 pt-3 border-t border-gray-700"><i class="fas fa-user mr-1"></i>Diperbarui oleh: ${item.updated_by}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Scroll to result
            setTimeout(() => {
                document.getElementById('tracking-result').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 300);
        }

        // Auto search if code in URL
        const urlParams = new URLSearchParams(window.location.search);
        const codeFromUrl = urlParams.get('code');
        if (codeFromUrl) {
            document.getElementById('tracking-input').value = codeFromUrl;
            searchTracking();
        }
    </script>
</body>
</html>
