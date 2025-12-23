<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_code',
        'sender_name',
        'receiver_name',
        'sender_address',
        'sender_city',
        'sender_province',
        'sender_postal_code',
        'sender_phone',
        'receiver_address',
        'receiver_city',
        'receiver_province',
        'receiver_postal_code',
        'receiver_phone',
        'status',
        'weight',
        'shipping_cost',
        'item_type',
        'item_quantity',
        'length_cm',
        'width_cm',
        'height_cm',
        'service_type',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'item_quantity' => 'integer',
    ];
}
