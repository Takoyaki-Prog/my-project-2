<?php

namespace App\Filament\Resources\HouseUnitResource\Pages;

use App\Filament\Resources\HouseUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHouseUnit extends EditRecord
{
    protected static string $resource = HouseUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
