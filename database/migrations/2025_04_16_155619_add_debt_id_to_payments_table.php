<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('debt_id')->nullable()->constrained('debts')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['debt_id']);
            $table->dropColumn('debt_id');
        });
    }
};
