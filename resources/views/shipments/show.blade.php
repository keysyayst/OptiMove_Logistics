@extends('layouts.app')

@section('title', 'Detail Pengiriman - Optimove')

@section('content')
<div class="min-h-screen bg-[#111111] text-white px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-orange-400 text-sm mb-3 inline-block transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
                <h1 class="text-3xl font-bold" id="page-title">Detail Pengiriman</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <button id="btn-edit" class="bg-yellow-600 hover:bg-yellow-500 text-white px-5 py-2 rounded-lg text-sm font-medium transition transform hover:scale-[1.02]">
                    <i class="fas fa-edit mr-2"></i>Edit
                </button>
                <button id="btn-add-tracking" class="bg-green-600 hover:bg-green-500 text-white px-5 py-2 rounded-lg text-sm font-medium transition transform hover:scale-[1.02]">
                    <i class="fas fa-plus mr-2"></i>Tambah Tracking
                </button>
                <button id="btn-delete" class="bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg text-sm font-medium transition transform hover:scale-[1.02]">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="text-center py-20">
            <i class="fas fa-spinner fa-spin text-6xl text-orange-500 mb-4"></i>
            <p class="text-gray-400">Memuat data pengiriman...</p>
        </div>

        <!-- Content -->
        <div id="content" class="hidden space-y-6">
            <!-- Shipment Details Card -->
            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
                    <h2 class="text-xl font-bold">
                        <i class="fas fa-box text-orange-500 mr-2"></i>Informasi Pengiriman
                    </h2>
                    <span id="status-badge" class="px-4 py-2 rounded-full text-sm font-semibold"></span>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div class="bg-black/40 rounded-lg p-4 border border-gray-800">
                                <label class="text-xs text-gray-400 uppercase tracking-wide block mb-2">Kode Pengiriman</label>
                                <p class="font-bold text-xl text-orange-400" id="shipment-code"></p>
                            </div>
                            <div class="bg-black/40 rounded-lg p-4 border border-gray-800">
                                <label class="text-xs text-gray-400 uppercase tracking-wide block mb-2">UUID</label>
                                <p class="font-mono text-sm text-gray-300" id="shipment-uuid"></p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-400 block mb-2">Jenis Layanan</label>
                                    <p class="font-semibold capitalize" id="service-type"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 block mb-2">Berat</label>
                                    <p class="font-semibold" id="weight"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="bg-gradient-to-br from-green-600/20 to-green-800/20 border border-green-700/50 rounded-lg p-6">
                                <label class="text-xs text-green-300 uppercase tracking-wide block mb-2">Biaya Pengiriman</label>
                                <p class="font-bold text-4xl text-green-400" id="shipping-cost"></p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-400 block mb-2">Jenis Barang</label>
                                    <p class="font-semibold" id="item-type"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 block mb-2">Jumlah</label>
                                    <p class="font-semibold" id="item-quantity"></p>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 block mb-2">Dimensi (P×L×T)</label>
                                <p class="font-semibold" id="dimensions"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sender & Receiver -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Pengirim -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-800 bg-blue-600/10">
                        <h3 class="font-bold text-lg">
                            <i class="fas fa-user text-blue-400 mr-2"></i>Pengirim
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-xs text-gray-400 block mb-1">Nama</label>
                            <p class="font-semibold text-lg" id="sender-name"></p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 block mb-1">Alamat</label>
                            <p class="text-sm text-gray-300" id="sender-address"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-400 block mb-1">Kota / Provinsi</label>
                                <p class="text-sm" id="sender-location"></p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 block mb-1">Kode Pos</label>
                                <p class="text-sm" id="sender-postal"></p>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 block mb-1">Telepon</label>
                            <p class="text-sm" id="sender-phone"></p>
                        </div>
                    </div>
                </div>

                <!-- Penerima -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-800 bg-green-600/10">
                        <h3 class="font-bold text-lg">
                            <i class="fas fa-map-marker-alt text-green-400 mr-2"></i>Penerima
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-xs text-gray-400 block mb-1">Nama</label>
                            <p class="font-semibold text-lg" id="receiver-name"></p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 block mb-1">Alamat</label>
                            <p class="text-sm text-gray-300" id="receiver-address"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-400 block mb-1">Kota / Provinsi</label>
                                <p class="text-sm" id="receiver-location"></p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 block mb-1">Kode Pos</label>
                                <p class="text-sm" id="receiver-postal"></p>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 block mb-1">Telepon</label>
                            <p class="text-sm" id="receiver-phone"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracking History -->
            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-800">
                    <h2 class="text-xl font-bold">
                        <i class="fas fa-route text-purple-500 mr-2"></i>Riwayat Tracking
                    </h2>
                </div>
                <div class="p-6">
                    <div id="tracking-list" class="space-y-4"></div>
                    <div id="no-tracking" class="hidden text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400">Belum ada riwayat tracking</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Tracking -->
