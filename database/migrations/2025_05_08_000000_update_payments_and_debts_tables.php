<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'payment_type')) {
                $table->enum('payment_type', ['nakit', 'havale'])->after('amount');
            }
            if (!Schema::hasColumn('payments', 'receipt_path')) {
                $table->string('receipt_path')->nullable()->after('payment_type');
            }
            if (!Schema::hasColumn('payments', 'rejection_reason')) {
                $table->string('rejection_reason')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('payments', 'debt_id')) {
                $table->foreignId('debt_id')->nullable()->after('student_id')->constrained('debts')->onDelete('cascade');
            }
        });

        Schema::table('debts', function (Blueprint $table) {
            if (!Schema::hasColumn('debts', 'status')) {
                $table->enum('status', ['bekliyor', 'ödendi', 'ödüyor'])->default('bekliyor')->after('amount');
            }
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'receipt_path', 'rejection_reason']);
            $table->dropForeign(['debt_id']);
            $table->dropColumn('debt_id');
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}; 