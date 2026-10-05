<x-filament-panels::page>

    <style>
        .atur-tarif-page {
            width: 100%;
        }

        .loket-info-card,
        .tarif-card {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .loket-info-card {
            padding: 22px 24px;
            margin-bottom: 20px;
        }

        .loket-info-title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 600;
        }

        .loket-info-subtitle {
            margin-top: 4px;
            color: #6b7280;
            font-size: 14px;
        }

        .loket-info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            margin-top: 20px;
        }

        .loket-info-label {
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .loket-info-value {
            margin-top: 5px;
            color: #111827;
            font-size: 15px;
            font-weight: 600;
        }

        .tarif-card {
            overflow: hidden;
            border-top: 3px solid #2563eb;
        }

        .tarif-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 18px 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .tarif-card-title {
            color: #111827;
            font-size: 20px;
            font-weight: 600;
        }

        .tarif-card-description {
            margin-top: 4px;
            color: #6b7280;
            font-size: 14px;
        }

        .tarif-search {
            width: 280px;
            max-width: 100%;
            height: 40px;
            padding: 0 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
        }

        .tarif-search:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
        }

        .tarif-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .tarif-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tarif-table th,
        .tarif-table td {
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .tarif-table th {
            padding: 13px 18px;
            background: #1681c4;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
        }

        .tarif-table td {
            padding: 15px 18px;
            color: #374151;
            font-size: 14px;
            background: #ffffff;
        }

        .tarif-table tbody tr:last-child td {
            border-bottom: none;
        }

        .tarif-table tbody tr:hover td {
            background: #f9fafb;
        }

        .tarif-name {
            color: #111827;
            font-weight: 600;
        }

        .tarif-category {
            color: #6b7280;
        }

        .tarif-price {
            color: #111827;
            text-align: right !important;
            white-space: nowrap;
        }

        .tarif-check {
            width: 90px;
            text-align: center !important;
        }

        .tarif-check input {
            width: 17px;
            height: 17px;
            margin: 0;
            cursor: pointer;
            accent-color: #2563eb;
            vertical-align: middle;
        }

        .tarif-table th:nth-child(1) {
            width: 42%;
        }

        .tarif-table th:nth-child(2) {
            width: 23%;
        }

        .tarif-table th:nth-child(3) {
            width: 20%;
        }

        .tarif-table th:nth-child(4) {
            width: 15%;
        }

        .tarif-empty {
            padding: 40px 20px !important;
            color: #6b7280 !important;
            text-align: center !important;
        }

        .tarif-card-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .tarif-btn {
            min-width: 90px;
            height: 40px;
            padding: 0 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .tarif-btn-cancel {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .tarif-btn-cancel:hover {
            background: #f9fafb;
        }

        .tarif-btn-save {
            border: 1px solid #f59e0b;
            background: #f59e0b;
            color: #ffffff;
        }

        .tarif-btn-save:hover {
            background: #d97706;
            border-color: #d97706;
        }

        @media (max-width: 900px) {
            .loket-info-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .tarif-card-header {
                flex-direction: column;
            }

            .tarif-search {
                width: 100%;
            }

            .tarif-table {
                min-width: 720px;
            }
        }

        @media (max-width: 640px) {
            .loket-info-card {
                padding: 18px;
            }

            .tarif-card-header {
                padding: 16px 18px;
            }

            .tarif-card-footer {
                padding: 14px 18px;
            }
        }
    </style>

    <div class="atur-tarif-page">

        {{-- INFORMASI LOKET --}}
        <div class="loket-info-card">

            <div class="loket-info-title">
                {{ $record->nama_loket }}
            </div>

            <div class="loket-info-subtitle">
                Pengaturan tarif yang dapat dilayani oleh loket
            </div>

            <div class="loket-info-grid">

                <div>
                    <div class="loket-info-label">
                        Pelabuhan
                    </div>

                    <div class="loket-info-value">
                        {{ $record->dermaga?->nama_dermaga ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="loket-info-label">
                        Kode Loket
                    </div>

                    <div class="loket-info-value">
                        {{ $record->kode_loket }}
                    </div>
                </div>

                <div>
                    <div class="loket-info-label">
                        Status
                    </div>

                    <div class="loket-info-value">
                        {{ ucfirst($record->status) }}
                    </div>
                </div>

            </div>

        </div>


        {{-- TARIF YANG DILAYANI --}}
        <div class="tarif-card">

            <div class="tarif-card-header">

                <div>
                    <div class="tarif-card-title">
                        Tarif yang Dilayani
                    </div>

                    <div class="tarif-card-description">
                        Pilih tarif yang dapat digunakan pada loket ini.
                    </div>
                </div>

                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Cari tarif..."
                    class="tarif-search"
                >

            </div>


            {{-- TABEL TARIF --}}
            <div class="tarif-table-wrapper">

                <table class="tarif-table">

                    <thead>
                        <tr>
                            <th>
                                Nama Tarif
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th class="tarif-price">
                                Harga
                            </th>

                            <th class="tarif-check">
                                Dilayani
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($this->tarifs as $tarif)

                            <tr>

                                <td>
                                    <div class="tarif-name">
                                        {{ $tarif->nama_tarif }}
                                    </div>
                                </td>

                                <td>
                                    <div class="tarif-category">
                                        {{ ucfirst($tarif->kategori) }}
                                    </div>
                                </td>

                                <td class="tarif-price">
                                    Rp {{ number_format($tarif->harga, 0, ',', '.') }}
                                </td>

                                <td class="tarif-check">

                                    <input
                                        type="checkbox"
                                        value="{{ $tarif->id_tarif }}"
                                        wire:model="selectedTarifIds"
                                        @disabled($tarif->status !== 'aktif')
                                    >

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="4"
                                    class="tarif-empty"
                                >
                                    Tidak ada data tarif.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- TOMBOL --}}
            <div class="tarif-card-footer">

                <button
                    type="button"
                    wire:click="batal"
                    class="tarif-btn tarif-btn-cancel"
                >
                    Batal
                </button>

                <button
                    type="button"
                    wire:click="simpanTarif"
                    class="tarif-btn tarif-btn-save"
                >
                    Simpan
                </button>

            </div>

        </div>

    </div>

</x-filament-panels::page>