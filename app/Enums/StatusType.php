<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusType extends Enum
{
    const ACTIVE = "ACTIVE";
    const INACTIVE = "INACTIVE";

    public static function getStrings(): array {
        $getKeys = self::getKeys();
        $keyValues = [];
        foreach ($getKeys as $key => $value) {
            $keyValues[$value] = $value;
        }

        return $keyValues;
    }
}
