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
        Schema::create('room_change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // öğrencinin ID'si
            $table->unsignedBigInteger('current_room_id'); // mevcut oda
            $table->unsignedBigInteger('requested_room_id'); // talep edilen oda
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('admin_message')->nullable(); // reddedilme nedeni
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('current_room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('requested_room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_change_requests');
    }
};
