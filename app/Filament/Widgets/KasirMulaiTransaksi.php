<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class KasirMulaiTransaksi extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.widgets.kasir-mulai-transaksi';

    protected int|string|array $columnSpan = 'full';
}