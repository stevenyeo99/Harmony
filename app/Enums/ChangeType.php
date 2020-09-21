<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ChangeType extends Enum {

    const PURCHASE = "PURCHASE";
    const SALES = "SALES";
    const NEWITEM = "NEWITEM";
    const EDITITEM = "EDITITEM";

    public static function getStrings(): array {
        $getKeys = self::getKeys();
        $keyValues = [];
        foreach ($getKeys as $key => $value) {
            $keyValues[$value] = $value;
        }

        return $keyValues;
    }
}