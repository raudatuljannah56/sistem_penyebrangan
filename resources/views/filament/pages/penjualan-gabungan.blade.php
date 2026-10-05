<x-filament-panels::page>

    <style>
        .gabungan-page {
            width: 100%;
        }

        /* =========================================================
           FILTER
        ========================================================= */

        .gabungan-filter-card {
            background: #ffffff;
            border-top: 3px solid #2563eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .gabungan-filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1.2fr auto auto;
            gap: 14px;
            align-items: end;
        }

        .gabungan-field {
            min-width: 0;
        }

        .gabungan-field label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
        }

        .gabungan-field input,
        .gabungan-field select {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        .gabungan-field input:focus,
        .gabungan-field select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 1px #2563eb;
        }

        /* =========================================================
           BUTTON
        ========================================================= */

        .gabungan-button {
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

        .gabungan-button-primary {
            background: #2563eb;
        }

        .gabungan-button-primary:hover {
            background: #1d4ed8;
        }

        .gabungan-button-success {
            background: #16a34a;
        }

        .gabungan-button-success:hover {
            background: #15803d;
        }

        /* =========================================================
           BAGIAN LAPORAN
        ========================================================= */

        .gabungan-report-section {
            --report-side-gap: 24px;

            width: 100%;
            background: #ffffff;
            border-top: 3px solid #2563eb;
            border-radius: 8px;
            padding: 0 var(--report-side-gap) 18px var(--report-side-gap);
            margin: 0;
            box-sizing: border-box;
        }

        .gabungan-report-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 0 12px 0;
            margin: 0;
            gap: 20px;
            box-sizing: border-box;
        }

        .gabungan-report-title {
            color: #111827;
            font-size: 20px;
            font-weight: 600;
        }

        .gabungan-report-date {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            color: #6b7280;
            font-size: 14px;
            flex-wrap: wrap;
            text-align: right;
        }

        /* =========================================================
           TANGGAL DALAM KOTAK MERAH MUDA
        ========================================================= */

        .gabungan-report-date .gabungan-tanggal-box {
            display: inline-block;
            background: #ffd6d6;
            color: #dc2626;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 5px;
            line-height: 1.3;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .gabungan-table-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .gabungan-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* =========================================================
           HEADER TABLE
        ========================================================= */

        .gabungan-table thead th {
            height: 46px;
            padding: 10px 14px;
            background: #1681c4;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.35);
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .gabungan-table thead th:first-child {
            border-top-left-radius: 7px;
        }

        .gabungan-table thead th:last-child {
            border-top-right-radius: 7px;
        }

        /* =========================================================
           LEBAR KOLOM
        ========================================================= */

        .gabungan-table thead th:nth-child(1) {
            width: 7%;
        }

        .gabungan-table thead th:nth-child(2) {
            width: 33%;
        }

        .gabungan-table thead th:nth-child(3) {
            width: 20%;
        }

        .gabungan-table thead th:nth-child(4) {
            width: 20%;
        }

        .gabungan-table thead th:nth-child(5) {
            width: 20%;
        }

        /* =========================================================
           DATA TABLE
        ========================================================= */

        .gabungan-table tbody td {
            padding: 12px 10px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            vertical-align: middle;
        }

        .gabungan-table tbody tr:hover td {
            background: #f8fafc;
        }

        /* =========================================================
           ALIGNMENT
        ========================================================= */

        .gabungan-no {
            text-align: center;
        }

        .gabungan-lokasi {
            text-align: left;
        }

        .gabungan-nominal {
            text-align: right;
            white-space: nowrap;
        }

        /* =========================================================
           TOTAL KESELURUHAN
        ========================================================= */

        .gabungan-total-row td {
            background: #e5e7eb !important;
            color: #374151 !important;
            font-weight: 700;
            border: 1px solid #d1d5db;
        }

        .gabungan-total-label {
            text-align: center !important;
        }

        .gabungan-total-row td:first-child {
            border-bottom-left-radius: 7px;
        }

        .gabungan-total-row td:last-child {
            border-bottom-right-radius: 7px;
        }

        /* =========================================================
           DATA KOSONG
        ========================================================= */

        .gabungan-empty {
            padding: 30px !important;
            text-align: center;
            color: #6b7280 !important;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {

            .gabungan-filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .gabungan-filter-grid > div:nth-child(3) {
                grid-column: 1 / -1;
            }

            .gabungan-filter-grid > div:nth-child(4),
            .gabungan-filter-grid > div:nth-child(5) {
                width: 100%;
            }

            .gabungan-button {
                width: 100%;
            }
        }

        @media (max-width: 768px) {

            .gabungan-filter-card {
                padding: 16px;
            }

            .gabungan-filter-grid {
                grid-template-columns: 1fr;
            }

            .gabungan-filter-grid > div:nth-child(3),
            .gabungan-filter-grid > div:nth-child(4),
            .gabungan-filter-grid > div:nth-child(5) {
                grid-column: auto;
            }

            .gabungan-button {
                width: 100%;
            }

            .gabungan-report-section {
                --report-side-gap: 14px;
                padding: 0 var(--report-side-gap) 14px var(--report-side-gap);
            }

            .gabungan-report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 13px 0 12px 0;
            }

            .gabungan-report-date {
                justify-content: flex-start;
                text-align: left;
                padding: 0;
            }

            .gabungan-table {
                min-width: 850px;
            }
        }
    </style>


    <div class="gabungan-page">

        {{-- =====================================================
             FILTER
        ====================================================== --}}

        <div class="gabungan-filter-card">

            <div class="gabungan-filter-grid">

                {{-- TANGGAL --}}
                <div class="gabungan-field">

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
                <div class="gabungan-field">

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
                <div class="gabungan-field">

                    <label for="lokasi">
                        Lokasi
                    </label>

                    <select
                        id="lokasi"
                        wire:model="lokasi"
                    >

                        <option value="">
                            - Pilih Lokasi -
                        </option>

                        @foreach ($this->lokasiOptions as $lokasiItem)

                            <option
                                value="{{ $lokasiItem->id_dermaga }}"
                            >
                                {{ $lokasiItem->nama_dermaga }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TAMPIL DATA --}}
                <div>

                    <button
                        type="button"
                        wire:click="tampilkanData"
                        class="gabungan-button gabungan-button-primary"
                    >
                        Tampil Data
                    </button>

                </div>


                {{-- EXPORT --}}
                <div>

                    <button
                        type="button"
                        wire:click="exportExcel"
                        class="gabungan-button gabungan-button-success"
                    >
                        Export ke Excel
                    </button>

                </div>

            </div>

        </div>


        {{-- =====================================================
             LAPORAN
        ====================================================== --}}

        <div class="gabungan-report-section">

            <div class="gabungan-report-header">

                <div class="gabungan-report-title">
                    Laporan Pendapatan Gabungan
                </div>


                <div class="gabungan-report-date">

                    Tanggal:

                    <span class="gabungan-tanggal-box">
                        {{
                            $tanggalAwal
                                ? \Carbon\Carbon::parse(
                                    $tanggalAwal
                                )->format('d-m-Y')
                                : '-'
                        }}
                    </span>

                    -

                    <span class="gabungan-tanggal-box">
                        {{
                            $tanggalAkhir
                                ? \Carbon\Carbon::parse(
                                    $tanggalAkhir
                                )->format('d-m-Y')
                                : '-'
                        }}
                    </span>

                </div>

            </div>


            {{-- =================================================
                 TABLE
            ================================================== --}}

            <div class="gabungan-table-wrapper">

                <table class="gabungan-table">

                    <thead>

                        <tr>

                            <th class="gabungan-no">
                                No
                            </th>

                            <th>
                                Nama Lokasi
                            </th>

                            <th>
                                Total Pendapatan
                            </th>

                            <th>
                                Total Discount
                            </th>

                            <th>
                                Total
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($this->laporan as $index => $item)

                            <tr>

                                <td class="gabungan-no">
                                    {{ $index + 1 }}
                                </td>

                                <td class="gabungan-lokasi">
                                    {{ $item['nama_dermaga'] }}
                                </td>

                                <td class="gabungan-nominal">

                                    Rp
                                    {{
                                        number_format(
                                            $item['total_pendapatan'],
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>

                                <td class="gabungan-nominal">

                                    Rp
                                    {{
                                        number_format(
                                            $item['total_discount'],
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>

                                <td class="gabungan-nominal">

                                    Rp
                                    {{
                                        number_format(
                                            $item['total'],
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
                                    class="gabungan-empty"
                                >
                                    Data tidak tersedia.
                                </td>

                            </tr>

                        @endforelse


                        {{-- =================================================
                             TOTAL KESELURUHAN
                        ================================================== --}}

                        <tr class="gabungan-total-row">

                            <td
                                colspan="2"
                                class="gabungan-total-label"
                            >
                                Total Keseluruhan
                            </td>

                            <td class="gabungan-nominal">

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

                            <td class="gabungan-nominal">

                                Rp
                                {{
                                    number_format(
                                        $this->totalDiscountKeseluruhan,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </td>

                            <td class="gabungan-nominal">

                                Rp
                                {{
                                    number_format(
                                        $this->totalKeseluruhan,
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

        </div>

    </div>

</x-filament-panels::page>