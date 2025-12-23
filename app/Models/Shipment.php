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
    'origin',
    'destination',
    'status',
    'weight',
    'shipping_cost',

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
    'item_type',
    'item_quantity',
    'length_cm',
    'width_cm',
    'height_cm',
    'item_value',
    'service_type',
    'use_insurance',
];


    public static function generateCode(): string
    {
        $last = self::latest('id')->first();
        $number = $last ? $last->id + 1 : 1;

        return 'OPT-' . now()->format('ymd') . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
