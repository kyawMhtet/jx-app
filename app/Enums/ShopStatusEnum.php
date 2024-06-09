<?php

namespace App\Enums;

enum ShopStatusEnum: string
{
        //
    case Active = 'active';
    case Inactive = 'inactive';
    case Deleted = 'deleted';

    public static function getValueArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
