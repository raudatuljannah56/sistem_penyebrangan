<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'kode_transaksi',
        'id_shift',
        'id_pelayanan',
        'id_tarif',
        'jumlah',
        'harga',
        'total',
        'metode_pembayaran',
        'status',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
        'tanggal_transaksi' => 'datetime',
    ];

    /**
     * Transaksi dilakukan dalam satu shift.
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(
            Shift::class,
            'id_shift',
            'id_shift'
        );
    }

    /**
     * Transaksi menggunakan satu jenis pelayanan.
     */
    public function pelayanan(): BelongsTo
    {
        return $this->belongsTo(
            Pelayanan::class,
            'id_pelayanan',
            'id_pelayanan'
        );
    }

    /**
     * Transaksi menggunakan satu tarif.
     */
    public function tarif(): BelongsTo
    {
        return $this->belongsTo(
            Tarif::class,
            'id_tarif',
            'id_tarif'
        );
    }

    /**
     * Transaksi dapat memiliki satu pembayaran QRIS.
     */
    public function pembayaranQris(): HasOne
    {
        return $this->hasOne(
            PembayaranQris::class,
            'id_transaksi',
            'id_transaksi'
        );
    }
}