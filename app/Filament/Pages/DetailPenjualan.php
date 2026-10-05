<?php

namespace App\Filament\Pages;

use App\Models\Dermaga;
use App\Models\NomorDokumenLaporan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use UnitEnum;

class DetailPenjualan extends Page
{
    use WithPagination;

    protected static ?string $title = 'Laporan Detail Penjualan';

    protected static ?string $navigationLabel = 'Detail Penjualan';

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.detail-penjualan';

    public string $tanggalAwal = '';

    public string $tanggalAkhir = '';

    public string $lokasi = '';

    public string $search = '';

    public int $perPage = 25;

    public function mount(): void
    {
        $hariIni = now()->toDateString();

        $this->tanggalAwal = $hariIni;
        $this->tanggalAkhir = $hariIni;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function tampilkanData(): void
    {
        $this->resetPage();
    }

    protected function baseQuery(): Builder
    {
        return Transaksi::query()
            ->with([
                'shift.user',
                'shift.loket.dermaga',
                'tarif',
            ])
            ->when(
                $this->tanggalAwal,
                fn (Builder $query) =>
                    $query->whereDate(
                        'tanggal_transaksi',
                        '>=',
                        $this->tanggalAwal
                    )
            )
            ->when(
                $this->tanggalAkhir,
                fn (Builder $query) =>
                    $query->whereDate(
                        'tanggal_transaksi',
                        '<=',
                        $this->tanggalAkhir
                    )
            )
            ->when(
                $this->lokasi,
                fn (Builder $query) =>
                    $query->whereHas(
                        'shift.loket.dermaga',
                        fn (Builder $query) =>
                            $query->where(
                                'id_dermaga',
                                $this->lokasi
                            )
                    )
            )
            ->when(
                $this->search,
                function (Builder $query) {

                    $search = trim(
                        $this->search
                    );

                    $query->where(function (Builder $query) use ($search) {

                        $query
                            ->where(
                                'kode_transaksi',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhereHas(
                                'shift.user',
                                fn (Builder $query) =>
                                    $query->where(
                                        'nama',
                                        'like',
                                        "%{$search}%"
                                    )
                            )
                            ->orWhereHas(
                                'shift.loket.dermaga',
                                fn (Builder $query) =>
                                    $query->where(
                                        'nama_dermaga',
                                        'like',
                                        "%{$search}%"
                                    )
                            )
                            ->orWhereHas(
                                'tarif',
                                fn (Builder $query) =>
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
                'tanggal_transaksi',
                'desc'
            );
    }

    public function getTransaksisProperty(): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate(
            $this->perPage,
            ['*'],
            'detailPage'
        );
    }

    public function getLokasiOptionsProperty(): array
    {
        return Dermaga::query()
            ->orderBy('nama_dermaga')
            ->pluck(
                'nama_dermaga',
                'id_dermaga'
            )
            ->toArray();
    }

    public function getNamaLokasiProperty(): string
    {
        if (!$this->lokasi) {
            return 'Semua Lokasi';
        }

        return Dermaga::where(
            'id_dermaga',
            $this->lokasi
        )->value(
            'nama_dermaga'
        ) ?? 'Semua Lokasi';
    }

    public function getTotalQtyProperty(): int|float
    {
        return (clone $this->baseQuery())
            ->sum('jumlah');
    }

    public function getTotalPendapatanProperty(): float
    {
        return (float) (
            clone $this->baseQuery()
        )->sum('total');
    }

    public function getRingkasanLokasiProperty(): array
    {
        $data = (clone $this->baseQuery())
            ->get();

        return $data
            ->groupBy(
                fn ($transaksi) =>
                    $transaksi
                        ->shift
                        ?->loket
                        ?->dermaga
                        ?->id_dermaga
                    ?? 0
            )
            ->map(
                fn ($transaksiLokasi) => [
                    'qty' =>
                        $transaksiLokasi->sum(
                            fn ($transaksi) =>
                                (int) $transaksi->jumlah
                        ),

                    'pendapatan' =>
                        (float) $transaksiLokasi->sum(
                            fn ($transaksi) =>
                                (float) $transaksi->total
                        ),
                ]
            )
            ->toArray();
    }

    public function getTotalQtyKeseluruhanProperty(): int|float
    {
        return (clone $this->baseQuery())
            ->sum('jumlah');
    }

    public function getTotalPendapatanKeseluruhanProperty(): float
    {
        return (float) (
            clone $this->baseQuery()
        )->sum('total');
    }

    public function exportExcel(): StreamedResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data sesuai filter
        |--------------------------------------------------------------------------
        */

        $data = (clone $this->baseQuery())
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Buat spreadsheet
        |--------------------------------------------------------------------------
        */

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle(
            'Detail Penjualan'
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
            ->setWidth(30);

        $sheet
            ->getColumnDimension('C')
            ->setWidth(32);

        $sheet
            ->getColumnDimension('D')
            ->setWidth(28);

        $sheet
            ->getColumnDimension('E')
            ->setWidth(22);

        $sheet
            ->getColumnDimension('F')
            ->setWidth(30);

        $sheet
            ->getColumnDimension('G')
            ->setWidth(20);

        /*
        |--------------------------------------------------------------------------
        | Font dasar
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:G300')
            ->getFont()
            ->setName('Arial')
            ->setSize(10);

        /*
        |--------------------------------------------------------------------------
        | JUDUL UTAMA
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A1:G1'
        );

        $sheet->setCellValue(
            'A1',
            'Laporan Detail Penjualan'
        );

        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true)
            ->setSize(20)
            ->getColor()
            ->setARGB(
                'FF000000'
            );

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
        | JARAK
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
        | DETAIL PENJUALAN
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A4:G4'
        );

        $sheet->setCellValue(
            'A4',
            'Detail Penjualan'
        );

        $sheet
            ->getStyle('A4')
            ->getFont()
            ->setSize(11)
            ->getColor()
            ->setARGB(
                'FF000000'
            );

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
        | LOKASI
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A5:G5'
        );

        $sheet->setCellValue(
            'A5',
            'Lokasi : ' . $this->namaLokasi
        );

        $sheet
            ->getStyle('A5')
            ->getFont()
            ->setSize(10)
            ->getColor()
            ->setARGB(
                'FF000000'
            );

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
        | PERIODE TANGGAL
        |--------------------------------------------------------------------------
        */

        $tanggalAwal = $this->tanggalAwal !== ''
            ? Carbon::parse(
                $this->tanggalAwal
            )->format('d-m-Y')
            : '-';

        $tanggalAkhir = $this->tanggalAkhir !== ''
            ? Carbon::parse(
                $this->tanggalAkhir
            )->format('d-m-Y')
            : '-';

        $sheet->mergeCells(
            'A6:G6'
        );

        $sheet->setCellValue(
            'A6',
            'Periode Tanggal : '
            . $tanggalAwal
            . ' — '
            . $tanggalAkhir
        );

        $sheet
            ->getStyle('A6')
            ->getFont()
            ->setSize(10)
            ->getColor()
            ->setARGB(
                'FF000000'
            );

        $sheet
            ->getStyle('A6')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getRowDimension(6)
            ->setRowHeight(20);

        /*
        |--------------------------------------------------------------------------
        | JARAK SEBELUM TABEL
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getRowDimension(7)
            ->setRowHeight(8);

        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $headerRow = 8;

        $sheet->setCellValue(
            "A{$headerRow}",
            'No'
        );

        $sheet->setCellValue(
            "B{$headerRow}",
            'Lokasi'
        );

        $sheet->setCellValue(
            "C{$headerRow}",
            'Petugas'
        );

        $sheet->setCellValue(
            "D{$headerRow}",
            'Kode TRX'
        );

        $sheet->setCellValue(
            "E{$headerRow}",
            'Tanggal'
        );

        $sheet->setCellValue(
            "F{$headerRow}",
            'Item'
        );

        $sheet->setCellValue(
            "G{$headerRow}",
            'Pendapatan'
        );

        $headerStyle = $sheet->getStyle(
            "A{$headerRow}:G{$headerRow}"
        );

        /*
        |--------------------------------------------------------------------------
        | Background HEADER
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Font HEADER
        |--------------------------------------------------------------------------
        */

        $headerStyle
            ->getFont()
            ->setBold(true)
            ->getColor()
            ->setARGB(
                'FF000000'
            );

        /*
        |--------------------------------------------------------------------------
        | Alignment HEADER
        |--------------------------------------------------------------------------
        */

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
        | Border HEADER
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
        | DATA LAPORAN
        |--------------------------------------------------------------------------
        */

        $row = 9;

        $totalQty = 0;

        $totalPendapatan = 0;

        foreach ($data as $index => $transaksi) {

            /*
            |--------------------------------------------------------------------------
            | Isi data
            |--------------------------------------------------------------------------
            */

            $sheet->setCellValue(
                "A{$row}",
                $index + 1
            );

            $sheet->setCellValue(
                "B{$row}",
                $transaksi->shift?->loket?->dermaga?->nama_dermaga
                    ?? '-'
            );

            $sheet->setCellValue(
                "C{$row}",
                $transaksi->shift?->user?->nama
                    ?? '-'
            );

            $sheet->setCellValue(
                "D{$row}",
                $transaksi->kode_transaksi
                    ?? '-'
            );

            $tanggalTransaksi = $transaksi->tanggal_transaksi
                ? Carbon::parse(
                    $transaksi->tanggal_transaksi
                )->format('d/m/Y H:i:s')
                : '-';

            $sheet->setCellValue(
                "E{$row}",
                $tanggalTransaksi
            );

            $sheet->setCellValue(
                "F{$row}",
                $transaksi->tarif?->nama_tarif
                    ?? '-'
            );

            $sheet->setCellValue(
                "G{$row}",
                (float) $transaksi->total
            );

            /*
            |--------------------------------------------------------------------------
            | Border DATA
            |--------------------------------------------------------------------------
            */

            $dataStyle = $sheet->getStyle(
                "A{$row}:G{$row}"
            );

            $dataStyle
                ->getBorders()
                ->getTop()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $dataStyle
                ->getBorders()
                ->getBottom()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $dataStyle
                ->getBorders()
                ->getLeft()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $dataStyle
                ->getBorders()
                ->getRight()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $dataStyle
                ->getBorders()
                ->getVertical()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $dataStyle
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
                    Alignment::HORIZONTAL_LEFT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("E{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("F{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("G{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_RIGHT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            /*
            |--------------------------------------------------------------------------
            | Format Pendapatan
            |--------------------------------------------------------------------------
            */

            $sheet
                ->getStyle("G{$row}")
                ->getNumberFormat()
                ->setFormatCode(
                    '#,##0'
                );

            $sheet
                ->getRowDimension($row)
                ->setRowHeight(20);

            /*
            |--------------------------------------------------------------------------
            | Hitung Total
            |--------------------------------------------------------------------------
            */

            $totalQty +=
                (int) $transaksi->jumlah;

            $totalPendapatan +=
                (float) $transaksi->total;

            $row++;
        }

        /*
        |--------------------------------------------------------------------------
        | DATA KOSONG
        |--------------------------------------------------------------------------
        */

        if ($data->isEmpty()) {

            $sheet->mergeCells(
                "A{$row}:G{$row}"
            );

            $sheet->setCellValue(
                "A{$row}",
                'Tidak ada data penjualan.'
            );

            $emptyStyle = $sheet->getStyle(
                "A{$row}:G{$row}"
            );

            $emptyStyle
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $emptyStyle
                ->getFont()
                ->getColor()
                ->setARGB(
                    'FF6B7280'
                );

            $emptyStyle
                ->getBorders()
                ->getTop()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $emptyStyle
                ->getBorders()
                ->getBottom()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $emptyStyle
                ->getBorders()
                ->getLeft()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $emptyStyle
                ->getBorders()
                ->getRight()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $emptyStyle
                ->getBorders()
                ->getVertical()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $emptyStyle
                ->getBorders()
                ->getHorizontal()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

            $sheet
                ->getRowDimension($row)
                ->setRowHeight(25);

            $row++;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL KESELURUHAN
        |--------------------------------------------------------------------------
        */

        $totalRow = $row;

        $sheet->mergeCells(
            "A{$totalRow}:F{$totalRow}"
        );

        $sheet->setCellValue(
            "A{$totalRow}",
            'Total Keseluruhan'
        );

        $sheet->setCellValue(
            "G{$totalRow}",
            $totalPendapatan
        );

        $totalStyle = $sheet->getStyle(
            "A{$totalRow}:G{$totalRow}"
        );

        /*
        |--------------------------------------------------------------------------
        | Background TOTAL
        |--------------------------------------------------------------------------
        */

        $totalStyle
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            );

        $totalStyle
            ->getFill()
            ->getStartColor()
            ->setARGB(
                'FFD9D9D9'
            );

        /*
        |--------------------------------------------------------------------------
        | Font TOTAL
        |--------------------------------------------------------------------------
        */

        $totalStyle
            ->getFont()
            ->setBold(true)
            ->getColor()
            ->setARGB(
                'FF000000'
            );

        /*
        |--------------------------------------------------------------------------
        | Border TOTAL
        |--------------------------------------------------------------------------
        */

        $totalStyle
            ->getBorders()
            ->getTop()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $totalStyle
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $totalStyle
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $totalStyle
            ->getBorders()
            ->getRight()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $totalStyle
            ->getBorders()
            ->getVertical()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $totalStyle
            ->getBorders()
            ->getHorizontal()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        /*
        |--------------------------------------------------------------------------
        | Alignment TOTAL
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
            ->getStyle("G{$totalRow}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        /*
        |--------------------------------------------------------------------------
        | Format Total
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle("G{$totalRow}")
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
        |
        | Nomor dokumen menggunakan tanggal saat Export ditekan,
        | bukan tanggal periode laporan.
        |--------------------------------------------------------------------------
        */

        $tanggalDokumen = now()->toDateString();

        $nomorDokumen = NomorDokumenLaporan::buatNomor(
            $tanggalDokumen
        );

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        $documentRow = $totalRow + 2;

        /*
        |--------------------------------------------------------------------------
        | Nomor Dokumen
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
            "G{$documentRow}",
            'Admin'
        );

        $sheet
            ->getStyle("G{$documentRow}")
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
        | Nama File
        |--------------------------------------------------------------------------
        */

        $filename =
            'Laporan-Detail-Penjualan-'
            . (
                $this->tanggalAwal !== ''
                    ? Carbon::parse(
                        $this->tanggalAwal
                    )->format('d-m-Y')
                    : now()->format('d-m-Y')
            )
            . '-sampai-'
            . (
                $this->tanggalAkhir !== ''
                    ? Carbon::parse(
                        $this->tanggalAkhir
                    )->format('d-m-Y')
                    : now()->format('d-m-Y')
            )
            . '.xlsx';

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