<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ActionType extends Enum {

    const STORE = "STORE";
    const EDIT = "EDIT";
    const TERMINATE = "TERMINATE";

    public static function getStrings(): array {
        $getKeys = self::getKeys();
        $keyValues = [];
        foreach ($getKeys as $key => $value) {
            $keyValues[$value] = $value;
        }

        return $keyValues;
    }
}