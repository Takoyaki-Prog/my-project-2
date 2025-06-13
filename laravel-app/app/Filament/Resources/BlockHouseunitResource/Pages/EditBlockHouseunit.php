<?php

namespace App\Filament\Resources\BlockHouseunitResource\Pages;

use App\Filament\Resources\BlockHouseunitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlockHouseunit extends EditRecord
{
    protected static string $resource = BlockHouseunitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
