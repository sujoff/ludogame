<?php

namespace App\Enums\Interfaces;

interface HasUtility
{
    public function is(int|string $value): bool;

    /**
     * @return array<string>
     */
    public static function getValues(): array;
}
