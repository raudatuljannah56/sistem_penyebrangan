<x-filament-panels::page>

    {{-- Sinkronisasi tarif loket dari pengaturan Admin --}}
    <div
        wire:poll.3s="refreshTarifLoket"
        style="display: none;"
    ></div>

    <style>
        .trx-wrapper {
            width: 100%;
        }

        /* =========================================================
           TOTAL PENDAPATAN
        ========================================================= */

        .trx-income-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }

        .trx-income-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
        }

        .trx-income-value {
            margin-top: 5px;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        /* =========================================================
        INFORMASI SHIFT
        Background luar + 4 card informasi terpisah
        ========================================================= */

        /* =========================================================
        INFORMASI SHIFT
        ========================================================= */

        .trx-shift {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 32px;
            padding: 25px 18px 18px;

            background: #ffffff;

            border: 1px solid #e5e7eb;
            border-top: 3px solid #1681c4;

            border-radius: 14px;
        }

        /* Masing-masing card tetap terpisah */
        .trx-info-card {
            min-width: 0;

            background: #ffffff;

            border: 1px solid #e5e7eb;
            border-radius: 12px;

            padding: 15px 17px;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .trx-info-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }

        .trx-info-value {
            margin-top: 5px;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* =========================================================
           SECTION TARIF
        ========================================================= */

        .trx-section {
            margin-bottom: 34px;
        }

        .trx-section-header {
            margin-bottom: 14px;
        }

        .trx-section-title {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #111827;
        }

        .trx-section-description {
            margin-top: 3px;
            font-size: 13px;
            color: #6b7280;
        }

        /* =========================================================
           GRID TARIF
        ========================================================= */

        .trx-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        /* =========================================================
           CARD TARIF
        ========================================================= */

        .trx-card {
            display: block;
            width: 100%;
            padding: 10px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease,
                border-color 0.15s ease;
        }

        .trx-card:hover {
            transform: translateY(-2px);
            border-color: #d1d5db;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
        }

        .trx-image {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #ffffff;
            border-radius: 9px;
        }

        .trx-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 0;
        }

        .trx-placeholder {
            font-size: 12px;
            line-height: 18px;
            color: #9ca3af;
        }

        .trx-name {
            min-height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 4px 0;
            font-size: 17px;
            font-weight: 700;
            line-height: 22px;
            color: #111827;
        }

        .trx-price {
            padding-bottom: 10px;
            font-size: 15px;
            font-weight: 700;
            color: #6b7280;
        }
        /* =========================================================
           DETAIL TRANSAKSI
        ========================================================= */

        .trx-detail {
            width: 100%;
            margin-top: 8px;
            padding: 22px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        .trx-detail-main {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px;
            gap: 40px;
            align-items: start;
        }

        .trx-detail-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
        }

        .trx-detail-name {
            margin-top: 5px;
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .trx-detail-category {
            margin-top: 2px;
            font-size: 12px;
            color: #6b7280;
            text-transform: capitalize;
        }

        .trx-detail-price {
            margin-top: 4px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        /* =========================================================
           JUMLAH
        ========================================================= */

        .trx-quantity-title {
            margin-bottom: 7px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
        }

        .trx-quantity {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .trx-quantity button {
            width: 38px;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
        }

        .trx-quantity button:hover {
            background: #f9fafb;
        }

        .trx-quantity-value {
            width: 46px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f3f4f6;
            color: #111827;
            font-weight: 700;
        }

        /* =========================================================
           TOTAL DI BAWAH JUMLAH
        ========================================================= */

        .trx-total {
            margin-top: 22px;
        }

        .trx-total-value {
            margin-top: 3px;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        /* =========================================================
           PEMBAYARAN
        ========================================================= */

        .trx-payment {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
        }

        .trx-payment-title {
            margin-bottom: 10px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
        }

        .trx-payment-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .trx-payment-button {
            min-width: 110px;
            height: 40px;
            padding: 0 18px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .trx-payment-button:hover {
            background: #f9fafb;
        }

        .trx-payment-button.active {
            background: #111827;
            border-color: #111827;
            color: #ffffff;
        }

        /* =========================================================
           PROSES
        ========================================================= */

        .trx-process-button {
            width: 100%;
            height: 42px;
            margin-top: 12px;
            padding: 0 20px;
            border: 0;
            border-radius: 8px;
            background: #111827;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .trx-process-button:hover {
            background: #1f2937;
        }

        /* =========================================================
           BATAL
        ========================================================= */

        .trx-cancel-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .trx-cancel-button {
            min-width: 90px;
            height: 38px;
            padding: 0 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .trx-cancel-button:hover {
            background: #f9fafb;
        }

        /* =========================================================
           QRIS
        ========================================================= */

        .trx-qris-box {
            margin-top: 18px;
            padding: 18px;
            border-radius: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .trx-qris-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .trx-qris-info {
            margin-top: 5px;
            font-size: 13px;
            color: #6b7280;
        }

        .trx-qris-placeholder {
            margin-top: 15px;
            padding: 25px 20px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px dashed #d1d5db;
            color: #6b7280;
            font-size: 13px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {
            .trx-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .trx-shift {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .trx-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .trx-shift {
                grid-template-columns: 1fr;
            }

            .trx-detail-main {
                grid-template-columns: 1fr;
                gap: 22px;
            }
        }
    </style>


    <div class="trx-wrapper">

        {{-- =====================================================
             TOTAL PENDAPATAN
        ====================================================== --}}

        <div class="trx-income-card">

            <div class="trx-income-label">
                Total Pendapatan Hari Ini
            </div>

            <div class="trx-income-value">
                Rp {{ number_format($this->totalPendapatanHariIni, 0, ',', '.') }}
            </div>

        </div>


        {{-- =====================================================
             INFORMASI SHIFT
             Hanya ditampilkan jika shift ditemukan
        ====================================================== --}}

        @if ($shiftAktif)

            <div class="trx-shift">

                <div class="trx-info-card">

                    <div class="trx-info-label">
                        Petugas
                    </div>

                    <div class="trx-info-value">
                        {{ auth()->user()->nama }}
                    </div>

                </div>


                <div class="trx-info-card">

                    <div class="trx-info-label">
                        Loket
                    </div>

                    <div class="trx-info-value">
                        {{ $shiftAktif['loket'] ?? '-' }}
                    </div>

                </div>


                <div class="trx-info-card">

                    <div class="trx-info-label">
                        Dermaga
                    </div>

                    <div class="trx-info-value">
                        {{ $shiftAktif['dermaga'] ?? '-' }}
                    </div>

                </div>


                <div class="trx-info-card">

                    <div class="trx-info-label">
                        Shift
                    </div>

                    <div class="trx-info-value">
                        {{ $shiftAktif['jam_mulai'] ?? '-' }}
                        -
                        {{ $shiftAktif['jam_selesai'] ?? '-' }}
                    </div>

                </div>

            </div>

        @endif


        {{-- =====================================================
             DAFTAR TARIF
             Selalu ditampilkan sebelum memilih tarif
        ====================================================== --}}

        @if (!$selectedTarifId)

            {{-- DAFTAR KENDARAAN --}}
            @if (count($tarifsKendaraan) > 0)

                <div class="trx-section">

                    <div class="trx-section-header">

                        <h2 class="trx-section-title">
                            Daftar Kendaraan
                        </h2>

                        <div class="trx-section-description">
                            Klik kendaraan untuk melakukan transaksi
                        </div>

                    </div>


                    <div class="trx-grid">

                        @foreach ($tarifsKendaraan as $tarif)

                            <button
                                type="button"
                                wire:click="pilihTarif({{ $tarif['id_tarif'] }})"
                                class="trx-card"
                            >

                                <div class="trx-image">

                                    @if ($tarif['foto'])

                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($tarif['foto']) }}"
                                            alt="{{ $tarif['nama_tarif'] }}"
                                        >

                                    @else

                                        <div class="trx-placeholder">
                                            Gambar belum tersedia
                                        </div>

                                    @endif

                                </div>

                                <div class="trx-name">
                                    {{ $tarif['nama_tarif'] }}
                                </div>


                                <div class="trx-price">
                                    Rp {{ number_format($tarif['harga'], 0, ',', '.') }}
                                </div>

                            </button>

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- DAFTAR PENUMPANG --}}
            @if (count($tarifsPenumpang) > 0)

                <div class="trx-section">

                    <div class="trx-section-header">

                        <h2 class="trx-section-title">
                            Daftar Penumpang
                        </h2>

                        <div class="trx-section-description">
                            Klik jenis penumpang untuk melakukan transaksi
                        </div>

                    </div>


                    <div class="trx-grid">

                        @foreach ($tarifsPenumpang as $tarif)

                            <button
                                type="button"
                                wire:click="pilihTarif({{ $tarif['id_tarif'] }})"
                                class="trx-card"
                            >

                                <div class="trx-image">

                                    @if ($tarif['foto'])

                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($tarif['foto']) }}"
                                            alt="{{ $tarif['nama_tarif'] }}"
                                        >

                                    @else

                                        <div class="trx-placeholder">
                                            Gambar belum tersedia
                                        </div>

                                    @endif

                                </div>


                                <div class="trx-name">
                                    {{ $tarif['nama_tarif'] }}
                                </div>


                                <div class="trx-price">
                                    Rp {{ number_format($tarif['harga'], 0, ',', '.') }}
                                </div>

                            </button>

                        @endforeach

                    </div>

                </div>

            @endif

        @endif


        {{-- =====================================================
             DETAIL TRANSAKSI
        ====================================================== --}}

        @if ($selectedTarifId)

            <div class="trx-detail">

                {{-- =================================================
                     TARIF + JUMLAH + TOTAL
                ================================================== --}}

                <div class="trx-detail-main">

                    {{-- TARIF --}}
                    <div>

                        <div class="trx-detail-label">
                            Tarif Dipilih
                        </div>

                        <div class="trx-detail-name">
                            {{ $selectedTarifName }}
                        </div>

                        <div class="trx-detail-category">
                            {{ $selectedKategori }}
                        </div>

                        <div class="trx-detail-price">
                            Rp {{ number_format($selectedHarga, 0, ',', '.') }}
                        </div>

                    </div>


                    {{-- JUMLAH --}}
                    <div>

                        <div class="trx-quantity-title">
                            Jumlah
                        </div>

                        <div class="trx-quantity">

                            <button
                                type="button"
                                wire:click="kurangiJumlah"
                            >
                                −
                            </button>


                            <div class="trx-quantity-value">
                                {{ $jumlah }}
                            </div>


                            <button
                                type="button"
                                wire:click="tambahJumlah"
                            >
                                +
                            </button>

                        </div>


                        {{-- TOTAL DI BAWAH JUMLAH --}}
                        <div class="trx-total">

                            <div class="trx-detail-label">
                                Total
                            </div>

                            <div class="trx-total-value">
                                Rp {{ number_format($this->getTotal(), 0, ',', '.') }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     METODE PEMBAYARAN
                ================================================== --}}

                <div class="trx-payment">

                    <div class="trx-payment-title">
                        Metode Pembayaran
                    </div>


                    <div class="trx-payment-options">

                        <button
                            type="button"
                            wire:click="pilihPembayaran('tunai')"
                            class="trx-payment-button {{ $metodePembayaran === 'tunai' ? 'active' : '' }}"
                        >
                            Tunai
                        </button>


                        <button
                            type="button"
                            wire:click="pilihPembayaran('qris')"
                            class="trx-payment-button {{ $metodePembayaran === 'qris' ? 'active' : '' }}"
                        >
                            QRIS
                        </button>

                    </div>


                    {{-- =================================================
                         TOMBOL PROSES
                    ================================================== --}}

                    @if ($metodePembayaran)

                        <button
                            type="button"
                            wire:click="prosesTransaksi"
                            class="trx-process-button"
                        >
                            {{ $metodePembayaran === 'qris'
                                ? 'Buat Pembayaran QRIS'
                                : 'Proses Transaksi'
                            }}
                        </button>

                    @endif


                    {{-- =================================================
                         STATUS QRIS
                    ================================================== --}}

                    @if ($qrisMenungguPembayaran)

                        <div class="trx-qris-box">

                            <div class="trx-qris-title">
                                Menunggu Pembayaran QRIS
                            </div>


                            <div class="trx-qris-info">
                                Kode Transaksi:
                                <strong>
                                    {{ $kodeTransaksiTerakhir }}
                                </strong>
                            </div>


                            <div class="trx-qris-info">
                                Referensi:
                                <strong>
                                    {{ $referensiQris }}
                                </strong>
                            </div>


                            <div class="trx-qris-placeholder">
                                QR pembayaran akan ditampilkan di sini
                                setelah payment gateway QRIS dikonfigurasi.
                            </div>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                     BATAL - KANAN BAWAH
                ================================================== --}}

                <div class="trx-cancel-wrapper">

                    <button
                        type="button"
                        wire:click="batalPilihTarif"
                        class="trx-cancel-button"
                    >
                        Batal
                    </button>

                </div>

            </div>

        @endif

    </div>

</x-filament-panels::page>