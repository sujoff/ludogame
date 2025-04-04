<?php

namespace App\Enums;

use App\Enums\Interfaces\HasUtility;

enum CurrencyTypeEnum: string implements HasUtility
{
    use HasCommonMethods;

    case ADS = 'ADS';
    case GEM = 'GEM';
    case COIN = 'COIN';
    case MONEY = 'MONEY';
    case WIN = 'WIN';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADS => 'ADS',
            self::GEM => 'GEM',
            self::COIN => 'COIN',
            self::MONEY => 'MONEY',
            self::WIN => 'WIN',
        };
    }
}
