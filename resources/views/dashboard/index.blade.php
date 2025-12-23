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
                            <option value="pending">Pending</option>
                            <option value="shipping">Dalam Pengiriman</option>
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

                {{-- DIMENSI PAKET (PANJANG, LEBAR, TINGGI) --}}
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

                {{-- TOTAL HARGA (CALCULATED) --}}
                <div class="bg-black/40 border border-gray-700 rounded-lg p-4 mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-300">Total Harga Pengiriman</span>
                        <span id="total-price-display" class="text-xl font-bold text-orange-400">Rp 0</span>
                    </div>
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">

                    {{-- Breakdown biaya --}}
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
                        Formula: Berat yang ditagih (max antara berat aktual & volumetrik) × Rp 5.000/kg + Jarak × Rp 1.500/km
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
const token = localStorage.getItem('optimove_token');
if (!token) {
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

// KONSTANTA TARIF
const TARIF_PER_KG = 5000;           // Rp 5.000 per kg
const TARIF_PER_KM = 1500;           // Rp 1.500 per km
const DIVIDER_VOLUMETRIK = 5000;     // 1 kg volumetrik = 5000 cm³

let editingId = null;
let shipmentsData = [];

// Database estimasi jarak antar kota (dalam km)
// Untuk implementasi production, bisa menggunakan API seperti Google Distance Matrix
const cityDistances = {
    'jakarta-bandung': 150,
    'jakarta-surabaya': 800,
    'jakarta-semarang': 450,
    'jakarta-yogyakarta': 520,
    'bandung-surabaya': 700,
    'bandung-semarang': 350,
    'surabaya-malang': 90,
    'surabaya-bali': 350,
    'semarang-yogyakarta': 120,
    // Tambahkan lebih banyak rute sesuai kebutuhan
};

// Fungsi estimasi jarak berdasarkan kota
function estimateDistance(cityFrom, cityTo) {
    if (!cityFrom || !cityTo) return 0;

    const from = cityFrom.toLowerCase().trim();
    const to = cityTo.toLowerCase().trim();

    // Jika kota sama
    if (from === to) return 10; // Default jarak dalam kota

    // Cek dalam database
    let key1 = `${from}-${to}`;
    let key2 = `${to}-${from}`;

    if (cityDistances[key1]) return cityDistances[key1];
    if (cityDistances[key2]) return cityDistances[key2];

    // Default fallback: estimasi kasar berdasarkan panjang nama kota (untuk demo)
    // Dalam production, gunakan API geocoding + distance calculation
    return 200; // Default 200 km jika tidak ditemukan
}

// Fungsi menghitung total harga berdasarkan dimensi, berat, dan jarak
function calculateShippingCost() {
    const weight = Number(form.weight.value) || 0;
    const length = Number(form.length_cm.value) || 0;
    const width = Number(form.width_cm.value) || 0;
    const height = Number(form.height_cm.value) || 0;

    const senderCity = form.sender_city.value || '';
    const receiverCity = form.receiver_city.value || '';

    // 1. Hitung berat volumetrik
    const volume = length * width * height;
    const volumetricWeight = volume / DIVIDER_VOLUMETRIK;

    // 2. Ambil yang lebih besar (berat aktual vs volumetrik)
    const chargeableWeight = Math.max(weight, volumetricWeight);

    // 3. Hitung biaya berat
    const costWeight = chargeableWeight * TARIF_PER_KG;

    // 4. Estimasi jarak
    const distance = estimateDistance(senderCity, receiverCity);

    // 5. Hitung biaya jarak
    const costDistance = distance * TARIF_PER_KM;

    // 6. Total biaya
    const totalCost = costWeight + costDistance;

    // Update display
    document.getElementById('total-price-display').textContent =
        'Rp ' + Math.round(totalCost).toLocaleString('id-ID');
    document.getElementById('shipping_cost').value = Math.round(totalCost);
    document.getElementById('cost-weight').textContent =
        'Rp ' + Math.round(costWeight).toLocaleString('id-ID');
    document.getElementById('cost-distance').textContent =
        'Rp ' + Math.round(costDistance).toLocaleString('id-ID');
    document.getElementById('estimated-distance').value =
        distance + ' km';

    return totalCost;
}

// Event listeners untuk perhitungan otomatis
const weightInput = form.querySelector('[name="weight"]');
const lengthInput = form.querySelector('[name="length_cm"]');
const widthInput = form.querySelector('[name="width_cm"]');
const heightInput = form.querySelector('[name="height_cm"]');
const senderCityInput = form.querySelector('[name="sender_city"]');
const receiverCityInput = form.querySelector('[name="receiver_city"]');

[weightInput, lengthInput, widthInput, heightInput, senderCityInput, receiverCityInput].forEach(input => {
    if (input) {
        input.addEventListener('input', calculateShippingCost);
        input.addEventListener('change', calculateShippingCost);
    }
});

// Toggle kolom jenis barang lainnya
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

// Generate kode pengiriman
async function generateShipmentCode() {
    try {
        shipmentCodeInput.value = 'Sedang generate...';
        const res = await fetch('/api/shipments/generate-code');

        if (!res.ok) {
            console.error('Generate code gagal:', res.status, res.statusText);
            const errorText = await res.text();
            console.error('Response:', errorText);
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

// Buka & tutup modal
async function openModal(mode, data = null) {
    editingId = data ? data.id : null;
    modalTitle.textContent = mode === 'create' ? 'Buat Pengiriman' : 'Ubah Pengiriman';
    formError.textContent = '';

    if (data) {
        // Mode edit
        form.id.value = data.id;
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

        // Hitung ulang total harga
        calculateShippingCost();

    } else {
        // Mode create
        form.reset();
        form.id.value = '';
        await generateShipmentCode();
        form.status.value = 'pending';
        form.item_type.value = 'dokumen';
        form.item_quantity.value = 1;
        form.service_type.value = 'regular';
        if (itemTypeSelect) itemTypeSelect.dispatchEvent(new Event('change'));
        calculateShippingCost();
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Load profil user
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

// Render kartu shipment
function renderShipments(list) {
    shipmentsContainer.innerHTML = '';
    shipmentsData = list;

    if (!list || !list.length) {
        emptyMsg.classList.remove('hidden');
        return;
    }
    emptyMsg.classList.add('hidden');

    list.forEach(item => {
        const div = document.createElement('div');
        div.className = 'rounded-2xl border border-gray-800 bg-gradient-to-br from-[#1a1a1a] to-[#0b0b0b] p-4 text-sm space-y-2';

        // Hitung estimasi jarak untuk display
        const distance = estimateDistance(item.sender_city, item.receiver_city);

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
                <div class="flex justify-between">
                    <span>Jarak:</span>
                    <span>~${distance} km</span>
                </div>
            </div>
            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-700">
                <span class="text-xs text-gray-400">Total Harga:</span>
                <span class="text-base font-bold text-orange-400">Rp ${Number(item.shipping_cost || 0).toLocaleString('id-ID')}</span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs px-2 py-1 rounded-full bg-orange-600/20 text-orange-300 capitalize">
                    ${item.status || 'pending'}
                </span>
            </div>
            <div class="flex gap-2 mt-3">
                <button data-id="${item.id}" class="btn-edit flex-1 rounded-full border border-gray-600 px-2 py-1 text-xs hover:bg-gray-800">
                    Edit
                </button>
                <button data-id="${item.id}" class="btn-delete flex-1 rounded-full bg-red-600 hover:bg-red-500 px-2 py-1 text-xs">
                    Hapus
                </button>
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

// Load data dari API
async function loadShipments() {
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
            console.error('Load shipments gagal:', res.status, res.statusText);
            const errorText = await res.text();
            console.error('Response:', errorText);
            renderShipments([]);
            return;
        }

        const data = await res.json();
        renderShipments(data);
    } catch (e) {
        console.error('Network error load shipments:', e);
        renderShipments([]);
    }
}

// Create / Update (form submit)
form.addEventListener('submit', async (e) => {
    e.preventDefault();
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
            console.error('Save gagal:', res.status);
            const err = await res.json().catch(() => ({}));
            formError.textContent = err.message ?? `Gagal menyimpan: ${res.status}`;
            return;
        }

        closeModal();
        await loadShipments();
    } catch (err) {
        console.error('Network error save:', err);
        formError.textContent = 'Terjadi kesalahan jaringan.';
    }
});

// Delete
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

// Logout
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

// Event open/close modal
openCreateBtn.addEventListener('click', () => openModal('create'));
closeModalBtn.addEventListener('click', closeModal);
cancelModalBtn.addEventListener('click', closeModal);

// INIT
loadMe();
loadShipments();
</script>
@endsection
