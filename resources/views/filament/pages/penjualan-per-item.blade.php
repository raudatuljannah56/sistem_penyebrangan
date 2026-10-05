<x-filament-panels::page>

    <style>
        .item-page {
            width: 100%;
        }

        /* =====================================================
           FILTER
        ====================================================== */

        .item-filter-card {
            background: #ffffff;
            border-top: 3px solid #2563eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .item-filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto auto;
            gap: 14px;
            align-items: end;
        }

        .item-field {
            min-width: 0;
        }

        .item-field label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
        }

        .item-field input {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
        }

        .item-field input:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 1px #2563eb;
        }

        /* =====================================================
           BUTTON
        ====================================================== */

        .item-btn {
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

        .item-btn-primary {
            background: #2563eb;
        }

        .item-btn-primary:hover {
            background: #1d4ed8;
        }

        .item-btn-success {
            background: #16a34a;
        }

        .item-btn-success:hover {
            background: #15803d;
        }

        /* =====================================================
           REPORT
        ====================================================== */

        .item-report-section {
            --report-side-gap: 24px;

            width: 100%;
            background: #ffffff;
            border-top: 3px solid #2563eb;
            border-radius: 8px;
            padding: 0 var(--report-side-gap) 18px var(--report-side-gap);
            margin: 0;
            box-sizing: border-box;
        }

        .item-report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 0 12px 0;
            margin: 0;
            gap: 20px;
            box-sizing: border-box;
        }

        .item-report-title {
            color: #111827;
            font-size: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        .item-report-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            color: #6b7280;
            font-size: 14px;
            flex-wrap: wrap;
            text-align: right;
        }

        .item-report-info span {
            display: inline-block;
            background: #ffd6d690;
            color: #dc2626;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 5px;
            line-height: 1.3;
        }

        /* =====================================================
           TABLE
        ====================================================== */

        .item-table-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .item-table {
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .item-table thead th {
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

        .item-table thead th:nth-child(1) {
            width: 65px;
        }

        .item-table thead th:nth-child(2) {
            width: 38%;
        }

        .item-table thead th:nth-child(3) {
            width: 18%;
        }

        .item-table thead th:nth-child(4) {
            width: 15%;
        }

        .item-table thead th:nth-child(5) {
            width: 22%;
        }

        .item-table tbody td {
            padding: 14px 12px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            vertical-align: middle;
        }

        .item-table tbody tr:hover td {
            background: #f8fafc;
        }

        .item-no {
            text-align: center;
        }

        .item-name {
            text-align: left;
        }

        .item-price {
            text-align: right;
            white-space: nowrap;
        }

        .item-qty {
            text-align: center;
        }

        .item-total {
            text-align: right;
            white-space: nowrap;
            font-weight: 600;
        }

        /* =====================================================
           TOTAL
        ====================================================== */

        .item-total-row td {
            background: #e5e7eb !important;
            color: #374151 !important;
            font-weight: 700;
            border: 1px solid #d1d5db;
        }

        .item-total-label {
            text-align: right !important;
        }

        .item-empty {
            padding: 35px 20px !important;
            text-align: center;
            color: #6b7280 !important;
            border: 1px solid #d1d5db !important;
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {
            .item-filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 650px) {
            .item-filter-grid {
                grid-template-columns: 1fr;
            }

            .item-report-section {
                --report-side-gap: 14px;
                padding: 0 var(--report-side-gap) 14px var(--report-side-gap);
            }

            .item-report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 13px 0 12px 0;
            }

            .item-report-info {
                justify-content: flex-start;
                text-align: left;
            }

            .item-table {
                min-width: 750px;
            }
        }
    </style>


    <div class="item-page">

        {{-- =====================================================
             FILTER
        ====================================================== --}}

        <div class="item-filter-card">

            <div class="item-filter-grid">

                <div class="item-field">

                    <label for="tanggalAwal">
                        Tanggal
                    </label>

                    <input
                        id="tanggalAwal"
                        type="date"
                        wire:model="tanggalAwal"
                    >

                </div>


                <div class="item-field">

                    <label for="tanggalAkhir">
                        Sampai
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
                        class="item-btn item-btn-primary"
                    >
                        Tampil Data
                    </button>

                </div>


                <div>

                    <button
                        type="button"
                        wire:click="exportExcel"
                        class="item-btn item-btn-success"
                    >
                        Export ke Excel
                    </button>

                </div>

            </div>

        </div>


        {{-- =====================================================
             LAPORAN
        ====================================================== --}}

        <div class="item-report-section">

            <div class="item-report-header">

                <div class="item-report-title">
                    Laporan Penjualan by Menu
                </div>

                <div class="item-report-info">

                    Tanggal:

                    <span>
                        {{
                            $tanggalAwal
                                ? \Carbon\Carbon::parse(
                                    $tanggalAwal
                                )->format('d-m-Y')
                                : '-'
                        }}
                    </span>

                    &nbsp; - &nbsp;

                    <span>
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
                 TABEL
            ================================================== --}}

            <div class="item-table-wrapper">

                <table class="item-table">

                    <thead>

                        <tr>

                            <th class="item-no">
                                No
                            </th>

                            <th>
                                Nama Menu
                            </th>

                            <th>
                                Harga Menu
                            </th>

                            <th>
                                Qty
                            </th>

                            <th>
                                TOTAL
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($this->laporan as $index => $item)

                            <tr>

                                <td class="item-no">
                                    {{ $index + 1 }}
                                </td>

                                <td class="item-name">
                                    {{ $item['nama_tarif'] }}
                                </td>

                                <td class="item-price">
                                    Rp
                                    {{
                                        number_format(
                                            $item['harga'],
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                </td>

                                <td class="item-qty">
                                    {{ $item['qty'] }}
                                </td>

                                <td class="item-total">
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
                                    class="item-empty"
                                >
                                    Tidak ada data penjualan.
                                </td>

                            </tr>

                        @endforelse


                        {{-- =================================================
                             TOTAL KESELURUHAN
                        ================================================== --}}

                        <tr class="item-total-row">

                            <td
                                colspan="3"
                                class="item-total-label"
                            >
                                Total Keseluruhan
                            </td>

                            <td class="item-qty">
                                {{ $this->totalQty }}
                            </td>

                            <td class="item-total">
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