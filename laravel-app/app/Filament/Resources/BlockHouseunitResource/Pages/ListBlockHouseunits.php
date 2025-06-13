<?php

namespace App\Filament\Resources\BlockHouseunitResource\Pages;

use App\Filament\Resources\BlockHouseunitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlockHouseunits extends ListRecords
{
    protected static string $resource = BlockHouseunitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
