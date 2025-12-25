@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#111111] text-white px-6 py-8">
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-semibold">Optimove Dashboard</h1>
            <p class="text-xs text-gray-400 mt-1">
                Kelola data pengiriman alat berat dan proyek secara terpusat.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <span id="dashboard-user" class="text-sm text-gray-300"></span>
            <button id="logout-btn"
                    class="rounded-full bg-red-600 hover:bg-red-500 px-4 py-2 text-sm">
                Logout
            </button>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-5">
            <div class="text-xs text-blue-100 mb-1">Total Pengiriman</div>
            <div id="stat-total" class="text-3xl font-bold">0</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-2xl p-5">
            <div class="text-xs text-yellow-100 mb-1">Menunggu Pickup</div>
            <div id="stat-pending" class="text-3xl font-bold">0</div>
        </div>
        <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl p-5">
            <div class="text-xs text-purple-100 mb-1">Dalam Perjalanan</div>
            <div id="stat-transit" class="text-3xl font-bold">0</div>
        </div>
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-2xl p-5">
            <div class="text-xs text-green-100 mb-1">Terkirim</div>
            <div id="stat-delivered" class="text-3xl font-bold">0</div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Data Pengiriman</h2>
        <button id="open-create"
                class="rounded-full bg-orange-600 hover:bg-orange-500 px-4 py-2 text-sm">
            + Buat Pengiriman
        </button>
    </div>

    {{-- LIST SHIPMENTS --}}
    <div id="shipments" class="grid md:grid-cols-3 gap-4"></div>
    <p id="empty-msg" class="text-gray-400 text-sm mt-6 hidden">
        Belum ada data pengiriman. Klik
        <span class="text-orange-400 font-medium">Buat Pengiriman</span>
        untuk menambahkan.
    </p>

    {{-- MODAL FORM (BUAT / UBAH PENGIRIMAN) --}}
    <div id="shipment-modal"
         class="fixed inset-0 bg-black/60 hidden items-center justify-center z-40">
        <div class="w-full max-w-3xl bg-[#1a1a1a] rounded-2xl border border-gray-800 p-6 relative max-h-[90vh] overflow-y-auto">
            <button id="close-modal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-white text-xl">
                &times;
            </button>

            <h3 id="modal-title" class="text-xl font-semibold mb-4">
                Buat Pengiriman
            </h3>

            <form id="shipment-form" class="space-y-4">
                <input type="hidden" name="id" />
                <input type="hidden" name="uuid" />

                {{-- KODE --}}
                <div>
                    <label class="text-xs text-gray-300">Kode Pengiriman</label>
                    <input
                        type="text"
                        name="shipment_code"
                        id="shipment_code"
                        readonly
                        placeholder="Akan terisi otomatis setelah disimpan"
                        class="mt-1 w-full rounded-lg bg-black/60 border border-gray-700 px-3 py-2 text-sm text-gray-400">
                </div>

                {{-- NAMA PENGIRIM / PENERIMA --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-gray-300">Nama Pengirim</label>
                        <input type="text" name="sender_name" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Nama Penerima</label>
                        <input type="text" name="receiver_name" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                </div>

                {{-- ALAMAT PENGIRIM --}}
                <div>
                    <label class="text-xs text-gray-300">Alamat Pengirim</label>
                    <textarea name="sender_address" required
                              class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm"
                              placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" rows="2"></textarea>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs text-gray-300">Kota Pengirim</label>
                        <input type="text" name="sender_city" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Provinsi Pengirim</label>
                        <input type="text" name="sender_province" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Kode Pos Pengirim</label>
                        <input type="text" name="sender_postal_code" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-300">Telepon Pengirim</label>
                    <input type="text" name="sender_phone" required
                           class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                </div>

                {{-- ALAMAT PENERIMA --}}
                <div class="mt-2">
                    <label class="text-xs text-gray-300">Alamat Penerima</label>
                    <textarea name="receiver_address" required
                              class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm"
                              placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" rows="2"></textarea>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs text-gray-300">Kota Penerima</label>
                        <input type="text" name="receiver_city" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Provinsi Penerima</label>
                        <input type="text" name="receiver_province" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Kode Pos Penerima</label>
                        <input type="text" name="receiver_postal_code" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-300">Telepon Penerima</label>
                    <input type="text" name="receiver_phone" required
                           class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                </div>

                {{-- STATUS & BERAT --}}
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="text-xs text-gray-300">Status</label>
                        <select name="status" required
                                class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                            <option value="pending">Menunggu Pickup</option>
                            <option value="picked_up">Sudah Diambil</option>
                            <option value="in_transit">Dalam Perjalanan</option>
                            <option value="arrived_at_hub">Tiba di Hub</option>
                            <option value="out_for_delivery">Siap Diantar</option>
                            <option value="delivered">Terkirim</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Berat (kg)</label>
                        <input type="number" name="weight" min="0" step="0.1" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                </div>

                {{-- RINCIAN BARANG --}}
                <div class="grid md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="text-xs text-gray-300">Jenis Barang</label>
                        <select name="item_type" id="item_type" required
                                class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                            <option value="dokumen">Dokumen</option>
                            <option value="makanan">Makanan</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <input type="text" name="item_type_other" id="item_type_other"
                               placeholder="Jenis barang lainnya (contoh: alat berat)"
                               class="mt-2 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm hidden">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Jumlah Barang</label>
                        <input type="number" name="item_quantity" min="1" value="1" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                </div>

                {{-- DIMENSI PAKET --}}
                <div class="grid md:grid-cols-3 gap-4 mt-2">
                    <div>
                        <label class="text-xs text-gray-300">Panjang (cm)</label>
                        <input type="number" name="length_cm" min="0" step="0.1" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Lebar (cm)</label>
                        <input type="number" name="width_cm" min="0" step="0.1" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Tinggi (cm)</label>
                        <input type="number" name="height_cm" min="0" step="0.1" required
                               class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                    </div>
                </div>

                {{-- JENIS LAYANAN --}}
                <div class="grid md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="text-xs text-gray-300">Jenis Layanan</label>
                        <select name="service_type" required
                                class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm">
                            <option value="regular">Reguler</option>
                            <option value="express">Express</option>
                            <option value="cargo">Kargo</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-300">Estimasi Jarak</label>
                        <input type="text" id="estimated-distance" readonly
                               class="mt-1 w-full rounded-lg bg-black/60 border border-gray-700 px-3 py-2 text-sm text-gray-400"
                               placeholder="Akan dihitung otomatis">
                    </div>
                </div>

                {{-- TOTAL HARGA --}}
                <div class="bg-black/40 border border-gray-700 rounded-lg p-4 mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-300">Total Harga Pengiriman</span>
                        <span id="total-price-display" class="text-xl font-bold text-orange-400">Rp 0</span>
                    </div>
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">

                    <div class="mt-3 pt-3 border-t border-gray-700 text-[11px] text-gray-400 space-y-1">
                        <div class="flex justify-between">
                            <span>Biaya Berat/Volume:</span>
                            <span id="cost-weight">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Jarak:</span>
                            <span id="cost-distance">Rp 0</span>
                        </div>
                    </div>

                    <p class="text-[10px] text-gray-500 mt-2">
                        Formula: Berat yang ditagih (max antara berat aktual & volumetrik) × Rp 5.000/kg + Biaya jarak bertingkat (0-10km: Rp 5.000, 11-50km: Rp 10.000, 51-150km: Rp 20.000)
                    </p>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" id="cancel-modal"
                            class="rounded-full border border-gray-600 px-4 py-2 text-xs">
                        Batal
                    </button>
                    <button type="submit"
                            class="rounded-full bg-orange-600 hover:bg-orange-500 px-5 py-2 text-xs font-medium">
                        Simpan
                    </button>
                </div>

                <p id="form-error" class="text-xs text-red-400 mt-2"></p>
            </form>
        </div>
    </div>
</div>

<script>
console.log('🚀 Script dashboard dimulai...');

const token = localStorage.getItem('optimove_token');
console.log('🔑 Token:', token ? 'Ada' : 'Tidak ada');

if (!token) {
    console.warn('⚠️ Token tidak ada, redirect ke login');
    window.location.href = '{{ route('login.page') }}';
}

const shipmentsContainer = document.getElementById('shipments');
const emptyMsg = document.getElementById('empty-msg');
const userLabel = document.getElementById('dashboard-user');

const modal = document.getElementById('shipment-modal');
const openCreateBtn = document.getElementById('open-create');
const closeModalBtn = document.getElementById('close-modal');
const cancelModalBtn = document.getElementById('cancel-modal');
const form = document.getElementById('shipment-form');
const modalTitle = document.getElementById('modal-title');
const formError = document.getElementById('form-error');

const shipmentCodeInput = document.getElementById('shipment_code');
const itemTypeSelect = document.getElementById('item_type');
const itemTypeOtherInput = document.getElementById('item_type_other');

const TARIF_PER_KG = 5000;
const DIVIDER_VOLUMETRIK = 5000;

let editingId = null;
let shipmentsData = [];

// STATUS LABELS
const statusLabels = {
    'pending': 'Menunggu Pickup',
    'picked_up': 'Sudah Diambil',
    'in_transit': 'Dalam Perjalanan',
    'arrived_at_hub': 'Tiba di Hub',
    'out_for_delivery': 'Siap Diantar',
    'delivered': 'Terkirim'
};

const statusColors = {
    'pending': 'bg-yellow-600',
    'picked_up': 'bg-blue-600',
    'in_transit': 'bg-purple-600',
    'arrived_at_hub': 'bg-orange-600',
    'out_for_delivery': 'bg-indigo-600',
    'delivered': 'bg-green-600'
};

// GEOCODING & DISTANCE
const cityCoordinatesCache = {};

async function geocodeCity(cityName) {
    if (cityCoordinatesCache[cityName]) {
        return cityCoordinatesCache[cityName];
    }

    try {
        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(cityName)},Indonesia&format=json&limit=1`;
        const res = await fetch(url, {
            headers: { 'User-Agent': 'Optimove-App/1.0' }
        });
        const data = await res.json();

        if (data.length > 0) {
            const coords = {
                lat: parseFloat(data[0].lat),
                lng: parseFloat(data[0].lon)
            };
            cityCoordinatesCache[cityName] = coords;
            return coords;
        }
        return null;
    } catch (e) {
        console.error('Geocode error:', e);
        return null;
    }
}

async function getDistanceFromOSRM(coordFrom, coordTo) {
    try {
        const url = `https://router.project-osrm.org/route/v1/driving/${coordFrom.lng},${coordFrom.lat};${coordTo.lng},${coordTo.lat}?overview=false`;
        const res = await fetch(url);
        const data = await res.json();

        if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
            return Math.round(data.routes[0].distance / 1000);
        }
        return null;
    } catch (e) {
        console.error('OSRM error:', e);
        return null;
    }
}

function haversineDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;

    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return Math.round(R * c);
}

async function estimateDistance(cityFrom, cityTo) {
    if (!cityFrom || !cityTo) return 0;

    const from = cityFrom.trim();
    const to = cityTo.trim();

    if (from.toLowerCase() === to.toLowerCase()) return 10;

    const distanceInput = document.getElementById('estimated-distance');
    if (distanceInput) distanceInput.value = 'Menghitung...';

    try {
        const coordFrom = await geocodeCity(from);
        const coordTo = await geocodeCity(to);

        if (!coordFrom || !coordTo) return 200;

        const distance = await getDistanceFromOSRM(coordFrom, coordTo);
        if (distance) return distance;

        return haversineDistance(coordFrom.lat, coordFrom.lng, coordTo.lat, coordTo.lng);
    } catch (e) {
        console.error('Error estimating distance:', e);
        return 200;
    }
}

// ✅ FUNGSI HITUNG BIAYA JARAK BERTINGKAT
function calculateDistanceCost(distance) {
    if (distance <= 10) {
        return 5000;
    } else if (distance <= 50) {
        return 10000;
    } else if (distance <= 150) {
        return 20000;
    } else {
        // Jarak > 150 km, tambahkan biaya tambahan jika diperlukan
        return 20000 + ((distance - 150) * 500);
    }
}

