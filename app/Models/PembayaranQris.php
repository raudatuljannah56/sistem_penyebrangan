<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranQris extends Model
{
    protected $table = 'pembayaran_qris';

    protected $primaryKey = 'id_pembayaran_qris';

    protected $fillable = [
        'id_transaksi',
        'referensi_qris',
        'tanggal_pembayaran',
        'status',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    /**
     * Pembayaran QRIS terkait dengan satu transaksi.
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(
            Transaksi::class,
            'id_transaksi',
            'id_transaksi'
        );
    }
}