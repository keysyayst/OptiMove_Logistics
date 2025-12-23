<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            // alamat pengirim
            $table->string('sender_address')->nullable();
            $table->string('sender_city')->nullable();
            $table->string('sender_province')->nullable();
            $table->string('sender_postal_code')->nullable();
            $table->string('sender_phone')->nullable();

            // alamat penerima
            $table->string('receiver_address')->nullable();
            $table->string('receiver_city')->nullable();
            $table->string('receiver_province')->nullable();
            $table->string('receiver_postal_code')->nullable();
            $table->string('receiver_phone')->nullable();

            // rincian barang
            $table->string('item_type')->nullable();          // dokumen/makanan/elektronik
            $table->integer('item_quantity')->default(1);
            $table->decimal('length_cm', 8, 2)->nullable();
            $table->decimal('width_cm', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->decimal('item_value', 12, 2)->nullable(); // untuk asuransi

            // jenis layanan
            $table->enum('service_type', ['regular','express','cargo'])->default('regular');
            $table->boolean('use_insurance')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'sender_address','sender_city','sender_province','sender_postal_code','sender_phone',
                'receiver_address','receiver_city','receiver_province','receiver_postal_code','receiver_phone',
                'item_type','item_quantity','length_cm','width_cm','height_cm','item_value',
                'service_type','use_insurance',
            ]);
        });
    }
};
