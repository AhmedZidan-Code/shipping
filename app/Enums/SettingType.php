<?php

namespace App\Enums;

class SettingType
{
    const EXPENSES = 1;

    /**
     * Get all possible values as an array.
     *
     * @return int[]
     */
    public static function getValues(): array
    {
        return [
            self::EXPENSES,
        ];
    }

    /**
     * Validate if a given value is a valid enum value.
     *
     * @param int $value
     * @return bool
     */
    public static function isValid(int $value): bool
    {
        return in_array($value, self::getValues(), true);
    }

    /**
     * Get the name associated with a given value.
     *
     * @param int $value
     * @return string|null
     */
    public static function getName(int $value): ?string
    {
        $names = [
            self::EXPENSES => 'المصروفات',
        ];

        return $names[$value] ?? null;
    }
}
