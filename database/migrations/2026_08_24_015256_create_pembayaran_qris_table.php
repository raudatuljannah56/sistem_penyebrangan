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
        Schema::create('pembayaran_qris', function (Blueprint $table) {
            $table->id('id_pembayaran_qris');

            $table->foreignId('id_transaksi')
                ->unique()
                ->constrained('transaksis', 'id_transaksi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('referensi_qris')->unique();
            $table->dateTime('tanggal_pembayaran');

            $table->enum('status', [
                'pending',
                'berhasil',
                'gagal'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_qris');
    }
};