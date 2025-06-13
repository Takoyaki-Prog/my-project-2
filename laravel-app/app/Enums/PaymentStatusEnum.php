<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case TERTUNDA = 'tertunda';
    case BERHASIL = 'berhasil';
    case GAGAL = 'gagal';
    case KADALUARSA = 'kadaluarsa';
}
