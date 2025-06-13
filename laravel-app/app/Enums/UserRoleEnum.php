<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case MARKETING = 'marketing';
    case CUSTOMER = 'customer';
}
