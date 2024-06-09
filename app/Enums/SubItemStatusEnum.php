<?php

namespace App\Enums;

enum SubItemStatusEnum: string
{
        //
    case Active = 'active';
    case Inactive = 'inactive';
    case OutOfStock = 'out_of_stock';
    case Deleted = 'deleted';

    public static function getValueArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
