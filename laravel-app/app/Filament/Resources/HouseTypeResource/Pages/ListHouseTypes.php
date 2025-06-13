<?php

namespace App\Filament\Resources\HouseTypeResource\Pages;

use App\Filament\Resources\HouseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHouseTypes extends ListRecords
{
    protected static string $resource = HouseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