// ✅ CALCULATE SHIPPING COST (DIUBAH)
async function calculateShippingCost() {
    const weight = Number(form.weight.value) || 0;
    const length = Number(form.length_cm.value) || 0;
    const width = Number(form.width_cm.value) || 0;
    const height = Number(form.height_cm.value) || 0;

    const senderCity = form.sender_city.value || '';
    const receiverCity = form.receiver_city.value || '';

    const volume = length * width * height;
    const volumetricWeight = volume / DIVIDER_VOLUMETRIK;
    const chargeableWeight = Math.max(weight, volumetricWeight);
    const costWeight = chargeableWeight * TARIF_PER_KG;

    const distance = await estimateDistance(senderCity, receiverCity);
    const costDistance = calculateDistanceCost(distance); // ✅ PERUBAHAN UTAMA
    const totalCost = costWeight + costDistance;

    document.getElementById('total-price-display').textContent =
        'Rp ' + Math.round(totalCost).toLocaleString('id-ID');
    document.getElementById('shipping_cost').value = Math.round(totalCost);
    document.getElementById('cost-weight').textContent =
        'Rp ' + Math.round(costWeight).toLocaleString('id-ID');
    document.getElementById('cost-distance').textContent =
        'Rp ' + Math.round(costDistance).toLocaleString('id-ID');
    document.getElementById('estimated-distance').value = distance + ' km';

    return totalCost;
}

