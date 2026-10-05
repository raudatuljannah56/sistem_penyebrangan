<?php

namespace App\Filament\Petugas\Pages;

use App\Models\PembayaranQris;
use App\Models\Pelayanan;
use App\Models\Shift;
use App\Models\Tarif;
use App\Models\Transaksi as TransaksiModel;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class Transaksi extends Page
{
    protected static ?string $title = 'Transaksi';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static string|UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedClipboardDocumentCheck;

    protected string $view = 'filament.petugas.pages.transaksi';

    /*
    |--------------------------------------------------------------------------
    | TARIF
    |--------------------------------------------------------------------------
    */

    public array $tarifsKendaraan = [];

    public array $tarifsPenumpang = [];

    /*
    |--------------------------------------------------------------------------
    | TARIF TERPILIH
    |--------------------------------------------------------------------------
    */

    public ?int $selectedTarifId = null;

    public ?string $selectedTarifName = null;

    public ?string $selectedKategori = null;

    public float $selectedHarga = 0;

    public int $jumlah = 1;

    /*
    |--------------------------------------------------------------------------
    | SHIFT
    |--------------------------------------------------------------------------
    */

    public ?array $shiftAktif = null;

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public ?string $metodePembayaran = null;

    public ?string $kodeTransaksiTerakhir = null;

    public ?string $referensiQris = null;

    public bool $qrisMenungguPembayaran = false;

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $this->loadShiftPetugas();
        $this->loadTarifs();
    }

    /*
    |--------------------------------------------------------------------------
    | SHIFT PETUGAS
    |--------------------------------------------------------------------------
    |
    | Setiap akun Petugas mempunyai satu Shift tetap.
    | Shift ditentukan berdasarkan id_user dari akun yang sedang login.
    |--------------------------------------------------------------------------
    */

    protected function loadShiftPetugas(): void
    {
        $userId = auth()->id();

        if (!$userId) {
            $this->shiftAktif = null;

            return;
        }

        $shift = Shift::query()
            ->with([
                'user',
                'loket.dermaga',
            ])
            ->where('id_user', $userId)
            ->first();

        if (!$shift) {
            $this->shiftAktif = null;

            session()->forget('id_shift_aktif');

            return;
        }

        /*
         * Simpan Shift Petugas ke session.
         */
        session()->put(
            'id_shift_aktif',
            $shift->id_shift
        );

        /*
         * Data Shift untuk tampilan.
         */
        $this->shiftAktif = [
            'id_shift' => $shift->id_shift,
            'nama_shift' => $shift->nama_shift,
            'jam_mulai' => $shift->jam_mulai
                ? substr($shift->jam_mulai, 0, 5)
                : '-',
            'jam_selesai' => $shift->jam_selesai
                ? substr($shift->jam_selesai, 0, 5)
                : '-',
            'loket' => $shift->loket?->nama_loket,
            'dermaga' => $shift->loket?->dermaga?->nama_dermaga,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SHIFT UNTUK TRANSAKSI
    |--------------------------------------------------------------------------
    |
    | Transaksi menggunakan Shift milik akun Petugas yang login.
    | Petugas tidak memilih Shift atau Loket sendiri.
    |--------------------------------------------------------------------------
    */

    protected function getShiftUntukTransaksi(): ?Shift
    {
        $userId = auth()->id();

        if (!$userId) {
            return null;
        }

        $idShift = session('id_shift_aktif');

        /*
         * Cek Shift dari session.
         * Shift harus benar-benar milik user yang sedang login.
         */
        if ($idShift) {
            $shift = Shift::query()
                ->with([
                    'user',
                    'loket.dermaga',
                ])
                ->where('id_shift', $idShift)
                ->where('id_user', $userId)
                ->first();

            if ($shift) {
                return $shift;
            }

            session()->forget('id_shift_aktif');
        }

        /*
         * Jika session tidak ada atau tidak valid,
         * ambil Shift langsung berdasarkan akun Petugas.
         */
        $shift = Shift::query()
            ->with([
                'user',
                'loket.dermaga',
            ])
            ->where('id_user', $userId)
            ->first();

        if ($shift) {
            session()->put(
                'id_shift_aktif',
                $shift->id_shift
            );
        }

        return $shift;
    }

    /*
    |--------------------------------------------------------------------------
    | TARIF
    |--------------------------------------------------------------------------
    */

    protected function loadTarifs(): void
    {
        $shift = $this->getShiftUntukTransaksi();

        if (!$shift || !$shift->loket) {
            $this->tarifsKendaraan = [];
            $this->tarifsPenumpang = [];

            return;
        }

        $tarifs = $shift->loket
            ->tarifs()
            ->where('tarifs.status', 'aktif')
            ->orderBy('tarifs.kategori')
            ->orderBy('tarifs.nama_tarif')
            ->get();

        $this->tarifsKendaraan = $tarifs
            ->where('kategori', 'kendaraan')
            ->map(fn (Tarif $tarif): array => [
                'id_tarif' => $tarif->id_tarif,
                'nama_tarif' => $tarif->nama_tarif,
                'harga' => (float) $tarif->harga,
                'foto' => $tarif->foto,
            ])
            ->values()
            ->all();

        $this->tarifsPenumpang = $tarifs
            ->where('kategori', 'penumpang')
            ->map(fn (Tarif $tarif): array => [
                'id_tarif' => $tarif->id_tarif,
                'nama_tarif' => $tarif->nama_tarif,
                'harga' => (float) $tarif->harga,
                'foto' => $tarif->foto,
            ])
            ->values()
            ->all();
    }

    public function refreshTarifLoket(): void
    {
        $this->loadTarifs();

        $tarifIds = collect([
            ...array_column($this->tarifsKendaraan, 'id_tarif'),
            ...array_column($this->tarifsPenumpang, 'id_tarif'),
        ])
            ->map(fn ($id) => (int) $id)
            ->all();

        if (
            $this->selectedTarifId
            && !in_array(
                $this->selectedTarifId,
                $tarifIds,
                true
            )
        ) {
            $this->batalPilihTarif();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PILIH TARIF
    |--------------------------------------------------------------------------
    */

    public function pilihTarif(int $idTarif): void
    {
        /*
         * Tarif harus termasuk tarif yang dilayani oleh
         * Loket pada Shift Petugas yang sedang aktif.
         */
        $shift = $this->getShiftUntukTransaksi();

        if (!$shift || !$shift->loket) {
            Notification::make()
                ->title('Loket Petugas belum tersedia.')
                ->body(
                    'Shift Petugas ini belum memiliki Loket.'
                )
                ->danger()
                ->send();

            return;
        }

        $tarif = $shift->loket
            ->tarifs()
            ->where('tarifs.id_tarif', $idTarif)
            ->where('tarifs.status', 'aktif')
            ->first();

        if (!$tarif) {
            Notification::make()
                ->title('Tarif tidak tersedia di loket ini.')
                ->body(
                    'Tarif tersebut belum diatur sebagai tarif yang dilayani oleh loket Petugas.'
                )
                ->warning()
                ->send();

            return;
        }

        $this->selectedTarifId = $tarif->id_tarif;

        $this->selectedTarifName = $tarif->nama_tarif;

        $this->selectedKategori = $tarif->kategori;

        $this->selectedHarga = (float) $tarif->harga;

        $this->jumlah = 1;

        $this->metodePembayaran = null;

        $this->kodeTransaksiTerakhir = null;

        $this->referensiQris = null;

        $this->qrisMenungguPembayaran = false;
    }

    /*
    |--------------------------------------------------------------------------
    | BATAL
    |--------------------------------------------------------------------------
    */

    public function batalPilihTarif(): void
    {
        $this->selectedTarifId = null;

        $this->selectedTarifName = null;

        $this->selectedKategori = null;

        $this->selectedHarga = 0;

        $this->jumlah = 1;

        $this->metodePembayaran = null;

        $this->kodeTransaksiTerakhir = null;

        $this->referensiQris = null;

        $this->qrisMenungguPembayaran = false;
    }

    /*
    |--------------------------------------------------------------------------
    | JUMLAH
    |--------------------------------------------------------------------------
    */

    public function tambahJumlah(): void
    {
        if (!$this->selectedTarifId) {
            return;
        }

        $this->jumlah++;
    }

    public function kurangiJumlah(): void
    {
        if (!$this->selectedTarifId) {
            return;
        }

        if ($this->jumlah > 1) {
            $this->jumlah--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    public function getTotal(): float
    {
        return $this->selectedHarga * max(1, $this->jumlah);
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function pilihPembayaran(string $metode): void
    {
        if (!in_array($metode, [
            'tunai',
            'qris',
        ], true)) {
            return;
        }

        if (!$this->selectedTarifId) {
            Notification::make()
                ->title('Pilih tarif terlebih dahulu.')
                ->warning()
                ->send();

            return;
        }

        $this->metodePembayaran = $metode;

        $this->kodeTransaksiTerakhir = null;

        $this->referensiQris = null;

        $this->qrisMenungguPembayaran = false;
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function prosesTransaksi(): void
    {
        /*
         * Validasi tarif.
         */
        if (!$this->selectedTarifId) {
            Notification::make()
                ->title('Tarif belum dipilih.')
                ->warning()
                ->send();

            return;
        }

        /*
         * Validasi jumlah.
         */
        if ($this->jumlah < 1) {
            Notification::make()
                ->title('Jumlah tidak valid.')
                ->warning()
                ->send();

            return;
        }

        /*
         * Validasi pembayaran.
         */
        if (!$this->metodePembayaran) {
            Notification::make()
                ->title('Pilih metode pembayaran.')
                ->warning()
                ->send();

            return;
        }

        /*
         * Ambil Shift sesuai akun Petugas yang sedang login.
         */
        $shift = $this->getShiftUntukTransaksi();

        if (!$shift) {
            Notification::make()
                ->title('Shift Petugas belum tersedia.')
                ->body(
                    'Akun Petugas ini belum memiliki Shift yang ditugaskan.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
         * Pastikan Shift mempunyai Loket.
         */
        if (!$shift->loket) {
            Notification::make()
                ->title('Loket Shift belum tersedia.')
                ->body(
                    'Shift Petugas ini belum memiliki Loket.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
         * Pastikan Loket mempunyai Dermaga.
         */
        if (!$shift->loket->dermaga) {
            Notification::make()
                ->title('Dermaga belum tersedia.')
                ->body(
                    'Loket Shift Petugas ini belum memiliki Dermaga.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
         * Ambil tarif terbaru dari database.
         */
        $tarif = $shift->loket
            ->tarifs()
            ->where('tarifs.id_tarif', $this->selectedTarifId)
            ->where('tarifs.status', 'aktif')
            ->first();

        if (!$tarif) {
            Notification::make()
                ->title('Tarif tidak tersedia di loket ini.')
                ->body(
                    'Tarif tersebut belum diatur sebagai tarif yang dilayani oleh loket Petugas.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
         * Ambil pelayanan aktif.
         */
        $pelayanan = Pelayanan::query()
            ->where('status', 'aktif')
            ->first();

        if (!$pelayanan) {
            Notification::make()
                ->title('Pelayanan belum tersedia.')
                ->body(
                    'Belum ada pelayanan aktif di database.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
         * Hitung transaksi.
         */
        $harga = (float) $tarif->harga;

        $jumlah = max(1, $this->jumlah);

        $total = $harga * $jumlah;

        /*
         * Status transaksi.
         *
         * Tunai = langsung berhasil
         * QRIS  = menunggu pembayaran
         */
        $status = $this->metodePembayaran === 'tunai'
            ? 'berhasil'
            : 'pending';

        /*
         * Simpan transaksi dan buat Kode TX
         * berdasarkan dermaga + tanggal + nomor urut.
         */
        try {
            DB::transaction(function () use (
                $shift,
                $pelayanan,
                $tarif,
                $harga,
                $jumlah,
                $total,
                $status
            ) {
                /*
                 * Buat Kode TX di dalam transaksi database.
                 */
                $kodeTransaksi = $this->buatKodeTransaksi(
                    $shift->loket->dermaga->id_dermaga
                );

                /*
                 * Simpan transaksi.
                 */
                $transaksi = TransaksiModel::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'id_shift' => $shift->id_shift,
                    'id_pelayanan' => $pelayanan->id_pelayanan,
                    'id_tarif' => $tarif->id_tarif,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'total' => $total,
                    'metode_pembayaran' => $this->metodePembayaran,
                    'status' => $status,
                    'tanggal_transaksi' => now(),
                ]);

                /*
                 * Jika pembayaran QRIS,
                 * buat data pembayaran QRIS.
                 */
                if ($this->metodePembayaran === 'qris') {
                    $referensiQris = $this->buatReferensiQris();

                    $transaksi->pembayaranQris()->create([
                        'referensi_qris' => $referensiQris,
                        'tanggal_pembayaran' => now(),
                        'status' => 'pending',
                    ]);

                    $this->referensiQris = $referensiQris;
                }

                /*
                 * Simpan Kode TX yang baru dibuat
                 * untuk ditampilkan pada notifikasi.
                 */
                $this->kodeTransaksiTerakhir = $kodeTransaksi;
            });
        } catch (\Throwable $e) {
            report($e);

            Notification::make()
                ->title('Transaksi gagal disimpan.')
                ->body(
                    'Terjadi kesalahan saat menyimpan transaksi.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | TUNAI
        |--------------------------------------------------------------------------
        */

        if ($this->metodePembayaran === 'tunai') {
            Notification::make()
                ->title('Transaksi berhasil.')
                ->body(
                    "Kode transaksi: {$this->kodeTransaksiTerakhir}"
                )
                ->success()
                ->send();

            /*
             * Setelah berhasil,
             * kembali ke daftar tarif.
             */
            $this->batalPilihTarif();

            /*
             * Refresh informasi Shift.
             */
            $this->loadShiftPetugas();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | QRIS
        |--------------------------------------------------------------------------
        */

        $this->qrisMenungguPembayaran = true;

        Notification::make()
            ->title('Pembayaran QRIS dibuat.')
            ->body(
                "Kode transaksi: {$this->kodeTransaksiTerakhir}. "
                . 'Menunggu pembayaran.'
            )
            ->info()
            ->send();
    }

    /*
    |--------------------------------------------------------------------------
    | KODE TRANSAKSI
    |--------------------------------------------------------------------------
    |
    | Format:
    |
    | TRX-PBR260907-001
    |
    | TRX = transaksi
    | PBR = kode pelabuhan/dermaga
    | 260907 = tanggal transaksi
    | 001 = nomor urut transaksi pada dermaga tersebut
    |
    | Nomor urut dimulai kembali dari 001 setiap hari
    | untuk masing-masing dermaga.
    |--------------------------------------------------------------------------
    */

    protected function buatKodeTransaksi(int $idDermaga): string
    {
        /*
         * Kode masing-masing pelabuhan.
         */
        $kodeDermaga = match ($idDermaga) {
            1 => 'PBR', // Pelabuhan Banjar Raya
            2 => 'PAL', // Pelabuhan Alalak
            3 => 'PUM', // Pelabuhan Ujung Murung
            4 => 'PPB', // Pelabuhan Pasar Baru
            5 => 'PPL', // Pelabuhan Pasar Lima
            default => null,
        };

        /*
         * Dermaga belum memiliki kode.
         */
        if ($kodeDermaga === null) {
            throw new \RuntimeException(
                'Kode pelabuhan untuk dermaga tidak ditemukan.'
            );
        }

        /*
         * Tanggal transaksi.
         *
         * Format YYMMDD
         * Contoh:
         * 07 September 2026 = 260907
         */
        $tanggal = now()->format('ymd');

        /*
         * Prefix Kode TX.
         *
         * Contoh:
         * TRX-PBR260907-
         */
        $prefix = 'TRX-'
            . $kodeDermaga
            . $tanggal
            . '-';

        /*
         * Cari transaksi terakhir pada dermaga
         * dan tanggal yang sama.
         */
        $kodeTerakhir = TransaksiModel::query()
            ->where(
                'kode_transaksi',
                'like',
                $prefix . '%'
            )
            ->orderByDesc('kode_transaksi')
            ->lockForUpdate()
            ->value('kode_transaksi');

        /*
         * Jika belum ada transaksi,
         * mulai dari 001.
         */
        if (!$kodeTerakhir) {
            $nomorUrut = 1;
        } else {
            /*
             * Ambil 3 digit terakhir.
             *
             * Contoh:
             * TRX-PBR260907-007
             * menjadi:
             * 007
             */
            $nomorTerakhir = (int) substr(
                $kodeTerakhir,
                -3
            );

            $nomorUrut = $nomorTerakhir + 1;
        }

        /*
         * Bentuk nomor urut tiga digit.
         *
         * 1   -> 001
         * 10  -> 010
         * 125 -> 125
         */
        $nomorFormat = str_pad(
            (string) $nomorUrut,
            3,
            '0',
            STR_PAD_LEFT
        );

        /*
         * Hasil akhir.
         */
        $kode = $prefix . $nomorFormat;

        /*
         * Pastikan tetap unik.
         *
         * Pemeriksaan tambahan ini digunakan untuk
         * mengantisipasi data yang sudah ada.
         */
        while (
            TransaksiModel::query()
                ->where(
                    'kode_transaksi',
                    $kode
                )
                ->exists()
        ) {
            $nomorUrut++;

            $nomorFormat = str_pad(
                (string) $nomorUrut,
                3,
                '0',
                STR_PAD_LEFT
            );

            $kode = $prefix . $nomorFormat;
        }

        return $kode;
    }

    /*
    |--------------------------------------------------------------------------
    | REFERENSI QRIS
    |--------------------------------------------------------------------------
    */

    protected function buatReferensiQris(): string
    {
        do {
            $referensi = 'QRIS-'
                . now()->format('YmdHis')
                . '-'
                . strtoupper(
                    bin2hex(
                        random_bytes(3)
                    )
                );
        } while (
            PembayaranQris::query()
                ->where(
                    'referensi_qris',
                    $referensi
                )
                ->exists()
        );

        return $referensi;
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL PENDAPATAN HARI INI
    |--------------------------------------------------------------------------
    */

    public function getTotalPendapatanHariIniProperty(): float
    {
        $userId = auth()->id();

        if (!$userId) {
            return 0;
        }

        return (float) TransaksiModel::query()
            ->whereHas(
                'shift',
                function ($query) use ($userId) {
                    $query->where(
                        'id_user',
                        $userId
                    );
                }
            )
            ->whereDate(
                'tanggal_transaksi',
                now()->toDateString()
            )
            ->where(
                'status',
                'berhasil'
            )
            ->sum('total');
    }

    /*
    |--------------------------------------------------------------------------
    | GAMBAR TARIF
    |--------------------------------------------------------------------------
    */

    public function getGambarTarif(string $namaTarif): string
    {
        $nama = strtolower($namaTarif);

        return match (true) {

            str_contains(
                $nama,
                'roda 2'
            )
                => 'images/tarif/roda-2.png',

            str_contains(
                $nama,
                'roda 3'
            )
                => 'images/tarif/roda-3.png',

            str_contains(
                $nama,
                'roda 4'
            )
                => 'images/tarif/roda-4.png',

            str_contains(
                $nama,
                'roda 6'
            )
                => 'images/tarif/roda-6.png',

            str_contains(
                $nama,
                'jalan kaki'
            )
                => 'images/tarif/jalan-kaki.png',

            str_contains(
                $nama,
                'penumpang kapal'
            )
                => 'images/tarif/penumpang-kapal.png',

            str_contains(
                $nama,
                'bongkar'
            )
                => 'images/tarif/bongkar-muat.png',

            default
                => 'images/tarif/default.png',
        };
    }
}