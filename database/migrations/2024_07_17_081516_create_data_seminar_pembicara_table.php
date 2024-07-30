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
        Schema::create('data_seminar_pembicara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_seminar_id')->constrained('data_seminar')->onDelete('cascade');
            $table->foreignId('pembicara_id')->constrained('pembicara')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_seminar_pembicara');
    }
};
