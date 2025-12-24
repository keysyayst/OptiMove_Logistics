<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

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
        'weight' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'item_value' => 'decimal:2',
        'item_quantity' => 'integer',
        'use_insurance' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Mutator untuk memastikan data bersih sebelum disimpan
    public function setSenderNameAttribute($value)
    {
        $this->attributes['sender_name'] = trim(preg_replace('/\s+/', ' ', $value));
    }

    public function setReceiverNameAttribute($value)
    {
        $this->attributes['receiver_name'] = trim(preg_replace('/\s+/', ' ', $value));
    }

    public function setSenderPhoneAttribute($value)
    {
        $this->attributes['sender_phone'] = preg_replace('/[^0-9+]/', '', $value);
    }

    public function setReceiverPhoneAttribute($value)
    {
        $this->attributes['receiver_phone'] = preg_replace('/[^0-9+]/', '', $value);
    }

    // Accessor untuk format yang lebih baik
    public function getFormattedShippingCostAttribute()
    {
        return $this->shipping_cost ? 'Rp ' . number_format($this->shipping_cost, 0, ',', '.') : 'Rp 0';
    }

    public function getFormattedWeightAttribute()
    {
        return $this->weight . ' kg';
    }
}
