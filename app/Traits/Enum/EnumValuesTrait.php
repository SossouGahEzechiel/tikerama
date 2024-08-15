<?php

namespace App\Traits\Enum;

trait EnumValuesTrait
{
    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }
}
