<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NomorDokumenLaporan extends Model
{
    protected $table = 'nomor_dokumen_laporans';

    protected $fillable = [
        'tanggal_laporan',
        'nomor_terakhir',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_laporan' => 'date',
            'nomor_terakhir' => 'integer',
        ];
    }

    /**
     * Membuat nomor dokumen laporan berikutnya
     * berdasarkan tanggal laporan.
     *
     * Contoh:
     *
     * 02-09-2026 -> 20260902DOC01
     * 02-09-2026 -> 20260902DOC02
     * 02-09-2026 -> 20260902DOC03
     *
     * Ketika tanggal berubah:
     *
     * 03-09-2026 -> 20260903DOC01
     */
    public static function buatNomor(string $tanggal): string
    {
        $nomorUrut = DB::transaction(function () use ($tanggal) {

            $dokumen = self::query()
                ->where(
                    'tanggal_laporan',
                    $tanggal
                )
                ->lockForUpdate()
                ->first();

            /*
             * Belum ada dokumen untuk tanggal tersebut.
             * Maka mulai dari DOC01.
             */
            if ($dokumen === null) {
                self::query()->create([
                    'tanggal_laporan' => $tanggal,
                    'nomor_terakhir' => 1,
                ]);

                return 1;
            }

            /*
             * Sudah ada dokumen pada tanggal tersebut.
             * Naikkan nomor terakhir.
             */
            $dokumen->increment('nomor_terakhir');

            return $dokumen->fresh()->nomor_terakhir;
        });

        /*
         * Format:
         * YYYYMMDDDOCXX
         */
        return Carbon::parse($tanggal)->format('Ymd')
            . 'DOC'
            . str_pad(
                (string) $nomorUrut,
                2,
                '0',
                STR_PAD_LEFT
            );
    }
}