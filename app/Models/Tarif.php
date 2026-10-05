<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarif extends Model
{
    protected $table = 'tarifs';

    protected $primaryKey = 'id_tarif';

    protected $fillable = [
        'nama_tarif',
        'kategori',
        'harga',
        'foto',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Satu tarif dapat digunakan pada banyak transaksi.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(
            Transaksi::class,
            'id_tarif',
            'id_tarif'
        );
    }

    /**
     * Satu tarif dapat dilayani oleh banyak loket.
     */
    public function lokets(): BelongsToMany
    {
        return $this->belongsToMany(
            Loket::class,
            'loket_tarifs',
            'id_tarif',
            'id_loket',
            'id_tarif',
            'id_loket'
        );
    }
}