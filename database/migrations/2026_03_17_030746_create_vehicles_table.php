<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number', 20)->unique();
            $table->string('name', 100);
            $table->enum('type', ['passenger', 'cargo']);
            $table->enum('ownership', ['owned', 'rented']);
            $table->integer('capacity');
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->string('fuel_type', 20);
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};