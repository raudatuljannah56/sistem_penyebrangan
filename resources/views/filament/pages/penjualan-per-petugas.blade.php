<x-filament-panels::page>

    <style>
        .petugas-page {
            width: 100%;
        }

        /* =====================================================
           FILTER HALAMAN UTAMA
        ====================================================== */

        .petugas-filter-card {
            width: 100%;
            background: #ffffff;
            border-top: 3px solid #2563eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .petugas-filter-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr auto auto;
            gap: 14px;
            align-items: end;
        }

        .petugas-field {
            min-width: 0;
        }

        .petugas-field label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
        }

        .petugas-field input,
        .petugas-field select {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        .petugas-field input:focus,
        .petugas-field select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 1px #2563eb;
        }

        /* =====================================================
           BUTTON
        ====================================================== */

        .petugas-btn {
            height: 42px;
            padding: 0 18px;
            border: none;
            border-radius: 6px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .petugas-btn-primary {
            background: #2563eb;
        }

        .petugas-btn-primary:hover {
            background: #1d4ed8;
        }

        .petugas-btn-success {
            background: #16a34a;
        }

        .petugas-btn-success:hover {
            background: #15803d;
        }

        .petugas-btn-detail {
            height: 34px;
            padding: 0 14px;
            background: #16a34a;
            font-size: 13px;
        }

        .petugas-btn-detail:hover {
            background: #15803d;
        }

        /* =====================================================
           BAGIAN LAPORAN
        ====================================================== */

        .petugas-report-section {
            --report-side-gap: 24px;

            width: 100%;
            background: #ffffff;
            border-top: 3px solid #2563eb;
            border-radius: 8px;
            padding: 0 var(--report-side-gap) 18px var(--report-side-gap);
            margin: 0;
            box-sizing: border-box;
        }

        .petugas-report-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 0 12px 0;
            margin: 0;
            gap: 20px;
            box-sizing: border-box;
        }

        .petugas-report-title {
            color: #111827;
            font-size: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        .petugas-report-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            color: #6b7280;
            font-size: 14px;
            flex-wrap: wrap;
            text-align: right;
        }

        /* =====================================================
           KOTAK TANGGAL DAN NAMA PETUGAS
        ====================================================== */

        .petugas-tanggal-box,
        .petugas-nama-box {
            display: inline-block;
            background: #ffd6d690;
            color: #dc2626;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 5px;
            line-height: 1.4;
            white-space: nowrap;
        }

        .petugas-pemisah {
            color: #6b7280;
            margin: 0 3px;
        }

        /* =====================================================
           TABEL UTAMA
        ====================================================== */

        .petugas-table-wrapper {
            width: 100%;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .petugas-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .petugas-table thead th {
            height: 46px;
            padding: 10px 12px;
            background: #1681c4;
            color: #ffffff;
            border: 1px solid #d1d5db;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .petugas-table thead th:last-child {
            border-right: 1px solid #d1d5db;
        }

        .petugas-table thead th:nth-child(1) {
            width: 65px;
        }

        .petugas-table thead th:nth-child(2) {
            width: 23%;
        }

        .petugas-table thead th:nth-child(3) {
            width: 38%;
        }

        .petugas-table thead th:nth-child(4) {
            width: 21%;
        }

        .petugas-table thead th:nth-child(5) {
            width: 100px;
        }

        .petugas-table tbody td {
            padding: 14px 12px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            vertical-align: middle;
        }

        .petugas-table tbody tr:hover td {
            background: #f8fafc;
        }

        .petugas-table tbody tr:last-child td {
            border-bottom: 1px solid #d1d5db;
        }

        .petugas-no {
            text-align: center;
        }

        .petugas-date {
            text-align: center;
            white-space: nowrap;
        }

        .petugas-time {
            margin-top: 4px;
            color: #dc2626;
            font-size: 13px;
        }

        .petugas-name {
            line-height: 1.45;
        }

        .petugas-income {
            text-align: right;
            white-space: nowrap;
            font-weight: 600;
        }

        .petugas-option {
            text-align: center;
        }

        .petugas-empty {
            padding: 35px 20px !important;
            text-align: center;
            color: #6b7280 !important;
        }

        /* =====================================================
           PAGINATION HALAMAN UTAMA
        ====================================================== */

        .petugas-pagination {
            width: 100%;
            padding: 15px 0;
        }

        /* =====================================================
           MODAL DETAIL
        ====================================================== */

        .petugas-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background: rgba(0, 0, 0, 0.45);
        }

        .petugas-modal {
            width: 100%;
            max-width: 950px;
            max-height: 88vh;
            overflow-y: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        }

        /* =====================================================
           HEADER DETAIL
        ====================================================== */

        .petugas-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            border: 1px solid #d1d5db;
        }

        .petugas-modal-title {
            color: #374151;
            font-size: 18px;
            font-weight: 600;
            font-style: normal !important;
            line-height: 1.4;
        }

        .petugas-modal-title,
        .petugas-modal-title * {
            font-style: normal !important;
        }

        .petugas-modal-close {
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 25px;
            line-height: 1;
            cursor: pointer;
        }

        .petugas-modal-close:hover {
            color: #111827;
        }

        .petugas-modal-body {
            padding: 20px;
        }

        /* =====================================================
           TOOLBAR DETAIL
        ====================================================== */

        .detail-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .detail-per-page {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #374151;
            font-size: 14px;
        }

        .detail-per-page select {
            width: 80px;
            height: 36px;
            padding: 0 8px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
        }

        .detail-search-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-search-label {
            color: #555555;
            font-size: 13px;
        }

        .detail-search {
            width: 240px;
            height: 38px;
            padding: 0 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        .detail-search:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 1px #2563eb;
        }

        /* =====================================================
           TABEL DETAIL
        ====================================================== */

        .detail-table-wrapper {
            width: 100%;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        .detail-table thead th {
            height: 42px;
            padding: 10px;
            background: #1681c4;
            color: #ffffff;
            border: 1px solid #d1d5db;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            white-space: nowrap;
        }

        .detail-table thead th:first-child {
            border-top-left-radius: 7px;
        }

        .detail-table thead th:last-child {
            border-top-right-radius: 7px;
            border-right: 1px solid #d1d5db;
        }

        .detail-table tbody td {
            padding: 11px 10px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #555555;
            font-size: 13px;
            vertical-align: middle;
        }

        .detail-table tbody tr:hover td {
            background: #f8fafc;
        }

        .detail-table tbody tr:last-child td {
            border-bottom: 1px solid #d1d5db;
        }

        .detail-harga,
        .detail-total-cell {
            text-align: right !important;
            white-space: nowrap;
        }

        .detail-qty {
            text-align: center;
        }

        /* =====================================================
           TOTAL PENDAPATAN
        ====================================================== */

        .detail-total-row td {
            background: #e5e7eb !important;
            color: #374151 !important;
            font-weight: 700;
        }

        .detail-total-label {
            text-align: right !important;
        }

        .detail-total-row td:first-child {
            border-bottom-left-radius: 7px;
        }

        .detail-total-row td:last-child {
            border-bottom-right-radius: 7px;
        }

        /* =====================================================
           SHOWING + PAGINATION DETAIL
        ====================================================== */

        .detail-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0 0 0;
            gap: 20px;
        }

        .detail-showing {
            color: #666666;
            font-size: 13px;
            white-space: nowrap;
        }

        .detail-showing strong {
            color: #374151;
            font-weight: 600;
        }

        .detail-pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 4px;
        }

        .detail-pagination-button {
            min-width: 34px;
            height: 34px;
            padding: 0 9px;
            border: 1px solid #d1d5db;
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

        @media (max-width: 1000px) {
            .petugas-filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .petugas-report-header {
                align-items: flex-start;
                gap: 10px;
            }

            .petugas-report-info {
                justify-content: flex-end;
            }
        }

        @media (max-width: 700px) {
            .petugas-filter-grid {
                grid-template-columns: 1fr;
            }

            .petugas-filter-grid > div {
                grid-column: auto;
            }

            .petugas-report-section {
                --report-side-gap: 14px;
                padding: 0 var(--report-side-gap) 14px var(--report-side-gap);
            }

            .petugas-report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 13px 0 12px 0;
            }

            .petugas-report-info {
                justify-content: flex-start;
                text-align: left;
            }

            .petugas-table {
                min-width: 800px;
            }

            .detail-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .detail-search-wrapper {
                justify-content: flex-end;
            }

            .detail-search {
                width: 100%;
            }

            .detail-footer {
                flex-direction: column;
                align-items: flex-end;
            }

            .detail-showing {
                width: 100%;
                text-align: left;
            }

            .petugas-modal-overlay {
                padding: 10px;
            }

            .petugas-modal {
                max-height: 92vh;
            }
        }
    </style>


    <div class="petugas-page">

        {{-- =====================================================
             FILTER HALAMAN UTAMA
        ====================================================== --}}

        <div class="petugas-filter-card">

            <div class="petugas-filter-grid">

                <div class="petugas-field">

                    <label for="tanggal">
                        Tanggal
                    </label>

                    <input
                        id="tanggal"
                        type="date"
                        wire:model="tanggal"
                    >

                </div>


                <div class="petugas-field">

                    <label for="petugas">
                        Petugas
                    </label>

                    <select
                        id="petugas"
                        wire:model="petugas"
                    >

                        <option value="">
                            - Pilih Petugas -
                        </option>

                        @foreach ($this->petugasOptions as $item)

                            <option value="{{ $item->id_user }}">
                                {{ $item->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <button
                        type="button"
                        wire:click="tampilkanData"
                        class="petugas-btn petugas-btn-primary"
                    >
                        Tampil Data
                    </button>

                </div>


                <div>

                    <button
                        type="button"
                        wire:click="exportExcel"
                        class="petugas-btn petugas-btn-success"
                    >
                        Export ke Excel
                    </button>

                </div>

            </div>

        </div>


        {{-- =====================================================
             LAPORAN UTAMA
        ====================================================== --}}

        <div class="petugas-report-section">

            <div class="petugas-report-header">

                <div class="petugas-report-title">
                    Laporan Pendapatan Per Shift
                </div>


                <div class="petugas-report-info">

                    <span>
                        Tanggal:
                    </span>

                    <span class="petugas-tanggal-box">
                        {{
                            $tanggal
                                ? \Carbon\Carbon::parse(
                                    $tanggal
                                )->format('Y-m-d')
                                : '-'
                        }}
                    </span>


                    @if ($petugas)

                        @php
                            $petugasTerpilih =
                                $this->petugasOptions->firstWhere(
                                    'id_user',
                                    (int) $petugas
                                );
                        @endphp


                        <span class="petugas-pemisah">
                            |
                        </span>


                        <span>
                            Nama Petugas:
                        </span>

                        <span class="petugas-nama-box">
                            {{ $petugasTerpilih?->nama ?? '-' }}
                        </span>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 TABEL UTAMA
            ================================================== --}}

            <div class="petugas-table-wrapper">

                <table class="petugas-table">

                    <thead>

                        <tr>

                            <th class="petugas-no">
                                No
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th>
                                Pendapatan
                            </th>

                            <th>
                                Opsi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($this->laporan as $index => $item)

                            <tr>

                                <td class="petugas-no">

                                    {{
                                        $this->laporan->firstItem() + $index
                                    }}

                                </td>


                                <td class="petugas-date">

                                    {{
                                        \Carbon\Carbon::parse(
                                            $item->tanggal_laporan
                                        )->format('d-M-Y')
                                    }}

                                    <div class="petugas-time">

                                        {{
                                            \Carbon\Carbon::parse(
                                                $item->waktu_awal
                                            )->format('H:i:s')
                                        }}

                                        -

                                        {{
                                            \Carbon\Carbon::parse(
                                                $item->waktu_akhir
                                            )->format('H:i:s')
                                        }}

                                    </div>

                                </td>


                                <td class="petugas-name">

                                    {{ $item->nama_petugas }}

                                </td>


                                <td class="petugas-income">

                                    Rp
                                    {{
                                        number_format(
                                            (float) $item->pendapatan,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>


                                <td class="petugas-option">

                                    <button
                                        type="button"
                                        wire:click="lihatDetail(
                                            {{ $item->id_shift }},
                                            '{{ $item->tanggal_laporan }}'
                                        )"
                                        class="petugas-btn petugas-btn-detail"
                                    >
                                        Detail
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="petugas-empty"
                                >
                                    Tidak ada data penjualan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION UTAMA --}}

            <div class="petugas-pagination">

                {{ $this->laporan->links() }}

            </div>

        </div>

    </div>


    {{-- =========================================================
         DETAIL MODAL
    ========================================================== --}}

    @if ($shiftDetail)

        <div
            class="petugas-modal-overlay"
            wire:click.self="tutupDetail"
        >

            <div class="petugas-modal">

                {{-- =================================================
                     HEADER DETAIL
                ================================================== --}}

                <div class="petugas-modal-header">

                    <div class="petugas-modal-title">

                        Detail Laporan Pendapatan Petugas
                        {{ $this->detailPetugas }}

                    </div>


                    <button
                        type="button"
                        wire:click="tutupDetail"
                        class="petugas-modal-close"
                        aria-label="Tutup"
                    >
                        ×
                    </button>

                </div>


                {{-- =================================================
                     BODY DETAIL
                ================================================== --}}

                <div class="petugas-modal-body">

                    {{-- TOOLBAR --}}

                    <div class="detail-toolbar">

                        <div class="detail-per-page">

                            <select wire:model="detailPerPage">

                                <option value="10">
                                    10
                                </option>

                                <option value="25">
                                    25
                                </option>

                                <option value="50">
                                    50
                                </option>

                                <option value="100">
                                    100
                                </option>

                            </select>

                            <span>
                                records per page
                            </span>

                        </div>


                        <div class="detail-search-wrapper">

                            <span class="detail-search-label">
                                Search:
                            </span>

                            <input
                                type="text"
                                wire:model.live.debounce.400ms="detailSearch"
                                class="detail-search"
                            >

                        </div>

                    </div>


                    {{-- =================================================
                         DETAIL TABLE
                    ================================================== --}}

                    <div class="detail-table-wrapper">

                        <table class="detail-table">

                            <thead>

                                <tr>

                                    <th>
                                        Lokasi
                                    </th>

                                    <th>
                                        Item
                                    </th>

                                    <th>
                                        Harga
                                    </th>

                                    <th>
                                        Qty
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($this->detailTransaksi as $detail)

                                    <tr>

                                        <td>
                                            {{ $detail['lokasi'] }}
                                        </td>

                                        <td>
                                            {{ $detail['item'] }}
                                        </td>

                                        <td class="detail-harga">

                                            {{
                                                number_format(
                                                    $detail['harga'],
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </td>

                                        <td class="detail-qty">
                                            {{ $detail['qty'] }}
                                        </td>

                                        <td class="detail-total-cell">

                                            {{
                                                number_format(
                                                    $detail['total'],
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            style="
                                                padding: 25px;
                                                text-align: center;
                                                color: #6b7280;
                                            "
                                        >
                                            Tidak ada data.
                                        </td>

                                    </tr>

                                @endforelse


                                {{-- TOTAL PENDAPATAN --}}

                                <tr class="detail-total-row">

                                    <td
                                        colspan="4"
                                        class="detail-total-label"
                                    >
                                        Total Pendapatan
                                    </td>

                                    <td class="detail-total-cell">

                                        {{
                                            number_format(
                                                $this->detailTotal,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    {{-- =================================================
                         SHOWING + PAGINATION
                    ================================================== --}}

                    <div class="detail-footer">

                        <div class="detail-showing">

                            Showing

                            <strong>
                                {{
                                    $this->detailTransaksi->firstItem()
                                    ?? 0
                                }}
                            </strong>

                            to

                            <strong>
                                {{
                                    $this->detailTransaksi->lastItem()
                                    ?? 0
                                }}
                            </strong>

                            of

                            <strong>
                                {{
                                    $this->detailTransaksi->total()
                                }}
                            </strong>

                            entries

                        </div>


                        <div class="detail-pagination">

                            <button
                                type="button"
                                class="detail-pagination-button"
                                wire:click="previousPage('detailPage')"
                                @disabled(
                                    $this->detailTransaksi->onFirstPage()
                                )
                            >
                                Previous
                            </button>


                            @for (
                                $page = 1;
                                $page <= $this->detailTransaksi->lastPage();
                                $page++
                            )

                                <button
                                    type="button"
                                    class="detail-pagination-button {{
                                        $page ===
                                        $this->detailTransaksi->currentPage()
                                            ? 'active'
                                            : ''
                                    }}"
                                    wire:click="gotoPage(
                                        {{ $page }},
                                        'detailPage'
                                    )"
                                >
                                    {{ $page }}
                                </button>

                            @endfor


                            <button
                                type="button"
                                class="detail-pagination-button"
                                wire:click="nextPage('detailPage')"
                                @disabled(
                                    !$this->detailTransaksi->hasMorePages()
                                )
                            >
                                Next
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif

</x-filament-panels::page>