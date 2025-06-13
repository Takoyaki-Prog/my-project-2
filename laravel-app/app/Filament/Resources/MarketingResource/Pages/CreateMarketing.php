<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use App\Enums\UserRoleEnum;
use App\Filament\Resources\MarketingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMarketing extends CreateRecord
{
    protected static string $resource = MarketingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = UserRoleEnum::MARKETING;

        return $data;
    }
}
