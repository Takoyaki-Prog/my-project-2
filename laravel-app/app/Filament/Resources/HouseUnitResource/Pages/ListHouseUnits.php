<?php

namespace App\Filament\Resources\HouseUnitResource\Pages;

use App\Filament\Resources\HouseUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHouseUnits extends ListRecords
{
    protected static string $resource = HouseUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
