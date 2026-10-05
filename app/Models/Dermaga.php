<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dermaga extends Model
{
    protected $table = 'dermagas';

    protected $primaryKey = 'id_dermaga';

    protected $fillable = [
        'nama_dermaga',
        'lokasi',
        'keterangan',
        'status',
    ];

    /**
     * Satu dermaga memiliki banyak loket.
     */
    public function lokets(): HasMany
    {
        return $this->hasMany(Loket::class, 'id_dermaga', 'id_dermaga');
    }
}