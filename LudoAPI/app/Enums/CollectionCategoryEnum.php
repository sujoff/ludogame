<?php

namespace App\Enums;

enum CollectionCategoryEnum: string
{
    use HasCommonMethods;
    case INVENTORY = 'inventory';
    case CURRENCY = 'currency';

    public function getLabel(): string
    {
        return match ($this) {
            self::INVENTORY => 'inventory',
            self::CURRENCY => 'currency',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INVENTORY => 'success',
            self::CURRENCY => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BOARD => 'heroicon-m-check-badge',
            self::DICE => 'heroicon-m-x-circle',
            self::EMOTE => 'heroicon-m-x-circle',
            self::TOKEN => 'heroicon-m-x-circle',
        };
    }
}
