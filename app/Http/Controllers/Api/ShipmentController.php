<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    /**
     * Generate kode pengiriman unik
     */
    public function generateCode()
    {
        $date = date('Ymd');

        $lastShipment = Shipment::where('shipment_code', 'LIKE', "SHIP-{$date}-%")
                                ->orderBy('shipment_code', 'desc')
                                ->first();

        if ($lastShipment) {
            $lastNumber = (int) substr($lastShipment->shipment_code, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $code = "SHIP-{$date}-{$newNumber}";

        return response()->json(['code' => $code], 200);
    }

    /**
     * Get all shipments
     */
    public function index()
    {
        try {
            $shipments = Shipment::orderBy('created_at', 'desc')->get();
            return response()->json($shipments, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new shipment
     */
    public function store(Request $request)
    {
        try {
            // VALIDASI YANG DIPERBAIKI - lebih ketat
            $validator = Validator::make($request->all(), [
                // Data Pengirim - REQUIRED dengan format ketat
                'sender_name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[a-zA-Z\s.]+$/' // hanya huruf, spasi, dan titik
                ],
                'sender_address' => 'required|string|min:10|max:500',
                'sender_city' => 'required|string|min:3|max:100',
                'sender_province' => 'required|string|min:3|max:100',
                'sender_postal_code' => 'required|string|regex:/^[0-9]{5}$/',
                'sender_phone' => [
                    'required',
                    'string',
                    'regex:/^(\+62|62|0)[0-9]{9,12}$/'
                ],

                // Data Penerima - REQUIRED dengan format ketat
                'receiver_name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[a-zA-Z\s.]+$/'
                ],
                'receiver_address' => 'required|string|min:10|max:500',
                'receiver_city' => 'required|string|min:3|max:100',
                'receiver_province' => 'required|string|min:3|max:100',
                'receiver_postal_code' => 'required|string|regex:/^[0-9]{5}$/',
                'receiver_phone' => [
                    'required',
                    'string',
                    'regex:/^(\+62|62|0)[0-9]{9,12}$/'
                ],

                // Rincian Barang
                'weight' => 'required|numeric|min:0.01|max:999999.99',
                'item_type' => 'required|string|min:3|max:100',
                'item_quantity' => 'required|integer|min:1|max:10000',
                'length_cm' => 'nullable|numeric|min:0|max:99999.99',
                'width_cm' => 'nullable|numeric|min:0|max:99999.99',
                'height_cm' => 'nullable|numeric|min:0|max:99999.99',
                'item_value' => 'nullable|numeric|min:0|max:9999999999.99',

                // Jenis Layanan
                'service_type' => 'required|in:regular,express,cargo',
                'use_insurance' => 'nullable|boolean',
                'shipping_cost' => 'nullable|numeric|min:0|max:99999999.99',
                'status' => 'nullable|in:pending,shipping,delivered',
            ], [
                // Pesan error custom
                'sender_name.required' => 'Nama pengirim wajib diisi',
                'sender_name.min' => 'Nama pengirim minimal 3 karakter',
                'sender_name.max' => 'Nama pengirim maksimal 100 karakter',
                'sender_name.regex' => 'Nama pengirim hanya boleh berisi huruf dan spasi',

                'sender_address.required' => 'Alamat pengirim wajib diisi',
                'sender_address.min' => 'Alamat pengirim minimal 10 karakter',

                'sender_city.required' => 'Kota pengirim wajib diisi',
                'sender_province.required' => 'Provinsi pengirim wajib diisi',

                'sender_postal_code.required' => 'Kode pos pengirim wajib diisi',
                'sender_postal_code.regex' => 'Kode pos harus 5 digit angka',

                'sender_phone.required' => 'Nomor telepon pengirim wajib diisi',
                'sender_phone.regex' => 'Format nomor telepon tidak valid (contoh: 08123456789)',

                'receiver_name.required' => 'Nama penerima wajib diisi',
                'receiver_name.regex' => 'Nama penerima hanya boleh berisi huruf dan spasi',

                'receiver_address.required' => 'Alamat penerima wajib diisi',
                'receiver_address.min' => 'Alamat penerima minimal 10 karakter',

                'receiver_city.required' => 'Kota penerima wajib diisi',
                'receiver_province.required' => 'Provinsi penerima wajib diisi',

                'receiver_postal_code.required' => 'Kode pos penerima wajib diisi',
                'receiver_postal_code.regex' => 'Kode pos harus 5 digit angka',

                'receiver_phone.required' => 'Nomor telepon penerima wajib diisi',
                'receiver_phone.regex' => 'Format nomor telepon tidak valid',

                'weight.required' => 'Berat barang wajib diisi',
                'weight.min' => 'Berat barang minimal 0.01 kg',

                'item_type.required' => 'Jenis barang wajib diisi',
                'item_quantity.required' => 'Jumlah barang wajib diisi',

                'service_type.required' => 'Jenis layanan wajib dipilih',
                'service_type.in' => 'Jenis layanan tidak valid',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generate kode pengiriman
            $date = date('Ymd');
            $lastShipment = Shipment::where('shipment_code', 'LIKE', "SHIP-{$date}-%")
                                    ->orderBy('shipment_code', 'desc')
                                    ->first();

            if ($lastShipment) {
                $lastNumber = (int) substr($lastShipment->shipment_code, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $shipmentCode = "SHIP-{$date}-{$newNumber}";

            // Ambil data yang sudah tervalidasi
            $data = $validator->validated();
            $data['shipment_code'] = $shipmentCode;
            $data['status'] = $data['status'] ?? 'pending';
            $data['service_type'] = $data['service_type'] ?? 'regular';
            $data['item_quantity'] = $data['item_quantity'] ?? 1;
            $data['use_insurance'] = $data['use_insurance'] ?? 0;

            // BERSIHKAN DATA sebelum disimpan
            // Bersihkan nama (hapus karakter aneh)
            $data['sender_name'] = trim(preg_replace('/\s+/', ' ', $data['sender_name']));
            $data['receiver_name'] = trim(preg_replace('/\s+/', ' ', $data['receiver_name']));

            // Bersihkan nomor telepon (hapus karakter non-digit kecuali +)
            $data['sender_phone'] = preg_replace('/[^0-9+]/', '', $data['sender_phone']);
            $data['receiver_phone'] = preg_replace('/[^0-9+]/', '', $data['receiver_phone']);

            // Pastikan format angka benar
            $data['weight'] = (float) $data['weight'];
            $data['shipping_cost'] = isset($data['shipping_cost']) ? (float) $data['shipping_cost'] : null;

            // Create shipment
            $shipment = Shipment::create($data);

            return response()->json([
                'message' => 'Pengiriman berhasil dibuat',
                'data' => $shipment
            ], 201);

        } catch (\Exception $e) {
            logger()->error('Error create shipment: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal membuat pengiriman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single shipment
     */
    public function show($id)
    {
        try {
            $shipment = Shipment::findOrFail($id);
            return response()->json($shipment, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update shipment
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sender_name' => [
                'sometimes',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z\s.]+$/'
            ],
            'receiver_name' => [
                'sometimes',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z\s.]+$/'
            ],
            'sender_address' => 'sometimes|string|min:10|max:500',
            'sender_city' => 'sometimes|string|min:3|max:100',
            'sender_province' => 'sometimes|string|min:3|max:100',
            'sender_postal_code' => 'sometimes|string|regex:/^[0-9]{5}$/',
            'sender_phone' => 'sometimes|string|regex:/^(\+62|62|0)[0-9]{9,12}$/',
            'receiver_address' => 'sometimes|string|min:10|max:500',
            'receiver_city' => 'sometimes|string|min:3|max:100',
            'receiver_province' => 'sometimes|string|min:3|max:100',
            'receiver_postal_code' => 'sometimes|string|regex:/^[0-9]{5}$/',
            'receiver_phone' => 'sometimes|string|regex:/^(\+62|62|0)[0-9]{9,12}$/',
            'weight' => 'sometimes|numeric|min:0.01|max:999999.99',
            'status' => 'sometimes|in:pending,shipping,delivered',
            'shipping_cost' => 'sometimes|numeric|min:0|max:99999999.99',
            'item_type' => 'sometimes|string|min:3|max:100',
            'item_quantity' => 'sometimes|integer|min:1|max:10000',
            'service_type' => 'sometimes|in:regular,express,cargo',
            'length_cm' => 'sometimes|nullable|numeric|min:0|max:99999.99',
            'width_cm' => 'sometimes|nullable|numeric|min:0|max:99999.99',
            'height_cm' => 'sometimes|nullable|numeric|min:0|max:99999.99',
            'item_value' => 'sometimes|nullable|numeric|min:0|max:9999999999.99',
            'use_insurance' => 'sometimes|boolean',
        ], [
            'sender_name.regex' => 'Nama pengirim hanya boleh berisi huruf dan spasi',
            'receiver_name.regex' => 'Nama penerima hanya boleh berisi huruf dan spasi',
            'sender_postal_code.regex' => 'Kode pos harus 5 digit angka',
            'receiver_postal_code.regex' => 'Kode pos harus 5 digit angka',
            'sender_phone.regex' => 'Format nomor telepon tidak valid',
            'receiver_phone.regex' => 'Format nomor telepon tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $shipment = Shipment::findOrFail($id);

            $data = $validator->validated();

            // Bersihkan data jika ada
            if (isset($data['sender_name'])) {
                $data['sender_name'] = trim(preg_replace('/\s+/', ' ', $data['sender_name']));
            }
            if (isset($data['receiver_name'])) {
                $data['receiver_name'] = trim(preg_replace('/\s+/', ' ', $data['receiver_name']));
            }
            if (isset($data['sender_phone'])) {
                $data['sender_phone'] = preg_replace('/[^0-9+]/', '', $data['sender_phone']);
            }
            if (isset($data['receiver_phone'])) {
                $data['receiver_phone'] = preg_replace('/[^0-9+]/', '', $data['receiver_phone']);
            }

            $shipment->update($data);

            return response()->json([
                'message' => 'Pengiriman berhasil diupdate',
                'data' => $shipment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate pengiriman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete shipment
     */
    public function destroy($id)
    {
        try {
            $shipment = Shipment::findOrFail($id);
            $shipment->delete();

            return response()->json([
                'message' => 'Pengiriman berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus pengiriman',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
