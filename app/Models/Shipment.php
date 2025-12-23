<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_code',
        'status',
        'shipping_cost',
        'weight',
        'sender_name',
        'sender_address',
        'sender_city',
        'sender_province',
        'sender_postal_code',
        'sender_phone',
        'receiver_name',
        'receiver_address',
        'receiver_city',
        'receiver_province',
        'receiver_postal_code',
        'receiver_phone',
        'item_type',
        'item_quantity',
        'length_cm',
        'width_cm',
        'height_cm',
        'item_value',
        'service_type',
        'use_insurance',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'weight' => 'decimal:2',
        'item_value' => 'decimal:2',
        'use_insurance' => 'boolean',
    ];
}
