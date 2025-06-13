<?php

namespace App\Filament\Resources\HouseTypeResource\Pages;

use App\Filament\Resources\HouseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHouseType extends EditRecord
{
    protected static string $resource = HouseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
