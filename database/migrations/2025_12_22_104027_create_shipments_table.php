<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('shipments', function (Blueprint $table) {
        $table->id();
        $table->string('shipment_code')->unique(); // identifier unik (bisa UUID/slug)
        $table->string('customer_name');
        $table->string('origin');
        $table->string('destination');
        $table->enum('status', ['pending', 'shipping', 'delivered'])->default('pending');
        $table->decimal('shipping_cost', 10, 2);
        $table->timestamps();
    });

    }
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