<div id="tracking-modal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
    <div class="bg-[#1a1a1a] rounded-2xl border border-gray-800 max-w-2xl w-full shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
            <h3 class="text-xl font-bold">
                <i class="fas fa-plus-circle text-green-500 mr-2"></i>Tambah Tracking
            </h3>
            <button id="close-tracking-modal" class="text-gray-400 hover:text-white transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <form id="tracking-form" class="p-6 space-y-4">
            <input type="hidden" id="tracking-shipment-uuid">

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>Status *
                </label>
                <select id="tracking-status" required
                    class="w-full px-4 py-3 bg-black/40 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                    <option value="pending">Menunggu Pickup</option>
                    <option value="picked_up">Sudah Diambil</option>
                    <option value="in_transit">Dalam Perjalanan</option>
                    <option value="arrived_at_hub">Tiba di Hub</option>
                    <option value="out_for_delivery">Siap Diantar</option>
                    <option value="delivered">Terkirim</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>Lokasi *
                </label>
                <input type="text" id="tracking-location" required
                    class="w-full px-4 py-3 bg-black/40 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Jakarta Warehouse">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-file-alt text-orange-500 mr-2"></i>Deskripsi *
                </label>
                <textarea id="tracking-description" required rows="3"
                    class="w-full px-4 py-3 bg-black/40 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Paket sedang diproses di gudang..."></textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-globe text-orange-500 mr-2"></i>Latitude (Opsional)
                    </label>
                    <input type="number" id="tracking-latitude" step="0.0000001"
                        class="w-full px-4 py-3 bg-black/40 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="-6.200000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-globe text-orange-500 mr-2"></i>Longitude (Opsional)
                    </label>
                    <input type="number" id="tracking-longitude" step="0.0000001"
                        class="w-full px-4 py-3 bg-black/40 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="106.816666">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-800">
                <button type="button" id="cancel-tracking"
                    class="px-6 py-3 border border-gray-600 rounded-lg hover:bg-white/5 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-orange-600 hover:bg-orange-500 rounded-lg font-medium transition transform hover:scale-[1.02]">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>

            <p id="tracking-error" class="text-red-400 text-sm hidden"></p>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const token = localStorage.getItem('optimove_token');
    const shipmentId = window.location.pathname.split('/').pop();
    let shipmentData = null;

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

    const statusBorderColors = {
        'pending': 'border-yellow-600',
        'picked_up': 'border-blue-600',
        'in_transit': 'border-purple-600',
        'arrived_at_hub': 'border-orange-600',
        'out_for_delivery': 'border-indigo-600',
        'delivered': 'border-green-600'
    };

    async function loadShipment() {
        try {
            const res = await axios.get(`/api/shipments/${shipmentId}`);
            shipmentData = res.data;
            displayShipment(shipmentData);
            await loadTracking();
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal memuat data pengiriman',
                confirmButtonColor: '#ea580c'
            });
            console.error(error);
        }
    }

    function displayShipment(data) {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('content').classList.remove('hidden');

        document.getElementById('shipment-code').textContent = data.shipment_code;
        document.getElementById('shipment-uuid').textContent = data.uuid;

        const statusBadge = document.getElementById('status-badge');
        statusBadge.textContent = statusLabels[data.status] || data.status;
        statusBadge.className = `px-4 py-2 rounded-full text-sm font-semibold ${statusColors[data.status]}`;

        document.getElementById('service-type').textContent = data.service_type;
        document.getElementById('weight').textContent = data.weight + ' kg';
        document.getElementById('shipping-cost').textContent = 'Rp ' + Number(data.shipping_cost || 0).toLocaleString('id-ID');
        document.getElementById('item-type').textContent = data.item_type || '-';
        document.getElementById('item-quantity').textContent = data.item_quantity + ' unit';
        document.getElementById('dimensions').textContent = `${data.length_cm || 0} × ${data.width_cm || 0} × ${data.height_cm || 0} cm`;

        document.getElementById('sender-name').textContent = data.sender_name;
        document.getElementById('sender-address').textContent = data.sender_address;
        document.getElementById('sender-location').textContent = `${data.sender_city}, ${data.sender_province}`;
        document.getElementById('sender-postal').textContent = data.sender_postal_code;
        document.getElementById('sender-phone').textContent = data.sender_phone;

        document.getElementById('receiver-name').textContent = data.receiver_name;
        document.getElementById('receiver-address').textContent = data.receiver_address;
        document.getElementById('receiver-location').textContent = `${data.receiver_city}, ${data.receiver_province}`;
        document.getElementById('receiver-postal').textContent = data.receiver_postal_code;
        document.getElementById('receiver-phone').textContent = data.receiver_phone;
    }

    async function loadTracking() {
        try {
            const res = await axios.get(`/api/tracking/uuid/${shipmentData.uuid}`);
            const histories = res.data.tracking_histories || [];
            displayTracking(histories);
        } catch (error) {
            console.error('Error loading tracking:', error);
        }
    }

    function displayTracking(histories) {
        const list = document.getElementById('tracking-list');
        const noTracking = document.getElementById('no-tracking');

        if (histories.length === 0) {
            list.innerHTML = '';
            noTracking.classList.remove('hidden');
            return;
        }

        noTracking.classList.add('hidden');
        list.innerHTML = histories.map((item, index) => `
            <div class="relative pl-8 pb-8 ${index === histories.length - 1 ? '' : 'border-l-2 border-gray-800'}">
                <div class="absolute left-0 top-0 -translate-x-1/2 w-4 h-4 rounded-full ${statusColors[item.status].split(' ')[0]} border-4 border-[#111111]"></div>
                <div class="bg-black/40 rounded-lg p-4 border ${statusBorderColors[item.status]} hover:bg-black/60 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-semibold text-lg">${item.status_label}</h4>
                            <p class="text-sm text-gray-400">
                                <i class="fas fa-clock mr-1"></i>${item.tracked_at_formatted}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${statusColors[item.status]}">
                            ${item.status}
                        </span>
                    </div>
                    <p class="text-sm text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>${item.location}
                    </p>
                    <p class="text-sm text-gray-400">${item.description}</p>
                    ${item.updated_by ? `<p class="text-xs text-gray-500 mt-2"><i class="fas fa-user mr-1"></i>Oleh: ${item.updated_by}</p>` : ''}
                </div>
            </div>
        `).join('');
    }

    // Modal Controls
    document.getElementById('btn-add-tracking').addEventListener('click', () => {
        document.getElementById('tracking-shipment-uuid').value = shipmentData.uuid;
        document.getElementById('tracking-modal').classList.remove('hidden');
        document.getElementById('tracking-modal').classList.add('flex');
    });

    document.getElementById('close-tracking-modal').addEventListener('click', () => {
        document.getElementById('tracking-modal').classList.add('hidden');
    });

    document.getElementById('cancel-tracking').addEventListener('click', () => {
        document.getElementById('tracking-modal').classList.add('hidden');
    });

    // Submit Tracking
    document.getElementById('tracking-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            shipment_uuid: document.getElementById('tracking-shipment-uuid').value,
            status: document.getElementById('tracking-status').value,
            location: document.getElementById('tracking-location').value,
            description: document.getElementById('tracking-description').value,
            latitude: document.getElementById('tracking-latitude').value || null,
            longitude: document.getElementById('tracking-longitude').value || null,
        };

        try {
            await axios.post('/api/tracking', payload);

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Tracking berhasil ditambahkan',
                confirmButtonColor: '#ea580c'
            });

            document.getElementById('tracking-modal').classList.add('hidden');
            document.getElementById('tracking-form').reset();
            await loadShipment();
        } catch (error) {
            const msg = error.response?.data?.message || 'Gagal menambahkan tracking';
            document.getElementById('tracking-error').textContent = msg;
            document.getElementById('tracking-error').classList.remove('hidden');
        }
    });

    // Edit Button
    document.getElementById('btn-edit').addEventListener('click', () => {
        window.location.href = `{{ route('dashboard') }}`;
    });

    // Delete Button
    document.getElementById('btn-delete').addEventListener('click', async () => {
        const result = await Swal.fire({
            title: 'Hapus Pengiriman?',
            text: 'Data tidak dapat dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            try {
                await axios.delete(`/api/shipments/${shipmentId}`);

                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: 'Pengiriman berhasil dihapus',
                    confirmButtonColor: '#ea580c'
                });

                setTimeout(() => {
                    window.location.href = '{{ route('dashboard') }}';
                }, 1500);
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal menghapus pengiriman',
                    confirmButtonColor: '#ea580c'
                });
            }
        }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', loadShipment);
</script>
@endsection
