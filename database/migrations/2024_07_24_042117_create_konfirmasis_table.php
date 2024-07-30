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
        Schema::create('konfirmasi', function (Blueprint $table) {
            $table->id();
            $table->string('bukti_pembayaran')->default('-');
            $table->integer('status_pembayaran')->default(0);
            $table->unsignedBigInteger('peserta_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmasi');
    }
};
