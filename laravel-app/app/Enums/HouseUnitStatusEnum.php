<?php

namespace App\Enums;

enum HouseUnitStatusEnum: string
{
    case TERSEDIA = 'tersedia';
    case DIBOOKING = 'dibooking';
    case TERJUAL = 'terjual';

    public static function getOptions()
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => str($case->name)->title()])
            ->toArray();
    }
}
