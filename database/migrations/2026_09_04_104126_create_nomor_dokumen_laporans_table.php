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
        Schema::create('nomor_dokumen_laporans', function (Blueprint $table) {
            $table->id();

            // Tanggal laporan.
            // Satu tanggal hanya mempunyai satu catatan nomor terakhir.
            $table->date('tanggal_laporan')->unique();

            // Menyimpan nomor DOC terakhir yang sudah digunakan.
            // Contoh:
            // 1 = DOC01
            // 2 = DOC02
            // 3 = DOC03
            $table->unsignedInteger('nomor_terakhir')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_dokumen_laporans');
    }
};