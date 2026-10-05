<x-filament-panels::page>

    <style>

        /*
        |--------------------------------------------------------------------------
        | WRAPPER
        |--------------------------------------------------------------------------
        */

        .laporan-wrapper {
            width: 100%;
            max-width: 100%;
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        .laporan-filter {
            width: 100%;
            box-sizing: border-box;

            background: #ffffff;

            border: 1px solid #d1d5db;
            border-top: 4px solid #1681c4;

            border-radius: 10px;

            padding: 18px 20px;

            margin-bottom: 22px;
        }

        .laporan-filter-grid {
            width: 100%;

            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr)
                minmax(0, 1fr)
                auto;

            gap: 14px;

            align-items: end;
        }

        .laporan-filter-item {
            min-width: 0;

            display: flex;
            flex-direction: column;

            gap: 7px;
        }

        .laporan-filter-item label {
            color: #374151;

            font-size: 13px;
            font-weight: 600;

            line-height: 1.4;
        }

        .laporan-filter-item input,
        .laporan-filter-item select {
            width: 100%;

            height: 40px;

            box-sizing: border-box;

            padding: 0 11px;

            background: #ffffff;
            color: #111827;

            border: 1px solid #d1d5db;
            border-radius: 7px;

            font-size: 13px;

            outline: none;
        }

        .laporan-filter-item input:hover,
        .laporan-filter-item select:hover {
            border-color: #9ca3af;
        }

        .laporan-filter-item input:focus,
        .laporan-filter-item select:focus {
            border-color: #1681c4;

            box-shadow:
                0 0 0 1px #1681c4;
        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON FILTER
        |--------------------------------------------------------------------------
        */

        .laporan-filter-button {
            display: flex;

            align-items: end;

            gap: 8px;
        }

        .laporan-btn {
            height: 40px;

            padding: 0 17px;

            border: 0;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            white-space: nowrap;
        }

        .laporan-btn-primary {
            background: #1681c4;

            color: #ffffff;
        }

        .laporan-btn-primary:hover {
            background: #116ea8;
        }

        .laporan-btn-print {
            background: #16a34a;

            color: #ffffff;
        }

        .laporan-btn-print:hover {
            background: #15803d;
        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL RIWAYAT
        |--------------------------------------------------------------------------
        */

        .laporan-history-heading {
            margin-bottom: 12px;
        }

        .laporan-history-title {
            color: #111827;

            font-size: 18px;

            font-weight: 700;

            line-height: 1.4;

            margin: 0;
        }

        .laporan-history-subtitle {
            color: #6b7280;

            font-size: 13px;

            line-height: 1.5;

            margin-top: 3px;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE BOX
        |--------------------------------------------------------------------------
        */

        .laporan-table-box {
            width: 100%;

            box-sizing: border-box;

            background: #ffffff;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            overflow: hidden;
        }

        .laporan-table-wrapper {
            width: 100%;

            overflow-x: auto;

            overflow-y: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .laporan-table {
            width: 100%;

            min-width: 1050px;

            border-collapse: separate;

            border-spacing: 0;

            table-layout: fixed;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE HEADER
        |--------------------------------------------------------------------------
        */

        .laporan-table thead th {
            height: 46px;

            padding: 10px 12px;

            background: #1681c4;

            color: #ffffff;

            border-bottom: 1px solid #d1d5db;

            border-right: 1px solid rgba(255, 255, 255, 0.35);

            font-size: 13px;

            font-weight: 700;

            text-align: center;

            white-space: nowrap;
        }

        .laporan-table thead th:first-child {
            border-left: 0;

            border-top-left-radius: 9px;
        }

        .laporan-table thead th:last-child {
            border-right: 0;

            border-top-right-radius: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE BODY
        |--------------------------------------------------------------------------
        */

        .laporan-table tbody td {
            padding: 12px 10px;

            background: #ffffff;

            color: #111827;

            border-bottom: 1px solid #d1d5db;

            border-right: 1px solid #d1d5db;

            font-size: 13px;

            vertical-align: middle;
        }

        .laporan-table tbody td:first-child {
            border-left: 0;
        }

        .laporan-table tbody td:last-child {
            border-right: 0;
        }

        .laporan-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .laporan-table tbody tr:hover td {
            background: #f8fafc;
        }


        /*
        |--------------------------------------------------------------------------
        | SUDUT BAWAH
        |--------------------------------------------------------------------------
        */

        .laporan-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 9px;
        }

        .laporan-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | LEBAR KOLOM
        |--------------------------------------------------------------------------
        */

        .laporan-table th:nth-child(1),
        .laporan-table td:nth-child(1) {
            width: 55px;
            text-align: center;
        }

        .laporan-table th:nth-child(2),
        .laporan-table td:nth-child(2) {
            width: 120px;
            text-align: center;
        }

        .laporan-table th:nth-child(3),
        .laporan-table td:nth-child(3) {
            width: 245px;
        }

        .laporan-table th:nth-child(4),
        .laporan-table td:nth-child(4) {
            width: 220px;
        }

        .laporan-table th:nth-child(5),
        .laporan-table td:nth-child(5) {
            width: 120px;
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDAPATAN
        |--------------------------------------------------------------------------
        */

        .laporan-table th:nth-child(6) {
            width: 180px;
            text-align: center;
        }

        .laporan-table td:nth-child(6) {
            width: 180px;
            text-align: right;
        }


        /*
        |--------------------------------------------------------------------------
        | OPSI
        |--------------------------------------------------------------------------
        */

        .laporan-table th:nth-child(7),
        .laporan-table td:nth-child(7) {
            width: 120px;
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | PETUGAS
        |--------------------------------------------------------------------------
        */

        .petugas-name {
            color: #111827;

            font-weight: 700;

            line-height: 1.4;
        }

        .petugas-shift {
            margin-top: 3px;

            color: #6b7280;

            font-size: 12px;

            line-height: 1.4;
        }


        /*
        |--------------------------------------------------------------------------
        | LOKASI
        |--------------------------------------------------------------------------
        */

        .lokasi-name {
            color: #111827;

            font-weight: 600;

            line-height: 1.4;
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        .laporan-total {
            color: #111827;

            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | ACTION
        |--------------------------------------------------------------------------
        */

        .laporan-action-wrap {
            display: flex;

            justify-content: center;

            align-items: center;
        }

        .laporan-action {
            border: 0;

            border-radius: 6px;

            padding: 7px 12px;

            font-size: 12px;

            font-weight: 700;

            line-height: 1.2;

            cursor: pointer;

            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | LIHAT
        |--------------------------------------------------------------------------
        */

        .laporan-action-view {
            background: #e0f2fe;

            color: #0369a1;
        }

        .laporan-action-view:hover {
            background: #bae6fd;
        }


        /*
        |--------------------------------------------------------------------------
        | CETAK
        |--------------------------------------------------------------------------
        */

        .laporan-action-print {
            background: #dcfce7;

            color: #15803d;
        }

        .laporan-action-print:hover {
            background: #bbf7d0;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA KOSONG
        |--------------------------------------------------------------------------
        */

        .laporan-empty {
            padding: 45px 20px;

            text-align: center;
        }

        .laporan-empty-title {
            color: #374151;

            font-size: 15px;

            font-weight: 700;
        }

        .laporan-empty-text {
            margin-top: 5px;

            color: #6b7280;

            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        .laporan-pagination {
            padding: 14px 18px;

            border-top: 1px solid #e5e7eb;
        }


        /*
        |--------------------------------------------------------------------------
        | MODAL
        |--------------------------------------------------------------------------
        */

        .laporan-modal-overlay {
            position: fixed;

            inset: 0;

            z-index: 9999;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

            background: rgba(15, 23, 42, 0.52);
        }

        .laporan-modal {
            width: 100%;

            /*
            | Lebar modal dibuat mengikuti karcis,
            | bukan selebar halaman.
            */

            max-width: 430px;

            max-height: 92vh;

            overflow-y: auto;

            background: #ffffff;

            border-radius: 12px;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.22);
        }


        /*
        |--------------------------------------------------------------------------
        | MODAL HEADER
        |--------------------------------------------------------------------------
        */

        .laporan-modal-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 16px;

            padding: 15px 18px;

            border-bottom: 1px solid #e5e7eb;
        }

        .laporan-modal-title {
            color: #111827;

            font-size: 17px;

            font-weight: 700;
        }

        .laporan-modal-close {
            width: 32px;

            height: 32px;

            border: 0;

            border-radius: 50%;

            background: #f3f4f6;

            color: #374151;

            font-size: 19px;

            line-height: 1;

            cursor: pointer;
        }

        .laporan-modal-close:hover {
            background: #e5e7eb;
        }


        /*
        |--------------------------------------------------------------------------
        | MODAL BODY
        |--------------------------------------------------------------------------
        */

        .laporan-modal-body {
            padding: 14px 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | PREVIEW KARCIS
        |
        | Dibuat sama seperti karcis hasil cetak.
        |--------------------------------------------------------------------------
        */

        .struk-preview {
            width: 80mm;

            max-width: 100%;

            box-sizing: border-box;

            margin: 0 auto;

            padding:
                3mm
                2.5mm
                2mm
                2.5mm;

            background: #ffffff;

            color: #000000;

            border: 0;

            border-radius: 0;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            line-height: 1.18;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER KARCIS
        |--------------------------------------------------------------------------
        */

        .struk-header {
            margin:
                0
                0
                5px
                0;

            padding: 0;

            text-align: center;
        }

        .struk-pelabuhan {
            margin: 0;

            padding: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 700;

            text-transform: uppercase;

            line-height: 1.1;
        }

        .struk-kota {
            margin: 0;

            padding: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 700;

            line-height: 1.1;
        }


        /*
        |--------------------------------------------------------------------------
        | INFO KARCIS
        |--------------------------------------------------------------------------
        */

        .struk-info {
            margin: 0;

            padding: 0;

            border: 0;
        }

        .struk-info-row {
            display: grid;

            grid-template-columns:
                13ch
                1ch
                minmax(0, 1fr);

            column-gap: 0;

            margin: 0;

            padding: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            line-height: 1.18;
        }

        .struk-label {
            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            white-space: nowrap;
        }

        .struk-colon {
            width: 1ch;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            text-align: left;

            white-space: nowrap;
        }

        .struk-value {
            min-width: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            word-break: break-word;
        }


        /*
        |--------------------------------------------------------------------------
        | GARIS
        |--------------------------------------------------------------------------
        */

        .print-dash {
            width: 100%;

            height: 0;

            margin:
                4px
                0;

            padding: 0;

            border-top:
                1px dashed #000000;
        }


        /*
        |--------------------------------------------------------------------------
        | SECTION
        |--------------------------------------------------------------------------
        */

        .struk-section-title {
            margin:
                4px
                0
                1px
                0;

            padding: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            line-height: 1.18;
        }


        /*
        |--------------------------------------------------------------------------
        | TABEL ITEM
        |--------------------------------------------------------------------------
        */

        .struk-table {
            width: 100%;

            margin: 0;

            padding: 0;

            border-collapse: collapse;

            table-layout: fixed;
        }

        .struk-table th,
        .struk-table td {
            margin: 0;

            padding: 0;

            border: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            line-height: 1.18;

            vertical-align: top;
        }

        .struk-table th {
            font-weight: 400;
        }

        .struk-table th:first-child,
        .struk-table td:first-child {
            width: 64%;

            text-align: left;

            white-space: normal;

            word-break: break-word;
        }

        .struk-table th:nth-child(2),
        .struk-table td:nth-child(2) {
            width: 12%;

            text-align: right;

            white-space: nowrap;
        }

        .struk-table th:nth-child(3),
        .struk-table td:nth-child(3) {
            width: 24%;

            text-align: right;

            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        .struk-payment {
            margin: 0;

            padding: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;
        }

        .struk-payment-row {
            display: grid;

            grid-template-columns:
                6ch
                1ch
                auto;

            column-gap: 0;

            justify-content: start;

            align-items: center;

            margin: 0;

            padding: 0;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            line-height: 1.18;
        }

        .payment-label {
            white-space: nowrap;
        }

        .payment-colon {
            width: 1ch;

            white-space: nowrap;
        }

        .payment-value {
            margin-left: 1ch;

            text-align: left;

            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | PENUTUP
        |--------------------------------------------------------------------------
        */

        .struk-thanks {
            margin:
                4px
                0
                0
                0;

            padding: 0;

            border: 0;

            text-align: left;

            color: #000000;

            font-family:
                "Courier New",
                Courier,
                monospace;

            font-size: 8px;

            font-weight: 400;

            line-height: 1.18;
        }


        /*
        |--------------------------------------------------------------------------
        | MODAL FOOTER
        |--------------------------------------------------------------------------
        */

        .laporan-modal-footer {
            display: flex;

            justify-content: flex-end;

            gap: 8px;

            padding:
                12px
                16px;

            border-top: 1px solid #e5e7eb;
        }


        /*
        |--------------------------------------------------------------------------
        | AREA CETAK
        |--------------------------------------------------------------------------
        */

        #laporan-cetak {
            display: none;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1100px) {

            .laporan-filter-grid {
                grid-template-columns:
                    minmax(0, 1fr)
                    minmax(0, 1fr);
            }

            .laporan-filter-button {
                grid-column: span 2;
            }

        }

        @media (max-width: 650px) {

            .laporan-filter-grid {
                grid-template-columns: 1fr;
            }

            .laporan-filter-button {
                grid-column: span 1;
            }

            .laporan-filter-button .laporan-btn {
                flex: 1;
            }

            .laporan-modal-overlay {
                padding: 10px;
            }

            .laporan-modal {
                max-width: 390px;
            }

            .laporan-modal-body {
                padding: 12px 10px;
            }

            .struk-preview {
                width: 80mm;

                max-width: 100%;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | PRINT
        |
        | 1 A4 = 6 KARCIS
        | 2 KOLOM x 3 BARIS
        |--------------------------------------------------------------------------
        */

        @media print {

            @page {
                size: A4 portrait;

                margin: 7mm;
            }


            /*
            |--------------------------------------------------------------------------
            | BODY
            |--------------------------------------------------------------------------
            */

            html,
            body {
                margin: 0 !important;

                padding: 0 !important;

                background: #ffffff !important;
            }


            /*
            |--------------------------------------------------------------------------
            | SEMBUNYIKAN SEMUA KONTEN WEB
            |--------------------------------------------------------------------------
            */

            body * {
                visibility: hidden !important;
            }


            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN AREA CETAK
            |--------------------------------------------------------------------------
            */

            #laporan-cetak,
            #laporan-cetak * {
                visibility: visible !important;
            }


            /*
            |--------------------------------------------------------------------------
            | AREA A4
            |
            | 2 kolom x 3 baris
            |--------------------------------------------------------------------------
            */

            #laporan-cetak {

                display: grid !important;

                grid-template-columns:
                    repeat(2, 80mm) !important;

                grid-auto-rows: 90mm !important;

                column-gap: 8mm !important;

                row-gap: 4mm !important;

                justify-content: center !important;

                align-content: start !important;

                width: 100% !important;

                box-sizing: border-box !important;

                position: absolute !important;

                left: 0 !important;

                top: 0 !important;

                margin: 0 !important;

                padding: 0 !important;

                background: #ffffff !important;
            }


            /*
            |--------------------------------------------------------------------------
            | KARCIS
            |--------------------------------------------------------------------------
            */

            .print-struk {

                width: 80mm !important;

                height: 90mm !important;

                min-width: 80mm !important;

                max-width: 80mm !important;

                min-height: 90mm !important;

                max-height: 90mm !important;

                box-sizing: border-box !important;

                margin: 0 !important;

                padding:
                    3mm
                    2.5mm
                    2mm
                    2.5mm !important;

                background: #ffffff !important;

                border: 0 !important;

                border-radius: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                line-height: 1.18 !important;

                overflow: hidden !important;

                break-inside: avoid !important;

                page-break-inside: avoid !important;

                page-break-before: auto !important;

                page-break-after: auto !important;
            }


            /*
            |--------------------------------------------------------------------------
            | HEADER
            |--------------------------------------------------------------------------
            */

            .print-struk .struk-header {

                margin:
                    0
                    0
                    5px
                    0 !important;

                padding: 0 !important;

                text-align: center !important;
            }

            .print-struk .struk-pelabuhan {

                margin: 0 !important;

                padding: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 700 !important;

                text-transform: uppercase !important;

                line-height: 1.1 !important;
            }

            .print-struk .struk-kota {

                margin: 0 !important;

                padding: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 700 !important;

                line-height: 1.1 !important;
            }


            /*
            |--------------------------------------------------------------------------
            | INFO
            |--------------------------------------------------------------------------
            */

            .print-struk .struk-info {

                margin: 0 !important;

                padding: 0 !important;

                border: 0 !important;
            }

            .print-struk .struk-info-row {

                display: grid !important;

                grid-template-columns:
                    13ch
                    1ch
                    minmax(0, 1fr) !important;

                column-gap: 0 !important;

                margin: 0 !important;

                padding: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                line-height: 1.18 !important;
            }

            .print-struk .struk-label {

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                white-space: nowrap !important;
            }

            .print-struk .struk-colon {

                width: 1ch !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                text-align: left !important;

                white-space: nowrap !important;
            }

            .print-struk .struk-value {

                min-width: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                word-break: break-word !important;
            }


            /*
            |--------------------------------------------------------------------------
            | GARIS
            |--------------------------------------------------------------------------
            */

            .print-struk .print-dash {

                display: block !important;

                width: 100% !important;

                height: 0 !important;

                margin:
                    4px
                    0 !important;

                padding: 0 !important;

                border-top:
                    1px dashed #000000 !important;
            }


            /*
            |--------------------------------------------------------------------------
            | JENIS KENDARAAN
            |--------------------------------------------------------------------------
            */

            .print-struk .struk-section-title {

                margin:
                    4px
                    0
                    1px
                    0 !important;

                padding: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                line-height: 1.18 !important;
            }


            /*
            |--------------------------------------------------------------------------
            | TABEL ITEM
            |--------------------------------------------------------------------------
            */

            .print-struk .struk-table {

                width: 100% !important;

                margin: 0 !important;

                padding: 0 !important;

                border-collapse: collapse !important;

                table-layout: fixed !important;
            }

            .print-struk .struk-table th,
            .print-struk .struk-table td {

                margin: 0 !important;

                padding: 0 !important;

                border: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                line-height: 1.18 !important;

                vertical-align: top !important;
            }

            .print-struk .struk-table th {

                font-weight: 400 !important;
            }

            .print-struk .struk-table th:first-child,
            .print-struk .struk-table td:first-child {

                width: 64% !important;

                text-align: left !important;

                white-space: normal !important;

                word-break: break-word !important;
            }

            .print-struk .struk-table th:nth-child(2),
            .print-struk .struk-table td:nth-child(2) {

                width: 12% !important;

                text-align: right !important;

                white-space: nowrap !important;
            }

            .print-struk .struk-table th:nth-child(3),
            .print-struk .struk-table td:nth-child(3) {

                width: 24% !important;

                text-align: right !important;

                white-space: nowrap !important;
            }


            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            .print-struk .struk-payment {

                margin: 0 !important;

                padding: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;
            }

            .print-struk .struk-payment-row {

                display: grid !important;

                grid-template-columns:
                    6ch
                    1ch
                    auto !important;

                column-gap: 0 !important;

                justify-content: start !important;

                align-items: center !important;

                margin: 0 !important;

                padding: 0 !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                line-height: 1.18 !important;
            }

            .print-struk .payment-label {

                white-space: nowrap !important;
            }

            .print-struk .payment-colon {

                width: 1ch !important;

                white-space: nowrap !important;
            }

            .print-struk .payment-value {

                margin-left: 1ch !important;

                text-align: left !important;

                white-space: nowrap !important;
            }


            /*
            |--------------------------------------------------------------------------
            | TERIMA KASIH
            |--------------------------------------------------------------------------
            */

            .print-struk .struk-thanks {

                margin:
                    4px
                    0
                    0
                    0 !important;

                padding: 0 !important;

                border: 0 !important;

                text-align: left !important;

                color: #000000 !important;

                font-family:
                    "Courier New",
                    Courier,
                    monospace !important;

                font-size: 8px !important;

                font-weight: 400 !important;

                line-height: 1.18 !important;
            }


            /*
            |--------------------------------------------------------------------------
            | SEMBUNYIKAN WEB
            |--------------------------------------------------------------------------
            */

            .laporan-wrapper,
            .laporan-modal-overlay {

                display: none !important;
            }

        }

    </style>


    {{-- ======================================================================
         HALAMAN LAPORAN
    ======================================================================= --}}

    <div class="laporan-wrapper">

        {{-- FILTER --}}

        <div class="laporan-filter">

            <div class="laporan-filter-grid">

                {{-- TANGGAL AWAL --}}

                <div class="laporan-filter-item">

                    <label for="tanggalAwal">
                        Tanggal Awal
                    </label>

                    <input
                        id="tanggalAwal"
                        type="date"
                        wire:model="tanggalAwal"
                    >

                </div>


                {{-- TANGGAL AKHIR --}}

                <div class="laporan-filter-item">

                    <label for="tanggalAkhir">
                        Tanggal Akhir
                    </label>

                    <input
                        id="tanggalAkhir"
                        type="date"
                        wire:model="tanggalAkhir"
                    >

                </div>


                {{-- PETUGAS --}}

                <div class="laporan-filter-item">

                    <label for="petugas">
                        Petugas
                    </label>

                    <select
                        id="petugas"
                        wire:model="petugas"
                    >

                        <option value="">
                            Semua Petugas
                        </option>

                        @foreach (
                            $this->petugasOptions
                            as $petugasItem
                        )

                            <option
                                value="{{ $petugasItem->id_user }}"
                            >
                                {{ $petugasItem->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BUTTON --}}

                <div class="laporan-filter-button">

                    <button
                        type="button"
                        wire:click="tampilkanData"
                        class="laporan-btn laporan-btn-primary"
                    >
                        Tampilkan Data
                    </button>


                    <button
                        type="button"
                        wire:click="cetakSemua"
                        class="laporan-btn laporan-btn-print"
                    >
                        Cetak Semua
                    </button>

                </div>

            </div>

        </div>


        {{-- RIWAYAT --}}

        <div class="laporan-history-heading">

            <div class="laporan-history-title">
                Riwayat Laporan
            </div>

            <div class="laporan-history-subtitle">
                Rekap transaksi berdasarkan shift dan tanggal
            </div>

        </div>


        {{-- TABEL --}}

        <div class="laporan-table-box">

            <div class="laporan-table-wrapper">

                <table class="laporan-table">

                    <thead>

                        <tr>

                            <th>
                                No
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th>
                                Lokasi
                            </th>

                            <th>
                                Jumlah Trx
                            </th>

                            <th>
                                Total Pendapatan
                            </th>

                            <th>
                                Opsi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse (
                            $this->laporan
                            as $index => $item
                        )

                            <tr>

                                <td>
                                    {{
                                        $this->laporan->firstItem()
                                        + $index
                                    }}
                                </td>


                                <td>
                                    {{
                                        $this->formatTanggal(
                                            $item->tanggal
                                        )
                                    }}
                                </td>


                                <td>

                                    <div class="petugas-name">
                                        {{ $item->nama_petugas }}
                                    </div>

                                    <div class="petugas-shift">
                                        {{ $item->nama_shift }}
                                    </div>

                                </td>


                                <td>

                                    <div class="lokasi-name">
                                        {{ $item->nama_dermaga }}
                                    </div>

                                    <div class="petugas-shift">
                                        {{ $item->nama_loket }}
                                    </div>

                                </td>


                                <td>

                                    {{
                                        number_format(
                                            $item->jumlah_trx,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>


                                <td class="laporan-total">

                                    Rp
                                    {{
                                        $this->formatRupiah(
                                            $item->total
                                        )
                                    }}

                                </td>


                                <td>

                                    <div class="laporan-action-wrap">

                                        <button
                                            type="button"
                                            wire:click="lihatLaporan(
                                                {{ $item->id_shift }},
                                                '{{ $item->tanggal }}'
                                            )"
                                            class="
                                                laporan-action
                                                laporan-action-view
                                            "
                                        >
                                            Lihat
                                        </button>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="laporan-empty">

                                        <div class="laporan-empty-title">
                                            Belum ada laporan
                                        </div>

                                        <div class="laporan-empty-text">
                                            Belum ada transaksi berhasil
                                            pada periode yang dipilih.
                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            @if ($this->laporan->hasPages())

                <div class="laporan-pagination">

                    {{ $this->laporan->links() }}

                </div>

            @endif

        </div>

    </div>


    {{-- ======================================================================
         DETAIL LAPORAN
    ======================================================================= --}}

    @if ($detailShiftId && $detailTanggal)

        @php
            $detail = $this->detailLaporan;
        @endphp


        @if ($detail)

            {{-- MODAL --}}

            <div
                class="laporan-modal-overlay"
                wire:click.self="tutupDetail"
            >

                <div class="laporan-modal">


                    {{-- MODAL HEADER --}}

                    <div class="laporan-modal-header">

                        <div class="laporan-modal-title">
                            Detail Laporan Petugas
                        </div>


                        <button
                            type="button"
                            wire:click="tutupDetail"
                            class="laporan-modal-close"
                            aria-label="Tutup"
                        >
                            ×
                        </button>

                    </div>


                    {{-- MODAL BODY --}}

                    <div class="laporan-modal-body">

                        <div class="struk-preview">


                            {{-- HEADER --}}

                            <div class="struk-header">

                                <div class="struk-pelabuhan">
                                    {{ $detail['nama_dermaga'] }}
                                </div>

                                <div class="struk-kota">
                                    BANJARMASIN
                                </div>

                            </div>


                            {{-- IDENTITAS --}}

                            <div class="struk-info">

                                <div class="struk-info-row">

                                    <div class="struk-label">
                                        Nama Petugas
                                    </div>

                                    <div class="struk-colon">
                                        :
                                    </div>

                                    <div class="struk-value">
                                        {{ $detail['nama_petugas'] }}
                                    </div>

                                </div>


                                <div class="struk-info-row">

                                    <div class="struk-label">
                                        Tanggal
                                    </div>

                                    <div class="struk-colon">
                                        :
                                    </div>

                                    <div class="struk-value">
                                        {{ $detail['tanggal'] }}
                                        sd
                                        {{ $detail['tanggal'] }}
                                    </div>

                                </div>

                            </div>


                            {{-- GARIS --}}

                            <div class="print-dash"></div>


                            {{-- RINGKASAN --}}

                            <div class="struk-info">

                                <div class="struk-info-row">

                                    <div class="struk-label">
                                        Jumlah Trx
                                    </div>

                                    <div class="struk-colon">
                                        :
                                    </div>

                                    <div class="struk-value">
                                        {{
                                            number_format(
                                                $detail['jumlah_trx'],
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}
                                    </div>

                                </div>


                                <div class="struk-info-row">

                                    <div class="struk-label">
                                        Total
                                    </div>

                                    <div class="struk-colon">
                                        :
                                    </div>

                                    <div class="struk-value">
                                        {{
                                            $this->formatRupiah(
                                                $detail['total']
                                            )
                                        }}
                                    </div>

                                </div>

                            </div>


                            {{-- JENIS KENDARAAN --}}

                            <div class="struk-section-title">
                                Jenis Kendaraan:
                            </div>


                            <table class="struk-table">

                                <thead>

                                    <tr>

                                        <th>
                                            Jenis
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

                                    @forelse (
                                        $detail['items']
                                        as $detailItem
                                    )

                                        <tr>

                                            <td>
                                                {{
                                                    strtoupper(
                                                        $detailItem->nama_tarif
                                                    )
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    number_format(
                                                        $detailItem->jumlah,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    $this->formatRupiah(
                                                        $detailItem->total
                                                    )
                                                }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td>
                                                -
                                            </td>

                                            <td>
                                                -
                                            </td>

                                            <td>
                                                -
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>


                            {{-- GARIS --}}

                            <div class="print-dash"></div>


                            {{-- PEMBAYARAN --}}

                            <div class="struk-payment">

                                <div class="struk-payment-row">

                                    <span class="payment-label">
                                        Tunai
                                    </span>

                                    <span class="payment-colon">
                                        :
                                    </span>

                                    <span class="payment-value">
                                        {{
                                            $this->formatRupiah(
                                                $detail['tunai']
                                            )
                                        }}
                                    </span>

                                </div>


                                <div class="struk-payment-row">

                                    <span class="payment-label">
                                        QRIS
                                    </span>

                                    <span class="payment-colon">
                                        :
                                    </span>

                                    <span class="payment-value">
                                        {{
                                            $this->formatRupiah(
                                                $detail['qris']
                                            )
                                        }}
                                    </span>

                                </div>

                            </div>


                            {{-- GARIS --}}

                            <div class="print-dash"></div>


                            {{-- PENUTUP --}}

                            <div class="struk-thanks">
                                Terima kasih
                            </div>

                        </div>

                    </div>


                    {{-- MODAL FOOTER --}}

                    <div class="laporan-modal-footer">

                        <button
                            type="button"
                            wire:click="tutupDetail"
                            class="
                                laporan-action
                                laporan-action-view
                            "
                        >
                            Tutup
                        </button>


                        <button
                            type="button"
                            wire:click="cetakLaporan(
                                {{ $detail['id_shift'] }},
                                '{{ $detail['tanggal'] }}'
                            )"
                            class="
                                laporan-action
                                laporan-action-print
                            "
                        >
                            Cetak Struk
                        </button>

                    </div>

                </div>

            </div>


            {{-- ============================================================== 
                 PRINT SATU LAPORAN
            =============================================================== --}}

            @if ($modeCetak === 'satu')

                <div id="laporan-cetak">

                    <div class="print-struk">


                        {{-- HEADER --}}

                        <div class="struk-header">

                            <div class="struk-pelabuhan">
                                {{ $detail['nama_dermaga'] }}
                            </div>

                            <div class="struk-kota">
                                BANJARMASIN
                            </div>

                        </div>


                        {{-- IDENTITAS --}}

                        <div class="struk-info">

                            <div class="struk-info-row">

                                <div class="struk-label">
                                    Nama Petugas
                                </div>

                                <div class="struk-colon">
                                    :
                                </div>

                                <div class="struk-value">
                                    {{ $detail['nama_petugas'] }}
                                </div>

                            </div>


                            <div class="struk-info-row">

                                <div class="struk-label">
                                    Tanggal
                                </div>

                                <div class="struk-colon">
                                    :
                                </div>

                                <div class="struk-value">
                                    {{ $detail['tanggal'] }}
                                    sd
                                    {{ $detail['tanggal'] }}
                                </div>

                            </div>

                        </div>


                        {{-- GARIS --}}

                        <div class="print-dash"></div>


                        {{-- RINGKASAN --}}

                        <div class="struk-info">

                            <div class="struk-info-row">

                                <div class="struk-label">
                                    Jumlah Trx
                                </div>

                                <div class="struk-colon">
                                    :
                                </div>

                                <div class="struk-value">
                                    {{
                                        number_format(
                                            $detail['jumlah_trx'],
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                </div>

                            </div>


                            <div class="struk-info-row">

                                <div class="struk-label">
                                    Total
                                </div>

                                <div class="struk-colon">
                                    :
                                </div>

                                <div class="struk-value">
                                    {{
                                        $this->formatRupiah(
                                            $detail['total']
                                        )
                                    }}
                                </div>

                            </div>

                        </div>


                        {{-- JENIS KENDARAAN --}}

                        <div class="struk-section-title">
                            Jenis Kendaraan:
                        </div>


                        <table class="struk-table">

                            <thead>

                                <tr>

                                    <th>
                                        Jenis
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

                                @forelse (
                                    $detail['items']
                                    as $detailItem
                                )

                                    <tr>

                                        <td>
                                            {{
                                                strtoupper(
                                                    $detailItem->nama_tarif
                                                )
                                            }}
                                        </td>

                                        <td>
                                            {{
                                                number_format(
                                                    $detailItem->jumlah,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}
                                        </td>

                                        <td>
                                            {{
                                                $this->formatRupiah(
                                                    $detailItem->total
                                                )
                                            }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td>
                                            -
                                        </td>

                                        <td>
                                            -
                                        </td>

                                        <td>
                                            -
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>


                        {{-- GARIS --}}

                        <div class="print-dash"></div>


                        {{-- PEMBAYARAN --}}

                        <div class="struk-payment">

                            <div class="struk-payment-row">

                                <span class="payment-label">
                                    Tunai
                                </span>

                                <span class="payment-colon">
                                    :
                                </span>

                                <span class="payment-value">
                                    {{
                                        $this->formatRupiah(
                                            $detail['tunai']
                                        )
                                    }}
                                </span>

                            </div>


                            <div class="struk-payment-row">

                                <span class="payment-label">
                                    QRIS
                                </span>

                                <span class="payment-colon">
                                    :
                                </span>

                                <span class="payment-value">
                                    {{
                                        $this->formatRupiah(
                                            $detail['qris']
                                        )
                                    }}
                                </span>

                            </div>

                        </div>


                        {{-- GARIS --}}

                        <div class="print-dash"></div>


                        {{-- PENUTUP --}}

                        <div class="struk-thanks">
                            Terima kasih
                        </div>

                    </div>

                </div>

            @endif

        @endif

    @endif


    {{-- ======================================================================
         CETAK SEMUA
    ======================================================================= --}}

    @if ($modeCetak === 'semua')

        <div id="laporan-cetak">

            @foreach (
                $this->semuaLaporanUntukPrint
                as $laporanPrint
            )

                <div class="print-struk">


                    {{-- HEADER --}}

                    <div class="struk-header">

                        <div class="struk-pelabuhan">
                            {{ $laporanPrint['nama_dermaga'] }}
                        </div>

                        <div class="struk-kota">
                            BANJARMASIN
                        </div>

                    </div>


                    {{-- IDENTITAS --}}

                    <div class="struk-info">

                        <div class="struk-info-row">

                            <div class="struk-label">
                                Nama Petugas
                            </div>

                            <div class="struk-colon">
                                :
                            </div>

                            <div class="struk-value">
                                {{ $laporanPrint['nama_petugas'] }}
                            </div>

                        </div>


                        <div class="struk-info-row">

                            <div class="struk-label">
                                Tanggal
                            </div>

                            <div class="struk-colon">
                                :
                            </div>

                            <div class="struk-value">
                                {{ $laporanPrint['tanggal'] }}
                                sd
                                {{ $laporanPrint['tanggal'] }}
                            </div>

                        </div>

                    </div>


                    {{-- GARIS --}}

                    <div class="print-dash"></div>


                    {{-- RINGKASAN --}}

                    <div class="struk-info">

                        <div class="struk-info-row">

                            <div class="struk-label">
                                Jumlah Trx
                            </div>

                            <div class="struk-colon">
                                :
                            </div>

                            <div class="struk-value">
                                {{
                                    number_format(
                                        $laporanPrint['jumlah_trx'],
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}
                            </div>

                        </div>


                        <div class="struk-info-row">

                            <div class="struk-label">
                                Total
                            </div>

                            <div class="struk-colon">
                                :
                            </div>

                            <div class="struk-value">
                                {{
                                    $this->formatRupiah(
                                        $laporanPrint['total']
                                    )
                                }}
                            </div>

                        </div>

                    </div>


                    {{-- JENIS KENDARAAN --}}

                    <div class="struk-section-title">
                        Jenis Kendaraan:
                    </div>


                    <table class="struk-table">

                        <thead>

                            <tr>

                                <th>
                                    Jenis
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

                            @forelse (
                                $laporanPrint['items']
                                as $detailItem
                            )

                                <tr>

                                    <td>
                                        {{
                                            strtoupper(
                                                $detailItem->nama_tarif
                                            )
                                        }}
                                    </td>

                                    <td>
                                        {{
                                            number_format(
                                                $detailItem->jumlah,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}
                                    </td>

                                    <td>
                                        {{
                                            $this->formatRupiah(
                                                $detailItem->total
                                            )
                                        }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td>
                                        -
                                    </td>

                                    <td>
                                        -
                                    </td>

                                    <td>
                                        -
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>


                    {{-- GARIS --}}

                    <div class="print-dash"></div>


                    {{-- PEMBAYARAN --}}

                    <div class="struk-payment">

                        <div class="struk-payment-row">

                            <span class="payment-label">
                                Tunai
                            </span>

                            <span class="payment-colon">
                                :
                            </span>

                            <span class="payment-value">
                                {{
                                    $this->formatRupiah(
                                        $laporanPrint['tunai']
                                    )
                                }}
                            </span>

                        </div>


                        <div class="struk-payment-row">

                            <span class="payment-label">
                                QRIS
                            </span>

                            <span class="payment-colon">
                                :
                            </span>

                            <span class="payment-value">
                                {{
                                    $this->formatRupiah(
                                        $laporanPrint['qris']
                                    )
                                }}
                            </span>

                        </div>

                    </div>


                    {{-- GARIS --}}

                    <div class="print-dash"></div>


                    {{-- PENUTUP --}}

                    <div class="struk-thanks">
                        Terima kasih
                    </div>

                </div>

            @endforeach

        </div>

    @endif


    {{-- ======================================================================
         EVENT PRINT
    ======================================================================= --}}

    <script>

        document.addEventListener('livewire:init', () => {

            Livewire.on('print-laporan', () => {

                setTimeout(() => {

                    window.print();

                }, 300);

            });

        });

    </script>

</x-filament-panels::page>