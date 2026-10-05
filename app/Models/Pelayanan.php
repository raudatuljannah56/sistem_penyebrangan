<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelayanan extends Model
{
    protected $table = 'pelayanans';

    protected $primaryKey = 'id_pelayanan';

    protected $fillable = [
        'nama_pelayanan',
        'keterangan',
        'status',
    ];

    /**
     * Satu pelayanan dapat digunakan pada banyak transaksi.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(
            Transaksi::class,
            'id_pelayanan',
            'id_pelayanan'
        );
    }
}