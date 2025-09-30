<?php

namespace App\Enums;

enum UserType: int
{
    case Owner = 10;
    case Customer = 40;
    case SystemWallet = 50;

    public static function usernameLength(UserType $type): int
    {
        return match ($type) {
            self::Owner => 1,
            self::Customer => 2,
            self::SystemWallet => 3,
        };
    }

    public static function childUserType(UserType $type): UserType
    {
        return match ($type) {
            self::Owner => self::Customer,
            self::Customer, self::SystemWallet => self::Customer,
        };
    }

    public static function canHaveChild(UserType $parent, UserType $child): bool
    {
        return match ($parent) {
            self::Owner => $child === self::Customer,
            self::Customer, self::SystemWallet => false,
        };
    }
}