// AUTO CALCULATE ON INPUT CHANGE
[form.weight, form.length_cm, form.width_cm, form.height_cm, form.sender_city, form.receiver_city].forEach(input => {
    if (input) {
        input.addEventListener('input', calculateShippingCost);
        input.addEventListener('change', calculateShippingCost);
    }
});

// ITEM TYPE TOGGLE
if (itemTypeSelect && itemTypeOtherInput) {
    itemTypeSelect.addEventListener('change', () => {
        if (itemTypeSelect.value === 'lainnya') {
            itemTypeOtherInput.classList.remove('hidden');
            itemTypeOtherInput.required = true;
        } else {
            itemTypeOtherInput.classList.add('hidden');
            itemTypeOtherInput.required = false;
            itemTypeOtherInput.value = '';
        }
    });
}

// GENERATE CODE
async function generateShipmentCode() {
    try {
        shipmentCodeInput.value = 'Sedang generate...';

        const res = await fetch('/api/shipments/generate-code', {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (!res.ok) {
            shipmentCodeInput.value = 'GAGAL-GENERATE';
            return null;
        }

        const data = await res.json();
        shipmentCodeInput.value = data.code ?? 'KODE-KOSONG';
        return data.code;
    } catch (e) {
        console.error('Network error generate code:', e);
        shipmentCodeInput.value = 'ERROR-NETWORK';
        return null;
    }
}

// OPEN MODAL
async function openModal(mode, data = null) {
    console.log('📂 Opening modal:', mode);

    editingId = data ? data.id : null;
    modalTitle.textContent = mode === 'create' ? 'Buat Pengiriman' : 'Ubah Pengiriman';
    formError.textContent = '';

    if (data) {
        form.id.value = data.id;
        form.uuid.value = data.uuid || '';
        shipmentCodeInput.value = data.shipment_code || '';

        form.sender_name.value = data.sender_name || '';
        form.receiver_name.value = data.receiver_name || '';
        form.sender_address.value = data.sender_address || '';
        form.sender_city.value = data.sender_city || '';
        form.sender_province.value = data.sender_province || '';
        form.sender_postal_code.value = data.sender_postal_code || '';
        form.sender_phone.value = data.sender_phone || '';
        form.receiver_address.value = data.receiver_address || '';
        form.receiver_city.value = data.receiver_city || '';
        form.receiver_province.value = data.receiver_province || '';
        form.receiver_postal_code.value = data.receiver_postal_code || '';
        form.receiver_phone.value = data.receiver_phone || '';

        form.status.value = data.status || 'pending';
        form.weight.value = data.weight || '';

        const itemType = data.item_type || 'dokumen';
        form.item_type.value = itemType;
        form.item_quantity.value = data.item_quantity || 1;
        form.length_cm.value = data.length_cm || '';
        form.width_cm.value = data.width_cm || '';
        form.height_cm.value = data.height_cm || '';
        form.service_type.value = data.service_type || 'regular';

        if (itemType === 'lainnya' && itemTypeOtherInput) {
            itemTypeOtherInput.value = data.item_type_other || '';
            itemTypeOtherInput.classList.remove('hidden');
        }
        if (itemTypeSelect) itemTypeSelect.dispatchEvent(new Event('change'));

        await calculateShippingCost();

    } else {
        form.reset();
        form.id.value = '';
        form.uuid.value = '';
        await generateShipmentCode();
        form.status.value = 'pending';
        form.item_type.value = 'dokumen';
        form.item_quantity.value = 1;
        form.service_type.value = 'regular';
        if (itemTypeSelect) itemTypeSelect.dispatchEvent(new Event('change'));
        await calculateShippingCost();
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// LOAD USER
async function loadMe() {
    try {
        const res = await fetch('/api/auth/me', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        if (!res.ok) return;
        const user = await res.json();
        userLabel.textContent = `Hai, ${user.name}`;
    } catch (e) {
        console.error('Load user gagal:', e);
    }
}

// RENDER SHIPMENTS
function renderShipments(list) {
    console.log('🎨 Rendering shipments:', list.length);

    shipmentsContainer.innerHTML = '';
    shipmentsData = list;

    // UPDATE STATS
    document.getElementById('stat-total').textContent = list.length;
    document.getElementById('stat-pending').textContent = list.filter(s => s.status === 'pending').length;
    document.getElementById('stat-transit').textContent = list.filter(s =>
        ['picked_up', 'in_transit', 'arrived_at_hub', 'out_for_delivery'].includes(s.status)
    ).length;
    document.getElementById('stat-delivered').textContent = list.filter(s => s.status === 'delivered').length;

    if (!list || !list.length) {
        emptyMsg.classList.remove('hidden');
        return;
    }
    emptyMsg.classList.add('hidden');

    list.forEach(item => {
        const div = document.createElement('div');
        div.className = 'rounded-2xl border border-gray-800 bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] p-4 text-sm space-y-2';

        div.innerHTML = `
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-400">Kode</span>
                <span class="font-semibold">${item.shipment_code || 'N/A'}</span>
            </div>
            <div class="text-xs text-gray-300 space-y-1">
                <p>Dari: <span class="font-medium">${item.sender_city || 'N/A'}</span></p>
                <p>Ke: <span class="font-medium">${item.receiver_city || 'N/A'}</span></p>
            </div>
            <div class="text-xs text-gray-300 space-y-1">
                <div class="flex justify-between">
                    <span>Berat:</span>
                    <span>${item.weight ?? 0} kg</span>
                </div>
                <div class="flex justify-between">
                    <span>Dimensi:</span>
                    <span>${item.length_cm || 0}×${item.width_cm || 0}×${item.height_cm || 0} cm</span>
                </div>
            </div>
            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-700">
                <span class="text-xs text-gray-400">Total Harga:</span>
                <span class="text-base font-bold text-orange-400">Rp ${Number(item.shipping_cost || 0).toLocaleString('id-ID')}</span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs px-2 py-1 rounded-full ${statusColors[item.status]} text-white">
                    ${statusLabels[item.status] || item.status}
                </span>
            </div>
            <div class="flex gap-2 mt-3">
                <button data-id="${item.id}" class="btn-edit flex-1 rounded-full border border-gray-600 px-2 py-1 text-xs hover:bg-gray-800">
                    Edit
                </button>
                <button data-id="${item.id}" class="btn-delete flex-1 rounded-full bg-red-600 hover:bg-red-500 px-2 py-1 text-xs">
                    Hapus
                </button>
                <a href="/tracking/${item.uuid}" class="flex-1 text-center rounded-full bg-purple-600 hover:bg-purple-500 px-2 py-1 text-xs">
                    Tracking
                </a>
            </div>
        `;

        shipmentsContainer.appendChild(div);
    });

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            const data = shipmentsData.find(s => String(s.id) === String(id));
            if (data) openModal('edit', data);
        };
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.onclick = () => handleDelete(btn.dataset.id);
    });
}

// LOAD SHIPMENTS
async function loadShipments() {
    console.log('🔄 Loading shipments...');

    try {
        const res = await fetch('/api/shipments', {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (res.status === 401) {
            localStorage.removeItem('optimove_token');
            window.location.href = '{{ route('login.page') }}';
            return;
        }

        if (!res.ok) {
            console.error('❌ Load shipments gagal:', res.status);
            renderShipments([]);
            return;
        }

        const data = await res.json();
        console.log('📦 Data shipments:', data);

        renderShipments(data);
    } catch (e) {
        console.error('❌ Network error load shipments:', e);
        renderShipments([]);
    }
}

// FORM SUBMIT
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    console.log('🔥 FORM SUBMIT TRIGGERED!');

    formError.textContent = '';

    const payload = {
        sender_name: form.sender_name.value,
        receiver_name: form.receiver_name.value,
        status: form.status.value,
        weight: Number(form.weight.value),
        shipping_cost: Number(form.shipping_cost.value),
        sender_address: form.sender_address.value,
        sender_city: form.sender_city.value,
        sender_province: form.sender_province.value,
        sender_postal_code: form.sender_postal_code.value,
        sender_phone: form.sender_phone.value,
        receiver_address: form.receiver_address.value,
        receiver_city: form.receiver_city.value,
        receiver_province: form.receiver_province.value,
        receiver_postal_code: form.receiver_postal_code.value,
        receiver_phone: form.receiver_phone.value,
        item_type: form.item_type.value === 'lainnya'
            ? (form.item_type_other.value || 'lainnya')
            : form.item_type.value,
        item_quantity: Number(form.item_quantity.value),
        length_cm: form.length_cm.value ? Number(form.length_cm.value) : null,
        width_cm: form.width_cm.value ? Number(form.width_cm.value) : null,
        height_cm: form.height_cm.value ? Number(form.height_cm.value) : null,
        service_type: form.service_type.value,
    };

    const isEdit = !!editingId;
    const url = isEdit ? `/api/shipments/${editingId}` : '/api/shipments';
    const method = isEdit ? 'PUT' : 'POST';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            console.error('❌ Error response:', err);
            formError.textContent = err.message ?? `Gagal menyimpan: ${res.status}`;
            return;
        }

        const result = await res.json();
        console.log('✅ Success!', result);

        closeModal();
        await loadShipments();

    } catch (err) {
        console.error('❌ Network error:', err);
        formError.textContent = 'Terjadi kesalahan jaringan.';
    }
});

// DELETE
async function handleDelete(id) {
    if (!confirm('Yakin ingin menghapus pengiriman ini?')) return;

    try {
        const res = await fetch(`/api/shipments/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (!res.ok) {
            alert('Gagal menghapus data.');
            return;
        }

        await loadShipments();
    } catch (e) {
        console.error('Delete error:', e);
        alert('Terjadi kesalahan saat menghapus.');
    }
}

// LOGOUT
document.getElementById('logout-btn').addEventListener('click', async () => {
    try {
        await fetch('/api/auth/logout', {
            method: 'POST',
            headers: { 'Authorization': `Bearer ${token}` }
        });
    } catch (e) {
        console.error('Logout error:', e);
    } finally {
        localStorage.removeItem('optimove_token');
        window.location.href = '{{ route('login.page') }}';
    }
});

// MODAL BUTTONS
openCreateBtn.addEventListener('click', () => openModal('create'));
closeModalBtn.addEventListener('click', closeModal);
cancelModalBtn.addEventListener('click', closeModal);

// INIT
console.log('Initializing...');
loadMe();
loadShipments();
console.log('Dashboard siap!');
</script>
@endsection
