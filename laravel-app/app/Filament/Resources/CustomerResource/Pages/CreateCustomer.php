<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Enums\UserRoleEnum;
use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = UserRoleEnum::CUSTOMER;

        return $data;
    }
}
