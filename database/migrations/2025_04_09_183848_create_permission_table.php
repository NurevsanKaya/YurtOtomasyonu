<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // İlgili öğrenci ID'si
            $table->text('description')->nullable(); // Açıklama
            $table->date('start_date'); // İzin başlangıç tarihi
            $table->date('end_date'); // İzin bitiş tarihi
            $table->string('phone_number', 20); // Telefon numarası
            $table->string('destination_address'); // Gitmek istediği adres
            $table->timestamps();

            // Yabancı anahtar tanımı
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
