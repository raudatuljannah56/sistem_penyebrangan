<x-filament-panels::page>

    <style>

        /* =========================================================
         * HALAMAN
         * ========================================================= */

        .history-page {
            width: 100%;
        }


        /* =========================================================
         * FILTER TANGGAL
         * ========================================================= */

        .history-filter {
            width: 100%;
            margin-bottom: 18px;
        }

        .history-filter-grid {
            display: grid;

            grid-template-columns:
                minmax(220px, 1fr)
                minmax(220px, 1fr)
                auto;

            gap: 14px;

            align-items: end;
        }

        .history-filter-item {
            display: flex;

            flex-direction: column;
        }

        .history-filter-item label {
            margin-bottom: 6px;

            font-size: 14px;

            font-weight: 600;

            color: #374151;
        }

        .history-filter-item input {
            width: 100%;

            height: 40px;

            padding: 0 10px;

            border: 1px solid #cbd5e1;

            border-radius: 5px;

            background: #ffffff;

            color: #374151;

            font-size: 14px;

            box-sizing: border-box;

            outline: none;
        }

        .history-filter-item input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 1px #2563eb;
        }


        /* =========================================================
         * TOMBOL TAMPIL DATA
         * ========================================================= */

        .history-submit {
            height: 40px;

            padding: 0 18px;

            border: none;

            border-radius: 5px;

            background: #2563eb;

            color: #ffffff;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            white-space: nowrap;
        }

        .history-submit:hover {
            background: #1d4ed8;
        }


        /* =========================================================
         * TOOLBAR CUSTOM
         * ========================================================= */

        .history-toolbar {
            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 11px 14px;

            background: #ffffff;

            border: 1px solid #d1d5db;

            border-bottom: none;

            border-radius:
                9px
                9px
                0
                0;

            box-sizing: border-box;
        }


        /* =========================================================
         * RECORDS PER PAGE - ATAS
         * ========================================================= */

        .history-toolbar-left {
            display: flex;

            align-items: center;

            gap: 8px;
        }

        .history-toolbar-left label {
            font-size: 13px;

            color: #4b5563;

            white-space: nowrap;
        }

        .history-per-page {
            width: 68px;

            height: 36px;

            padding: 0 8px;

            border: 1px solid #cbd5e1;

            border-radius: 5px;

            background: #ffffff;

            color: #374151;

            font-size: 13px;

            outline: none;

            cursor: pointer;
        }


        /* =========================================================
         * SEARCH HISTORY CUSTOM
         * ========================================================= */

        .history-toolbar-right {
            width: 250px;
        }

        .history-search-wrapper {
            position: relative;

            width: 100%;
        }

        .history-search-icon {
            position: absolute;

            top: 50%;

            left: 11px;

            transform:
                translateY(-50%);

            color: #9ca3af;

            pointer-events: none;
        }

        .history-search {
            width: 100%;

            height: 38px;

            padding:
                0
                12px
                0
                36px;

            border: 1px solid #cbd5e1;

            border-radius: 6px;

            background: #ffffff;

            color: #111827;

            font-size: 13px;

            outline: none;

            box-sizing: border-box;
        }

        .history-search::placeholder {
            color: #9ca3af;
        }

        .history-search:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 1px #2563eb;
        }


        /* =========================================================
         * HILANGKAN TOOLBAR SEARCH BAWAAN FILAMENT
         * ========================================================= */

        .history-table .fi-ta-header-toolbar {
            display: none !important;
        }


        /* =========================================================
         * TABLE
         * ========================================================= */

        .history-table {
            width: 100%;
        }

        .history-table .fi-ta-ctn {
            width: 100%;

            background: #ffffff !important;

            /*
             * BORDER LUAR TABLE
             *
             * KIRI  = #d1d5db
             * KANAN = #d1d5db
             *
             * BORDER BAWAH TIDAK DIBUAT
             * KARENA GARIS BAWAH NO. 9
             * MENGGUNAKAN BORDER PADA CELL TABLE.
             */

            border-left:
                1px solid #d1d5db !important;

            border-right:
                1px solid #d1d5db !important;

            border-bottom:
                none !important;

            border-top:
                none !important;

            border-radius: 0 !important;

            overflow: hidden !important;

            box-shadow: none !important;
        }

        .history-table .fi-ta-table {
            width: 100%;

            border-radius: 0 !important;

            border-collapse: collapse !important;
        }

        .history-table .fi-ta-table tbody tr {
            border-radius: 0 !important;
        }

        .history-table .fi-ta-table tbody td {
            border-radius: 0 !important;
        }


        /* =========================================================
         * HEADER TABEL
         * ========================================================= */

        .history-table .fi-ta-table thead th {
            background: #1681c4 !important;

            color: #ffffff !important;

            border-color:
                rgba(255, 255, 255, 0.45) !important;

            font-size: 13px !important;

            font-weight: 600 !important;

            white-space: nowrap;
        }


        /* =========================================================
         * ISI TABEL
         * ========================================================= */

        .history-table .fi-ta-table tbody td {
            background: #ffffff !important;

            border-color:
                #d1d5db !important;

            color: #374151 !important;

            font-size: 13px !important;

            white-space: nowrap;
        }

        .history-table .fi-ta-table tbody tr:last-child > td {
            border-bottom:
                1px solid #d1d5db !important;
        }


        /* =========================================================
         * HOVER BARIS
         * ========================================================= */

        .history-table .fi-ta-table tbody tr:hover td {
            background: #f8fafc !important;
        }


        /* =========================================================
        * LEBAR DAN POSISI ISI KOLOM
        * ========================================================= */

        /* NO. */
        .history-table .fi-ta-table th:first-child,
        .history-table .fi-ta-table td:first-child {
            width: 50px;
            min-width: 50px;
            text-align: center !important;
        }

        .history-table .fi-ta-table td:first-child > *,
        .history-table .fi-ta-table td:first-child .fi-ta-text,
        .history-table .fi-ta-table td:first-child .fi-ta-col-wrp {
            justify-content: center !important;
            text-align: center !important;
        }


        /* KODE TRX */
        .history-table .fi-ta-table th:nth-child(2),
        .history-table .fi-ta-table td:nth-child(2) {
            min-width: 190px;
            text-align: left !important;
        }


        /* TANGGAL */
        .history-table .fi-ta-table th:nth-child(3),
        .history-table .fi-ta-table td:nth-child(3) {
            min-width: 105px;
            text-align: left !important;
        }


        /* JAM */
        .history-table .fi-ta-table th:nth-child(4),
        .history-table .fi-ta-table td:nth-child(4) {
            min-width: 90px;
            text-align: left !important;
        }


        /* TOTAL QTY */
        .history-table .fi-ta-table th:nth-child(5),
        .history-table .fi-ta-table td:nth-child(5) {
            min-width: 90px;
            text-align: center !important;
        }

        .history-table .fi-ta-table td:nth-child(5) > *,
        .history-table .fi-ta-table td:nth-child(5) .fi-ta-text,
        .history-table .fi-ta-table td:nth-child(5) .fi-ta-col-wrp {
            justify-content: center !important;
            text-align: center !important;
        }


        /* METODE PEMBAYARAN */
        .history-table .fi-ta-table th:nth-child(6),
        .history-table .fi-ta-table td:nth-child(6) {
            min-width: 145px;
            text-align: center !important;
        }

        .history-table .fi-ta-table td:nth-child(6) > *,
        .history-table .fi-ta-table td:nth-child(6) .fi-ta-text,
        .history-table .fi-ta-table td:nth-child(6) .fi-ta-col-wrp {
            justify-content: center !important;
            text-align: center !important;
        }


        /* STATUS */
        .history-table .fi-ta-table th:nth-child(7),
        .history-table .fi-ta-table td:nth-child(7) {
            min-width: 100px;
            text-align: center !important;
        }

        .history-table .fi-ta-table td:nth-child(7) > *,
        .history-table .fi-ta-table td:nth-child(7) .fi-ta-text,
        .history-table .fi-ta-table td:nth-child(7) .fi-ta-col-wrp {
            justify-content: center !important;
            text-align: center !important;
        }


        /* DISCOUNT NOMINAL */
        .history-table .fi-ta-table th:nth-child(8),
        .history-table .fi-ta-table td:nth-child(8) {
            min-width: 135px;
            text-align: right !important;
        }

        .history-table .fi-ta-table td:nth-child(8) > *,
        .history-table .fi-ta-table td:nth-child(8) .fi-ta-text,
        .history-table .fi-ta-table td:nth-child(8) .fi-ta-col-wrp {
            justify-content: flex-end !important;
            text-align: right !important;
        }


        /* TOTAL TRANSAKSI */
        .history-table .fi-ta-table th:nth-child(9),
        .history-table .fi-ta-table td:nth-child(9) {
            min-width: 145px;
            text-align: right !important;
        }

        .history-table .fi-ta-table td:nth-child(9) > *,
        .history-table .fi-ta-table td:nth-child(9) .fi-ta-text,
        .history-table .fi-ta-table td:nth-child(9) .fi-ta-col-wrp {
            justify-content: flex-end !important;
            text-align: right !important;
        }


        /* =========================================================
         * BADGE
         * ========================================================= */

        .history-table .fi-badge {
            font-size: 12px !important;

            font-weight: 600 !important;
        }


        /* =========================================================
         * HILANGKAN PAGINATION BAWAAN FILAMENT
         * ========================================================= */

        .history-table .fi-pagination {
            display: none !important;
        }


        /* =========================================================
         * PAGINATION CUSTOM
         * ========================================================= */

        .history-pagination {
            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                11px
                14px;

            background: #ffffff;

            box-sizing: border-box;

            /*
             * BORDER LUAR PAGINATION
             *
             * KIRI   = #d1d5db
             * KANAN  = #d1d5db
             * BAWAH  = #d1d5db
             *
             * ATAS TIDAK DIBUAT AGAR TIDAK DOUBLE
             * DENGAN BORDER BAWAH TABLE.
             */

            border-left:
                1px solid #d1d5db;

            border-right:
                1px solid #d1d5db;

            border-bottom:
                1px solid #d1d5db;

            border-top:
                none;

            border-radius:
                0
                0
                9px
                9px;
        }


        /* =========================================================
         * SHOWING DI KIRI
         * ========================================================= */

        .history-pagination-info {
            display: flex;

            align-items: center;

            color: #6b7280;

            font-size: 13px;

            white-space: nowrap;
        }


        /* =========================================================
         * PAGINATION DI KANAN
         * ========================================================= */

        .history-pagination-nav {
            display: flex;

            align-items: center;

            gap: 5px;
        }


        /* =========================================================
         * BUTTON PAGINATION
         * ========================================================= */

        .history-page-button {
            min-width: 40px;

            height: 36px;

            padding:
                0
                12px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border: 1px solid #d1d5db;

            border-radius: 5px;

            background: #ffffff;

            color: #374151;

            font-size: 13px;

            cursor: pointer;

            transition:
                background-color 0.15s ease,
                border-color 0.15s ease,
                color 0.15s ease;
        }

        .history-page-button:hover:not(:disabled) {
            background: #f3f4f6;
        }

        .history-page-button:disabled {
            color: #9ca3af;

            background: #ffffff;

            cursor: not-allowed;
        }


        /* =========================================================
         * HALAMAN AKTIF
         * ========================================================= */

        .history-page-button.active {
            background: #1681c4;

            border-color: #1681c4;

            color: #ffffff;
        }

        .history-page-button.active:hover {
            background: #1681c4;

            border-color: #1681c4;

            color: #ffffff;
        }


        /* =========================================================
         * RESPONSIVE
         * ========================================================= */

        @media (max-width: 900px) {

            .history-filter-grid {
                grid-template-columns:
                    1fr
                    1fr;
            }

            .history-filter-grid > div:last-child {
                grid-column: 1 / -1;
            }

            .history-submit {
                width: 100%;
            }

            .history-toolbar {
                flex-direction: column;

                align-items: stretch;

                gap: 10px;
            }

            .history-toolbar-right {
                width: 100%;
            }

            .history-pagination {
                padding:
                    11px
                    14px;
            }

        }


        @media (max-width: 640px) {

            .history-filter-grid {
                grid-template-columns: 1fr;
            }

            .history-filter-grid > div:last-child {
                grid-column: auto;
            }

            .history-submit {
                width: 100%;
            }

            .history-table {
                overflow-x: auto;
            }

            .history-table .fi-ta-ctn {
                min-width: 1050px;
            }

            .history-toolbar {
                min-width: 1050px;
            }

            .history-pagination {
                min-width: 1050px;

                padding:
                    11px
                    14px;
            }

        }

    </style>


    <div class="history-page">


        {{-- =====================================================
             FILTER TANGGAL
             ===================================================== --}}

        <div class="history-filter">

            <div class="history-filter-grid">


                <div class="history-filter-item">

                    <label for="tanggalAwal">
                        Tanggal Awal
                    </label>

                    <input
                        id="tanggalAwal"
                        type="date"
                        wire:model="tanggalAwal"
                    >

                </div>


                <div class="history-filter-item">

                    <label for="tanggalAkhir">
                        Tanggal Akhir
                    </label>

                    <input
                        id="tanggalAkhir"
                        type="date"
                        wire:model="tanggalAkhir"
                    >

                </div>


                <div>

                    <button
                        type="button"
                        wire:click="tampilkanData"
                        class="history-submit"
                    >
                        Tampil Data
                    </button>

                </div>


            </div>

        </div>


        {{-- =====================================================
             TOOLBAR CUSTOM
             ===================================================== --}}

        <div class="history-toolbar">


            {{-- RECORDS PER PAGE --}}

            <div class="history-toolbar-left">

                <select
                    class="history-per-page"
                    wire:model.live="tableRecordsPerPage"
                >

                    <option value="10">
                        5
                    </option>

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

                <label>
                    records per page
                </label>

            </div>


            {{-- SEARCH CUSTOM --}}

            <div class="history-toolbar-right">

                <div class="history-search-wrapper">


                    <span class="history-search-icon">

                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            ></circle>

                            <line
                                x1="16.5"
                                y1="16.5"
                                x2="21"
                                y2="21"
                            ></line>

                        </svg>

                    </span>


                    <input
                        type="text"
                        class="history-search"
                        placeholder="Search"
                        wire:model.live.debounce.500ms="tableSearch"
                    >

                </div>

            </div>


        </div>


        {{-- =====================================================
             TABLE
             ===================================================== --}}

        <div class="history-table">

            {{ $this->table }}

        </div>


        {{-- =====================================================
             DATA PAGINATION
             ===================================================== --}}

        @php

            $records = $this->getTableRecords();

            $total = $records->total();

            $currentPage = $records->currentPage();

            $lastPage = $records->lastPage();

            $firstItem = $records->firstItem() ?? 0;

            $lastItem = $records->lastItem() ?? 0;

        @endphp


        {{-- =====================================================
             PAGINATION CUSTOM
             ===================================================== --}}

        <div class="history-pagination">


            {{-- SHOWING --}}

            <div class="history-pagination-info">

                Showing
                {{ $firstItem }}
                to
                {{ $lastItem }}
                of
                {{ $total }}
                entries

            </div>


            {{-- PAGINATION --}}

            <div class="history-pagination-nav">


                {{-- PREVIOUS --}}

                <button
                    type="button"
                    class="history-page-button"
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    @disabled($currentPage <= 1)
                >
                    Previous
                </button>


                {{-- NOMOR HALAMAN --}}

                @for (
                    $page = 1;
                    $page <= $lastPage;
                    $page++
                )

                    <button
                        type="button"
                        class="history-page-button {{ $currentPage === $page ? 'active' : '' }}"
                        wire:click="gotoPage({{ $page }})"
                        wire:loading.attr="disabled"
                    >
                        {{ $page }}
                    </button>

                @endfor


                {{-- NEXT --}}

                <button
                    type="button"
                    class="history-page-button"
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    @disabled($currentPage >= $lastPage)
                >
                    Next
                </button>


            </div>


        </div>


    </div>

</x-filament-panels::page>