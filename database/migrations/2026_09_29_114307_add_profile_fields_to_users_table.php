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
        Schema::table('users', function (Blueprint $table) {

            $table->string('no_telepon', 30)
                ->nullable()
                ->after('nama');

            $table->string('alamat', 500)
                ->nullable()
                ->after('no_telepon');

            $table->string('email')
                ->nullable()
                ->after('alamat');

            $table->string('foto')
                ->nullable()
                ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'no_telepon',
                'alamat',
                'email',
                'foto',
            ]);
        });
    }
};