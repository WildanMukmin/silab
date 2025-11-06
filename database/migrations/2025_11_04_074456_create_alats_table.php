<?php
// NAMA FILE: database/migrations/YYYY_MM_DD_HHMMSS_create_alat_table.php

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
        // Perhatikan, file migrasi peminjaman Anda mereferensikan 'alat'
        // Pastikan nama tabel di sini adalah 'alat'
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('gambar')->nullable();
            $table->enum('status', ['Tersedia', 'Sedang Digunakan', 'Maintenance', 'Rusak'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};