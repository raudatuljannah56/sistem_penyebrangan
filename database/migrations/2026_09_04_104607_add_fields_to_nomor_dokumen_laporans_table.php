<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom yang dibutuhkan untuk
     * penomoran dokumen laporan otomatis.
     */
    public function up(): void
    {
        Schema::table('nomor_dokumen_laporans', function (Blueprint $table) {
            $table->date('tanggal_laporan')
                ->unique()
                ->after('id');

            $table->unsignedInteger('nomor_terakhir')
                ->default(0)
                ->after('tanggal_laporan');
        });
    }

    /**
     * Kembalikan perubahan.
     */
    public function down(): void
    {
        Schema::table('nomor_dokumen_laporans', function (Blueprint $table) {
            $table->dropUnique([
                'tanggal_laporan',
            ]);

            $table->dropColumn([
                'tanggal_laporan',
                'nomor_terakhir',
            ]);
        });
    }
};