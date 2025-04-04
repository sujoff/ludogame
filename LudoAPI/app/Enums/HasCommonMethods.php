<?php

namespace App\Enums;

trait HasCommonMethods
{
    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function is(int|string $value): bool
    {
        return $this->value === $value;
    }

    /**
     * @return array<string>
     */
    public static function getValues(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
