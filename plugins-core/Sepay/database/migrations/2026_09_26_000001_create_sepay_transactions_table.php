<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('v2_sepay_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trade_no')->index();
            $table->string('callback_no')->nullable()->index();
            $table->string('bank_code', 32)->nullable()->index();
            $table->string('bank_name', 100)->nullable();
            $table->string('account_number', 64)->nullable();
            $table->string('account_name', 255)->nullable();
            $table->unsignedBigInteger('amount')->default(0);
            $table->string('content')->nullable();
            $table->string('status', 32)->default('pending');
            $table->json('raw_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique('trade_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('v2_sepay_transactions');
    }
};
