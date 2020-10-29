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

    public static function getTextChangeType($key = null) {
        switch ($key) {
            case ChangeType::PURCHASE:
                return 'Pembelian';
            case ChangeType::SALES:
                return 'Penjualan';
            case ChangeType::NEWITEM:
                return 'Item Baru';
            case ChangeType::EDITITEM:
                return 'Perubahan Item';
            default:
                return '';
        }
    }
}