<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    protected $table = 'shifts';

    protected $primaryKey = 'id_shift';

    protected $fillable = [
        'id_user',
        'id_loket',
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected $casts = [
        'jam_mulai' => 'string',
        'jam_selesai' => 'string',
    ];


    /*
    |--------------------------------------------------------------------------
    | USER / PETUGAS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOKET
    |--------------------------------------------------------------------------
    */

    public function loket(): BelongsTo
    {
        return $this->belongsTo(
            Loket::class,
            'id_loket',
            'id_loket'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function transaksis(): HasMany
    {
        return $this->hasMany(
            Transaksi::class,
            'id_shift',
            'id_shift'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU MULAI
    |--------------------------------------------------------------------------
    */

    public function waktuMulaiHariIni(): ?Carbon
    {
        if (!$this->jam_mulai) {
            return null;
        }

        return Carbon::today()->setTimeFromTimeString(
            (string) $this->jam_mulai
        );
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU SELESAI
    |--------------------------------------------------------------------------
    */

    public function waktuSelesaiHariIni(): ?Carbon
    {
        if (!$this->jam_selesai) {
            return null;
        }

        $mulai = $this->waktuMulaiHariIni();

        $selesai = Carbon::today()->setTimeFromTimeString(
            (string) $this->jam_selesai
        );

        /*
        |--------------------------------------------------------------------------
        | Shift melewati tengah malam
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | 23:00 - 07:00
        |
        */

        if (
            $mulai &&
            $selesai->lessThan($mulai)
        ) {
            $selesai->addDay();
        }

        return $selesai;
    }


    /*
    |--------------------------------------------------------------------------
    | CEK WAKTU SHIFT
    |--------------------------------------------------------------------------
    */

    public function sedangBerlangsung(): bool
    {
        $mulai = $this->waktuMulaiHariIni();

        $selesai = $this->waktuSelesaiHariIni();

        if (!$mulai || !$selesai) {
            return false;
        }

        $sekarang = now();

        /*
        |--------------------------------------------------------------------------
        | SHIFT NORMAL
        |--------------------------------------------------------------------------
        */

        if (
            $selesai->greaterThanOrEqualTo($mulai)
        ) {
            return $sekarang->greaterThanOrEqualTo($mulai)
                && $sekarang->lessThan($selesai);
        }

        /*
        |--------------------------------------------------------------------------
        | SHIFT MELEWATI TENGAH MALAM
        |--------------------------------------------------------------------------
        */

        return $sekarang->greaterThanOrEqualTo($mulai)
            || $sekarang->lessThan($selesai);
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS OTOMATIS
    |--------------------------------------------------------------------------
    */

    public function statusOtomatis(): string
    {
        $mulai = $this->waktuMulaiHariIni();

        $selesai = $this->waktuSelesaiHariIni();

        /*
        |--------------------------------------------------------------------------
        | Jam tidak lengkap
        |--------------------------------------------------------------------------
        */

        if (!$mulai || !$selesai) {
            return match ($this->status) {
                'berlangsung' => 'berlangsung',
                'selesai' => 'selesai',
                default => 'belum_mulai',
            };
        }

        $sekarang = now();


        /*
        |--------------------------------------------------------------------------
        | SHIFT NORMAL
        |--------------------------------------------------------------------------
        */

        if ($selesai->greaterThanOrEqualTo($mulai)) {

            /*
            | Jam selesai sudah lewat
            */

            if (
                $sekarang->greaterThanOrEqualTo($selesai)
            ) {
                return 'selesai';
            }

            /*
            | Sebelum jam mulai
            |
            | Ini juga membuat shift yang sudah selesai
            | pada hari sebelumnya kembali menjadi
            | "Belum Mulai" sebelum memasuki shift hari ini.
            */

            if (
                $sekarang->lessThan($mulai)
            ) {
                return 'belum_mulai';
            }

            /*
            | Di dalam jam shift.
            |
            | Hanya status "berlangsung" yang berarti
            | Petugas sudah login.
            */

            if ($this->status === 'berlangsung') {
                return 'berlangsung';
            }

            return 'belum_mulai';
        }


        /*
        |--------------------------------------------------------------------------
        | SHIFT MALAM / MELEWATI TENGAH MALAM
        |--------------------------------------------------------------------------
        */

        /*
        | Misalnya:
        | 23:00 - 07:00
        |
        | Pukul 23:30 sampai 23:59
        | adalah jam shift.
        |
        | Pukul 00:00 sampai 07:00
        | juga masih jam shift.
        */

        if (
            $sekarang->greaterThanOrEqualTo($mulai)
            ||
            $sekarang->lessThan($selesai)
        ) {
            if ($this->status === 'berlangsung') {
                return 'berlangsung';
            }

            return 'belum_mulai';
        }

        /*
        | Di luar jam shift.
        */

        return 'belum_mulai';
    }


    /*
    |--------------------------------------------------------------------------
    | SINKRONISASI STATUS DATABASE
    |--------------------------------------------------------------------------
    */

    public function sinkronisasiStatus(): string
    {
        $statusBaru = $this->statusOtomatis();

        if (
            $this->status !== $statusBaru
        ) {
            $this->updateQuietly([
                'status' => $statusBaru,
            ]);
        }

        return $statusBaru;
    }


    /*
    |--------------------------------------------------------------------------
    | MULAI SHIFT SAAT LOGIN PETUGAS
    |--------------------------------------------------------------------------
    */

    public function mulaiShift(): bool
    {
        $mulai = $this->waktuMulaiHariIni();

        $selesai = $this->waktuSelesaiHariIni();

        if (!$mulai || !$selesai) {
            return false;
        }

        $sekarang = now();


        /*
        |--------------------------------------------------------------------------
        | SHIFT NORMAL
        |--------------------------------------------------------------------------
        */

        if ($selesai->greaterThanOrEqualTo($mulai)) {

            /*
            | Belum masuk jam shift.
            */

            if (
                $sekarang->lessThan($mulai)
            ) {
                $this->updateQuietly([
                    'status' => 'belum_mulai',
                ]);

                return false;
            }


            /*
            | Jam shift sudah habis.
            */

            if (
                $sekarang->greaterThanOrEqualTo($selesai)
            ) {
                $this->updateQuietly([
                    'status' => 'selesai',
                ]);

                return false;
            }


            /*
            | Petugas login dalam jam shift.
            */

            $this->updateQuietly([
                'status' => 'berlangsung',
            ]);

            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | SHIFT MELEWATI TENGAH MALAM
        |--------------------------------------------------------------------------
        */

        if (
            $sekarang->greaterThanOrEqualTo($mulai)
            ||
            $sekarang->lessThan($selesai)
        ) {

            $this->updateQuietly([
                'status' => 'berlangsung',
            ]);

            return true;
        }


        /*
        | Di luar jam shift.
        */

        $this->updateQuietly([
            'status' => 'belum_mulai',
        ]);

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | SELESAIKAN SHIFT KETIKA JAM HABIS
    |--------------------------------------------------------------------------
    */

    public function selesaiJikaWaktunya(): bool
    {
        $selesai = $this->waktuSelesaiHariIni();

        if (!$selesai) {
            return false;
        }

        if (
            now()->greaterThanOrEqualTo($selesai)
        ) {
            if ($this->status !== 'selesai') {

                $this->updateQuietly([
                    'status' => 'selesai',
                ]);
            }

            return true;
        }

        return false;
    }
}