<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loket extends Model
{
    protected $table = 'lokets';

    protected $primaryKey = 'id_loket';

    protected $fillable = [
        'id_dermaga',
        'nama_loket',
        'kode_loket',
        'status',
    ];

    /**
     * Loket berada pada satu dermaga.
     */
    public function dermaga(): BelongsTo
    {
        return $this->belongsTo(
            Dermaga::class,
            'id_dermaga',
            'id_dermaga'
        );
    }

    /**
     * Satu loket dapat memiliki banyak shift.
     */
    public function shifts(): HasMany
    {
        return $this->hasMany(
            Shift::class,
            'id_loket',
            'id_loket'
        );
    }

    /**
     * Tarif yang dilayani oleh loket.
     */
    public function tarifs(): BelongsToMany
    {
        return $this->belongsToMany(
            Tarif::class,
            'loket_tarifs',
            'id_loket',
            'id_tarif',
            'id_loket',
            'id_tarif'
        );
    }
}