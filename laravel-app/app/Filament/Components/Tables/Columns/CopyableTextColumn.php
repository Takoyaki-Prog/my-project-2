<?php

namespace App\Filament\Components\Tables\Columns;

use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;

class CopyableTextColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->copyable()
            ->copyMessage('Disalin')
            ->tooltip('Klik untuk menyalin')
            ->icon('heroicon-m-clipboard')
            ->iconPosition(IconPosition::After)
            ->sortable()
            ->toggleable();
    }
}
