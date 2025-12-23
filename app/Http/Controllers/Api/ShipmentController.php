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
            // Validate field yang dikirim dari form
            $validator = Validator::make($request->all(), [
                'sender_name' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:255',
                'sender_address' => 'nullable|string',
                'sender_city' => 'nullable|string',
                'sender_province' => 'nullable|string',
                'sender_postal_code' => 'nullable|string',
                'sender_phone' => 'nullable|string',
                'receiver_address' => 'nullable|string',
                'receiver_city' => 'nullable|string',
                'receiver_province' => 'nullable|string',
                'receiver_postal_code' => 'nullable|string',
                'receiver_phone' => 'nullable|string',
                'weight' => 'required|numeric|min:0',
                'status' => 'nullable|in:pending,shipping,delivered',
                'item_type' => 'nullable|string',
                'item_quantity' => 'nullable|integer|min:1',
                'service_type' => 'nullable|in:regular,express,cargo',
                'shipping_cost' => 'nullable|numeric|min:0',
                'length_cm' => 'nullable|numeric|min:0',
                'width_cm' => 'nullable|numeric|min:0',
                'height_cm' => 'nullable|numeric|min:0',
                'item_value' => 'nullable|numeric|min:0',
                'use_insurance' => 'nullable|boolean',
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

            // Buat data shipment
            $data = $validator->validated();
            $data['shipment_code'] = $shipmentCode;
            $data['status'] = $data['status'] ?? 'pending';
            $data['service_type'] = $data['service_type'] ?? 'regular';
            $data['item_quantity'] = $data['item_quantity'] ?? 1;
            $data['use_insurance'] = $data['use_insurance'] ?? 0;

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
            'sender_name' => 'sometimes|string|max:255',
            'receiver_name' => 'sometimes|string|max:255',
            'sender_address' => 'sometimes|nullable|string',
            'sender_city' => 'sometimes|nullable|string',
            'sender_province' => 'sometimes|nullable|string',
            'sender_postal_code' => 'sometimes|nullable|string',
            'sender_phone' => 'sometimes|nullable|string',
            'receiver_address' => 'sometimes|nullable|string',
            'receiver_city' => 'sometimes|nullable|string',
            'receiver_province' => 'sometimes|nullable|string',
            'receiver_postal_code' => 'sometimes|nullable|string',
            'receiver_phone' => 'sometimes|nullable|string',
            'weight' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,shipping,delivered',
            'shipping_cost' => 'sometimes|numeric|min:0',
            'item_type' => 'sometimes|nullable|string',
            'item_quantity' => 'sometimes|integer|min:1',
            'service_type' => 'sometimes|in:regular,express,cargo',
            'length_cm' => 'sometimes|nullable|numeric|min:0',
            'width_cm' => 'sometimes|nullable|numeric|min:0',
            'height_cm' => 'sometimes|nullable|numeric|min:0',
            'item_value' => 'sometimes|nullable|numeric|min:0',
            'use_insurance' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $shipment = Shipment::findOrFail($id);
            $shipment->update($validator->validated());

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
