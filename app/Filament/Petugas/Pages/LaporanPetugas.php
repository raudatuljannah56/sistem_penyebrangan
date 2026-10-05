<?php

namespace App\Filament\Petugas\Pages;

use App\Models\Shift;
use App\Models\Transaksi as TransaksiModel;
use App\Models\User;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use UnitEnum;

class LaporanPetugas extends Page
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | INFORMASI HALAMAN
    |--------------------------------------------------------------------------
    */

    protected static ?string $title = 'Laporan Petugas';

    protected static ?string $navigationLabel = 'Laporan Petugas';

    protected static string|UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedDocumentChartBar;

    protected string $view =
        'filament.petugas.pages.laporan-petugas';


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    public ?string $tanggalAwal = null;

    public ?string $tanggalAkhir = null;


    /*
    |--------------------------------------------------------------------------
    | FILTER PETUGAS
    |--------------------------------------------------------------------------
    |
    | Kosong = semua petugas pada pelabuhan yang sama.
    | Berisi ID = hanya petugas yang dipilih.
    |
    */

    public string $petugas = '';


    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    public int $perPage = 10;


    /*
    |--------------------------------------------------------------------------
    | DETAIL LAPORAN
    |--------------------------------------------------------------------------
    |
    | Detail selalu mengacu pada:
    |
    | 1 shift
    | +
    | 1 tanggal
    |
    */

    public ?int $detailShiftId = null;

    public ?string $detailTanggal = null;


    /*
    |--------------------------------------------------------------------------
    | MODE CETAK
    |--------------------------------------------------------------------------
    |
    | null  = tidak mencetak
    | satu  = mencetak satu laporan
    | semua = mencetak seluruh hasil filter
    |
    */

    public ?string $modeCetak = null;


    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Default laporan hari ini
        |--------------------------------------------------------------------------
        */

        $this->tanggalAwal = now()->toDateString();

        $this->tanggalAkhir = now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Default = semua petugas pada pelabuhan yang sama
        |--------------------------------------------------------------------------
        */

        $this->petugas = '';
    }


    /*
    |--------------------------------------------------------------------------
    | CARI DERMAGA PETUGAS LOGIN
    |--------------------------------------------------------------------------
    |
    | Petugas
    |   ↓
    | Shift
    |   ↓
    | Loket
    |   ↓
    | Dermaga
    |
    */

    protected function getIdDermagaPetugas(): ?int
    {
        $userId = auth()->id();

        if (!$userId) {
            return null;
        }

        $shiftPetugas = Shift::query()
            ->with('loket')
            ->where('id_user', $userId)
            ->first();

        return $shiftPetugas?->loket?->id_dermaga;
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR PETUGAS
    |--------------------------------------------------------------------------
    |
    | Hanya petugas aktif yang mempunyai shift
    | pada pelabuhan yang sama.
    |
    */

    public function getPetugasOptionsProperty(): Collection
    {
        $idDermaga = $this->getIdDermagaPetugas();

        if (!$idDermaga) {
            return collect();
        }

        return User::query()
            ->join(
                'shifts',
                'shifts.id_user',
                '=',
                'users.id_user'
            )
            ->join(
                'lokets',
                'lokets.id_loket',
                '=',
                'shifts.id_loket'
            )
            ->where(
                'users.role',
                'petugas'
            )
            ->where(
                'users.status',
                'aktif'
            )
            ->where(
                'lokets.id_dermaga',
                $idDermaga
            )
            ->select([
                'users.id_user',
                'users.nama',
            ])
            ->distinct()
            ->orderBy(
                'users.nama'
            )
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI FILTER PETUGAS
    |--------------------------------------------------------------------------
    |
    | Mencegah filter memilih petugas dari pelabuhan lain.
    |
    */

    protected function petugasFilterValid(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Semua Petugas
        |--------------------------------------------------------------------------
        */

        if ($this->petugas === '') {
            return true;
        }

        $idDermaga = $this->getIdDermagaPetugas();

        if (!$idDermaga) {
            return false;
        }

        return User::query()
            ->join(
                'shifts',
                'shifts.id_user',
                '=',
                'users.id_user'
            )
            ->join(
                'lokets',
                'lokets.id_loket',
                '=',
                'shifts.id_loket'
            )
            ->where(
                'users.id_user',
                $this->petugas
            )
            ->where(
                'users.role',
                'petugas'
            )
            ->where(
                'users.status',
                'aktif'
            )
            ->where(
                'lokets.id_dermaga',
                $idDermaga
            )
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN DATA
    |--------------------------------------------------------------------------
    */

    public function tampilkanData(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi petugas yang dipilih
        |--------------------------------------------------------------------------
        */

        if (!$this->petugasFilterValid()) {
            $this->petugas = '';
        }

        /*
        |--------------------------------------------------------------------------
        | Reset pagination
        |--------------------------------------------------------------------------
        */

        $this->resetPage(
            'laporanPage'
        );

        /*
        |--------------------------------------------------------------------------
        | Tutup detail yang sedang terbuka
        |--------------------------------------------------------------------------
        */

        $this->detailShiftId = null;

        $this->detailTanggal = null;

        $this->modeCetak = null;
    }


    /*
    |--------------------------------------------------------------------------
    | QUERY DASAR LAPORAN
    |--------------------------------------------------------------------------
    |
    | PENTING:
    |
    | Petugas tidak dibatasi hanya ke shift miliknya sendiri.
    |
    | Contoh Petugas Banjar Raya:
    |
    | Shift 1
    | Shift 2
    | Shift 3
    |
    | semua dapat dilihat selama berada di
    | pelabuhan yang sama.
    |
    | Satu baris:
    |
    | 1 SHIFT + 1 TANGGAL
    |
    */

    protected function queryLaporan(): Builder
    {
        $idDermaga = $this->getIdDermagaPetugas();

        /*
        |--------------------------------------------------------------------------
        | Jika dermaga tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$idDermaga) {
            return TransaksiModel::query()
                ->from('transaksis')
                ->whereRaw('1 = 0');
        }

        /*
        |--------------------------------------------------------------------------
        | Jika filter petugas tidak valid
        |--------------------------------------------------------------------------
        */

        if (!$this->petugasFilterValid()) {
            return TransaksiModel::query()
                ->from('transaksis')
                ->whereRaw('1 = 0');
        }

        return TransaksiModel::query()
            ->from('transaksis')

            /*
            |--------------------------------------------------------------------------
            | FIELD LAPORAN
            |--------------------------------------------------------------------------
            */

            ->select([
                'transaksis.id_shift',

                'shifts.nama_shift',

                'shifts.jam_mulai',

                'shifts.jam_selesai',

                'users.nama as nama_petugas',

                'lokets.nama_loket',

                'dermagas.nama_dermaga',

                DB::raw(
                    'DATE(transaksis.tanggal_transaksi) as tanggal'
                ),

                DB::raw(
                    'COUNT(transaksis.id_transaksi) as jumlah_trx'
                ),

                DB::raw(
                    'SUM(transaksis.total) as total'
                ),
            ])

            /*
            |--------------------------------------------------------------------------
            | SHIFT
            |--------------------------------------------------------------------------
            */

            ->join(
                'shifts',
                'shifts.id_shift',
                '=',
                'transaksis.id_shift'
            )

            /*
            |--------------------------------------------------------------------------
            | USER / PETUGAS
            |--------------------------------------------------------------------------
            */

            ->join(
                'users',
                'users.id_user',
                '=',
                'shifts.id_user'
            )

            /*
            |--------------------------------------------------------------------------
            | LOKET
            |--------------------------------------------------------------------------
            */

            ->join(
                'lokets',
                'lokets.id_loket',
                '=',
                'shifts.id_loket'
            )

            /*
            |--------------------------------------------------------------------------
            | DERMAGA
            |--------------------------------------------------------------------------
            */

            ->join(
                'dermagas',
                'dermagas.id_dermaga',
                '=',
                'lokets.id_dermaga'
            )

            /*
            |--------------------------------------------------------------------------
            | HANYA PELABUHAN PETUGAS LOGIN
            |--------------------------------------------------------------------------
            */

            ->where(
                'lokets.id_dermaga',
                $idDermaga
            )

            /*
            |--------------------------------------------------------------------------
            | HANYA TRANSAKSI BERHASIL
            |--------------------------------------------------------------------------
            */

            ->where(
                'transaksis.status',
                'berhasil'
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL AWAL
            |--------------------------------------------------------------------------
            */

            ->when(
                $this->tanggalAwal,
                function (Builder $query): void {
                    $query->whereDate(
                        'transaksis.tanggal_transaksi',
                        '>=',
                        $this->tanggalAwal
                    );
                }
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL AKHIR
            |--------------------------------------------------------------------------
            */

            ->when(
                $this->tanggalAkhir,
                function (Builder $query): void {
                    $query->whereDate(
                        'transaksis.tanggal_transaksi',
                        '<=',
                        $this->tanggalAkhir
                    );
                }
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER PETUGAS
            |--------------------------------------------------------------------------
            |
            | Kosong = semua petugas.
            |
            */

            ->when(
                $this->petugas !== '',
                function (Builder $query): void {
                    $query->where(
                        'users.id_user',
                        $this->petugas
                    );
                }
            )

            /*
            |--------------------------------------------------------------------------
            | GROUP
            |--------------------------------------------------------------------------
            |
            | Satu shift + satu tanggal = satu laporan.
            |
            */

            ->groupBy(
                'transaksis.id_shift',

                'shifts.nama_shift',

                'shifts.jam_mulai',

                'shifts.jam_selesai',

                'users.nama',

                'lokets.nama_loket',

                'dermagas.nama_dermaga',

                DB::raw(
                    'DATE(transaksis.tanggal_transaksi)'
                )
            )

            /*
            |--------------------------------------------------------------------------
            | URUTAN
            |--------------------------------------------------------------------------
            */

            ->orderByDesc(
                DB::raw(
                    'DATE(transaksis.tanggal_transaksi)'
                )
            )

            ->orderBy(
                'shifts.jam_mulai'
            )

            ->orderBy(
                'shifts.id_shift'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA LAPORAN UNTUK TABEL
    |--------------------------------------------------------------------------
    */

    public function getLaporanProperty()
    {
        return $this->queryLaporan()
            ->paginate(
                $this->perPage,
                ['*'],
                'laporanPage'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA LAPORAN UNTUK CETAK
    |--------------------------------------------------------------------------
    |
    | Mengambil seluruh hasil query berdasarkan filter.
    |
    | TIDAK menggunakan paginate().
    |
    | Jadi meskipun tabel menampilkan 10 data per halaman,
    | Cetak Semua tetap mencetak seluruh data yang sesuai filter.
    |
    */

    public function getSemuaLaporanUntukPrintProperty(): Collection
    {
        return $this->queryLaporan()
            ->get()
            ->map(
                function ($laporan): array {

                    /*
                    |--------------------------------------------------------------------------
                    | Detail item untuk shift + tanggal
                    |--------------------------------------------------------------------------
                    */

                    $items = $this->ambilDetailItem(
                        (int) $laporan->id_shift,
                        (string) $laporan->tanggal
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Rekap pembayaran
                    |--------------------------------------------------------------------------
                    */

                    $pembayaran = $this->ambilPembayaran(
                        (int) $laporan->id_shift,
                        (string) $laporan->tanggal
                    );

                    return [
                        'id_shift' =>
                            (int) $laporan->id_shift,

                        'tanggal' =>
                            (string) $laporan->tanggal,

                        'nama_shift' =>
                            $laporan->nama_shift,

                        'nama_petugas' =>
                            $laporan->nama_petugas,

                        'nama_loket' =>
                            $laporan->nama_loket,

                        'nama_dermaga' =>
                            $laporan->nama_dermaga,

                        'jam_mulai' =>
                            $laporan->jam_mulai,

                        'jam_selesai' =>
                            $laporan->jam_selesai,

                        'jumlah_trx' =>
                            (int) $laporan->jumlah_trx,

                        'total' =>
                            (float) $laporan->total,

                        'items' =>
                            $items,

                        'tunai' =>
                            (float) (
                                $pembayaran->tunai ?? 0
                            ),

                        'qris' =>
                            (float) (
                                $pembayaran->qris ?? 0
                            ),
                    ];
                }
            )
            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL ITEM
    |--------------------------------------------------------------------------
    |
    | Untuk satu shift + satu tanggal.
    |
    */

    protected function ambilDetailItem(
        int $idShift,
        string $tanggal
    ): Collection {
        $idDermaga = $this->getIdDermagaPetugas();

        if (!$idDermaga) {
            return collect();
        }

        return TransaksiModel::query()
            ->from('transaksis')

            ->select([
                'tarifs.nama_tarif',

                DB::raw(
                    'SUM(transaksis.jumlah) as jumlah'
                ),

                DB::raw(
                    'SUM(transaksis.total) as total'
                ),

                DB::raw(
                    'MAX(transaksis.harga) as harga'
                ),
            ])

            /*
            |--------------------------------------------------------------------------
            | TARIF
            |--------------------------------------------------------------------------
            */

            ->join(
                'tarifs',
                'tarifs.id_tarif',
                '=',
                'transaksis.id_tarif'
            )

            /*
            |--------------------------------------------------------------------------
            | SHIFT
            |--------------------------------------------------------------------------
            */

            ->join(
                'shifts',
                'shifts.id_shift',
                '=',
                'transaksis.id_shift'
            )

            /*
            |--------------------------------------------------------------------------
            | LOKET
            |--------------------------------------------------------------------------
            */

            ->join(
                'lokets',
                'lokets.id_loket',
                '=',
                'shifts.id_loket'
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER SHIFT
            |--------------------------------------------------------------------------
            */

            ->where(
                'transaksis.id_shift',
                $idShift
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */

            ->whereDate(
                'transaksis.tanggal_transaksi',
                $tanggal
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER PELABUHAN
            |--------------------------------------------------------------------------
            */

            ->where(
                'lokets.id_dermaga',
                $idDermaga
            )

            /*
            |--------------------------------------------------------------------------
            | HANYA BERHASIL
            |--------------------------------------------------------------------------
            */

            ->where(
                'transaksis.status',
                'berhasil'
            )

            /*
            |--------------------------------------------------------------------------
            | GROUP ITEM
            |--------------------------------------------------------------------------
            */

            ->groupBy(
                'tarifs.id_tarif',
                'tarifs.nama_tarif'
            )

            ->orderBy(
                'tarifs.nama_tarif'
            )

            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | REKAP PEMBAYARAN
    |--------------------------------------------------------------------------
    |
    | Hanya:
    |
    | Tunai
    | QRIS
    |
    | MDR tidak dihitung.
    |
    */

    protected function ambilPembayaran(
        int $idShift,
        string $tanggal
    ): object {
        $idDermaga = $this->getIdDermagaPetugas();

        if (!$idDermaga) {
            return (object) [
                'tunai' => 0,
                'qris' => 0,
            ];
        }

        return TransaksiModel::query()
            ->from('transaksis')

            ->select([
                DB::raw(
                    "COALESCE(
                        SUM(
                            CASE
                                WHEN transaksis.metode_pembayaran = 'tunai'
                                THEN transaksis.total
                                ELSE 0
                            END
                        ),
                        0
                    ) as tunai"
                ),

                DB::raw(
                    "COALESCE(
                        SUM(
                            CASE
                                WHEN transaksis.metode_pembayaran = 'qris'
                                THEN transaksis.total
                                ELSE 0
                            END
                        ),
                        0
                    ) as qris"
                ),
            ])

            /*
            |--------------------------------------------------------------------------
            | SHIFT
            |--------------------------------------------------------------------------
            */

            ->join(
                'shifts',
                'shifts.id_shift',
                '=',
                'transaksis.id_shift'
            )

            /*
            |--------------------------------------------------------------------------
            | LOKET
            |--------------------------------------------------------------------------
            */

            ->join(
                'lokets',
                'lokets.id_loket',
                '=',
                'shifts.id_loket'
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER SHIFT
            |--------------------------------------------------------------------------
            */

            ->where(
                'transaksis.id_shift',
                $idShift
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */

            ->whereDate(
                'transaksis.tanggal_transaksi',
                $tanggal
            )

            /*
            |--------------------------------------------------------------------------
            | FILTER PELABUHAN
            |--------------------------------------------------------------------------
            */

            ->where(
                'lokets.id_dermaga',
                $idDermaga
            )

            /*
            |--------------------------------------------------------------------------
            | HANYA BERHASIL
            |--------------------------------------------------------------------------
            */

            ->where(
                'transaksis.status',
                'berhasil'
            )

            ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | LIHAT SATU LAPORAN
    |--------------------------------------------------------------------------
    |
    | Yang dibuka hanya:
    |
    | 1 shift
    | +
    | 1 tanggal
    |
    */

    public function lihatLaporan(
        int $idShift,
        string $tanggal
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Pastikan laporan memang ada
        |--------------------------------------------------------------------------
        |
        | Query tetap memakai scope pelabuhan dan filter petugas.
        |
        */

        $laporan = $this->queryLaporan()
            ->where(
                'transaksis.id_shift',
                $idShift
            )
            ->whereDate(
                'transaksis.tanggal_transaksi',
                $tanggal
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika tidak ditemukan, jangan buka detail.
        |--------------------------------------------------------------------------
        */

        if (!$laporan) {
            return;
        }

        $this->detailShiftId = $idShift;

        $this->detailTanggal = $tanggal;

        $this->modeCetak = null;
    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP DETAIL
    |--------------------------------------------------------------------------
    */

    public function tutupDetail(): void
    {
        $this->detailShiftId = null;

        $this->detailTanggal = null;

        $this->modeCetak = null;
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL LAPORAN
    |--------------------------------------------------------------------------
    |
    | Detail hanya:
    |
    | 1 shift + 1 tanggal
    |
    */

    public function getDetailLaporanProperty(): ?array
    {
        if (
            !$this->detailShiftId ||
            !$this->detailTanggal
        ) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Cari laporan berdasarkan shift + tanggal
        |--------------------------------------------------------------------------
        */

        $laporan = $this->queryLaporan()
            ->where(
                'transaksis.id_shift',
                $this->detailShiftId
            )
            ->whereDate(
                'transaksis.tanggal_transaksi',
                $this->detailTanggal
            )
            ->first();

        if (!$laporan) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Pembayaran
        |--------------------------------------------------------------------------
        */

        $pembayaran = $this->ambilPembayaran(
            (int) $laporan->id_shift,
            (string) $laporan->tanggal
        );

        return [
            'id_shift' =>
                (int) $laporan->id_shift,

            'tanggal' =>
                (string) $laporan->tanggal,

            'nama_shift' =>
                $laporan->nama_shift,

            'nama_petugas' =>
                $laporan->nama_petugas,

            'nama_loket' =>
                $laporan->nama_loket,

            'nama_dermaga' =>
                $laporan->nama_dermaga,

            'jam_mulai' =>
                $laporan->jam_mulai,

            'jam_selesai' =>
                $laporan->jam_selesai,

            'jumlah_trx' =>
                (int) $laporan->jumlah_trx,

            'total' =>
                (float) $laporan->total,

            'items' =>
                $this->ambilDetailItem(
                    (int) $laporan->id_shift,
                    (string) $laporan->tanggal
                ),

            'tunai' =>
                (float) (
                    $pembayaran->tunai ?? 0
                ),

            'qris' =>
                (float) (
                    $pembayaran->qris ?? 0
                ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CETAK SATU LAPORAN
    |--------------------------------------------------------------------------
    |
    | Hanya mencetak laporan yang dipilih:
    |
    | 1 shift + 1 tanggal
    |
    */

    public function cetakLaporan(
        int $idShift,
        string $tanggal
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Pastikan laporan valid
        |--------------------------------------------------------------------------
        */

        $laporan = $this->queryLaporan()
            ->where(
                'transaksis.id_shift',
                $idShift
            )
            ->whereDate(
                'transaksis.tanggal_transaksi',
                $tanggal
            )
            ->first();

        if (!$laporan) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan laporan yang akan dicetak
        |--------------------------------------------------------------------------
        */

        $this->detailShiftId = $idShift;

        $this->detailTanggal = $tanggal;

        $this->modeCetak = 'satu';

        /*
        |--------------------------------------------------------------------------
        | Trigger browser print
        |--------------------------------------------------------------------------
        */

        $this->dispatch(
            'print-laporan'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CETAK SEMUA
    |--------------------------------------------------------------------------
    |
    | Semua laporan yang masuk filter akan dicetak.
    |
    | Tidak dibatasi pagination.
    |
    */

    public function cetakSemua(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan ada hasil
        |--------------------------------------------------------------------------
        */

        if (
            $this->semuaLaporanUntukPrint
                ->isEmpty()
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Kosongkan detail satu laporan
        |--------------------------------------------------------------------------
        */

        $this->detailShiftId = null;

        $this->detailTanggal = null;

        /*
        |--------------------------------------------------------------------------
        | Ubah mode menjadi semua
        |--------------------------------------------------------------------------
        */

        $this->modeCetak = 'semua';

        /*
        |--------------------------------------------------------------------------
        | Trigger browser print
        |--------------------------------------------------------------------------
        */

        $this->dispatch(
            'print-laporan'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    public function formatRupiah(
        float|int|string|null $nominal
    ): string {
        return number_format(
            (float) ($nominal ?? 0),
            0,
            ',',
            '.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    public function formatTanggal(
        ?string $tanggal
    ): string {
        if (!$tanggal) {
            return '-';
        }

        return Carbon::parse(
            $tanggal
        )->format('d-m-Y');
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER BERUBAH
    |--------------------------------------------------------------------------
    */

    public function updated(
        string $property
    ): void {
        if (
            in_array(
                $property,
                [
                    'tanggalAwal',
                    'tanggalAkhir',
                    'petugas',
                ],
                true
            )
        ) {
            /*
            |--------------------------------------------------------------------------
            | Validasi petugas
            |--------------------------------------------------------------------------
            */

            if (
                $property === 'petugas' &&
                !$this->petugasFilterValid()
            ) {
                $this->petugas = '';
            }

            /*
            |--------------------------------------------------------------------------
            | Reset pagination
            |--------------------------------------------------------------------------
            */

            $this->resetPage(
                'laporanPage'
            );

            /*
            |--------------------------------------------------------------------------
            | Tutup detail ketika filter berubah
            |--------------------------------------------------------------------------
            */

            $this->detailShiftId = null;

            $this->detailTanggal = null;

            $this->modeCetak = null;
        }
    }
}