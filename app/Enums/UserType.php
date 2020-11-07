<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const IsAdmin = "YES";
    const NoAdmin = "NO";
    const Boss = "YESNO";

    public static function getDdlUserType(): array {
        $getKeys = self::getKeys();
        $keyValues = [];
        foreach ($getKeys as $key => $value) {
            if ($value == 'Boss') {
                continue;
            }
            $keyValues[UserType::getDBVal($value)] = UserType::getLabel($value);
        }

        return $keyValues;
    }

    private static function getDBVal($key) {
        switch ($key) {
            case 'IsAdmin':
                return Self::IsAdmin;
            case 'NoAdmin':
                return Self::NoAdmin;
            default:
                return '';
        }
    }

    private static function getLabel($key) {
        switch ($key) {
            case 'IsAdmin':
                return 'Admin';
            case 'NoAdmin':
                return 'Staff';
            default:
                return '';
        }
    }
}
