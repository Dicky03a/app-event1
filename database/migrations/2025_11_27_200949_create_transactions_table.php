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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('amount');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->text('payment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
