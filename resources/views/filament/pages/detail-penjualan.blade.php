<x-filament-panels::page>

    <style>

        /* =====================================================
           HALAMAN
        ====================================================== */

        .detail-page {
            width: 100%;
        }


        /* =====================================================
           FILTER
        ====================================================== */

        .detail-filter-card {
            width: 100%;

            background: #ffffff;

            border-top:
                3px solid
                #2563eb;

            border-radius: 8px;

            padding: 20px;

            margin-bottom: 20px;

            box-sizing: border-box;
        }

        .detail-filter-grid {
            display: grid;

            grid-template-columns:
                1fr
                1fr
                1.2fr
                auto
                auto;

            gap: 14px;

            align-items: end;
        }

        .detail-filter-item {
            min-width: 0;
        }

        .detail-filter-item label {
            display: block;

            margin-bottom: 7px;

            color: #374151;

            font-size: 14px;

            font-weight: 600;
        }

        .detail-filter-item input,
        .detail-filter-item select {
            width: 100%;

            height: 42px;

            padding:
                0
                12px;

            border:
                1px solid
                #d1d5db;

            border-radius: 6px;

            background: #ffffff;

            color: #111827;

            font-size: 14px;

            box-sizing: border-box;

            outline: none;
        }

        .detail-filter-item input:focus,
        .detail-filter-item select:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 1px #2563eb;
        }


        /* =====================================================
           BUTTON
        ====================================================== */

        .detail-btn {
            height: 42px;

            padding:
                0
                18px;

            border: none;

            border-radius: 6px;

            color: #ffffff;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            white-space: nowrap;
        }

        .detail-btn-primary {
            background: #2563eb;
        }

        .detail-btn-primary:hover {
            background: #1d4ed8;
        }

        .detail-btn-success {
            background: #16a34a;
        }

        .detail-btn-success:hover {
            background: #15803d;
        }


        /* =====================================================
           SATU KESATUAN LAPORAN

           Garis biru dibuat sama seperti Filter:
           border-top: 3px solid #2563eb
        ====================================================== */

        .detail-report-section {
            --report-side-gap: 24px;

            width: 100%;

            background: #ffffff;

            border-top:
                3px solid
                #2563eb;

            border-radius: 8px;

            padding:
                0
                var(--report-side-gap)
                18px
                var(--report-side-gap);

            margin: 0;

            box-sizing: border-box;
        }


        /* =====================================================
           HEADER LAPORAN
        ====================================================== */

        .detail-report-header {
            width: 100%;

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding:
                13px
                0
                12px
                0;

            margin: 0;

            gap: 20px;

            box-sizing: border-box;
        }

        .detail-report-title {
            color: #111827;

            font-size: 20px;

            font-weight: 600;

            white-space: nowrap;
        }

        .detail-report-info {
            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 6px;

            color: #6b7280;

            font-size: 14px;

            flex-wrap: wrap;

            text-align: right;
        }

        .detail-report-info-label {
            color: #6b7280;

            font-weight: 400;

            white-space: nowrap;
        }

        .detail-report-info-value {
            display: inline-block;

            padding:
                3px
                8px;

            background: #ffd6d690;

            color: #dc2626;

            border-radius: 5px;

            font-weight: 600;

            line-height: 1.4;

            white-space: nowrap;
        }

        .detail-report-separator {
            color: #9ca3af;

            margin:
                0
                2px;
        }


        /* =====================================================
           TOOLBAR
        ====================================================== */

        .detail-toolbar {
            width: 100%;

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding:
                8px
                0
                12px
                0;

            margin: 0;

            box-sizing: border-box;
        }

        .detail-per-page {
            display: flex;

            align-items: center;

            gap: 8px;

            color: #374151;

            font-size: 14px;
        }

        .detail-per-page select {
            height: 36px;

            min-width: 80px;

            border:
                1px solid
                #d1d5db;

            border-radius: 6px;

            padding:
                0
                8px;

            background: #ffffff;

            color: #374151;

            outline: none;
        }

        .detail-per-page select:focus {
            border-color: #2563eb;
        }

        .detail-search {
            width: 240px;

            height: 38px;

            border:
                1px solid
                #d1d5db;

            border-radius: 6px;

            padding:
                0
                12px;

            font-size: 14px;

            background: #ffffff;

            color: #111827;

            outline: none;

            box-sizing: border-box;
        }

        .detail-search:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 1px #2563eb;
        }


        /* =====================================================
           TABEL DETAIL
        ====================================================== */

        .detail-table-wrapper {
            width: 100%;

            overflow-x: auto;

            overflow-y: hidden;

            background: #ffffff;

            border:
                1px solid
                #d1d5db;

            border-radius: 8px;

            box-sizing: border-box;
        }

        .detail-table {
            width: max-content;

            min-width: 100%;

            border-collapse: collapse;

            table-layout: auto;
        }


        /* =====================================================
           HEADER TABEL
        ====================================================== */

        .detail-table thead th {
            background: #1681c4;

            color: #ffffff;

            padding:
                12px
                10px;

            font-size: 14px;

            font-weight: 700;

            text-align: center;

            border:
                1px solid
                rgba(255, 255, 255, 0.45);

            white-space: nowrap;

            vertical-align: middle;
        }

        .detail-table thead th:first-child {
            border-top-left-radius: 7px;
        }

        .detail-table thead th:last-child {
            border-top-right-radius: 7px;
        }


        /* =====================================================
           ISI TABEL
        ====================================================== */

        .detail-table tbody td {
            padding:
                11px
                10px;

            border:
                1px solid
                #d1d5db;

            color: #374151;

            font-size: 13px;

            vertical-align: middle;

            background: #ffffff;

            white-space: nowrap;
        }

        .detail-table tbody tr:hover td {
            background: #f8fafc;
        }


        /* =====================================================
           BARIS RINGKASAN PER LOKASI
        ====================================================== */

        .detail-location-summary td {
            background: #e5e7eb !important;

            color: #374151 !important;

            border-top:
                1px solid
                #c7cbd1 !important;

            border-bottom:
                1px solid
                #c7cbd1 !important;

            border-left:
                1px solid
                #d1d5db !important;

            border-right:
                1px solid
                #d1d5db !important;

            padding:
                10px
                12px !important;

            font-size: 13px !important;

            font-weight: 600 !important;

            vertical-align: middle !important;
        }

        .detail-location-summary-main {
            text-align: left !important;

            white-space: nowrap;
        }

        .detail-location-summary-qty {
            min-width: 100px;

            text-align: right !important;

            white-space: nowrap;
        }

        .detail-location-summary-income {
            min-width: 150px;

            text-align: right !important;

            white-space: nowrap;
        }


        /* =====================================================
           TOTAL KESELURUHAN

           HANYA MUNCUL SAAT SEMUA LOKASI
        ====================================================== */

        .detail-grand-total td {
            background: #e5e7eb !important;

            color: #374151 !important;

            border-top:
                1px solid
                #c7cbd1 !important;

            border-bottom:
                1px solid
                #c7cbd1 !important;

            padding:
                10px
                12px !important;

            font-size: 13px !important;

            font-weight: 700 !important;

            vertical-align: middle !important;
        }

        /*
         * Bagian kosong sebelum tulisan
         * Total keseluruhan tidak mempunyai
         * garis vertikal di antara kolom.
         */
        .detail-grand-total-empty {
            background: #e5e7eb !important;

            border-left:
                1px solid
                #d1d5db !important;

            border-right:
                none !important;

            border-top:
                1px solid
                #c7cbd1 !important;

            border-bottom:
                1px solid
                #c7cbd1 !important;
        }

        /*
         * Tulisan Total keseluruhan berada
         * pada kolom Tanggal.
         */
        .detail-grand-total-title {
            text-align: right !important;

            white-space: nowrap;

            border-left:
                none !important;

            border-right:
                1px solid
                #d1d5db !important;
        }

        /*
         * Total seluruh item.
         */
        .detail-grand-total-qty {
            min-width: 100px;

            text-align: right !important;

            white-space: nowrap;

            border-left:
                1px solid
                #d1d5db !important;
        }

        /*
         * Total seluruh pendapatan.
         */
        .detail-grand-total-income {
            min-width: 150px;

            text-align: right !important;

            white-space: nowrap;

            border-left:
                1px solid
                #d1d5db !important;
        }


        /* =====================================================
           NO
        ====================================================== */

        .detail-no {
            width: 55px;

            min-width: 55px;

            text-align: center !important;

            white-space: nowrap;
        }


        /* =====================================================
           LOKASI
        ====================================================== */

        .detail-table th:nth-child(2),
        .detail-table td:nth-child(2) {
            width: auto;

            min-width: 140px;

            max-width: 220px;
        }


        /* =====================================================
           PETUGAS
        ====================================================== */

        .detail-table th:nth-child(3),
        .detail-table td:nth-child(3) {
            width: auto;

            min-width: 170px;

            max-width: 230px;
        }


        /* =====================================================
           KODE TRX
        ====================================================== */

        .detail-table th:nth-child(4),
        .detail-table td:nth-child(4) {
            width: auto;

            min-width: 190px;

            white-space: nowrap;
        }


        /* =====================================================
           TANGGAL
        ====================================================== */

        .detail-table th:nth-child(5),
        .detail-table td:nth-child(5) {
            width: auto;

            min-width: 125px;
        }

        .detail-date {
            min-width: 125px;

            white-space: nowrap;
        }

        .detail-date-time {
            margin-top: 3px;

            color: #dc2626;

            font-size: 13px;
        }


        /* =====================================================
           ITEM
           
           HEADER = TENGAH
           ISI = KIRI
        ====================================================== */

        .detail-table th:nth-child(6) {
            width: auto;

            min-width: 100px;

            text-align: center !important;

            white-space: nowrap;
        }

        .detail-table td:nth-child(6) {
            width: auto;

            min-width: 100px;

            text-align: left !important;

            white-space: nowrap;
        }


        /* =====================================================
           PENDAPATAN

           HEADER = TENGAH
           ISI = KANAN
        ====================================================== */

        .detail-table th:nth-child(7) {
            width: auto;

            min-width: 120px;

            text-align: center !important;

            white-space: nowrap;
        }

        .detail-table td:nth-child(7) {
            width: auto;

            min-width: 120px;

            text-align: right !important;

            white-space: nowrap;
        }

        .detail-income {
            min-width: 120px;

            white-space: nowrap;

            text-align: right !important;

            font-weight: 600;
        }


        /* =====================================================
           DATA KOSONG
        ====================================================== */

        .detail-empty {
            padding:
                35px
                20px !important;

            text-align: center !important;

            color: #6b7280 !important;
        }


        /* =====================================================
           PAGINATION
        ====================================================== */

        .detail-pagination {
            width: 100%;

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding:
                14px
                0
                0
                0;

            margin: 0;

            background: #ffffff;

            gap: 20px;

            box-sizing: border-box;
        }

        .detail-showing {
            color: #666666;

            font-size: 13px;

            white-space: nowrap;

            padding: 0;
        }

        .detail-showing strong {
            color: #374151;

            font-weight: 600;
        }

        .detail-pagination-buttons {
            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 4px;

            padding: 0;
        }

        .detail-pagination-button {
            min-width: 34px;

            height: 34px;

            padding:
                0
                9px;

            border:
                1px solid
                #d1d5db;

            border-radius: 4px;

            background: #ffffff;

            color: #374151;

            font-size: 13px;

            cursor: pointer;
        }

        .detail-pagination-button:hover:not(:disabled) {
            background: #f3f4f6;
        }

        .detail-pagination-button.active {
            background: #1681c4;

            border-color: #1681c4;

            color: #ffffff;
        }

        .detail-pagination-button:disabled {
            color: #9ca3af;

            background: #ffffff;

            cursor: not-allowed;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1100px) {

            .detail-filter-grid {
                grid-template-columns:
                    1fr
                    1fr;
            }

            .detail-filter-grid > div:nth-child(3) {
                grid-column: 1 / -1;
            }

            .detail-filter-grid > div:nth-child(4),
            .detail-filter-grid > div:nth-child(5) {
                width: 100%;
            }

            .detail-btn {
                width: 100%;
            }

            .detail-report-header {
                align-items: flex-start;

                gap: 10px;
            }

            .detail-report-info {
                justify-content: flex-end;
            }

        }


        @media (max-width: 768px) {

            .detail-report-section {
                --report-side-gap: 14px;

                padding:
                    0
                    var(--report-side-gap)
                    14px
                    var(--report-side-gap);
            }

            .detail-filter-grid {
                grid-template-columns: 1fr;
            }

            .detail-filter-grid > div:nth-child(3),
            .detail-filter-grid > div:nth-child(4),
            .detail-filter-grid > div:nth-child(5) {
                grid-column: auto;
            }

            .detail-btn {
                width: 100%;
            }

            .detail-report-header {
                flex-direction: column;

                align-items: flex-start;

                gap: 8px;

                padding:
                    13px
                    0
                    12px
                    0;
            }

            .detail-report-info {
                justify-content: flex-start;

                text-align: left;

                padding: 0;
            }

            .detail-toolbar {
                flex-direction: column;

                align-items: stretch;

                gap: 10px;

                padding:
                    8px
                    0
                    12px
                    0;
            }

            .detail-search {
                width: 100%;
            }

            .detail-pagination {
                flex-direction: column;

                align-items: flex-start;

                padding:
                    14px
                    0
                    0
                    0;
            }

            .detail-pagination-buttons {
                align-self: flex-end;
            }

        }

    </style>


    <div class="detail-page">


        {{-- =====================================================
             FILTER
        ====================================================== --}}

        <div class="detail-filter-card">

            <div class="detail-filter-grid">


                {{-- TANGGAL --}}

                <div class="detail-filter-item">

                    <label for="tanggalAwal">
                        Tanggal
                    </label>

                    <input
                        id="tanggalAwal"
                        type="date"
                        wire:model="tanggalAwal"
                    >

                </div>


                {{-- SAMPAI --}}

                <div class="detail-filter-item">

                    <label for="tanggalAkhir">
                        Sampai
                    </label>

                    <input
                        id="tanggalAkhir"
                        type="date"
                        wire:model="tanggalAkhir"
                    >

                </div>


                {{-- LOKASI --}}

                <div class="detail-filter-item">

                    <label for="lokasi">
                        Lokasi
                    </label>

                    <select
                        id="lokasi"
                        wire:model="lokasi"
                    >

                        <option value="">
                            - Semua Lokasi -
                        </option>

                        @foreach ($this->lokasiOptions as $id => $nama)

                            <option value="{{ $id }}">
                                {{ $nama }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TAMPIL DATA --}}

                <div>

                    <button
                        type="button"
                        wire:click="tampilkanData"
                        class="detail-btn detail-btn-primary"
                    >
                        Tampil Data
                    </button>

                </div>


                {{-- EXPORT --}}

                <div>

                    <button
                        type="button"
                        wire:click="exportExcel"
                        class="detail-btn detail-btn-success"
                    >
                        Export ke Excel
                    </button>

                </div>


            </div>

        </div>


        {{-- =====================================================
             SATU KESATUAN LAPORAN
        ====================================================== --}}

        <div class="detail-report-section">


            {{-- =================================================
                 HEADER LAPORAN
            ================================================== --}}

            <div class="detail-report-header">


                {{-- JUDUL --}}

                <div class="detail-report-title">
                    Laporan Detail Penjualan
                </div>


                {{-- LOKASI + TANGGAL FILTER --}}

                <div class="detail-report-info">


                    {{-- LOKASI --}}

                    <span class="detail-report-info-label">
                        Lokasi:
                    </span>

                    <span class="detail-report-info-value">

                        @if ($lokasi)

                            {{ $this->lokasiOptions[$lokasi] ?? '-' }}

                        @else

                            Semua Lokasi

                        @endif

                    </span>


                    <span class="detail-report-separator">
                        |
                    </span>


                    {{-- TANGGAL --}}

                    <span class="detail-report-info-label">
                        Tanggal:
                    </span>

                    <span class="detail-report-info-value">

                        @if ($tanggalAwal && $tanggalAkhir)

                            @if ($tanggalAwal === $tanggalAkhir)

                                {{
                                    \Carbon\Carbon::parse(
                                        $tanggalAwal
                                    )->format('d-m-Y')
                                }}

                            @else

                                {{
                                    \Carbon\Carbon::parse(
                                        $tanggalAwal
                                    )->format('d-m-Y')
                                }}

                                -

                                {{
                                    \Carbon\Carbon::parse(
                                        $tanggalAkhir
                                    )->format('d-m-Y')
                                }}

                            @endif

                        @elseif ($tanggalAwal)

                            {{
                                \Carbon\Carbon::parse(
                                    $tanggalAwal
                                )->format('d-m-Y')
                            }}

                        @else

                            -

                        @endif

                    </span>


                </div>

            </div>


            {{-- =================================================
                 TOOLBAR
            ================================================== --}}

            <div class="detail-toolbar">


                {{-- RECORD PER PAGE --}}

                <div class="detail-per-page">

                    <select wire:model="perPage">

                        <option value="25">
                            25 baris
                        </option>

                        <option value="50">
                            50 baris
                        </option>

                        <option value="100">
                            100 baris
                        </option>

                    </select>

                    <span>
                        records per page
                    </span>

                </div>


                {{-- SEARCH --}}

                <div>

                    <input
                        type="text"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Search..."
                        class="detail-search"
                    >

                </div>


            </div>


            {{-- =================================================
                 TABLE
            ================================================== --}}

            <div class="detail-table-wrapper">

                <table class="detail-table">


                    {{-- =============================================
                         HEADER
                    ============================================== --}}

                    <thead>

                        <tr>

                            <th class="detail-no">
                                No
                            </th>

                            <th>
                                Lokasi
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th>
                                Kode TRX
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Item
                            </th>

                            <th>
                                Pendapatan
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | KELOMPOKKAN DATA BERDASARKAN LOKASI
                            |--------------------------------------------------------------------------
                            */

                            $kelompokLokasi = $this->transaksis
                                ->getCollection()
                                ->groupBy(function ($transaksi) {

                                    return
                                        $transaksi
                                            ->shift
                                            ?->loket
                                            ?->dermaga
                                            ?->id_dermaga
                                        ?? 0;

                                });

                        @endphp


                        @forelse (
                            $kelompokLokasi
                            as $idDermaga => $transaksiLokasi
                        )


                            {{-- =============================================
                                 DATA RINGKASAN LOKASI
                            ============================================== --}}

                            @php

                                $transaksiPertama =
                                    $transaksiLokasi->first();

                                $namaLokasi =
                                    $transaksiPertama
                                        ->shift
                                        ?->loket
                                        ?->dermaga
                                        ?->nama_dermaga
                                    ?? '-';

                                $ringkasanLokasi =
                                    $this->ringkasanLokasi[$idDermaga]
                                    ?? [
                                        'qty' => 0,
                                        'pendapatan' => 0,
                                    ];

                                $totalQtyLokasi =
                                    $ringkasanLokasi['qty'];

                                $totalPendapatanLokasi =
                                    $ringkasanLokasi['pendapatan'];

                            @endphp


                            {{-- =============================================
                                 BARIS ABU-ABU LOKASI
                            ============================================== --}}

                            <tr class="detail-location-summary">


                                {{-- LOKASI --}}

                                <td
                                    colspan="5"
                                    class="detail-location-summary-main"
                                >

                                    Lokasi:
                                    ({{ $namaLokasi }})

                                </td>


                                {{-- QTY --}}

                                <td
                                    class="detail-location-summary-qty"
                                >

                                    {{
                                        number_format(
                                            $totalQtyLokasi,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>


                                {{-- PENDAPATAN --}}

                                <td
                                    class="detail-location-summary-income"
                                >

                                    Rp

                                    {{
                                        number_format(
                                            $totalPendapatanLokasi,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>


                            </tr>


                            {{-- =============================================
                                 DATA TRANSAKSI
                            ============================================== --}}

                            @foreach (
                                $transaksiLokasi
                                as $transaksi
                            )


                                @php

                                    $posisi =
                                        $this->transaksis
                                            ->getCollection()
                                            ->search(
                                                fn ($item) =>
                                                    $item->id_transaksi
                                                    ===
                                                    $transaksi->id_transaksi
                                            );

                                    $nomor =
                                        ($this->transaksis->firstItem() ?? 1)
                                        + $posisi;

                                @endphp


                                <tr>


                                    {{-- NO --}}

                                    <td class="detail-no">

                                        {{ $nomor }}

                                    </td>


                                    {{-- LOKASI --}}

                                    <td>

                                        {{
                                            $transaksi
                                                ->shift
                                                ?->loket
                                                ?->dermaga
                                                ?->nama_dermaga
                                            ?? '-'
                                        }}

                                    </td>


                                    {{-- PETUGAS --}}

                                    <td>

                                        {{
                                            $transaksi
                                                ->shift
                                                ?->user
                                                ?->nama
                                            ?? '-'
                                        }}

                                    </td>


                                    {{-- KODE TRX --}}

                                    <td>

                                        {{
                                            $transaksi->kode_transaksi
                                            ?? '-'
                                        }}

                                    </td>


                                    {{-- TANGGAL --}}

                                    <td class="detail-date">

                                        @if (
                                            $transaksi->tanggal_transaksi
                                        )

                                            <div>

                                                {{
                                                    $transaksi
                                                        ->tanggal_transaksi
                                                        ->format('d F Y')
                                                }}

                                            </div>


                                            <div
                                                class="detail-date-time"
                                            >

                                                {{
                                                    $transaksi
                                                        ->tanggal_transaksi
                                                        ->format('H:i:s')
                                                }}

                                            </div>

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- ITEM → RATA KIRI --}}

                                    <td>

                                        {{
                                            $transaksi
                                                ->tarif
                                                ?->nama_tarif
                                            ?? '-'
                                        }}

                                    </td>


                                    {{-- PENDAPATAN → RATA KANAN --}}

                                    <td class="detail-income">

                                        Rp

                                        {{
                                            number_format(
                                                (float)
                                                $transaksi->total,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}

                                    </td>


                                </tr>


                            @endforeach


                        @empty


                            <tr>

                                <td
                                    colspan="7"
                                    class="detail-empty"
                                >

                                    Tidak ada data penjualan.

                                </td>

                            </tr>


                        @endforelse


                        {{-- =================================================
                             TOTAL KESELURUHAN

                             HANYA MUNCUL SAAT SEMUA LOKASI
                        ================================================== --}}

                        @if (
                            !$lokasi &&
                            $this->transaksis->total() > 0
                        )

                            <tr class="detail-grand-total">

                                {{-- KOLOM 1 - 4 --}}

                                <td
                                    colspan="4"
                                    class="detail-grand-total-empty"
                                >
                                </td>


                                {{-- TOTAL KESELURUHAN --}}

                                <td class="detail-grand-total-title">

                                    Total keseluruhan

                                </td>


                                {{-- TOTAL ITEM --}}

                                <td class="detail-grand-total-qty">

                                    {{
                                        number_format(
                                            $this->totalQtyKeseluruhan,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>


                                {{-- TOTAL PENDAPATAN --}}

                                <td class="detail-grand-total-income">

                                    Rp

                                    {{
                                        number_format(
                                            $this->totalPendapatanKeseluruhan,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>

                            </tr>

                        @endif


                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 SHOWING + PAGINATION
            ================================================== --}}

            <div class="detail-pagination">


                {{-- SHOWING --}}

                <div class="detail-showing">

                    Showing

                    <strong>
                        {{ $this->transaksis->firstItem() ?? 0 }}
                    </strong>

                    to

                    <strong>
                        {{ $this->transaksis->lastItem() ?? 0 }}
                    </strong>

                    of

                    <strong>
                        {{ $this->transaksis->total() }}
                    </strong>

                    entries

                </div>


                {{-- PAGINATION --}}

                <div class="detail-pagination-buttons">


                    {{-- PREVIOUS --}}

                    <button
                        type="button"
                        class="detail-pagination-button"
                        wire:click="previousPage"
                        @disabled(
                            $this->transaksis->onFirstPage()
                        )
                    >

                        Previous

                    </button>


                    {{-- NOMOR HALAMAN --}}

                    @for (
                        $page = 1;
                        $page <= $this->transaksis->lastPage();
                        $page++
                    )

                        <button
                            type="button"
                            class="detail-pagination-button {{
                                $page === $this->transaksis->currentPage()
                                    ? 'active'
                                    : ''
                            }}"
                            wire:click="gotoPage({{ $page }})"
                        >

                            {{ $page }}

                        </button>

                    @endfor


                    {{-- NEXT --}}

                    <button
                        type="button"
                        class="detail-pagination-button"
                        wire:click="nextPage"
                        @disabled(
                            !$this->transaksis->hasMorePages()
                        )
                    >

                        Next

                    </button>


                </div>

            </div>


        </div>


    </div>

</x-filament-panels::page>