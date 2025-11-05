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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alat')->onDelete('cascade');
            $table->date('tanggal_peminjaman');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('tujuan_penggunaan');
            $table->text('catatan_tambahan')->nullable();
            $table->string('lokasi_peminjaman')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('disetujui_at')->nullable();
            $table->timestamp('ditolak_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
