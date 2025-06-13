<?php

namespace App\Enums;

enum BookingStatusEnum: string
{
    case AKTIF = 'aktif';
    case TERBAYAR = 'terbayar';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
}
