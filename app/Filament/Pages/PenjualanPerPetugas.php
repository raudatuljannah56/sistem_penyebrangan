<?php

namespace App\Filament\Pages;

use App\Models\NomorDokumenLaporan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use UnitEnum;

class PenjualanPerPetugas extends Page
{
    use WithPagination;

    protected static ?string $title = 'Laporan Per Petugas';

    protected static ?string $navigationLabel = 'Penjualan by Petugas';

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.penjualan-per-petugas';

    /*
    |--------------------------------------------------------------------------
    | Filter halaman utama
    |--------------------------------------------------------------------------
    */

    public string $tanggal = '';

    public string $petugas = '';

    /*
    |--------------------------------------------------------------------------
    | Pagination halaman utama
    |--------------------------------------------------------------------------
    */

    public int $perPage = 10;

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public ?int $shiftDetail = null;

    public ?string $tanggalDetail = null;

    public string $detailSearch = '';

    public int $detailPerPage = 10;

    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $this->tanggal = now()->toDateString();
    }

    /*
    |--------------------------------------------------------------------------
    | Filter utama
    |--------------------------------------------------------------------------
    */

    public function tampilkanData(): void
    {
        $this->resetPage('laporanPage');
    }

    /*
    |--------------------------------------------------------------------------
    | Buka detail
    |--------------------------------------------------------------------------
    */

    public function lihatDetail(
        int $shiftId,
        string $tanggal
    ): void {
        $this->shiftDetail = $shiftId;
        $this->tanggalDetail = $tanggal;

        $this->detailSearch = '';
        $this->detailPerPage = 10;

        $this->setPage(
            1,
            'detailPage'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Tutup detail
    |--------------------------------------------------------------------------
    */

    public function tutupDetail(): void
    {
        $this->shiftDetail = null;
        $this->tanggalDetail = null;

        $this->detailSearch = '';

        $this->setPage(
            1,
            'detailPage'
        );
    }

    public function updatedDetailSearch(): void
    {
        $this->setPage(
            1,
            'detailPage'
        );
    }

    public function updatedDetailPerPage(): void
    {
        $this->setPage(
            1,
            'detailPage'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Pilihan petugas
    |--------------------------------------------------------------------------
    */

    public function getPetugasOptionsProperty()
    {
        return User::query()
            ->where('role', 'petugas')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get([
                'id_user',
                'nama',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Query laporan
    |--------------------------------------------------------------------------
    */

    protected function laporanQuery(): Builder
    {
        return Transaksi::query()
            ->join(
                'shifts',
                'transaksis.id_shift',
                '=',
                'shifts.id_shift'
            )
            ->join(
                'users',
                'shifts.id_user',
                '=',
                'users.id_user'
            )
            ->join(
                'lokets',
                'shifts.id_loket',
                '=',
                'lokets.id_loket'
            )
            ->where(
                'transaksis.status',
                'berhasil'
            )
            ->when(
                $this->tanggal !== '',
                fn (Builder $query): Builder =>
                    $query->whereDate(
                        'transaksis.tanggal_transaksi',
                        $this->tanggal
                    )
            )
            ->when(
                $this->petugas !== '',
                fn (Builder $query): Builder =>
                    $query->where(
                        'users.id_user',
                        $this->petugas
                    )
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Data laporan utama
    |--------------------------------------------------------------------------
    */

    public function getLaporanProperty(): LengthAwarePaginator
    {
        return $this->laporanQuery()
            ->selectRaw('
                shifts.id_shift,
                users.id_user,
                users.nama as nama_petugas,
                shifts.nama_shift,
                shifts.jam_mulai,
                shifts.jam_selesai,
                lokets.nama_loket,
                DATE(transaksis.tanggal_transaksi) as tanggal_laporan,
                MIN(transaksis.tanggal_transaksi) as waktu_awal,
                MAX(transaksis.tanggal_transaksi) as waktu_akhir,
                SUM(transaksis.total) as pendapatan
            ')
            ->groupBy(
                'shifts.id_shift',
                'users.id_user',
                'users.nama',
                'shifts.nama_shift',
                'shifts.jam_mulai',
                'shifts.jam_selesai',
                'lokets.nama_loket',
                'tanggal_laporan'
            )
            ->orderBy(
                'tanggal_laporan',
                'desc'
            )
            ->orderBy(
                'shifts.jam_mulai',
                'asc'
            )
            ->paginate(
                $this->perPage,
                ['*'],
                'laporanPage'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Query detail
    |--------------------------------------------------------------------------
    */

    protected function detailQuery(): Builder
    {
        return Transaksi::query()
            ->with([
                'shift.user',
                'shift.loket.dermaga',
                'tarif',
            ])
            ->where(
                'id_shift',
                $this->shiftDetail
            )
            ->where(
                'status',
                'berhasil'
            )
            ->when(
                $this->tanggalDetail,
                fn (Builder $query): Builder =>
                    $query->whereDate(
                        'tanggal_transaksi',
                        $this->tanggalDetail
                    )
            )
            ->when(
                trim($this->detailSearch) !== '',
                function (Builder $query): Builder {
                    $search = trim(
                        $this->detailSearch
                    );

                    return $query->where(function (
                        Builder $query
                    ) use ($search) {

                        $query
                            ->whereHas(
                                'shift.loket.dermaga',
                                fn (Builder $query): Builder =>
                                    $query->where(
                                        'nama_dermaga',
                                        'like',
                                        "%{$search}%"
                                    )
                            )
                            ->orWhereHas(
                                'tarif',
                                fn (Builder $query): Builder =>
                                    $query->where(
                                        'nama_tarif',
                                        'like',
                                        "%{$search}%"
                                    )
                            );
                    });
                }
            )
            ->orderBy(
                'id_tarif'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Detail dikelompokkan berdasarkan tarif
    |--------------------------------------------------------------------------
    */

    protected function getDetailCollection()
    {
        if (
            !$this->shiftDetail ||
            !$this->tanggalDetail
        ) {
            return collect();
        }

        return $this->detailQuery()
            ->get()
            ->groupBy('id_tarif')
            ->map(function ($items) {

                $transaksi = $items->first();

                return [
                    'lokasi' =>
                        $transaksi
                            ->shift
                            ?->loket
                            ?->dermaga
                            ?->nama_dermaga
                        ?? '-',

                    'item' =>
                        $transaksi
                            ->tarif
                            ?->nama_tarif
                        ?? '-',

                    'harga' =>
                        (float) $transaksi->harga,

                    'qty' =>
                        (int) $items->sum('jumlah'),

                    'total' =>
                        (float) $items->sum('total'),
                ];
            })
            ->values();
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination detail
    |--------------------------------------------------------------------------
    */

    public function getDetailTransaksiProperty(): LengthAwarePaginator
    {
        $collection = $this->getDetailCollection();

        $currentPage = $this->getPage(
            'detailPage'
        );

        $items = $collection
            ->forPage(
                $currentPage,
                $this->detailPerPage
            )
            ->values();

        return new LengthAwarePaginator(
            $items,
            $collection->count(),
            $this->detailPerPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'detailPage',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Nama petugas pada detail
    |--------------------------------------------------------------------------
    */

    public function getDetailPetugasProperty(): ?string
    {
        if (
            !$this->shiftDetail ||
            !$this->tanggalDetail
        ) {
            return null;
        }

        return Transaksi::query()
            ->with('shift.user')
            ->where(
                'id_shift',
                $this->shiftDetail
            )
            ->where(
                'status',
                'berhasil'
            )
            ->whereDate(
                'tanggal_transaksi',
                $this->tanggalDetail
            )
            ->first()
            ?->shift
            ?->user
            ?->nama;
    }

    /*
    |--------------------------------------------------------------------------
    | Nama shift pada detail
    |--------------------------------------------------------------------------
    */

    public function getDetailShiftProperty(): ?string
    {
        if (
            !$this->shiftDetail ||
            !$this->tanggalDetail
        ) {
            return null;
        }

        return Transaksi::query()
            ->with('shift')
            ->where(
                'id_shift',
                $this->shiftDetail
            )
            ->where(
                'status',
                'berhasil'
            )
            ->whereDate(
                'tanggal_transaksi',
                $this->tanggalDetail
            )
            ->first()
            ?->shift
            ?->nama_shift;
    }

    /*
    |--------------------------------------------------------------------------
    | Total pendapatan detail
    |--------------------------------------------------------------------------
    */

    public function getDetailTotalProperty(): float
    {
        if (
            !$this->shiftDetail ||
            !$this->tanggalDetail
        ) {
            return 0;
        }

        return (float) Transaksi::query()
            ->where(
                'id_shift',
                $this->shiftDetail
            )
            ->where(
                'status',
                'berhasil'
            )
            ->whereDate(
                'tanggal_transaksi',
                $this->tanggalDetail
            )
            ->sum('total');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function exportExcel()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data sesuai filter
        |--------------------------------------------------------------------------
        */

        $data = $this->laporanQuery()
            ->selectRaw('
                shifts.id_shift,
                users.id_user,
                users.nama as nama_petugas,
                DATE(transaksis.tanggal_transaksi) as tanggal_laporan,
                MIN(transaksis.tanggal_transaksi) as waktu_awal,
                MAX(transaksis.tanggal_transaksi) as waktu_akhir,
                SUM(transaksis.total) as pendapatan
            ')
            ->groupBy(
                'shifts.id_shift',
                'users.id_user',
                'users.nama',
                'tanggal_laporan'
            )
            ->orderBy(
                'tanggal_laporan',
                'desc'
            )
            ->orderBy(
                'shifts.id_shift',
                'asc'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Spreadsheet
        |--------------------------------------------------------------------------
        */

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle(
            'Laporan Petugas'
        );

        /*
        |--------------------------------------------------------------------------
        | Hilangkan gridline
        |--------------------------------------------------------------------------
        */

        $sheet->setShowGridlines(false);

        /*
        |--------------------------------------------------------------------------
        | Lebar kolom
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getColumnDimension('A')
            ->setWidth(7);

        $sheet
            ->getColumnDimension('B')
            ->setWidth(34);

        $sheet
            ->getColumnDimension('C')
            ->setWidth(34);

        $sheet
            ->getColumnDimension('D')
            ->setWidth(18);

        /*
        |--------------------------------------------------------------------------
        | Font
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:D100')
            ->getFont()
            ->setName('Arial')
            ->setSize(10);

        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A1:D1'
        );

        $sheet->setCellValue(
            'A1',
            'Laporan Per Petugas'
        );

        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true)
            ->setSize(20);

        $sheet
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getRowDimension(1)
            ->setRowHeight(30);

        /*
        |--------------------------------------------------------------------------
        | Jarak
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getRowDimension(2)
            ->setRowHeight(10);

        $sheet
            ->getRowDimension(3)
            ->setRowHeight(8);

        /*
        |--------------------------------------------------------------------------
        | SUBJUDUL
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A4:D4'
        );

        $sheet->setCellValue(
            'A4',
            'Laporan Pendapatan Petugas'
        );

        $sheet
            ->getStyle('A4')
            ->getFont()
            ->setSize(11);

        $sheet
            ->getStyle('A4')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getRowDimension(4)
            ->setRowHeight(20);

        /*
        |--------------------------------------------------------------------------
        | Nama petugas dan tanggal
        |--------------------------------------------------------------------------
        */

        if ($this->petugas !== '') {

            $namaPetugas = User::query()
                ->where(
                    'id_user',
                    $this->petugas
                )
                ->value('nama');

            $namaPetugas = $namaPetugas
                ? trim($namaPetugas)
                : '-';

        } else {

            $namaPetugas = 'Semua Petugas';
        }

        $tanggalLaporan = $this->tanggal !== ''
            ? Carbon::parse(
                $this->tanggal
            )->format('d-m-Y')
            : '-';

        /*
        |--------------------------------------------------------------------------
        | Informasi laporan
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A5:D5'
        );

        $sheet->setCellValue(
            'A5',
            'Nama Petugas : ' .
            $namaPetugas .
            ' | Tanggal : ' .
            $tanggalLaporan
        );

        $sheet
            ->getStyle('A5')
            ->getFont()
            ->setSize(10);

        $sheet
            ->getStyle('A5')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getRowDimension(5)
            ->setRowHeight(20);

        /*
        |--------------------------------------------------------------------------
        | Jarak sebelum tabel
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getRowDimension(6)
            ->setRowHeight(8);

        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $headerRow = 7;

        $sheet->setCellValue(
            "A{$headerRow}",
            'No'
        );

        $sheet->setCellValue(
            "B{$headerRow}",
            'Tanggal'
        );

        $sheet->setCellValue(
            "C{$headerRow}",
            'Petugas'
        );

        $sheet->setCellValue(
            "D{$headerRow}",
            'Pendapatan'
        );

        /*
        |--------------------------------------------------------------------------
        | Header biru
        |--------------------------------------------------------------------------
        */

        $headerStyle = $sheet->getStyle(
            "A{$headerRow}:D{$headerRow}"
        );

        $headerStyle
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            );

        $headerStyle
            ->getFill()
            ->getStartColor()
            ->setARGB(
                'FF4472C4'
            );

        $headerStyle
            ->getFont()
            ->setBold(true);

        $headerStyle
            ->getFont()
            ->getColor()
            ->setARGB(
                'FF000000'
            );

        $headerStyle
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        /*
        |--------------------------------------------------------------------------
        | Border header tabel
        |--------------------------------------------------------------------------
        */

        $headerStyle
            ->getBorders()
            ->getTop()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $headerStyle
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $headerStyle
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $headerStyle
            ->getBorders()
            ->getRight()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $headerStyle
            ->getBorders()
            ->getVertical()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $headerStyle
            ->getBorders()
            ->getHorizontal()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getRowDimension($headerRow)
            ->setRowHeight(22);

        /*
        |--------------------------------------------------------------------------
        | Data laporan
        |--------------------------------------------------------------------------
        */

        $row = 8;

        $totalPendapatan = 0;

        foreach ($data as $index => $item) {

            $tanggal = Carbon::parse(
                $item->tanggal_laporan
            )->format('d-M-Y');

            $waktuAwal = Carbon::parse(
                $item->waktu_awal
            )->format('H:i:s');

            $waktuAkhir = Carbon::parse(
                $item->waktu_akhir
            )->format('H:i:s');

            $tanggalDanWaktu =
                $tanggal .
                ' ' .
                $waktuAwal .
                ' - ' .
                $waktuAkhir;

            /*
            |--------------------------------------------------------------------------
            | Petugas hanya nama
            |--------------------------------------------------------------------------
            |
            | Tidak menambahkan:
            | - nama loket
            | - shift
            |--------------------------------------------------------------------------
            */

            $namaPetugasTabel = trim(
                (string) $item->nama_petugas
            );

            /*
            |--------------------------------------------------------------------------
            | Isi tabel
            |--------------------------------------------------------------------------
            */

            $sheet->setCellValue(
                "A{$row}",
                $index + 1
            );

            $sheet->setCellValue(
                "B{$row}",
                $tanggalDanWaktu
            );

            $sheet->setCellValue(
                "C{$row}",
                $namaPetugasTabel
            );

            $sheet->setCellValue(
                "D{$row}",
                (float) $item->pendapatan
            );

            /*
            |--------------------------------------------------------------------------
            | Border setiap baris data
            |--------------------------------------------------------------------------
            */

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getTop()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getBottom()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getLeft()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getRight()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getVertical()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getHorizontal()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            /*
            |--------------------------------------------------------------------------
            | Alignment
            |--------------------------------------------------------------------------
            */

            $sheet
                ->getStyle("A{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("B{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("C{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("D{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_RIGHT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            /*
            |--------------------------------------------------------------------------
            | Format pendapatan
            |--------------------------------------------------------------------------
            */

            $sheet
                ->getStyle("D{$row}")
                ->getNumberFormat()
                ->setFormatCode(
                    '#,##0'
                );

            $sheet
                ->getRowDimension($row)
                ->setRowHeight(20);

            $totalPendapatan +=
                (float) $item->pendapatan;

            $row++;
        }

        /*
        |--------------------------------------------------------------------------
        | Jika data kosong
        |--------------------------------------------------------------------------
        */

        if ($data->isEmpty()) {

            $sheet->setCellValue(
                "A{$row}",
                '-'
            );

            $sheet->mergeCells(
                "B{$row}:D{$row}"
            );

            $sheet->setCellValue(
                "B{$row}",
                'Tidak ada data'
            );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getTop()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getBottom()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getLeft()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getRight()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getVertical()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getStyle("A{$row}:D{$row}")
                ->getBorders()
                ->getHorizontal()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $row++;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalRow = $row;

        /*
        | A sampai C digabung.
        */

        $sheet->mergeCells(
            "A{$totalRow}:C{$totalRow}"
        );

        $sheet->setCellValue(
            "A{$totalRow}",
            'Total'
        );

        $sheet->setCellValue(
            "D{$totalRow}",
            $totalPendapatan
        );

        /*
        |--------------------------------------------------------------------------
        | Background abu-abu
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getFill()
            ->getStartColor()
            ->setARGB(
                'FFD9D9D9'
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getFont()
            ->setBold(true);

        /*
        |--------------------------------------------------------------------------
        | Border total
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getBorders()
            ->getTop()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getBorders()
            ->getRight()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getBorders()
            ->getVertical()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getStyle(
                "A{$totalRow}:D{$totalRow}"
            )
            ->getBorders()
            ->getHorizontal()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        /*
        |--------------------------------------------------------------------------
        | Alignment total
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle("A{$totalRow}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle("D{$totalRow}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle("D{$totalRow}")
            ->getNumberFormat()
            ->setFormatCode(
                '#,##0'
            );

        $sheet
            ->getRowDimension($totalRow)
            ->setRowHeight(20);

        /*
        |--------------------------------------------------------------------------
        | NOMOR DOKUMEN OTOMATIS
        |--------------------------------------------------------------------------
        */

        $tanggalDokumen = now()->toDateString();

        $nomorDokumen = NomorDokumenLaporan::buatNomor(
            $tanggalDokumen
        );

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        $documentRow = $totalRow + 2;

        /*
        |--------------------------------------------------------------------------
        | Nomor dokumen
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            "A{$documentRow}",
            $nomorDokumen
        );

        $sheet
            ->getStyle("A{$documentRow}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            "D{$documentRow}",
            'Admin'
        );

        $sheet
            ->getStyle("D{$documentRow}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getRowDimension($documentRow)
            ->setRowHeight(20);

        /*
        |--------------------------------------------------------------------------
        | Print
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getPageSetup()
            ->setFitToWidth(1);

        $sheet
            ->getPageSetup()
            ->setFitToHeight(0);

        /*
        |--------------------------------------------------------------------------
        | Nama file
        |--------------------------------------------------------------------------
        */

        $filename =
            'Laporan-Per-Petugas-' .
            (
                $this->tanggal !== ''
                    ? Carbon::parse(
                        $this->tanggal
                    )->format('d-m-Y')
                    : now()->format('d-m-Y')
            ) .
            '.xlsx';

        /*
        |--------------------------------------------------------------------------
        | Download
        |--------------------------------------------------------------------------
        */

        $writer = new Xlsx(
            $spreadsheet
        );

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save(
                    'php://output'
                );
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                'Cache-Control' =>
                    'max-age=0',

                'Pragma' =>
                    'public',
            ]
        );
    }
}