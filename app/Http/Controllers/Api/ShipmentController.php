<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    // GET /api/shipments
    public function index()
    {
        return response()->json(Shipment::latest()->get());
    }

    // POST /api/shipments
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name'   => 'required',
            'receiver_name' => 'required',
            'origin'        => 'required',
            'destination'   => 'required',
            'status'        => 'required',
            'weight'        => 'required|numeric',
            'shipping_cost' => 'required|numeric',
        ]);

        // generate kode otomatis
        $validated['shipment_code'] = Shipment::generateCode();

        $shipment = Shipment::create($validated);

        return response()->json($shipment, 201);
    }

    // GET /api/shipments/{shipment}
    public function show(Shipment $shipment)
    {
        return response()->json($shipment);
    }

    // PUT/PATCH /api/shipments/{shipment}
    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'sender_name'   => 'required',
            'receiver_name' => 'required',
            'origin'        => 'required',
            'destination'   => 'required',
            'status'        => 'required',
            'weight'        => 'required|numeric',
            'shipping_cost' => 'required|numeric',
        ]);

        $shipment->update($validated);

        return response()->json($shipment);
    }

    // DELETE /api/shipments/{shipment}
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return response()->json([
            'message' => 'Shipment deleted',
            'id'      => $shipment->id,
        ]);
    }
}
