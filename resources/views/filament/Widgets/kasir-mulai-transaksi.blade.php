<div id="kasir-mulai-transaksi" style="
    width: 100%;
    grid-column: 1 / -1;
    background: #ffffff;
    border-radius: 12px;
    padding: 14px 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    box-sizing: border-box;
">

    <div style="
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    ">

        <div style="
            display: flex;
            align-items: center;
            gap: 16px;
        ">

            <div style="
                width: 48px;
                height: 48px;
                min-width: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                background: #eff6ff;
            ">
                <x-heroicon-o-banknotes
                    style="width: 24px; height: 24px; color: #2563eb;"
                />
            </div>

            <div>
                <h2 style="
                    margin: 0;
                    font-size: 17px;
                    line-height: 24px;
                    font-weight: 700;
                    color: #111827;
                ">
                    Siap Melayani Transaksi
                </h2>

                <p style="
                    margin: 2px 0 0 0;
                    font-size: 13px;
                    line-height: 19px;
                    color: #6b7280;
                ">
                    Silakan mulai transaksi pembayaran penyeberangan.
                </p>
            </div>

        </div>

        <a
            href="{{ \App\Filament\Petugas\Pages\Transaksi::getUrl() }}"
            style="
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 10px 18px;
                border-radius: 8px;
                background: #2563eb;
                color: #ffffff;
                font-size: 14px;
                line-height: 20px;
                font-weight: 600;
                text-decoration: none;
                white-space: nowrap;
            "
        >
            <x-heroicon-o-plus
                style="width: 18px; height: 18px;"
            />

            Mulai Transaksi
        </a>

    </div>

</div>