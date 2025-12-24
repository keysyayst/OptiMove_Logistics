<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function getByShipmentUuid($uuid)
    {
        try {
            $shipment = Shipment::where('uuid', $uuid)
                ->with(['trackingHistories.updater'])
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'shipment' => [
                    'uuid' => $shipment->uuid,
                    'shipment_code' => $shipment->shipment_code,
                    'status' => $shipment->status,
                    'status_label' => $shipment->status_label,
                    'sender_name' => $shipment->sender_name,
                    'sender_city' => $shipment->sender_city,
                    'receiver_name' => $shipment->receiver_name,
                    'receiver_city' => $shipment->receiver_city,
                    'weight' => $shipment->weight,
                    'service_type' => $shipment->service_type,
                ],
                'tracking_histories' => $shipment->trackingHistories->map(function($history) {
                    return [
                        'uuid' => $history->uuid,
                        'status' => $history->status,
                        'status_label' => $history->status_label,
                        'location' => $history->location,
                        'description' => $history->description,
                        'latitude' => $history->latitude,
                        'longitude' => $history->longitude,
                        'tracked_at' => $history->tracked_at->format('Y-m-d H:i:s'),
                        'tracked_at_formatted' => $history->tracked_at->format('d M Y, H:i'),
                        'updated_by' => $history->updater ? $history->updater->name : null,
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Shipment tidak ditemukan'
            ], 404);
        }
    }

    public function getByShipmentCode($code)
    {
        try {
            $shipment = Shipment::where('shipment_code', $code)
                ->with(['trackingHistories.updater'])
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'shipment' => [
                    'uuid' => $shipment->uuid,
                    'shipment_code' => $shipment->shipment_code,
                    'status' => $shipment->status,
                    'status_label' => $shipment->status_label,
                    'sender_name' => $shipment->sender_name,
                    'sender_city' => $shipment->sender_city,
                    'receiver_name' => $shipment->receiver_name,
                    'receiver_city' => $shipment->receiver_city,
                    'weight' => $shipment->weight,
                    'service_type' => $shipment->service_type,
                ],
                'tracking_histories' => $shipment->trackingHistories->map(function($history) {
                    return [
                        'uuid' => $history->uuid,
                        'status' => $history->status,
                        'status_label' => $history->status_label,
                        'location' => $history->location,
                        'description' => $history->description,
                        'latitude' => $history->latitude,
                        'longitude' => $history->longitude,
                        'tracked_at' => $history->tracked_at->format('Y-m-d H:i:s'),
                        'tracked_at_formatted' => $history->tracked_at->format('d M Y, H:i'),
                        'updated_by' => $history->updater ? $history->updater->name : null,
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Shipment tidak ditemukan'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shipment_uuid' => 'required|string|exists:shipments,uuid',
                'status' => 'required|in:pending,picked_up,in_transit,arrived_at_hub,out_for_delivery,delivered',
                'location' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:10|max:1000',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'tracked_at' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $shipment = Shipment::where('uuid', $request->shipment_uuid)->firstOrFail();

            $tracking = TrackingHistory::create([
                'shipment_id' => $shipment->id,
                'status' => $request->status,
                'location' => $request->location,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'updated_by' => Auth::id(),
                'tracked_at' => $request->tracked_at ?? now(),
            ]);

            $shipment->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Tracking berhasil ditambahkan',
                'data' => $tracking
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tracking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $uuid)
    {
        try {
            $tracking = TrackingHistory::where('uuid', $uuid)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'status' => 'sometimes|in:pending,picked_up,in_transit,arrived_at_hub,out_for_delivery,delivered',
                'location' => 'sometimes|string|min:3|max:255',
                'description' => 'sometimes|string|min:10|max:1000',
                'latitude' => 'sometimes|nullable|numeric|between:-90,90',
                'longitude' => 'sometimes|nullable|numeric|between:-180,180',
                'tracked_at' => 'sometimes|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tracking->update($validator->validated());

            if ($request->has('status')) {
                $tracking->shipment->update(['status' => $request->status]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tracking berhasil diupdate',
                'data' => $tracking
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($uuid)
    {
        try {
            $tracking = TrackingHistory::where('uuid', $uuid)->firstOrFail();
            $tracking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tracking berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking tidak ditemukan'
            ], 404);
        }
    }
}
