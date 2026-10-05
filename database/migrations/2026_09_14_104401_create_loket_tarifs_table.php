<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loket_tarifs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_loket')
                ->constrained('lokets', 'id_loket')
                ->cascadeOnDelete();

            $table->foreignId('id_tarif')
                ->constrained('tarifs', 'id_tarif')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'id_loket',
                'id_tarif',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loket_tarifs');
    }
};