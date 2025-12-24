<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrackingHistory extends Model
{
    use HasFactory;

    protected $table = 'tracking_histories';

    // ✅ ALLOW SEMUA FIELD (untuk testing)
    protected $guarded = [];

    protected $casts = [
        'tracked_at' => 'datetime',
    ];

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

    // ✅ BOOT untuk auto UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
