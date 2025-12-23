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
            // Validate HANYA field yang dikirim dari form
            $validator = Validator::make($request->all(), [
                'sender_name' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:255',
                'sender_address' => 'required|string',
                'sender_city' => 'required|string',
                'sender_province' => 'required|string',
                'sender_postal_code' => 'required|string',
                'sender_phone' => 'required|string',
                'receiver_address' => 'required|string',
                'receiver_city' => 'required|string',
                'receiver_province' => 'required|string',
                'receiver_postal_code' => 'required|string',
                'receiver_phone' => 'required|string',
                'weight' => 'required|numeric|min:0',
                'status' => 'required|in:pending,shipping,delivered',
                'item_type' => 'required|string',
                'item_quantity' => 'required|integer|min:1',
                'service_type' => 'required|in:regular,express,cargo',
                'shipping_cost' => 'required|numeric|min:0',
                'length_cm' => 'nullable|numeric|min:0',
                'width_cm' => 'nullable|numeric|min:0',
                'height_cm' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                logger()->error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generate kode
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

            // Buat data shipment - HANYA field yang valid
            $data = [
                'shipment_code' => $shipmentCode,
                'sender_name' => $request->sender_name,
                'receiver_name' => $request->receiver_name,
                'sender_address' => $request->sender_address,
                'sender_city' => $request->sender_city,
                'sender_province' => $request->sender_province,
                'sender_postal_code' => $request->sender_postal_code,
                'sender_phone' => $request->sender_phone,
                'receiver_address' => $request->receiver_address,
                'receiver_city' => $request->receiver_city,
                'receiver_province' => $request->receiver_province,
                'receiver_postal_code' => $request->receiver_postal_code,
                'receiver_phone' => $request->receiver_phone,
                'weight' => $request->weight,
                'status' => $request->status,
                'item_type' => $request->item_type,
                'item_quantity' => $request->item_quantity,
                'service_type' => $request->service_type,
                'shipping_cost' => $request->shipping_cost,
                'length_cm' => $request->length_cm,
                'width_cm' => $request->width_cm,
                'height_cm' => $request->height_cm,
            ];

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
            'weight' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,shipping,delivered',
            'shipping_cost' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $shipment = Shipment::findOrFail($id);
            $shipment->update($request->all());

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
                'message' => 'Gagal menghapus pengiriman'
            ], 500);
        }
    }
}
