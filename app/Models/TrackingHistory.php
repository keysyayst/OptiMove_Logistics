<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TrackingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'shipment_id',
        'status',
        'location',
        'description',
        'latitude',
        'longitude',
        'updated_by',
        'tracked_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'tracked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->tracked_at)) {
                $model->tracked_at = now();
            }
        });
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Pickup',
            'picked_up' => 'Sudah Diambil',
            'in_transit' => 'Dalam Perjalanan',
            'arrived_at_hub' => 'Tiba di Hub',
            'out_for_delivery' => 'Siap Diantar',
            'delivered' => 'Terkirim'
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
