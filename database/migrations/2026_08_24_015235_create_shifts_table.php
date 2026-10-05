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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id('id_shift');

            /*
             * Akun Petugas yang menggunakan shift ini.
             */
            $table->foreignId('id_user')
                ->constrained('users', 'id_user')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
             * Loket yang digunakan oleh akun Petugas.
             */
            $table->foreignId('id_loket')
                ->constrained('lokets', 'id_loket')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
             * Nama shift tetap.
             * Contoh: Pagi, Siang, Malam.
             */
            $table->string('nama_shift', 50);

            /*
             * Jam kerja shift.
             */
            $table->time('jam_mulai');

            $table->time('jam_selesai');

            $table->timestamps();

            /*
             * Satu akun Petugas hanya mempunyai
             * satu konfigurasi shift tetap.
             */
            $table->unique('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};