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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('kode_registrasi')->unique();
            $table->string('nama_lengkap')->length(30);
            $table->string('phone')->length(30);
            $table->string('email')->length(30);
            $table->string('company')->length(255);
            $table->unsignedBigInteger('data_seminar_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
