<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('tc', 11);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->string('birth_date')->nullable();
            $table->date('registration_date')->nullable();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->text('medical_condition')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->boolean('is_active')->default(false);

            // Rezervasyon durumu
            $table->enum('status', ['beklemede', 'onaylandı', 'reddedildi'])->default('beklemede');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
