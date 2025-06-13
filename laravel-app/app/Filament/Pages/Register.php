<?php

namespace App\Filament\Pages;

use App\Enums\UserRoleEnum;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = UserRoleEnum::ADMIN;

        return $data;
    }
}
