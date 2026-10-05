<?php

namespace App\Filament\Pages;

use App\Models\NomorDokumenLaporan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Pages\Page;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use UnitEnum;

class PenjualanPerItem extends Page
{
    protected static ?string $title = 'Penjualan by Menu';

    protected static ?string $navigationLabel = 'Penjualan by Item';

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.penjualan-per-item';

    public string $tanggalAwal = '';

    public string $tanggalAkhir = '';

    public function mount(): void
    {
        $hariIni = now()->toDateString();

        $this->tanggalAwal = $hariIni;
        $this->tanggalAkhir = $hariIni;
    }

    public function tampilkanData(): void
    {
        // Filter langsung membaca nilai tanggal terbaru.
    }

    public function getLaporanProperty()
    {
        return Tarif::query()
            /*
            |--------------------------------------------------------------------------
            | Urutkan berdasarkan nama tarif secara alfabetis
            |--------------------------------------------------------------------------
            */
            ->orderBy('nama_tarif', 'asc')
            ->get()
            ->map(function (Tarif $tarif) {
                $query = Transaksi::query()
                    ->where(
                        'id_tarif',
                        $tarif->id_tarif
                    )
                    ->where(
                        'status',
                        'berhasil'
                    );

                if ($this->tanggalAwal) {
                    $query->whereDate(
                        'tanggal_transaksi',
                        '>=',
                        $this->tanggalAwal
                    );
                }

                if ($this->tanggalAkhir) {
                    $query->whereDate(
                        'tanggal_transaksi',
                        '<=',
                        $this->tanggalAkhir
                    );
                }

                return [
                    'id_tarif' => $tarif->id_tarif,
                    'nama_tarif' => $tarif->nama_tarif,
                    'kategori' => $tarif->kategori,
                    'harga' => (float) $tarif->harga,
                    'qty' => (int) $query->sum('jumlah'),
                    'total' => (float) $query->sum('total'),
                ];
            });
    }

    public function getTotalQtyProperty(): int
    {
        return (int) $this->laporan->sum('qty');
    }

    public function getTotalKeseluruhanProperty(): float
    {
        return (float) $this->laporan->sum('total');
    }

    public function exportExcel(): StreamedResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data laporan sesuai periode
        |--------------------------------------------------------------------------
        */

        $laporan = $this->laporan;

        /*
        |--------------------------------------------------------------------------
        | Buat spreadsheet
        |--------------------------------------------------------------------------
        */

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle(
            'Penjualan by Menu'
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
            ->setWidth(32);

        $sheet
            ->getColumnDimension('C')
            ->setWidth(15);

        $sheet
            ->getColumnDimension('D')
            ->setWidth(10);

        $sheet
            ->getColumnDimension('E')
            ->setWidth(16);

        /*
        |--------------------------------------------------------------------------
        | Font dasar
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:E200')
            ->getFont()
            ->setName('Arial')
            ->setSize(10);

        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A1:E1'
        );

        $sheet->setCellValue(
            'A1',
            'Laporan Penjualan by Menu'
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
        | SUBJUDUL
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            'A4:E4'
        );

        $sheet->setCellValue(
            'A4',
            'Penjualan by Menu'
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
            'A5:E5'
        );

        $sheet->setCellValue(
            'A5',
            'Periode Tanggal : '
            . $tanggalAwal
            . ' — '
            . $tanggalAkhir
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
        | JARAK SEBELUM TABEL
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
            'Nama Item'
        );

        $sheet->setCellValue(
            "C{$headerRow}",
            'Harga Item'
        );

        $sheet->setCellValue(
            "D{$headerRow}",
            'Qty'
        );

        $sheet->setCellValue(
            "E{$headerRow}",
            'TOTAL'
        );

        $headerStyle = $sheet->getStyle(
            "A{$headerRow}:E{$headerRow}"
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
        | Tulisan HEADER HITAM
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
        | BORDER HEADER
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

        $row = 8;

        $totalQty = 0;

        $totalKeseluruhan = 0;

        foreach ($laporan as $index => $item) {

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
                $item['nama_tarif']
            );

            $sheet->setCellValue(
                "C{$row}",
                (float) $item['harga']
            );

            $sheet->setCellValue(
                "D{$row}",
                (int) $item['qty']
            );

            $sheet->setCellValue(
                "E{$row}",
                (float) $item['total']
            );

            /*
            |--------------------------------------------------------------------------
            | BORDER SETIAP SEL
            |--------------------------------------------------------------------------
            */

            $dataStyle = $sheet->getStyle(
                "A{$row}:E{$row}"
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
            | ALIGNMENT
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
                    Alignment::HORIZONTAL_RIGHT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("D{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle("E{$row}")
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_RIGHT
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            /*
            |--------------------------------------------------------------------------
            | FORMAT ANGKA
            |--------------------------------------------------------------------------
            */

            $sheet
                ->getStyle("C{$row}")
                ->getNumberFormat()
                ->setFormatCode(
                    '#,##0'
                );

            $sheet
                ->getStyle("D{$row}")
                ->getNumberFormat()
                ->setFormatCode(
                    '#,##0'
                );

            $sheet
                ->getStyle("E{$row}")
                ->getNumberFormat()
                ->setFormatCode(
                    '#,##0'
                );

            $sheet
                ->getRowDimension($row)
                ->setRowHeight(20);

            /*
            |--------------------------------------------------------------------------
            | Total
            |--------------------------------------------------------------------------
            */

            $totalQty += (int) $item['qty'];

            $totalKeseluruhan +=
                (float) $item['total'];

            $row++;
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA DATA KOSONG
        |--------------------------------------------------------------------------
        */

        if ($laporan->isEmpty()) {

            $sheet->setCellValue(
                "A{$row}",
                '-'
            );

            $sheet->mergeCells(
                "B{$row}:E{$row}"
            );

            $sheet->setCellValue(
                "B{$row}",
                'Tidak ada data penjualan.'
            );

            $emptyStyle = $sheet->getStyle(
                "A{$row}:E{$row}"
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

            $row++;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL KESELURUHAN
        |--------------------------------------------------------------------------
        */

        $totalRow = $row;

        /*
        |--------------------------------------------------------------------------
        | A sampai C digabung
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells(
            "A{$totalRow}:C{$totalRow}"
        );

        $sheet->setCellValue(
            "A{$totalRow}",
            'Total Keseluruhan'
        );

        $sheet->setCellValue(
            "D{$totalRow}",
            $totalQty
        );

        $sheet->setCellValue(
            "E{$totalRow}",
            $totalKeseluruhan
        );

        $totalStyle = $sheet->getStyle(
            "A{$totalRow}:E{$totalRow}"
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
        | BORDER TOTAL
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
            ->getStyle("D{$totalRow}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle("E{$totalRow}")
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
            ->getStyle("E{$totalRow}")
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
        | Menggunakan tanggal saat tombol Export ditekan,
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
            "E{$documentRow}",
            'Admin'
        );

        $sheet
            ->getStyle("E{$documentRow}")
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
            'Laporan-Penjualan-by-Menu-'
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