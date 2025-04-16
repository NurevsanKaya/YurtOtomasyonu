<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // öğrenciyi bağlıyoruz
            $table->string('description');         // örneğin: "Nisan Yurt Ücreti"
            $table->decimal('amount', 8, 2);       // tutar
            $table->date('due_date');              // son ödeme tarihi
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid'); // borç durumu
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debts');
    }
};

