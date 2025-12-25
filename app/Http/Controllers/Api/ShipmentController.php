<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * Validasi manual untuk nama (hanya huruf dan spasi)
     */
    private function validateName($name, $fieldName)
    {
        if (empty($name)) {
            return "$fieldName wajib diisi";
        }

        if (strlen($name) < 3) {
            return "$fieldName minimal 3 karakter";
        }

        if (strlen($name) > 100) {
            return "$fieldName maksimal 100 karakter";
        }

        if (!ctype_alpha(str_replace([' ', '.'], '', $name))) {
            return "$fieldName hanya boleh berisi huruf dan spasi";
        }

        return null;
    }

    /**
     * Validasi manual untuk kode pos (5 digit)
     */
    private function validatePostalCode($code, $fieldName)
    {
        if (empty($code)) {
            return "$fieldName wajib diisi";
        }

        if (!ctype_digit($code) || strlen($code) != 5) {
            return "$fieldName harus 5 digit angka";
        }

        return null;
    }

    /**
     * Validasi manual untuk nomor telepon Indonesia
     */
    private function validatePhone($phone, $fieldName)
    {
        if (empty($phone)) {
            return "$fieldName wajib diisi";
        }

        $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);

        if (!preg_match('/^(\+62|62|0)[0-9]{9,12}$/', $cleanPhone)) {
            return "$fieldName tidak valid (contoh: 08123456789)";
        }

        return null;
    }

    /**
     * Create new shipment
     */
    public function store(Request $request)
    {
        // ✅ GUNAKAN DB TRANSACTION untuk memastikan shipment & tracking dibuat bersamaan
        DB::beginTransaction();

        try {
            logger()->info("========== STORE SHIPMENT START ==========");
            logger()->info("Request: " . json_encode($request->all()));

            // Validasi dasar Laravel
            $basicValidator = Validator::make($request->all(), [
                'sender_name' => 'required|string|min:3|max:100',
                'sender_address' => 'required|string|min:10|max:500',
                'sender_city' => 'required|string|min:3|max:100',
                'sender_province' => 'required|string|min:3|max:100',
                'sender_postal_code' => 'required|string|size:5',
                'sender_phone' => 'required|string',

                'receiver_name' => 'required|string|min:3|max:100',
                'receiver_address' => 'required|string|min:10|max:500',
                'receiver_city' => 'required|string|min:3|max:100',
                'receiver_province' => 'required|string|min:3|max:100',
                'receiver_postal_code' => 'required|string|size:5',
                'receiver_phone' => 'required|string',

                'weight' => 'required|numeric|min:0.01|max:999999.99',
                'item_type' => 'required|string|min:3|max:100',
                'item_quantity' => 'required|integer|min:1|max:10000',
                'length_cm' => 'nullable|numeric|min:0|max:99999.99',
                'width_cm' => 'nullable|numeric|min:0|max:99999.99',
                'height_cm' => 'nullable|numeric|min:0|max:99999.99',
                'item_value' => 'nullable|numeric|min:0|max:9999999999.99',

                'service_type' => 'required|in:regular,express,cargo',
                'shipping_cost' => 'nullable|numeric|min:0|max:99999999.99',
                'status' => 'nullable|in:pending,picked_up,in_transit,arrived_at_hub,out_for_delivery,delivered',
            ]);

            if ($basicValidator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $basicValidator->errors()
                ], 422);
            }

            // Validasi manual tambahan
            $errors = [];

            if ($error = $this->validateName($request->sender_name, 'Nama pengirim')) {
                $errors['sender_name'] = [$error];
            }

            if ($error = $this->validateName($request->receiver_name, 'Nama penerima')) {
                $errors['receiver_name'] = [$error];
            }

            if ($error = $this->validatePostalCode($request->sender_postal_code, 'Kode pos pengirim')) {
                $errors['sender_postal_code'] = [$error];
            }

            if ($error = $this->validatePostalCode($request->receiver_postal_code, 'Kode pos penerima')) {
                $errors['receiver_postal_code'] = [$error];
            }

            if ($error = $this->validatePhone($request->sender_phone, 'Nomor telepon pengirim')) {
                $errors['sender_phone'] = [$error];
            }

            if ($error = $this->validatePhone($request->receiver_phone, 'Nomor telepon penerima')) {
                $errors['receiver_phone'] = [$error];
            }

            if (!empty($errors)) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $errors
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

            // Siapkan data
            $data = $basicValidator->validated();
            $data['shipment_code'] = $shipmentCode;
            $data['status'] = $data['status'] ?? 'pending';
            $data['service_type'] = $data['service_type'] ?? 'regular';
            $data['item_quantity'] = $data['item_quantity'] ?? 1;

            // Bersihkan data
            $data['sender_name'] = trim(preg_replace('/\s+/', ' ', $data['sender_name']));
            $data['receiver_name'] = trim(preg_replace('/\s+/', ' ', $data['receiver_name']));
            $data['sender_phone'] = preg_replace('/[^0-9+]/', '', $data['sender_phone']);
            $data['receiver_phone'] = preg_replace('/[^0-9+]/', '', $data['receiver_phone']);

            logger()->info("Creating shipment: {$shipmentCode}");

            // Create shipment
            $shipment = Shipment::create($data);

            logger()->info("✅ Shipment created! ID: {$shipment->id}");
            logger()->info("Creating tracking history...");

            // ✅ AUTO CREATE TRACKING HISTORY
            $trackingData = [
                'shipment_id' => $shipment->id,
                'status' => $data['status'],
                'location' => $data['sender_city'] . ', ' . $data['sender_province'],
                'description' => 'Paket telah dibuat dan menunggu untuk diproses',
                'updated_by' => 1,
                'tracked_at' => now(),
            ];

            logger()->info("Tracking data: " . json_encode($trackingData));

            $tracking = TrackingHistory::create($trackingData);

            logger()->info("✅ Tracking created! ID: {$tracking->id}");
            logger()->info("========== STORE SHIPMENT END ==========");

            // ✅ COMMIT TRANSACTION
            DB::commit();

            return response()->json([
                'message' => 'Pengiriman berhasil dibuat',
                'data' => $shipment
            ], 201);

        } catch (\Exception $e) {
            // ✅ ROLLBACK jika ada error
            DB::rollBack();

            logger()->error('❌ STORE SHIPMENT FAILED!');
            logger()->error('Error: ' . $e->getMessage());
            logger()->error('File: ' . $e->getFile() . ':' . $e->getLine());
            logger()->error('Trace: ' . $e->getTraceAsString());

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
        DB::beginTransaction();

        try {
            logger()->info("========== UPDATE SHIPMENT START ==========");
            logger()->info("Shipment ID: {$id}");

            // ✅ AMBIL SHIPMENT & OLD STATUS DULU
            $shipment = Shipment::findOrFail($id);
            $oldStatus = $shipment->status;

            logger()->info("Old status: {$oldStatus}");
            logger()->info("Request: " . json_encode($request->all()));

            // Validasi dasar Laravel
            $basicValidator = Validator::make($request->all(), [
                'sender_name' => 'sometimes|string|min:3|max:100',
                'sender_address' => 'sometimes|string|min:10|max:500',
                'sender_city' => 'sometimes|string|min:3|max:100',
                'sender_province' => 'sometimes|string|min:3|max:100',
                'sender_postal_code' => 'sometimes|string|size:5',
                'sender_phone' => 'sometimes|string',

                'receiver_name' => 'sometimes|string|min:3|max:100',
                'receiver_address' => 'sometimes|string|min:10|max:500',
                'receiver_city' => 'sometimes|string|min:3|max:100',
                'receiver_province' => 'sometimes|string|min:3|max:100',
                'receiver_postal_code' => 'sometimes|string|size:5',
                'receiver_phone' => 'sometimes|string',

                'weight' => 'sometimes|numeric|min:0.01|max:999999.99',
                'item_type' => 'sometimes|string|min:3|max:100',
                'item_quantity' => 'sometimes|integer|min:1|max:10000',
                'length_cm' => 'sometimes|nullable|numeric|min:0|max:99999.99',
                'width_cm' => 'sometimes|nullable|numeric|min:0|max:99999.99',
                'height_cm' => 'sometimes|nullable|numeric|min:0|max:99999.99',
                'item_value' => 'sometimes|nullable|numeric|min:0|max:9999999999.99',
                'service_type' => 'sometimes|in:regular,express,cargo',
                'shipping_cost' => 'sometimes|numeric|min:0|max:99999999.99',
                'status' => 'sometimes|in:pending,picked_up,in_transit,arrived_at_hub,out_for_delivery,delivered',
            ]);

            if ($basicValidator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $basicValidator->errors()
                ], 422);
            }

            // Validasi manual tambahan
            $errors = [];

            if ($request->has('sender_name')) {
                if ($error = $this->validateName($request->sender_name, 'Nama pengirim')) {
                    $errors['sender_name'] = [$error];
                }
            }

            if ($request->has('receiver_name')) {
                if ($error = $this->validateName($request->receiver_name, 'Nama penerima')) {
                    $errors['receiver_name'] = [$error];
                }
            }

            if ($request->has('sender_postal_code')) {
                if ($error = $this->validatePostalCode($request->sender_postal_code, 'Kode pos pengirim')) {
                    $errors['sender_postal_code'] = [$error];
                }
            }

            if ($request->has('receiver_postal_code')) {
                if ($error = $this->validatePostalCode($request->receiver_postal_code, 'Kode pos penerima')) {
                    $errors['receiver_postal_code'] = [$error];
                }
            }

            if ($request->has('sender_phone')) {
                if ($error = $this->validatePhone($request->sender_phone, 'Nomor telepon pengirim')) {
                    $errors['sender_phone'] = [$error];
                }
            }

            if ($request->has('receiver_phone')) {
                if ($error = $this->validatePhone($request->receiver_phone, 'Nomor telepon penerima')) {
                    $errors['receiver_phone'] = [$error];
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $errors
                ], 422);
            }

            $data = $basicValidator->validated();

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

            logger()->info("Updating shipment...");
            $shipment->update($data);
            logger()->info("✅ Shipment updated!");

            $newStatus = $data['status'] ?? $oldStatus;
            logger()->info("New status: {$newStatus}");

            // ✅ AUTO CREATE TRACKING HISTORY jika status berubah
            if (isset($data['status']) && $oldStatus !== $data['status']) {
                logger()->info("Status changed! Creating tracking history...");

                $statusMessages = [
                    'pending' => 'Paket menunggu untuk diambil',
                    'picked_up' => 'Paket telah diambil kurir dari lokasi pengirim',
                    'in_transit' => 'Paket sedang dalam perjalanan menuju tujuan',
                    'arrived_at_hub' => 'Paket tiba di hub sortir untuk diproses',
                    'out_for_delivery' => 'Paket sedang dalam perjalanan menuju alamat penerima',
                    'delivered' => 'Paket telah sampai dan diterima oleh penerima',
                ];

                $trackingData = [
                    'shipment_id' => $shipment->id,
                    'status' => $data['status'],
                    'location' => $shipment->receiver_city . ', ' . $shipment->receiver_province,
                    'description' => $statusMessages[$data['status']] ?? 'Status pengiriman diperbarui',
                    'updated_by' => 1,
                    'tracked_at' => now(),
                ];

                logger()->info("Tracking data: " . json_encode($trackingData));

                $tracking = TrackingHistory::create($trackingData);

                logger()->info("✅ Tracking created! ID: {$tracking->id}");
            } else {
                logger()->info("⚠️ Status unchanged - no tracking created");
            }

            logger()->info("========== UPDATE SHIPMENT END ==========");

            // ✅ COMMIT TRANSACTION
            DB::commit();

            return response()->json([
                'message' => 'Pengiriman berhasil diupdate',
                'data' => $shipment
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            logger()->error('❌ UPDATE SHIPMENT FAILED!');
            logger()->error('Error: ' . $e->getMessage());
            logger()->error('File: ' . $e->getFile() . ':' . $e->getLine());
            logger()->error('Trace: ' . $e->getTraceAsString());

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
