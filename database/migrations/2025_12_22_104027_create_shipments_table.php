<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel packages
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('weight', 8, 2);
            $table->integer('stock')->default(1);
            $table->timestamps();
        });

        // Tabel shipments (lengkap)
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_code')->unique();
            $table->enum('status', ['pending', 'shipping', 'delivered'])->default('pending');
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('weight', 8, 2)->default(0);

            // Data pengirim
            $table->string('sender_name');
            $table->string('sender_address')->nullable();
            $table->string('sender_city')->nullable();
            $table->string('sender_province')->nullable();
            $table->string('sender_postal_code')->nullable();
            $table->string('sender_phone')->nullable();

            // Data penerima
            $table->string('receiver_name');
            $table->string('receiver_address')->nullable();
            $table->string('receiver_city')->nullable();
            $table->string('receiver_province')->nullable();
            $table->string('receiver_postal_code')->nullable();
            $table->string('receiver_phone')->nullable();

            // Rincian barang
            $table->string('item_type')->nullable();
            $table->integer('item_quantity')->default(1);
            $table->decimal('length_cm', 8, 2)->nullable();
            $table->decimal('width_cm', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->decimal('item_value', 12, 2)->nullable();

            // Jenis layanan
            $table->enum('service_type', ['regular', 'express', 'cargo'])->default('regular');
            $table->tinyInteger('use_insurance')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('packages');
    }
};
