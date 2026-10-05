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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');

            $table->string('kode_transaksi')->unique();

            $table->foreignId('id_shift')
                ->constrained('shifts', 'id_shift')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_pelayanan')
                ->constrained('pelayanans', 'id_pelayanan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_tarif')
                ->constrained('tarifs', 'id_tarif')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah')->default(1);

            $table->decimal('harga', 12, 2);

            $table->decimal('total', 12, 2);

            $table->enum('metode_pembayaran', [
                'tunai',
                'qris'
            ]);

            $table->enum('status', [
                'berhasil',
                'dibatalkan'
            ])->default('berhasil');

            $table->dateTime('tanggal_transaksi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};